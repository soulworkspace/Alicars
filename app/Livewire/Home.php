<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Ad; // تأكد من استدعاء موديل الإعلانات
use App\Models\FeaturedAd; // إذا كان لديك جدول للمميزة

class Home extends Component
{
    public function render()
    {
        // جلب أحدث 4 إعلانات
        $recentAds = Ad::with('primaryImage')
            ->where('status', 'active')
            ->latest()
            ->take(4)
            ->get();

        // جلب الإعلانات المميزة
        $featuredAds = FeaturedAd::with('ad.primaryImage')
            ->where('is_active', true)
            ->get();

        return view('livewire.home', [
            'recentAds' => $recentAds,
            'featuredAds' => $featuredAds
        ])->layout('layouts.app'); // تأكيد استخدام الـ Layout الصحيح
    }
}