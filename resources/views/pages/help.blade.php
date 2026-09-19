@extends('layouts.app')

@section('title', 'مركز المساعدة')

@section('content')
<div style="background-color: #ffcccb; padding: 10px; border: 2px solid red; margin-bottom: 20px;">
    <h1 style="color: black; font-weight: bold; text-align: center;">هذا الملف هو: <code>resources/views/pages/help.blade.php</code></h1>
</div>
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <h1 class="text-3xl font-bold mb-8 text-center">مركز المساعدة</h1>

    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">كيف أضيف إعلان؟</h2>
            <p class="text-gray-700 leading-relaxed">
                يمكنك إضافة إعلان جديد بالضغط على زر "إضافة إعلان" في أعلى الصفحة. املأ البيانات المطلوبة مثل عنوان الإعلان، 
                الوصف، السعر، واختر الفئة المناسبة. بعد المراجعة سيتم نشر إعلانك خلال 24 ساعة.
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">كيف أتواصل مع البائع؟</h2>
            <p class="text-gray-700 leading-relaxed">
                يمكنك التواصل مع البائع من خلال نموذج التواصل في صفحة الإعلان. أدخل بياناتك وسيتم إرسال رسالتك للبائع مباشرة. 
                بعض البائعين يفضلون التواصل عبر واتساب أو الهاتف المباشر.
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">كيف أنشئ متجر؟</h2>
            <p class="text-gray-700 leading-relaxed">
                لإنشاء متجر، قم بتسجيل حساب كبائع (vendor) ثم املأ بيانات متجرك من لوحة التحكم. 
                المتجر الموثق يحصل على شارة التوثيق التي تزيد من ثقة المشترين.
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">ما هي الإعلانات المميزة؟</h2>
            <p class="text-gray-700 leading-relaxed">
                الإعلانات المميزة تظهر في مقدمة الموقع وتتمتع بمشاهدات أعلى. يقتصر عدد الإعلانات المميزة على 30 إعلان 
                في الصدر الرئيسي. يمكن للبائعين ترقية إعلاناتهم للتميز مقابل رسوم رمزية.
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">هل الخدمة مجانية؟</h2>
            <p class="text-gray-700 leading-relaxed">
                نعم، إضافة الإعلانات مجانية للجميع. ومع ذلك، يوجد حد أقصى 30 إعلان لكل بائع. 
                للحصول على ميزات إضافية مثل الإعلانات المميزة، قد تكون هناك رسوم رمزية.
            </p>
        </div>
    </div>

    <div class="mt-8 text-center">
        <p class="text-gray-500">لم تجد إجابة لسؤالك؟</p>
        <p class="text-gray-700">
            <i class="fas fa-envelope ml-2"></i>
            تواصل معنا: {{ \App\Models\Setting::get('contact_email', 'support@ouedkniss.clone') }}
        </p>
    </div>
</div>
@endsection
