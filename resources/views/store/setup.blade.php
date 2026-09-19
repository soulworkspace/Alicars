@extends('layouts.dashboard')

@section('title', 'إنشاء متجر جديد')
@section('page-title', 'إنشاء متجر جديد')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Progress Steps -->
        <div class="flex items-center justify-center mb-8">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center text-black font-bold text-sm" id="step1-indicator">1</div>
                    <span class="text-sm font-bold">المعلومات الأساسية</span>
                </div>
                <div class="w-12 h-0.5 bg-gray-700" id="step1-2-line"></div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center text-gray-400 font-bold text-sm" id="step2-indicator">2</div>
                    <span class="text-sm text-gray-500">صور المتجر</span>
                </div>
                <div class="w-12 h-0.5 bg-gray-700" id="step2-3-line"></div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center text-gray-400 font-bold text-sm" id="step3-indicator">3</div>
                    <span class="text-sm text-gray-500">معلومات الاتصال</span>
                </div>
            </div>
        </div>
        
        <!-- Step 1: Basic Info -->
        <div id="step1" class="card p-6">
            <h3 class="font-bold text-lg mb-6">معلومات المتجر الأساسية</h3>
            
            <form id="step1-form">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold mb-2">اسم المتجر *</label>
                        <input type="text" name="name" id="store-name" 
                            class="form-input w-full px-4 py-3 rounded-xl" 
                            placeholder="مثال: متجر الأزياء الفاخرة" required>
                        <p class="text-xs text-gray-500 mt-1">اسم فريد يميز متجرك</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-2">وصف المتجر</label>
                        <textarea name="description" rows="4" 
                            class="form-input w-full px-4 py-3 rounded-xl"
                            placeholder="اكتب وصفاً جذاباً لمتجرك وما يميزه..."></textarea>
                    </div>
                </div>
                
                <div class="mt-6">
                    <button type="submit" class="btn-premium w-full py-3 rounded-xl">
                        التالي <i class="fa-solid fa-arrow-left mr-2"></i>
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Step 2: Branding -->
        <div id="step2" class="card p-6 hidden">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-bold text-lg">صور المتجر</h3>
                <button onclick="goToStep(1)" class="text-sm text-gray-500 hover:text-white">
                    <i class="fa-solid fa-arrow-right mr-1"></i> السابق
                </button>
            </div>
            
            <form id="step2-form">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold mb-2">شعار المتجر</label>
                        <div class="border-2 border-dashed border-white/20 rounded-xl p-8 text-center hover:border-emerald-500/50 transition-colors">
                            <input type="file" name="logo" id="logo-input" accept="image/*" class="hidden">
                            <label for="logo-input" class="cursor-pointer">
                                <div class="w-20 h-20 rounded-full bg-emerald-500/10 flex items-center justify-center mx-auto mb-4 overflow-hidden" id="logo-preview">
                                    <i class="fa-solid fa-camera text-emerald-400 text-2xl"></i>
                                </div>
                                <p class="text-sm text-gray-400">اضغط لرفع شعار المتجر</p>
                                <p class="text-xs text-gray-600 mt-1">الحجم المفضل: 400x400 بكسل</p>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-2">صورة الغلاف</label>
                        <div class="border-2 border-dashed border-white/20 rounded-xl p-8 text-center hover:border-emerald-500/50 transition-colors">
                            <input type="file" name="cover_image" id="cover-input" accept="image/*" class="hidden">
                            <label for="cover-input" class="cursor-pointer">
                                <div class="aspect-video bg-emerald-500/10 rounded-lg flex items-center justify-center mb-4 overflow-hidden" id="cover-preview">
                                    <i class="fa-solid fa-image text-emerald-400 text-3xl"></i>
                                </div>
                                <p class="text-sm text-gray-400">اضغط لرفع صورة الغلاف</p>
                                <p class="text-xs text-gray-600 mt-1">الحجم المفضل: 1200x400 بكسل</p>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex gap-3">
                    <button type="button" onclick="goToStep(3)" class="flex-1 btn-outline py-3 rounded-xl">
                        تخطي
                    </button>
                    <button type="submit" class="flex-1 btn-premium py-3 rounded-xl">
                        التالي <i class="fa-solid fa-arrow-left mr-2"></i>
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Step 3: Contact -->
        <div id="step3" class="card p-6 hidden">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-bold text-lg">معلومات الاتصال</h3>
                <button onclick="goToStep(2)" class="text-sm text-gray-500 hover:text-white">
                    <i class="fa-solid fa-arrow-right mr-1"></i> السابق
                </button>
            </div>
            
            <form id="step3-form">
                @csrf
                
                <div class="space-y-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">رقم الهاتف</label>
                            <input type="tel" name="phone" class="form-input w-full px-4 py-3 rounded-xl">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">واتساب</label>
                            <input type="tel" name="whatsapp" class="form-input w-full px-4 py-3 rounded-xl">
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">فيسبوك</label>
                            <input type="text" name="facebook" class="form-input w-full px-4 py-3 rounded-xl" placeholder="رابط الصفحة">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">انستغرام</label>
                            <input type="text" name="instagram" class="form-input w-full px-4 py-3 rounded-xl" placeholder="@username">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-2">الموقع الإلكتروني</label>
                        <input type="url" name="website" class="form-input w-full px-4 py-3 rounded-xl" placeholder="https://...">
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold mb-2">المدينة</label>
                            <input type="text" name="city" class="form-input w-full px-4 py-3 rounded-xl">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2">البلد</label>
                            <input type="text" name="country" value="الجزائر" class="form-input w-full px-4 py-3 rounded-xl">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold mb-2">العنوان</label>
                        <textarea name="address" rows="2" class="form-input w-full px-4 py-3 rounded-xl"></textarea>
                    </div>
                </div>
                
                <div class="mt-6">
                    <button type="submit" class="btn-premium w-full py-3 rounded-xl">
                        <i class="fa-solid fa-check mr-2"></i> إنشاء المتجر
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Success -->
        <div id="success" class="card p-8 text-center hidden">
            <div class="w-20 h-20 rounded-full bg-emerald-500/20 flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-check text-emerald-400 text-3xl"></i>
            </div>
            <h3 class="font-bold text-2xl mb-2">تم إنشاء المتجر بنجاح!</h3>
            <p class="text-gray-400 mb-6">متجرك جاهز الآن لاستقبال العملاء</p>
            <div class="flex gap-3 justify-center">
                <a href="{{ route('vendor.dashboard') }}" class="btn-premium px-6 py-3 rounded-xl">
                    لوحة المتجر
                </a>
                <a href="{{ route('ads.create') }}" class="btn-outline px-6 py-3 rounded-xl">
                    إضافة إعلان
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
let currentStep = 1;
let storeCreated = false;

