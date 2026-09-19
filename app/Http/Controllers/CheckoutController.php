<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * عرض صفحة إتمام الشراء
     */
    public function index(Request $request)
    {
        // التحقق من وجود معرف الإعلان
        $request->validate(['ad_id' => 'required|exists:ads,id']);

        $listing = Ad::findOrFail($request->ad_id);
        
        $selectedSize = $request->query('size', 'M');
        $selectedColor = $request->query('color', 'أسود');

        // تجهيز بيانات السلة في الجلسة
        $cart = [[
            'id'       => $listing->id,
            'title'    => $listing->title,
            'price'    => $listing->price,
            'size'     => $selectedSize,
            'color'    => $selectedColor,
            'image'    => $listing->images->where('is_primary', true)->first()->image_path ?? '',
            'quantity' => 1
        ]];

        session(['cart' => $cart]);

        return view('checkout.index', compact('cart'));
    }

    /**
     * حفظ الطلب في قاعدة البيانات
     */
    public function store(Request $request)
{
    // 1. التحقق من البيانات
    $request->validate([
        'phone'            => 'required|string|min:10|max:15',
        'city'             => 'required|string',
        'shipping_address' => 'required|string|min:10',
        'notes'            => 'nullable|string|max:500',
    ]);

    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->route('home')->with('error', 'السلة فارغة.');
    }

    DB::beginTransaction();

    try {
        foreach ($cart as $item) {
            // --- السطر الناقص كان هنا: جلب بيانات الإعلان من قاعدة البيانات ---
            $ad = \App\Models\Ad::findOrFail($item['id']); 

            \App\Models\Order::create([
                'buyer_id'         => Auth::id(),
                'listing_id'       => $ad->id,
                'seller_id'        => $ad->user_id, // الآن $ad معرف ولن يظهر الخطأ
                'size'             => $item['size'],
                'color'            => $item['color'],
                'quantity'         => $item['quantity'],
                'total_price'      => $ad->price * $item['quantity'],
                'status'           => 'pending',
                'phone'            => $request->phone,
                'city'             => $request->city,
                'shipping_address' => $request->shipping_address,
                'notes'            => $request->notes,
            ]);
        }

        DB::commit();
        session()->forget('cart');

        return redirect()->route('checkout.success');

    } catch (\Exception $e) {
        DB::rollback();
        \Illuminate\Support\Facades\Log::error('Checkout Error: ' . $e->getMessage());
        return redirect()->back()->withInput()->with('error', 'حدث خطأ: ' . $e->getMessage());
    }
}


    public function success()
    {
        return view('checkout.success');
    }

    /**
     * تحديث حالة الطلب (خاص بالبائع)
     */
    public function updateStatus(Request $request, Order $order)
    {
        // التحقق أن المستخدم الحالي هو البائع الفعلي لهذا الطلب
        if (Auth::id() !== $order->seller_id) {
            abort(403, 'غير مصرح لك بتعديل هذا الطلب.');
        }

        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'تم تحديث حالة الطلب بنجاح.');
    }

    /**
     * عرض طلبات المشتري (طلباتي)
     */
    public function myOrders()
    {
        $orders = Order::where('buyer_id', Auth::id())
            ->with(['listing' => function($q) {
                $q->withTrashed(); // لجلب البيانات حتى لو حُذف الإعلان
            }])
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * عرض طلبات الزبائن (لوحة البائع)
     */
    public function vendorOrders()
    {
        $orders = Order::where('seller_id', Auth::id())
            ->with(['listing' => function($q) {
                $q->withTrashed();
            }, 'buyer'])
            ->latest()
            ->get();

        return view('vendor.orders.index', compact('orders'));
    }
}