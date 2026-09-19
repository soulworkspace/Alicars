<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use App\Models\Ad;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class AdListing extends Component
{
    use WithPagination;
    public $page = 1;

    #[Url(except: '')]
    public $search = '';

    #[Url(except: null)]
    public $category = null;

    #[Url(except: null)]
    public $minPrice = null;

    #[Url(except: null)]
    public $maxPrice = null;

    #[Url(except: null)]
    public $city = null;

    #[Url(except: null)]
    public $condition = null;

    #[Url(except: 'latest')]
    public $sortBy = 'latest';

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'category', 'minPrice', 'maxPrice', 'city', 'condition', 'sortBy'])) {
            $this->resetPage();
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        // 1. بناء الاستعلام الأساسي
        $query = Ad::active()
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->when($this->category, fn($q) => $q->whereHas('category', fn($sq) => $sq->where('slug', $this->category)))
            ->when($this->minPrice, fn($q) => $q->where('price', '>=', $this->minPrice))
            ->when($this->maxPrice, fn($q) => $q->where('price', '<=', $this->maxPrice))
            ->when($this->city, fn($q) => $q->where('city', $this->city))
            ->when($this->condition, fn($q) => $q->where('condition', $this->condition));

        // 2. الترتيب
        $query = match($this->sortBy) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'oldest'     => $query->oldest(),
            default      => $query->latest(),
        };

        // 3. جلب البيانات الحقيقية
        $ads = $query->with(['category', 'user', 'images'])->paginate(30);

        // 4. نظام "البيانات الوهمية للملابس" في حال كانت القاعدة فارغة
        if ($ads->isEmpty() && empty($this->search)) {
            $ads = $this->generateFakeClothingAds();
        }

        return view('livewire.ad-listing', [
            'ads' => $ads,
            'categories' => Category::root()->active()->menu()->get(),
        ]);
    }

    /**
     * توليد 30 إعلاناً وهمياً مخصصاً للملابس
     */
    private function generateFakeClothingAds()
    {
        $fakeAds = [];
        $items = [
            ['title' => 'سترة صوفية كلاسيكية', 'price' => 8500],
            ['title' => 'فستان سهرة أسود فاخر', 'price' => 12000],
            ['title' => 'قميص كتان صيفي', 'price' => 4500],
            ['title' => 'بذلة رسمية مودرن', 'price' => 25000],
            ['title' => 'سروال جينز سليم فيت', 'price' => 6200],
            ['title' => 'معطف شتوي ثقيل', 'price' => 18000],
        ];

        for ($i = 1; $i <= 30; $i++) {
            $selection = $items[array_rand($items)];
            $fakeAds[] = (object) [
                'id' => $i,
                'title' => $selection['title'] . " - " . (100 + $i),
                'price' => $selection['price'] + rand(-500, 2000),
                'city' => 'الجزائر العاصمة',
                'condition' => 'new',
                'slug' => 'fake-ad-' . $i,
                'category' => (object) ['name' => 'ملابس', 'slug' => 'clothing'],
                // استخدام صور ملابس حقيقية من Unsplash
                'images' => collect([(object) ['path' => "https://images.unsplash.com/photo-".(1500000000000 + ($i * 1000000))."?auto=format&fit=crop&w=400&q=80"]]),
                'user' => (object) ['name' => 'بوتيك النخبة'],
                'created_at' => now()->subHours($i),
            ];
        }

        // تحويلها إلى Paginator متوافق مع Livewire
        return new LengthAwarePaginator(
            collect($fakeAds)->forPage($this->page, 30),
            count($fakeAds),
            30,
            $this->page
        );
    }
}