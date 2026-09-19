@extends('layouts.app')

@section('title', 'نصائح السلامة')

@section('content')
<div style="background-color: #fff3cd; padding: 10px; border: 2px solid #ffc107; margin-bottom: 20px;">
    <h1 style="color: black; font-weight: bold; text-align: center;">هذا الملف هو: <code>resources/views/pages/safety.blade.php</code></h1>
</div>
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <h1 class="text-3xl font-bold mb-8 text-center">نصائح السلامة</h1>

    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
        <p class="text-yellow-800 text-center font-medium">
            <i class="fas fa-exclamation-triangle ml-2"></i>
            أمانك يهمنا! اتبع هذه النصائح للتعامل الآمن على الموقع
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-handshake text-green-600 text-xl"></i>
                </div>
                <h2 class="text-lg font-bold">عند اللقاء</h2>
            </div>
            <ul class="space-y-2 text-gray-700">
                <li><i class="fas fa-check text-green-500 ml-2"></i> قابل البائع في مكان عام</li>
                <li><i class="fas fa-check text-green-500 ml-2"></i> احضر صديقاً معك إن أمكن</li>
                <li><i class="fas fa-check text-green-500 ml-2"></i> أخبر عائلتك بمكان اللقاء</li>
                <li><i class="fas fa-check text-green-500 ml-2"></i> التقِ خلال النهار في مكان مزدحم</li>
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-search text-blue-600 text-xl"></i>
                </div>
                <h2 class="text-lg font-bold">فحص المنتج</h2>
            </div>
            <ul class="space-y-2 text-gray-700">
                <li><i class="fas fa-check text-blue-500 ml-2"></i> افحص المنتج جيداً قبل الدفع</li>
                <li><i class="fas fa-check text-blue-500 ml-2"></i> تأكد من عمل المنتج كاملاً</li>
                <li><i class="fas fa-check text-blue-500 ml-2"></i> اطلب فاتورة أو إيصال</li>
                <li><i class="fas fa-check text-blue-500 ml-2"></i> لا تدفع قبل رؤية المنتج</li>
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-red-600 text-xl"></i>
                </div>
                <h2 class="text-lg font-bold">عند الدفع</h2>
            </div>
            <ul class="space-y-2 text-gray-700">
                <li><i class="fas fa-times text-red-500 ml-2"></i> لا ترسل أموال قبل استلام المنتج</li>
                <li><i class="fas fa-times text-red-500 ml-2"></i> تجنب التحويلات البنكية المسبقة</li>
                <li><i class="fas fa-check text-green-500 ml-2"></i> ادفع نقداً عند الاستلام</li>
                <li><i class="fas fa-check text-green-500 ml-2"></i> احتفظ بإيصال الدفع</li>
            </ul>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-shield-alt text-purple-600 text-xl"></i>
                </div>
                <h2 class="text-lg font-bold">حماية بياناتك</h2>
            </div>
            <ul class="space-y-2 text-gray-700">
                <li><i class="fas fa-check text-purple-500 ml-2"></i> لا تشارك معلوماتك البنكية</li>
                <li><i class="fas fa-check text-purple-500 ml-2"></i> احتفظ بكل إيصالات التواصل</li>
                <li><i class="fas fa-check text-purple-500 ml-2"></i> بلغ عن أي سلوك مشبوه</li>
                <li><i class="fas fa-check text-purple-500 ml-2"></i> استخدم التواصل داخل الموقع</li>
            </ul>
        </div>
    </div>

    <div class="mt-8 bg-red-50 border border-red-200 rounded-lg p-6">
        <h2 class="text-xl font-bold text-red-800 mb-3">
            <i class="fas fa-exclamation-circle ml-2"></i> تنبيهات هامة
        </h2>
        <ul class="space-y-2 text-red-700">
            <li>• تجنب العروض التي تبدو جيدة بشكل غير واقعي</li>
            <li>• لا ترسل أموال عبر خدمات تحويل الأموال للأشخاص الذين لم تقابلهم</li>
            <li>• احذر من الطلبات غير المبررة لإرسال مبالغ صغيرة "للتأكد"</li>
            <li>• إذا شعرت بشيء غير صحيح، انسحب من الصفقة</li>
        </ul>
    </div>

    <div class="mt-8 text-center">
        <p class="text-gray-500 mb-2">هل واجهت مشكلة أو تريد الإبلاغ عن مستخدم؟</p>
        <a href="mailto:{{ \App\Models\Setting::get('contact_email', 'support@ouedkniss.clone') }}" 
           class="text-red-600 font-medium hover:underline">
            <i class="fas fa-envelope ml-2"></i> تواصل مع فريق الأمان
        </a>
    </div>
</div>
@endsection
