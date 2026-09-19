<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\Category;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // استخدام Eager Loading لتقليل الضغط على قاعدة البيانات
        $query = Ad::query()->with(['category', 'images', 'user', 'store'])
            ->where('status', 'active');

        // البحث النصي (العنوان، الوصف، المدينة)
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('city', 'like', "%{$searchTerm}%");
            });

            // إعطاء أولوية للنتائج التي تطابق العنوان
            $query->orderByRaw("CASE WHEN title LIKE ? THEN 1 ELSE 2 END", ["%{$searchTerm}%"]);
        }

        // الفلاتر
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        
        $query->when($request->min_price, fn($q) => $q->where('price', '>=', $request->min_price))
              ->when($request->max_price, fn($q) => $q->where('price', '<=', $request->max_price))
              ->when($request->condition, fn($q) => $q->where('condition', $request->condition))
              ->when($request->city, fn($q) => $q->where('city', $request->city));

        // الترتيب
        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'oldest' => $query->oldest(),
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            default => $query->latest(),
        };

        $ads = $query->paginate(24)->withQueryString();
        
        // جلب البيانات للقوائم المنسدلة
        $categories = Category::active()->root()->with('children')->get();
        $cities = Ad::where('status', 'active')->whereNotNull('city')->distinct()->pluck('city')->sort();

        return view('search.index', compact('ads', 'categories', 'cities'));
    }

    public function suggestions(Request $request)
    {
        $searchTerm = $request->q;
        if (strlen($searchTerm) < 2) return response()->json([]);

        return response()->json(
            Ad::where('status', 'active')
                ->where('title', 'like', "%{$searchTerm}%")
                ->select('title', 'slug')
                ->limit(6)
                ->get()
        );
    }
}