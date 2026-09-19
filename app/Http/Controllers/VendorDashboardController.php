<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use Carbon\Carbon;

class VendorDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function index()
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return redirect()->route('dashboard')->with('error', 'ليس لديك متجر');
        }
        
        // Store stats
        $stats = [
            'total_ads' => $store->ads()->count(),
            'active_ads' => $store->ads()->where('status', 'active')->count(),
            'featured_ads' => $store->ads()->where('is_featured', true)->count(),
            'total_views' => $store->ads()->sum('views_count') ?? 0,
            'store_views' => $store->views_count ?? 0,
            'pending_ads' => $store->ads()->where('status', 'pending')->count(),
        ];
        
        // Recent store ads
        $recentAds = $store->ads()
            ->with('category', 'images')
            ->latest()
            ->take(10)
            ->get();
        
        return view('vendor.dashboard', compact('store', 'stats', 'recentAds'));
    }
    
    public function analytics()
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return redirect()->route('dashboard')->with('error', 'ليس لديك متجر');
        }
        
        // Monthly stats for charts
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyStats[] = [
                'month' => $month->format('M'),
                'ads' => $store->ads()
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
                'views' => $store->ads()
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('views_count') ?? 0,
            ];
        }
        
        // Top performing ads
        $topAds = $store->ads()
            ->where('status', 'active')
            ->orderByDesc('views_count')
            ->take(5)
            ->get();
        
        // Category breakdown
        $categoryStats = $store->ads()
            ->selectRaw('category_id, count(*) as count')
            ->with('category:id,name')
            ->groupBy('category_id')
            ->get();
        
        return view('vendor.analytics', compact('store', 'monthlyStats', 'topAds', 'categoryStats'));
    }
    
    public function manageAds()
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return redirect()->route('dashboard')->with('error', 'ليس لديك متجر');
        }
        
        $ads = $store->ads()
            ->with('category', 'images')
            ->latest()
            ->paginate(20);
        
        return view('vendor.ads-manage', compact('store', 'ads'));
    }
    
    public function storeSettings()
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return redirect()->route('dashboard')->with('error', 'ليس لديك متجر');
        }
        
        return view('vendor.store-settings', compact('store'));
    }
    
    public function updateStore(Request $request)
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return redirect()->route('dashboard')->with('error', 'ليس لديك متجر');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:stores,name,' . $store->id,
            'description' => 'nullable|string|max:1000',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'messenger' => 'nullable|string|max:50',
            'facebook' => 'nullable|string|max:100',
            'instagram' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'logo' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:5120',
        ]);
        
        $data = $validated;
        
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('stores/logos', 'public');
        }
        
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('stores/covers', 'public');
        }
        
        $store->update($data);
        
        return redirect()->route('vendor.store.settings')->with('success', 'تم تحديث إعدادات المتجر بنجاح');
    }
}
