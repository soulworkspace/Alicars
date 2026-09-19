# فهرس ملفات نظام البحث - مشروع الملابس (TRICO)

## File: app/Livewire/AdSearch.php
```php
<?php

namespace App\Livewire;

use Livewire\Component;

class AdSearch extends Component
{
    public function render()
    {
        return view('livewire.ad-search');
    }
}

```
---

## File: app/Http/Controllers/SearchController.php
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\Category;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Ad::query()->with('category', 'images', 'user');
        
        // Text search
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('city', 'like', "%{$searchTerm}%");
            });
        }
        
        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category)
                  ->orWhere('id', $request->category);
            });
        }
        
        // Price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Condition
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }
        
        // City
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }
        
        // Sort
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
        }
        
        // Only active ads
        $query->where('status', 'active');
        
        $ads = $query->paginate(24)->withQueryString();
        
        // Get categories for filter
        $categories = Category::active()->root()->with('children')->get();
        
        // Get cities for filter (distinct cities from active ads)
        $cities = Ad::where('status', 'active')
            ->whereNotNull('city')
            ->distinct()
            ->pluck('city')
            ->sort()
            ->values();
        
        return view('search.index', compact('ads', 'categories', 'cities'));
    }
    
    public function suggestions(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:50',
        ]);
        
        $searchTerm = $request->q;
        
        $suggestions = Ad::where('status', 'active')
            ->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', "%{$searchTerm}%")
                      ->orWhere('city', 'like', "%{$searchTerm}%");
            })
            ->select('title', 'slug')
            ->limit(5)
            ->get();
        
        return response()->json($suggestions);
    }
}

```
---

## File: resources/views/livewire/ad-search.blade.php
```php
<div class="relative">
    <div class="flex">
        <input type="text"
               wire:model="search"
               placeholder="بحث في الإعلانات..."
               class="w-full px-4 py-3 rounded-r-lg border-0 focus:ring-2 focus:ring-red-500"
               wire:keydown.enter="$emit('searchUpdated', search)">
        <button class="bg-red-600 text-white px-6 py-3 rounded-l-lg hover:bg-red-700">
            <i class="fas fa-search"></i>
        </button>
    </div>
</div>

```
---

## File: resources/views/search/index.blade.php
```php
@extends('layouts.main')

@section('title', 'البحث')
@section('meta')
<meta name="description" content="ابحث عن المنتجات والإعلانات في TRICO">
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Search Header -->
    <div class="card p-6 mb-6">
        <form action="{{ route('search') }}" method="GET" class="mb-6">
            <div class="relative">
                <input type="text" name="q" value="{{ request('q') }}" 
                    placeholder="ابحث عن منتج، ماركة، أو تصنيف..." 
                    class="form-input w-full px-6 py-4 rounded-xl text-lg pr-14">
                <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-emerald-400 text-xl">
                    <i class="fa-solid fa-search"></i>
                </button>
            </div>
        </form>
        
        <!-- Filters -->
        <form action="{{ route('search') }}" method="GET" class="grid md:grid-cols-4 gap-4">
            @if(request('q'))
                <input type="hidden" name="q" value="{{ request('q') }}">
            @endif
            
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-2">التصنيف</label>
                <select name="category" class="form-input w-full px-3 py-2 rounded-lg text-sm" onchange="this.form.submit()">
                    <option value="">كل التصنيفات</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @foreach($category->children as $child)
                            <option value="{{ $child->slug }}" {{ request('category') == $child->slug ? 'selected' : '' }}>
                                &nbsp;&nbsp;└ {{ $child->name }}
                            </option>
                        @endforeach
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-2">السعر</label>
                <div class="flex gap-2">
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="من" 
                        class="form-input w-full px-3 py-2 rounded-lg text-sm" onchange="this.form.submit()">
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="إلى" 
                        class="form-input w-full px-3 py-2 rounded-lg text-sm" onchange="this.form.submit()">
                </div>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-2">الحالة</label>
                <select name="condition" class="form-input w-full px-3 py-2 rounded-lg text-sm" onchange="this.form.submit()">
                    <option value="">الكل</option>
                    <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>جديد</option>
                    <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>مستعمل</option>
                    <option value="refurbished" {{ request('condition') == 'refurbished' ? 'selected' : '' }}>مجدد</option>
                </select>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-gray-500 mb-2">المدينة</label>
                <select name="city" class="form-input w-full px-3 py-2 rounded-lg text-sm" onchange="this.form.submit()">
                    <option value="">كل المدن</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            </div>
        </form>
        
        <!-- Sort -->
        <div class="flex items-center justify-between mt-4 pt-4 border-t border-white/5">
            <p class="text-sm text-gray-500">
                {{ $ads->total() }} نتيجة
                @if(request('q'))
                    لـ "{{ request('q') }}"
                @endif
            </p>
            
            <form action="{{ route('search') }}" method="GET" class="flex items-center gap-2">
                @foreach(request()->except('sort', 'page') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                
                <label class="text-xs text-gray-500">الترتيب:</label>
                <select name="sort" class="form-input px-3 py-1 rounded-lg text-sm" onchange="this.form.submit()">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>الأحدث</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>الأقدم</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>السعر: من الأقل</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>السعر: من الأعلى</option>
                </select>
            </form>
        </div>
    </div>
    
    <!-- Results -->
    @if($ads->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach($ads as $ad)
                <div class="card overflow-hidden group">
                    <a href="{{ route('ads.show', $ad->slug) }}" class="block">
                        <div class="aspect-video bg-emerald-500/10 relative overflow-hidden">
                            @if($ad->images->first())
                                <img src="{{ asset('storage/' . $ad->images->first()->image_path) }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fa-solid fa-image text-emerald-400 text-3xl"></i>
                                </div>
                            @endif
                            
                            @if($ad->is_featured)
                                <span class="absolute top-3 right-3 badge badge-amber">
                                    <i class="fa-solid fa-star mr-1"></i>مميز
                                </span>
                            @endif
                        </div>
                        
                        <div class="p-4">
                            <h4 class="font-bold truncate mb-2">{{ $ad->title }}</h4>
                            
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-emerald-400 font-bold">
                                    @if($ad->price)
                                        {{ number_format($ad->price) }} د.ج
                                    @else
                                        مجاني
                                    @endif
                                </span>
                                <span class="text-xs text-gray-500">{{ $ad->city ?? 'غير محدد' }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span class="badge badge-emerald">{{ $ad->category?->name ?? 'عام' }}</span>
                                <span><i class="fa-solid fa-eye mr-1"></i>{{ $ad->views_count ?? 0 }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $ads->links() }}
        </div>
    @else
        <div class="card p-12 text-center text-gray-500">
            <div class="w-20 h-20 rounded-full bg-emerald-500/10 flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-search text-emerald-400 text-3xl"></i>
            </div>
            <h4 class="font-bold text-lg mb-2">لا توجد نتائج</h4>
            <p class="text-sm mb-4">جرب البحث بكلمات مختلفة أو تعديل الفلاتر</p>
            <a href="{{ route('search') }}" class="btn-premium px-6 py-2 rounded-lg text-xs inline-block">
                إعادة ضبط البحث
            </a>
        </div>
    @endif
</div>
@endsection

```
---

