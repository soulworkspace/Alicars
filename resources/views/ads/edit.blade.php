@extends('layouts.dashboard') {{-- تأكد من مسار الـ layout الصحيح --}}

@section('title', 'تعديل الإعلان')
@section('page-title', 'تعديل الإعلان')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="card p-6 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-xl font-heavy text-white">تحرير: {{ $ad->title }}</h2>
            <p class="text-sm text-gray-400 mt-1">تحديث بيانات الإعلان والأسعار والموقع</p>
        </div>
        <a href="{{ route('ads.index') }}" class="sidebar-link !m-0 !py-2 bg-white/5 hover:bg-white/10 text-gray-300 text-sm">
            <i class="fa-solid fa-arrow-right ml-2"></i>
            رجوع للقائمة
        </a>
    </div>

    <form action="{{ route('ads.update', $ad->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="card p-8">
                    <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-emerald-500"></i>
                        المعلومات الأساسية
                    </h3>
                    
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-400 mb-2">عنوان الإعلان</label>
                            <input type="text" name="title" value="{{ old('title', $ad->title) }}" 
                                   class="form-input w-full p-3 rounded-lg" placeholder="مثال: سيارة مرسيدس للبيع...">
                            @error('title') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-400 mb-2">الوصف التفصيلي</label>
                            <textarea name="description" rows="8" 
                                      class="form-input w-full p-3 rounded-lg scrollbar-hide" 
                                      placeholder="اكتب تفاصيل المنتج بكل دقة...">{{ old('description', $ad->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card p-8">
                    <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-emerald-500"></i>
                        الموقع والتواصل
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-400 mb-2">المدينة / الولاية</label>
                            <input type="text" name="city" value="{{ old('city', $ad->city) }}" class="form-input w-full p-3 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-400 mb-2">رقم الهاتف</label>
                            <input type="text" name="contact_phone" value="{{ old('contact_phone', $ad->contact_phone) }}" class="form-input w-full p-3 rounded-lg text-left font-international">
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="card p-6 border-emerald-500/20">
                    <h3 class="text-md font-bold mb-4 text-emerald-400">التسعير</h3>
                    <div class="space-y-4">
                        <div class="relative">
                            <input type="number" name="price" value="{{ old('price', $ad->price) }}" 
                                   class="form-input w-full p-3 pl-12 rounded-lg font-international text-lg font-bold text-emerald-500">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-xs uppercase">DZD</span>
                        </div>
                        
                        <div class="flex items-center gap-3 p-3 bg-white/5 rounded-lg border border-white/5">
                            <input type="checkbox" name="is_negotiable" id="neg" value="1" {{ $ad->is_negotiable ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 bg-gray-700">
                            <label for="neg" class="text-sm text-gray-300">السعر قابل للتفاوض</label>
                        </div>
                    </div>
                </div>

                <div class="card p-6">
                    <h3 class="text-md font-bold mb-4 text-gray-300">الحالة</h3>
                    <select name="condition" class="form-input w-full p-3 rounded-lg text-sm mb-4">
                        <option value="new" {{ $ad->condition == 'new' ? 'selected' : '' }}>جديد (New)</option>
                        <option value="used" {{ $ad->condition == 'used' ? 'selected' : '' }}>مستعمل (Used)</option>
                    </select>

                    <div class="p-4 bg-emerald-500/5 rounded-lg border border-emerald-500/10 mb-6">
                        <div class="flex justify-between text-xs mb-1 text-gray-400">
                            <span>حالة النشر:</span>
                            <span class="badge {{ $ad->status == 'active' ? 'badge-emerald' : 'badge-amber' }}">
                                {{ $ad->status == 'active' ? 'نشط' : 'قيد المراجعة' }}
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn-premium w-full py-4 rounded-xl shadow-lg flex items-center justify-center gap-3">
                        <i class="fa-solid fa-cloud-arrow-up text-lg"></i>
                        تحديث الإعلان
                    </button>
                </div>

                <div class="p-4 bg-rose-500/5 border border-rose-500/10 rounded-xl text-center">
                    <p class="text-xs text-gray-500 mb-2">هل تريد حذف هذا الإعلان نهائياً؟</p>
                    <button type="button" class="text-rose-400 hover:text-rose-300 text-xs font-bold transition">
                        <i class="fa-solid fa-trash-can ml-1"></i> حذف الإعلان
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection