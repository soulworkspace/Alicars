@extends('layouts.app')

@section('title', 'لوحة تحكم المتجر')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">لوحة تحكم المتجر</h1>

    @if(auth()->user()->store)
        <!-- Store Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">إجمالي الإعلانات</p>
                        <p class="text-3xl font-bold">{{ auth()->user()->store->ads()->count() }}</p>
                    </div>
                    <i class="fas fa-ad text-3xl text-blue-500"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">الإعلانات النشطة</p>
                        <p class="text-3xl font-bold">{{ auth()->user()->store->ads()->active()->count() }}</p>
                    </div>
                    <i class="fas fa-check-circle text-3xl text-green-500"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">إجمالي المشاهدات</p>
                        <p class="text-3xl font-bold">{{ auth()->user()->store->ads()->sum('views_count') }}</p>
                    </div>
                    <i class="fas fa-eye text-3xl text-purple-500"></i>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">الرسائل الجديدة</p>
                        <p class="text-3xl font-bold">0</p>
                    </div>
                    <i class="fas fa-envelope text-3xl text-yellow-500"></i>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="font-bold text-lg mb-4">إجراءات سريعة</h3>
            <div class="flex gap-4">
                <a href="{{ route('ads.create') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700">
                    <i class="fas fa-plus ml-2"></i> إضافة إعلان
                </a>
                <a href="{{ route('my-ads') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                    <i class="fas fa-list ml-2"></i> إدارة الإعلانات
                </a>
                <a href="#" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
                    <i class="fas fa-users ml-2"></i> إدارة الخدامة
                </a>
            </div>
        </div>

        <!-- Store Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="font-bold text-lg mb-4 border-b pb-2">معلومات المتجر</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">اسم المتجر</label>
                    <input type="text" value="{{ auth()->user()->store->name }}" disabled
                           class="w-full border-gray-300 rounded-lg bg-gray-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">الحالة</label>
                    <span class="inline-block px-3 py-1 rounded text-sm font-medium
                        @if(auth()->user()->store->is_verified) bg-green-100 text-green-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ auth()->user()->store->is_verified ? 'موثق' : 'غير موثق' }}
                    </span>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg shadow-md">
            <i class="fas fa-store text-gray-400 text-6xl mb-4"></i>
            <h3 class="text-xl font-bold text-gray-600 mb-2">لا يوجد متجر</h3>
            <p class="text-gray-500 mb-4">يمكنك إنشاء متجر لعرض إعلاناتك بشكل احترافي</p>
            <a href="#" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700">
                إنشاء متجر
            </a>
        </div>
    @endif
</div>
@endsection
