@extends('layouts.app')

@section('title', 'الشروط والأحكام')

@section('content')
<div style="background-color: #d4edda; padding: 10px; border: 2px solid #28a745; margin-bottom: 20px;">
    <h1 style="color: black; font-weight: bold; text-align: center;">هذا الملف هو: <code>resources/views/pages/terms.blade.php</code></h1>
</div>
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <h1 class="text-3xl font-bold mb-8 text-center">الشروط والأحكام</h1>

    <div class="bg-white rounded-lg shadow-md p-8 space-y-6">
        <section>
            <h2 class="text-xl font-bold mb-3">1. قبول الشروط</h2>
            <p class="text-gray-700 leading-relaxed">
                باستخدامك لموقع OuedKniss Clone، فإنك توافق على هذه الشروط والأحكام. إذا كنت لا توافق على أي جزء من هذه الشروط، 
                يجب عليك عدم استخدام الموقع.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold mb-3">2. استخدام الموقع</h2>
            <p class="text-gray-700 leading-relaxed">
                يُسمح باستخدام الموقع لأغراض قانونية فقط. يُحظر استخدام الموقع لنشر أي محتوى غير قانوني أو مضلل أو ضار.
                يُحظر أيضاً استخدام الموقع لأغراض الاحتيال أو التلاعب.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold mb-3">3. الإعلانات</h2>
            <p class="text-gray-700 leading-relaxed">
                يجب أن تكون جميع الإعلانات دقيقة وصحيحة. يحق للإدارة مراجعة أي إعلان ورفضه دون إبداء أسباب. 
                يُحظر نشر نفس الإعلان أكثر من مرة. الحد الأقصى للإعلانات لكل مستخدم هو 30 إعلان.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold mb-3">4. المسؤولية</h2>
            <p class="text-gray-700 leading-relaxed">
                الموقع لا يتحمل مسؤولية أي صفقات تتم بين المستخدمين. المشترون والبائعون مسؤولون عن التحقق من جودة المنتجات 
                وإتمام الصفقات بشكل آمن.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold mb-3">5. حقوق الملكية</h2>
            <p class="text-gray-700 leading-relaxed">
                جميع حقوق الملكية الفكرية للموقع محفوظة. يُحظر نسخ أو إعادة نشر أي محتوى من الموقع دون إذن مسبق.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold mb-3">6. التعديلات</h2>
            <p class="text-gray-700 leading-relaxed">
                نحتفظ بالحق في تعديل هذه الشروط في أي وقت. سيتم إخطار المستخدمين بأي تغييرات جوهرية.
            </p>
        </section>

        <section>
            <h2 class="text-xl font-bold mb-3">7. التواصل</h2>
            <p class="text-gray-700 leading-relaxed">
                للاستفسارات حول هذه الشروط، يرجى التواصل معنا على: 
                {{ \App\Models\Setting::get('contact_email', 'support@ouedkniss.clone') }}
            </p>
        </section>
    </div>
</div>
@endsection
