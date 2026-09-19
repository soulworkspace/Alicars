<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Listing;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. تجميع الإحصائيات الأساسية
        $stats = [
            'total_ads'         => $user->listings()->count(),
            'active_ads'        => $user->listings()->where('status', 'active')->count(),
            'total_views'       => $user->listings()->sum('views_count') ?? 0,
            'unread_messages'   => Message::where('receiver_id', $user->id)->whereNull('read_at')->count(),
            'favorites_count'   => $user->favorites()->count(),
            'new_orders_count'  => Order::where('seller_id', $user->id)->where('status', 'pending')->count(),
        ];

        // 2. جلب أحدث الإعلانات المضافة (المنتجات)
        $recentAds = $user->listings()
            ->with(['images'])
            ->latest()
            ->take(5)
            ->get();

        // 3. جلب أحدث مبيعات الملابس (TRICO Orders)
        $recentOrders = Order::where('seller_id', $user->id)
            ->with(['listing', 'buyer'])
            ->latest()
            ->take(5)
            ->get();

        // 4. جلب أحدث الرسائل
        $recentMessages = Message::where('receiver_id', $user->id)
            ->with('sender')
            ->latest()
            ->take(5)
            ->get();

        // 5. إحصائيات المتجر (إذا وُجد)
        $storeStats = null;
        if ($user->hasStore()) {
            $storeStats = [
                'store_views'   => $user->store->views_count ?? 0,
                'store_ads'     => $user->store->listings()->count(),
                'featured_ads'  => $user->store->listings()->where('is_featured', true)->count(),
            ];
        }

        return view('dashboard.index', compact('stats', 'recentAds', 'recentOrders', 'recentMessages', 'storeStats'));
    }
}