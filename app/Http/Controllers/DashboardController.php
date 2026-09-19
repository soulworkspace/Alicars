<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use App\Models\Message;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * الصفحة الرئيسية للوحة التحكم
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. الإحصائيات العامة (Stats)
        $stats = [
            'total_ads' => $user->ads()->count(),
            'active_ads' => $user->ads()->where('status', 'active')->count(),
            'pending_ads' => $user->ads()->where('status', 'pending')->count(),
            'total_views' => $user->ads()->sum('views_count') ?? 0,
            'unread_messages' => $user->messages()->whereNull('read_at')->count(),
            'favorites_count' => $user->favorites()->count() ?? 0,
            
            // طلبات Trico المعلقة التي وصلت للبائع
            'new_orders_count' => Order::where('seller_id', $user->id)
                                    ->where('status', 'pending')
                                    ->count(),
        ];

        // 2. أحدث الإعلانات (Recent Ads)
        $recentAds = $user->ads()
            ->with(['category', 'images'])
            ->latest()
            ->take(5)
            ->get();

        // 3. أحدث الرسائل غير المقروءة (Unread Messages)
        $recentMessages = $user->messages()
            ->with(['sender', 'ad'])
            ->whereNull('read_at')
            ->latest()
            ->take(5)
            ->get();

        // 4. أحدث الطلبات المستلمة (Recent Orders)
        $recentOrders = Order::where('seller_id', $user->id)
            ->with(['listing', 'buyer'])
            ->latest()
            ->take(5)
            ->get();

        // 5. سجل النشاط الأخير (Recent Activity)
        $activity = $this->getRecentActivity($user);

        // 6. إحصائيات المتجر (في حال كان المستخدم "تاجر" ولديه متجر)
        $storeStats = null;
        if ($user->hasStore()) {
            $storeStats = [
                'store_views' => $user->store->views_count ?? 0,
                'store_ads' => $user->store->ads()->count(),
                'featured_ads' => $user->store->ads()->where('is_featured', true)->count(),
            ];
        }

        return view('dashboard.index', compact(
            'stats',
            'recentAds',
            'recentMessages',
            'recentOrders',
            'activity',
            'storeStats'
        ));
    }

    /**
     * صفحة الإحصائيات التفصيلية والرسوم البيانية
     */
    public function stats()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // جلب إحصائيات آخر 6 أشهر للرسوم البيانية
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyStats[] = [
                'month' => $month->format('M'),
                'ads' => $user->ads()
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
                'views' => $user->ads()
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->sum('views_count') ?? 0,
            ];
        }

        // توزيع الإعلانات حسب التصنيفات
        $categoryStats = $user->ads()
            ->selectRaw('category_id, count(*) as count')
            ->with('category:id,name')
            ->groupBy('category_id')
            ->get();

        return view('dashboard.stats', compact('monthlyStats', 'categoryStats'));
    }

    /**
     * عرض سجل النشاط الكامل
     */
    public function activity()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $activities = $this->getRecentActivity($user, 50);

        return view('dashboard.activity', compact('activities'));
    }

    /**
     * منطق جلب وترتيب النشاطات (إعلانات، رسائل، إلخ)
     */
    private function getRecentActivity($user, $limit = 10)
    {
        $activities = [];

        // تحويل أحدث الإعلانات إلى نشاطات
        $ads = $user->ads()
            ->select('id', 'title', 'slug', 'status', 'created_at')
            ->latest()
            ->take($limit)
            ->get();

        foreach ($ads as $ad) {
            $activities[] = [
                'type' => 'ad',
                'title' => $ad->title,
                'status' => $ad->status,
                'date' => $ad->created_at,
                'url' => route('ads.show', $ad->slug),
            ];
        }

        // تحويل أحدث الرسائل إلى نشاطات
        $messages = $user->messages()
            ->with('sender')
            ->latest()
            ->take($limit)
            ->get();

        foreach ($messages as $message) {
            $activities[] = [
                'type' => 'message',
                'title' => 'رسالة من ' . ($message->sender->name ?? 'مستخدم'),
                'status' => $message->read_at ? 'read' : 'unread',
                'date' => $message->created_at,
                'url' => route('messages.index'),
            ];
        }

        // ترتيب كافة النشاطات تنازلياً حسب التاريخ
        usort($activities, function ($a, $b) {
            return $b['date'] <=> $a['date'];
        });

        return array_slice($activities, 0, $limit);
    }
}