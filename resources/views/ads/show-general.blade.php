@extends('layouts.app')

@section('title', $ad->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Image Gallery -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                @if($ad->images->count() > 0)
                    <div class="relative h-96">
                        <img src="{{ asset('storage/' . $ad->images->first()->image_path) }}" 
                             alt="{{ $ad->title }}" 
                             class="w-full h-full object-cover">
                        @if($ad->is_featured)
                            <span class="absolute top-4 right-4 bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                مميز
                            </span>
                        @endif
                    </div>
                    @if($ad->images->count() > 1)
                        <div class="grid grid-cols-4 gap-2 p-4">
                            @foreach($ad->images->skip(1)->take(4) as $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     alt="{{ $ad->title }}" 
                                     class="w-full h-20 object-cover rounded cursor-pointer hover:opacity-75">
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="h-96 bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-image text-6xl text-gray-400"></i>
                    </div>
                @endif
            </div>

            <!-- Product Details -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h1 class="text-2xl font-bold mb-2">{{ $ad->title }}</h1>
                        <p class="text-gray-600">{{ $ad->location }} - {{ $ad->city }}</p>
                    </div>
                    <div class="text-left">
                        <span class="text-3xl font-bold text-red-600 block">
                            {{ number_format($ad->price, 0) }} د.ج
                        </span>
                        @if($ad->is_negotiable)
                            <span class="text-green-600 text-sm">قابل للتفاوض</span>
                        @endif
                    </div>
                </div>

                <!-- Condition Badge -->
                <div class="flex gap-2 mb-4">
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($ad->condition === 'new') bg-green-100 text-green-800
                        @elseif($ad->condition === 'used') bg-yellow-100 text-yellow-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ $ad->condition === 'new' ? 'جديد' : ($ad->condition === 'used' ? 'مستعمل' : 'مجدد') }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        {{ $ad->category->name }}
                    </span>
                </div>

                <!-- Custom Attributes -->
                @if($ad->attributes->count() > 0)
                    <div class="border-t pt-4 mb-4">
                        <h3 class="text-lg font-bold mb-3">المواصفات</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($ad->attributes as $attribute)
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-sm text-gray-500">{{ $attribute->label }}</p>
                                    <p class="font-medium">{{ $attribute->pivot->value }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="border-t pt-4">
                    <h3 class="text-lg font-bold mb-2">الوصف</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $ad->description }}</p>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Contact Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">معلومات الاتصال</h3>
                
                @if($ad->show_contact_info)
                    @if($ad->contact_phone)
                        <a href="tel:{{ $ad->contact_phone }}" 
                           class="flex items-center justify-center w-full bg-blue-600 text-white py-3 rounded-lg mb-3 hover:bg-blue-700">
                            <i class="fas fa-phone ml-2"></i>
                            {{ $ad->contact_phone }}
                        </a>
                    @endif
                    
                    @if($ad->contact_whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ad->contact_whatsapp) }}" 
                           target="_blank"
                           class="flex items-center justify-center w-full bg-green-500 text-white py-3 rounded-lg mb-3 hover:bg-green-600">
                            <i class="fab fa-whatsapp ml-2"></i>
                            واتساب
                        </a>
                    @endif
                    
                    @if($ad->accept_offers)
                        <div class="mt-4 pt-4 border-t">
                            <livewire:contact-form :ad-id="$ad->id" type="offer" />
                        </div>
                    @else
                        <div class="mt-4 pt-4 border-t">
                            <livewire:contact-form :ad-id="$ad->id" type="inquiry" />
                        </div>
                    @endif
                @else
                    <div class="mt-4 pt-4 border-t">
                        <livewire:contact-form :ad-id="$ad->id" type="inquiry" />
                    </div>
                @endif
            </div>

            <!-- Seller Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-bold mb-4">المعلن</h3>
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center ml-3">
                        <i class="fas fa-user text-gray-600"></i>
                    </div>
                    <div>
                        <p class="font-bold">{{ $ad->user->name }}</p>
                        @if($ad->store)
                            <p class="text-sm text-gray-500">{{ $ad->store->name }}</p>
                            @if($ad->store->is_verified)
                                <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded">
                                    <i class="fas fa-check-circle"></i> موثق
                                </span>
                            @endif
                        @endif
                    </div>
                </div>
                <p class="text-sm text-gray-500">
                    <i class="fas fa-eye ml-1"></i>
                    {{ $ad->views_count }} مشاهدة
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    <i class="fas fa-clock ml-1"></i>
                    {{ $ad->created_at->diffForHumans() }}
                </p>
            </div>

            <!-- Safety Tips -->
            <div class="bg-yellow-50 rounded-lg p-4">
                <h4 class="font-bold text-yellow-800 mb-2">
                    <i class="fas fa-shield-alt"></i> نصائح السلامة
                </h4>
                <ul class="text-sm text-yellow-700 space-y-1">
                    <li>• قابل البائع في مكان عام</li>
                    <li>• افحص المنتج جيداً قبل الشراء</li>
                    <li>• لا ترسل أموال قبل استلام المنتج</li>
                    <li>• احتفظ بكل إيصالات التواصل</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
