@extends('layouts.dashboard')

@section('title', 'إعدادات المتجر')
@section('page-title', 'إعدادات المتجر')

@section('content')
    <form action="{{ route('vendor.store.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Main Settings -->
            <div class="lg:col-span-2 space-y-6">
                <div class="card p-6">
                    <h3 class="font-bold text-lg mb-6">معلومات المتجر الأساسية</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">اسم المتجر *</label>
                            <input type="text" name="name" value="{{ old('name', $store->name) }}" 
                                class="form-input w-full px-4 py-3 rounded-xl" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold mb-2">الوصف</label>
                            <textarea name="description" rows="4" class="form-input w-full px-4 py-3 rounded-xl" 
                                placeholder="وصف المتجر...">{{ old('description', $store->description) }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="card p-6">
                    <h3 class="font-bold text-lg mb-6">معلومات الاتصال</h3>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">رقم الهاتف</label>
                            <input type="tel" name="phone" value="{{ old('phone', $store->phone) }}" 
                                class="form-input w-full px-4 py-3 rounded-xl">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">واتساب</label>
                            <input type="tel" name="whatsapp" value="{{ old('whatsapp', $store->whatsapp) }}" 
                                class="form-input w-full px-4 py-3 rounded-xl">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">ماسنجر</label>
                            <input type="text" name="messenger" value="{{ old('messenger', $store->messenger) }}" 
                                class="form-input w-full px-4 py-3 rounded-xl">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">فيسبوك</label>
                            <input type="text" name="facebook" value="{{ old('facebook', $store->facebook) }}" 
                                class="form-input w-full px-4 py-3 rounded-xl" placeholder="رابط الصفحة">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">انستغرام</label>
                            <input type="text" name="instagram" value="{{ old('instagram', $store->instagram) }}" 
                                class="form-input w-full px-4 py-3 rounded-xl" placeholder="@username">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">الموقع الإلكتروني</label>
                            <input type="url" name="website" value="{{ old('website', $store->website) }}" 
                                class="form-input w-full px-4 py-3 rounded-xl" placeholder="https://...">
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">المدينة</label>
                            <input type="text" name="city" value="{{ old('city', $store->city) }}" 
                                class="form-input w-full px-4 py-3 rounded-xl">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">البلد</label>
                            <input type="text" name="country" value="{{ old('country', $store->country) }}" 
                                class="form-input w-full px-4 py-3 rounded-xl">
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="block text-sm font-bold mb-2">العنوان التفصيلي</label>
                        <textarea name="address" rows="2" class="form-input w-full px-4 py-3 rounded-xl">{{ old('address', $store->address) }}</textarea>
                    </div>
                </div>
            </div>
            
            <!-- Side Column -->
            <div class="space-y-6">
                <!-- Store Preview -->
                <div class="card p-6 text-center">
                    <h3 class="font-bold mb-4">صور المتجر</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm text-gray-500 mb-2">الشعار</label>
                        <div class="w-24 h-24 rounded-2xl bg-emerald-500/10 flex items-center justify-center mx-auto mb-2 overflow-hidden">
                            @if($store->logo)
                                <img src="{{ asset('storage/' . $store->logo) }}" alt="" class="w-full h-full object-cover" id="logo-preview">
                            @else
                                <i class="fa-solid fa-store text-emerald-400 text-3xl" id="logo-icon"></i>
                            @endif
                        </div>
                        <label class="cursor-pointer">
                            <span class="text-sm text-emerald-400 hover:text-emerald-300">تغيير الشعار</span>
                            <input type="file" name="logo" class="hidden" accept="image/*" onchange="previewLogo(this)">
                        </label>
                    </div>
                    
                    <div>
                        <label class="block text-sm text-gray-500 mb-2">صورة الغلاف</label>
                        <div class="aspect-video rounded-xl bg-emerald-500/10 flex items-center justify-center mb-2 overflow-hidden">
                            @if($store->cover_image)
                                <img src="{{ asset('storage/' . $store->cover_image) }}" alt="" class="w-full h-full object-cover" id="cover-preview">
                            @else
                                <i class="fa-solid fa-image text-emerald-400 text-3xl" id="cover-icon"></i>
                            @endif
                        </div>
                        <label class="cursor-pointer">
                            <span class="text-sm text-emerald-400 hover:text-emerald-300">تغيير الغلاف</span>
                            <input type="file" name="cover_image" class="hidden" accept="image/*" onchange="previewCover(this)">
                        </label>
                    </div>
                </div>
                
                <!-- Status -->
                <div class="card p-6">
                    <h3 class="font-bold mb-4">حالة المتجر</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">الحالة</span>
                            <span class="badge {{ $store->is_active ? 'badge-emerald' : 'badge-rose' }}">
                                {{ $store->is_active ? 'نشط' : 'معطل' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">التوثيق</span>
                            <span class="badge {{ $store->is_verified ? 'badge-emerald' : 'badge-amber' }}">
                                {{ $store->is_verified ? 'موثق' : 'غير موثق' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">تاريخ الإنشاء</span>
                            <span class="font-bold">{{ $store->created_at->format('Y/m/d') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Save Button -->
                <button type="submit" class="btn-premium w-full py-3 rounded-xl">
                    <i class="fa-solid fa-save mr-2"></i> حفظ التغييرات
                </button>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
<script>
function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('logo-preview');
            if (preview) {
                preview.src = e.target.result;
            } else {
                document.getElementById('logo-icon').outerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover" id="logo-preview">';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function previewCover(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('cover-preview');
            if (preview) {
                preview.src = e.target.result;
            } else {
                document.getElementById('cover-icon').outerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover" id="cover-preview">';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
