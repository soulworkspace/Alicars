<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad; // تأكد من اسم الموديل عندك Ad أو Listing
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    // عرض السلة
    public function index()
    {
        $cart = Session::get('trico_cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart.index', compact('cart', 'total'));
    }

    // إضافة منتج للسلة
    public function add(Request $request, $id)
    {
        $product = Ad::findOrFail($id);
        
        $cart = Session::get('trico_cart', []);

        // مفتاح فريد يجمع ID المنتج + المقاس + اللون (لمنع تداخل الخيارات)
        $cartKey = $id . '_' . $request->size . '_' . $request->color;

        if(isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += 1;
        } else {
            $cart[$cartKey] = [
                "id" => $id,
                "title" => $product->title,
                "quantity" => 1,
                "price" => $product->price,
                "size" => $request->size,
                "color" => $request->color,
                "seller_id" => $product->user_id,
                "image" => $product->images->first()->path ?? 'default.jpg'
            ];
        }

        Session::put('trico_cart', $cart);
        return redirect()->route('cart.index')->with('success', 'تمت الإضافة لسلة تريكو!');
    }

    // حذف منتج
    public function remove($key)
    {
        $cart = Session::get('trico_cart', []);
        if(isset($cart[$key])) {
            unset($cart[$key]);
            Session::put('trico_cart', $cart);
        }
        return back()->with('success', 'تم حذف القطعة');
    }
}