function goToStep(step) {
    document.getElementById('step1').classList.add('hidden');
    document.getElementById('step2').classList.add('hidden');
    document.getElementById('step3').classList.add('hidden');
    document.getElementById('step' + step).classList.remove('hidden');
    
    // Update indicators
    document.getElementById('step1-indicator').className = 'w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm ' + (step >= 1 ? 'bg-emerald-500 text-black' : 'bg-gray-700 text-gray-400');
    document.getElementById('step2-indicator').className = 'w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm ' + (step >= 2 ? 'bg-emerald-500 text-black' : 'bg-gray-700 text-gray-400');
    document.getElementById('step3-indicator').className = 'w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm ' + (step >= 3 ? 'bg-emerald-500 text-black' : 'bg-gray-700 text-gray-400');
    
    currentStep = step;
}

// Step 1: Basic Info
document.getElementById('step1-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('{{ route('store.setup.basic') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            storeCreated = true;
            goToStep(2);
        } else {
            alert(data.message || 'حدث خطأ');
        }
    });
});

// Step 2: Branding
document.getElementById('step2-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('{{ route('store.setup.branding') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        goToStep(3);
    });
});

// Step 3: Contact
document.getElementById('step3-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('{{ route('store.setup.contact') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('step3').classList.add('hidden');
        document.getElementById('success').classList.remove('hidden');
    });
});

// Image previews
document.getElementById('logo-input').addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('logo-preview').innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover">';
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});

document.getElementById('cover-input').addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('cover-preview').innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover">';
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});
</script>
@endsection
