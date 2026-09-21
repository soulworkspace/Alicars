<?php

namespace App\Livewire;

use App\Models\Ad;
use App\Models\Attribute as AdAttribute;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdCreate extends Component
{
    use WithFileUploads;

    public string $title = '';
    public ?int $category_id = null;
    public ?int $year = null;
    public string $description = '';
    public ?float $price = null;
    public string $price_type = 'fixed';
    public string $condition = 'used';
    public string $mileage = '';
    public string $transmission = 'automatic';
    public string $fuel_type = 'gasoline';
    public string $city = '';
    public string $location = '';
    public string $contact_phone = '';
    public string $contact_whatsapp = '';
    public array $images = [];
    public int $primaryImage = 0;
    public $categories;

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'year' => ['required', 'integer', 'min:1900', 'max:' . (now()->year + 1)],
            'description' => ['required', 'string', 'min:20'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'price_type' => ['required', 'in:fixed,negotiable,free'],
            'condition' => ['required', 'in:new,used,refurbished'],
            'mileage' => ['required', 'integer', 'min:0', 'max:2000000'],
            'transmission' => ['required', 'in:automatic,manual,cvt'],
            'fuel_type' => ['required', 'in:gasoline,diesel,electric,hybrid'],
            'city' => ['nullable', 'string', 'max:100'],
            'location' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'contact_whatsapp' => ['nullable', 'string', 'max:20'],
            'images' => ['required', 'array', 'min:1', 'max:12'],
            'images.*' => ['file', 'max:5120', 'mimes:jpg,jpeg,png,webp,gif,heic,svg,avif'],
        ];
    }

    public function mount(): void
    {
        $this->categories = Category::active()->root()->with('children')->orderBy('sort_order')->get();
    }

    public function updatedImages(): void
    {
        $this->validateOnly('images');
        $this->primaryImage = min($this->primaryImage, max(count($this->images) - 1, 0));
    }

    public function removeImage(int $index): void
    {
        if (! array_key_exists($index, $this->images)) {
            return;
        }

        unset($this->images[$index]);
        $this->images = array_values($this->images);
        $this->primaryImage = $this->images === [] ? 0 : min($this->primaryImage, count($this->images) - 1);
    }

    public function setPrimaryImage(int $index): void
    {
        if (array_key_exists($index, $this->images)) {
            $this->primaryImage = $index;
        }
    }

    public function save(): mixed
    {
        $validated = $this->validate();
        $user = auth()->user();

        if (! $user->canCreateMoreAds()) {
            $this->addError('title', 'لقد وصلت إلى الحد الأقصى من الإعلانات المسموح بها.');
            return null;
        }

        if ($validated['price_type'] !== 'free' && $validated['price'] === null) {
            throw ValidationException::withMessages(['price' => 'يرجى إدخال السعر أو اختيار بدون سعر.']);
        }

        $ad = DB::transaction(function () use ($validated, $user) {
            $ad = Ad::create([
                'title' => $validated['title'],
                'category_id' => $validated['category_id'],
                'description' => $validated['description'],
                'price' => $validated['price_type'] === 'free' ? null : $validated['price'],
                'price_type' => $validated['price_type'],
                'condition' => $validated['condition'],
                'city' => $validated['city'] ?: null,
                'location' => $validated['location'] ?: null,
                'contact_phone' => $validated['contact_phone'] ?: null,
                'contact_whatsapp' => $validated['contact_whatsapp'] ?: null,
                'user_id' => $user->id,
                'store_id' => $user->store?->id,
                'status' => 'pending',
                'template' => 'car',
            ]);

            foreach ($this->images as $index => $image) {
                $path = $image->store('ads/' . $ad->id, 'public');
                $ad->images()->create([
                    'image_path' => $path,
                    'original_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getMimeType(),
                    'file_size' => $image->getSize(),
                    'is_primary' => $index === $this->primaryImage,
                    'sort_order' => $index,
                ]);
            }

            $attributes = [
                'year' => $validated['year'],
                'mileage' => $validated['mileage'],
                'transmission' => $validated['transmission'],
                'fuel_type' => $validated['fuel_type'],
            ];

            foreach ($attributes as $name => $value) {
                $attribute = AdAttribute::firstOrCreate(
                    ['category_id' => $validated['category_id'], 'name' => $name],
                    ['label' => ucfirst(str_replace('_', ' ', $name)), 'type' => 'text']
                );
                $ad->attributes()->syncWithoutDetaching([$attribute->id => ['value' => (string) $value]]);
            }

            return $ad;
        });

        return redirect()->route('ads.show', $ad->slug)->with('success', 'تم إرسال الإعلان للمراجعة بنجاح.');
    }

    public function render()
    {
        return view('livewire.ad-create');
    }
}
