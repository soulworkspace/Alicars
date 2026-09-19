<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()
            ->favorites()
            ->with(['ad.category', 'ad.images', 'ad.user'])
            ->latest()
            ->paginate(20);
        
        // Group by category for better organization
        $groupedFavorites = $favorites->groupBy(function ($favorite) {
            return $favorite->ad->category?->name ?? 'عام';
        });
        
        return view('favorites.index', compact('favorites', 'groupedFavorites'));
    }
    
    public function store(Ad $ad)
    {
        $user = auth()->user();
        
        // Check if already favorited
        if ($user->favorites()->where('ad_id', $ad->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'الإعلان موجود بالفعل في المفضلة',
            ], 422);
        }
        
        $user->favorites()->create(['ad_id' => $ad->id]);
        
        return response()->json([
            'success' => true,
            'message' => 'تمت الإضافة إلى المفضلة',
        ]);
    }
    
    public function destroy(Ad $ad)
    {
        $user = auth()->user();
        
        $user->favorites()->where('ad_id', $ad->id)->delete();
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تمت الإزالة من المفضلة',
            ]);
        }
        
        return redirect()->route('favorites.index')->with('success', 'تمت الإزالة من المفضلة');
    }
}
