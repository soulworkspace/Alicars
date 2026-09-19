<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    public function index()
    {
        // استخدام withCount('ads') لجلب عدد الإعلانات بكفاءة عالية
        $stores = Store::where('is_active', true)
            ->withCount('ads') 
            ->latest()
            ->paginate(12); // 12 رقم مثالي لتقسيم الشبكة (3 أعمدة أو 4)

        return view('stores.index', compact('stores'));
    }

    public function show($slug)
    {
        // جلب المتجر مع الإعلانات وصورها الأساسية في استعلام واحد
        $store = Store::where('slug', $slug)
            ->withCount('ads')
            ->with(['user', 'ads' => function ($query) {
                $query->active()
                      ->with('primaryImage') // تأكد من تحميل الصورة الأساسية لتجنب البطء
                      ->latest();
            }])
            ->firstOrFail();

        return view('stores.show', compact('store'));
    }
}