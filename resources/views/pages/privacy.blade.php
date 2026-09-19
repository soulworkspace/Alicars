@extends('layouts.app')

@section('title', 'سياسة الخصوصية')

@section('content')
<div style="background-color: #cce5ff; padding: 10px; border: 2px solid #007bff; margin-bottom: 20px;">
    <h1 style="color: black; font-weight: bold; text-align: center;">هذا الملف هو: <code>resources/views/pages/privacy.blade.php</code></h1>
</div>
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <h1 class="text-3xl font-bold mb-8 text-center">سياسة الخصوصية</h1>

    <div class="bg-white rounded-lg shadow-md p-8 space-y-6">
        <section>
            <h2 class="text-xl font-bold mb-3">1. جمع المعلومات</h2>
            <p class="text-gray-700 leading-relaxed">
                نقوم بجمع المعلومات التي تقدمها لنا مباشرة عند التسجيل (الاسم، البريد الإلكتروني، رقم الهاتف). 
                كما نجمع معلومات الإعلانات التي تنشرها على الموقع.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold mb-3">2. استخدام المعلومات</h2>
            <p class="text-gray-700 leading-relaxed">
                نستخدم معلوماتك لتشغيل الموقع وتحسين الخدمات. قد نستخدم بريدك الإلكتروني لإرسال إشعارات هامة 
                حول حسابك أو الإعلانات.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold mb-3">3. مشاركة المعلومات</h2>
            <p class="text-gray-700 leading-relaxed">
                عند نشر إعلان، يتم عرض معلومات الاتصال التي تختارها للمشترين المحتملين. 
                لا نشارك معلوماتك الشخصية مع أطراف ثالثة دون إذنك.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold mb-3">4. ملفات الكوكيز</h2>
            <p class="text-gray-700 leading-relaxed">
                نستخدم ملفات الكوكيز لتحسين تجربة المستخدم. يمكنك تعطيل الكوكيز من إعدادات المتصفح، 
                ولكن قد يؤثر ذلك على بعض وظائف الموقع.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold mb-3">5. حماية البيانات</h2>
            <p class="text-gray-700 leading-relaxed">
                نتخذ إجراءات أمنية لحماية معلوماتك من الوصول غير المصرح به أو التعديل أو الكشف.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold mb-3">6. حقوقك</h2>
            <p class="text-gray-700 leading-relaxed">
                يحق لك الوصول إلى معلوماتك الشخصية وتعديلها أو حذفها. للاستفسارات، تواصل معنا على:
                {{ \App\Models\Setting::get('contact_email', 'support@ouedkniss.clone') }}
            </p>
        </section>
    </div>
</div>
@endsection
