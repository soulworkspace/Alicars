<?php

namespace App\Livewire;

use App\Models\Ad;
use Livewire\Component;
use Livewire\WithPagination;

class AdSearch extends Component
{
    use WithPagination;

    public $search = '';
    public $city = '';
    public $category = '';
    
    // لمزامنة البحث مع رابط المتصفح (URL)
    protected $queryString = [
        'search' => ['except' => ''],
        'city' => ['except' => ''],
        'category' => ['except' => ''],
    ];

    public function updatingSearch() { $this->resetPage(); }

    public function render()
    {
        $ads = Ad::query()
            ->where('status', 'active')
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                      ->orWhere('description', 'like', '%'.$this->search.'%');
                })
                // ترتيب ذكي: العنوان المطابق يظهر أولاً
                ->orderByRaw("CASE WHEN title LIKE ? THEN 1 ELSE 2 END", ["%{$this->search}%"]);
            })
            ->when($this->city, fn($q) => $q->where('city', $this->city))
            ->latest()
            ->paginate(20);

        return view('livewire.ad-search', [
            'ads' => $ads
        ]);
    }
}