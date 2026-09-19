<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * تحويل محتويات السلة إلى طلبات حقيقية
     */
    public function store(Request $request)
    {
        // 1. التحقق من البيانات الأساسية للشحن
        $request->validate([
            'phone' => 'required|string',
            'shipping_address' => 'required|string|min:10',
        ]);

        // 2. جلب محتويات السلة من الجلسة (Session)
        $cart = Session::get('trico_cart', []);

        if (empty($cart)) {
            return redirect()->route('ads.index')->with('error', 'سلتك فارغة حالياً!');
        }

        // 3. إنشاء طلب لكل عنصر في السلة
        foreach ($cart as $item) {
            Order::create([
                'buyer_id'         => Auth::id(),
                'listing_id'       => $item['id'],
                'seller_id'        => $item['seller_id'],
                'size'             => $item['size'],
                'color'            => $item['color'],
                'quantity'         => $item['quantity'],
                'total_price'      => $item['price'] * $item['quantity'],
                'phone'            => $request->phone,
                'shipping_address' => $request->shipping_address,
                'status'           => 'pending', // حالة الطلب الافتراضية
            ]);
        }

        // 4. إفراغ السلة بعد نجاح العملية
        Session::forget('trico_cart');

        return redirect()->route('dashboard')->with('success', 'تم إرسال طلباتك بنجاح! يمكنك متابعة الحالة من لوحة التحكم.');
    }

    /**
     * عرض مشتريات المستخدم الحالي (للمشتري)
     */
    public function index()
    {
        $orders = Order::where('buyer_id', Auth::id())
            ->with('listing')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }
}