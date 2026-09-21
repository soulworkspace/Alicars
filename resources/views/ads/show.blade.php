@extends('layouts.app')

@section('title', $ad->title . ' | Hadj Aissa ai')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
{{-- الحاوية الرئيسية: خلفيات محايدة تتغير بسلاسة مع تحسين المسافات المتجاوبة --}}
<div class="bg-zinc-50 dark:bg-[#0c0c0e] min-h-screen text-right pb-24 md:pb-32 transition-colors duration-500 ease-in-out font-sans overflow-x-hidden" dir="rtl">
    
    {{-- Navbar Space Offset --}}
    <div class="h-14 md:h-20"></div>

    {{-- Breadcrumbs & Top Bar: تصميم زجاجي متكيف --}}
    <div class="sticky top-0 z-40 border-b border-zinc-200 dark:border-zinc-800 bg-white/80 dark:bg-[#0c0c0e]/80 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 md:py-4 flex justify-between items-center">
            <nav class="flex items-center gap-2 sm:gap-3 text-[9px] sm:text-[10px] font-bold text-zinc-400 dark:text-zinc-500 tracking-widest uppercase overflow-hidden whitespace-nowrap">
                <a href="/" class="hover:text-emerald-500 transition-colors flex-shrink-0">الرئيسية</a>
                <span class="opacity-35 flex-shrink-0">/</span>
                <span class="text-zinc-800 dark:text-zinc-200 truncate">{{ Str::limit($ad->title, 20) }}</span>
            </nav>
            
            <div class="hidden md:flex gap-6 items-center flex-shrink-0">
                <div class="flex items-center gap-2 text-zinc-500 dark:text-zinc-400">
                    <i class="far fa-eye text-emerald-500 text-[10px]"></i>
                    <span class="text-[10px] font-black uppercase">{{ $ad->views_count ?? 0 }} مشاهدة</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 md:py-12 lg:px-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-20">
            
            {{-- الجانب الأيمن: معرض الصور (متجاوب تماماً) --}}
            <div class="lg:col-span-7">
                <div class="lg:sticky lg:top-28 space-y-4 md:space-y-6">
                    {{-- الإطار الرئيسي للمركبة --}}
                    <div class="relative overflow-hidden rounded-2xl md:rounded-[2.5rem] bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm">
                        @php
                            $primaryImage = $ad->images?->where('is_primary', true)->first() ?? $ad->images?->first();
                            $mainUrl = $primaryImage ? asset('storage/' . $primaryImage->image_path) : 'https://via.placeholder.com/800x1000';
                            
                            $adAttributes = $ad->relationLoaded('attributes') ? $ad->attributes : ($ad->getRelation('attributes') ?: $ad->attributes()->get());
                        @endphp
                        <img src="{{ $mainUrl }}" id="mainHeroImage" class="w-full aspect-[4/3] sm:aspect-[4/5] object-cover transition-transform duration-700 hover:scale-105">
                        
                        {{-- حالة المركبة --}}
                        <div class="absolute top-4 sm:top-8 left-4 sm:left-8">
                            <span class="bg-zinc-900/90 dark:bg-zinc-100/90 backdrop-blur text-white dark:text-zinc-900 px-3 sm:px-5 py-1.5 sm:py-2 text-[8px] sm:text-[9px] font-black uppercase tracking-widest rounded-full shadow-xl">
                                {{ $ad->condition == 'new' ? 'جديدة تماماً (أصفار)' : 'مستعملة' }}
                            </span>
                        </div>
                    </div>

                    {{-- المصغرات --}}
                    @if($ad->images && $ad->images->count() > 1)
                    <div class="flex gap-3 sm:gap-4 overflow-x-auto no-scrollbar py-2">
                        @foreach($ad->images as $img)
                        <button onclick="document.getElementById('mainHeroImage').src='{{ asset('storage/' . $img->image_path) }}'" 
                             class="flex-shrink-0 w-16 sm:w-20 aspect-[3/4] rounded-xl sm:rounded-2xl overflow-hidden border-2 border-transparent focus:border-emerald-500 transition-all bg-white dark:bg-zinc-900 shadow-sm">
                            <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- الجانب الأيسر: التفاصيل (تخطيط متجاوب مرن) --}}
            <div class="lg:col-span-5">
                <div class="flex flex-col space-y-8 md:space-y-10">
                    
                    {{-- العنوان والسعر --}}
                    <div class="space-y-3 md:space-y-4">
                        <span class="text-emerald-600 dark:text-emerald-400 text-[10px] font-black uppercase tracking-[0.2em]">
                            {{ $ad->category?->name ?? 'مركبة مميزة' }}
                        </span>
                        <h1 class="text-2xl sm:text-3xl lg:text-5xl font-black text-zinc-900 dark:text-zinc-50 leading-snug sm:leading-tight tracking-tight">
                            {{ $ad->title }}
                        </h1>
                        <div class="flex items-baseline gap-2 pt-2 md:pt-4">
                            <span class="text-3xl sm:text-4xl lg:text-5xl font-black text-zinc-900 dark:text-zinc-50 tracking-tighter italic">
                                {{ number_format($ad->price, 0, '.', ' ') }}
                            </span>
                            <span class="text-emerald-600 dark:text-emerald-400 font-bold text-xs sm:text-sm uppercase">DA</span>
                        </div>
                    </div>

                    {{-- بطاقة البائع (المعرض أو المالك) --}}
                    <div class="p-4 sm:p-6 rounded-2xl md:rounded-[2rem] bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 flex items-center justify-between shadow-sm group hover:border-emerald-500/50 transition-colors">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl overflow-hidden bg-zinc-100 dark:bg-zinc-800 flex-shrink-0">
                                <img src="{{ $ad->user?->store?->logo ?? 'https://ui-avatars.com/api/?name='.urlencode($ad->user?->name ?? 'MB') }}" class="w-full h-full object-cover">
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-zinc-900 dark:text-zinc-100 font-black text-xs sm:text-sm tracking-tight truncate">{{ $ad->user?->store?->name ?? $ad->user?->name ?? 'MB Motors' }}</h4>
                                <p class="text-[9px] sm:text-[10px] text-zinc-500 dark:text-zinc-500 font-bold uppercase mt-0.5 sm:mt-1">معرض معتمد وموثوق</p>
                            </div>
                        </div>
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center text-zinc-400 group-hover:bg-emerald-500 group-hover:text-white transition-all italic text-xs flex-shrink-0">
                            <i class="fas fa-arrow-left"></i>
                        </div>
                    </div>

                    {{-- الوصف والمواصفات الفنية --}}
                    <div class="space-y-4 sm:space-y-6">
                        <h3 class="text-[10px] font-black text-zinc-400 dark:text-zinc-600 uppercase tracking-widest">وصف ومواصفات المركبة</h3>
                        <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed text-sm sm:text-base md:text-lg font-medium italic" style="white-space: pre-line;">
                            {{ $ad->description }}
                        </p>

                        {{-- شبكة المواصفات الفنية الفاخرة (متجاوبة: عمود واحد في الشاشات الصغيرة جداً وعمودان في المتوسطة) --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 pt-4 sm:pt-6 border-t border-zinc-100 dark:border-zinc-800/50">
                            {{-- سنة الصنع --}}
                            <div class="p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-100/50 dark:bg-zinc-900/50 border border-zinc-200/50 dark:border-zinc-800/50">
                                <span class="text-[8px] sm:text-[9px] font-black uppercase tracking-[0.2em] text-zinc-400 dark:text-zinc-500 block mb-1">سنة الصنع (الموديل)</span>
                                <span class="text-zinc-900 dark:text-zinc-100 font-bold text-xs sm:text-sm">{{ $adAttributes->where('name', 'year')->first()?->pivot->value ?? $ad->year ?? '2024' }}</span>
                            </div>
                            {{-- المسافة المقطوعة --}}
                            <div class="p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-100/50 dark:bg-zinc-900/50 border border-zinc-200/50 dark:border-zinc-800/50">
                                <span class="text-[8px] sm:text-[9px] font-black uppercase tracking-[0.2em] text-zinc-400 dark:text-zinc-500 block mb-1">المسافة المقطوعة</span>
                                <span class="text-zinc-900 dark:text-zinc-100 font-bold text-xs sm:text-sm">
                                    {{ number_format($adAttributes->where('name', 'mileage')->first()?->pivot->value ?? $ad->mileage ?? 0) }} KM
                                </span>
                            </div>
                            {{-- ناقل الحركة --}}
                            <div class="p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-100/50 dark:bg-zinc-900/50 border border-zinc-200/50 dark:border-zinc-800/50">
                                <span class="text-[8px] sm:text-[9px] font-black uppercase tracking-[0.2em] text-zinc-400 dark:text-zinc-500 block mb-1">ناقل الحركة</span>
                                <span class="text-zinc-900 dark:text-zinc-100 font-bold text-xs sm:text-sm">{{ $adAttributes->where('name', 'transmission')->first()?->pivot->value ?? $ad->transmission ?? 'أوتوماتيك' }}</span>
                            </div>
                            {{-- نوع الوقود --}}
                            <div class="p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-100/50 dark:bg-zinc-900/50 border border-zinc-200/50 dark:border-zinc-800/50">
                                <span class="text-[8px] sm:text-[9px] font-black uppercase tracking-[0.2em] text-zinc-400 dark:text-zinc-500 block mb-1">نوع الوقود</span>
                                <span class="text-zinc-900 dark:text-zinc-100 font-bold text-xs sm:text-sm">{{ $adAttributes->where('name', 'fuel_type')->first()?->pivot->value ?? $ad->fuel_type ?? 'بنزين' }}</span>
                            </div>
                            {{-- حالة المركبة الفنية --}}
                            <div class="p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-100/50 dark:bg-zinc-900/50 border border-zinc-200/50 dark:border-zinc-800/50">
                                <span class="text-[8px] sm:text-[9px] font-black uppercase tracking-[0.2em] text-zinc-400 dark:text-zinc-500 block mb-1">حالة المركبة</span>
                                <span class="text-zinc-900 dark:text-zinc-100 font-bold text-xs sm:text-sm">{{ $adAttributes->where('name', 'condition_state')->first()?->pivot->value ?? $ad->condition_state ?? 'بحالة ممتازة' }}</span>
                            </div>
                            {{-- نوع السعر والمعاملة --}}
                            <div class="p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-zinc-100/50 dark:bg-zinc-900/50 border border-zinc-200/50 dark:border-zinc-800/50">
                                <span class="text-[8px] sm:text-[9px] font-black uppercase tracking-[0.2em] text-zinc-400 dark:text-zinc-500 block mb-1">حالة السعر</span>
                                <span class="text-zinc-900 dark:text-zinc-100 font-bold text-xs sm:text-sm">{{ $adAttributes->where('name', 'price_status')->first()?->pivot->value ?? $ad->price_status ?? 'قابل للتفاوض' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- قسم الشراء والتواصل التفاعلي --}}
                    <div class="space-y-6 sm:space-y-8 pt-8 sm:pt-10 border-t border-zinc-100 dark:border-zinc-800/50">
                        
                        {{-- فورم إرسال طلب الشراء أو حجز المعاينة --}}
                        <form action="{{ route('checkout.index') }}" method="GET" class="space-y-4 sm:space-y-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                {{-- خيار طريقة الدفع المطلوبة --}}
                                <div class="space-y-1.5 sm:space-y-2">
                                    <label class="text-[8px] sm:text-[9px] font-black uppercase tracking-[0.2em] text-zinc-400 mr-2">طريقة الدفع المقترحة</label>
                                    <select name="payment_method" required class="w-full bg-zinc-100 dark:bg-white/5 border-transparent rounded-xl py-3.5 sm:py-4 px-4 text-xs font-bold text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-emerald-500 transition-all outline-none">
                                        <option value="كاش">دفع نقدي كامل (Cash)</option>
                                        <option value="تبادل">طلب تبادل مركبة (Échange)</option>
                                        <option value="تقسيط">دفع بالتقسيط (إن أمكن)</option>
                                    </select>
                                </div>

                                {{-- خيار موعد الاتصال المفضل للتفاوض --}}
                                <div class="space-y-1.5 sm:space-y-2">
                                    <label class="text-[8px] sm:text-[9px] font-black uppercase tracking-[0.2em] text-zinc-400 mr-2">موعد الاتصال المفضل</label>
                                    <select name="contact_time" required class="w-full bg-zinc-100 dark:bg-white/5 border-transparent rounded-xl py-3.5 sm:py-4 px-4 text-xs font-bold text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-emerald-500 transition-all outline-none">
                                        <option value="صباحا">الفترة الصباحية (09:00 - 12:00)</option>
                                        <option value="مساءا" selected>الفترة المسائية (13:00 - 18:00)</option>
                                        <option value="أي وقت">في أي وقت مناسب</option>
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="ad_id" value="{{ $ad->id }}">

                            {{-- زر تأكيد المعاملة --}}
                            <button type="submit" class="group relative flex items-center justify-center gap-3 sm:gap-4 w-full bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 py-4 sm:py-6 rounded-xl sm:rounded-2xl font-black text-[11px] sm:text-[12px] uppercase tracking-[0.2em] sm:tracking-[0.3em] transition-all hover:bg-emerald-500 hover:text-white shadow-2xl shadow-zinc-900/20 dark:shadow-none overflow-hidden">
                                <span class="relative z-10 flex items-center gap-2 sm:gap-3">
                                    حجز موعد معاينة أو شراء <i class="fa-solid fa-car text-base sm:text-lg"></i>
                                </span>
                                <div class="absolute inset-0 bg-emerald-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                            </button>
                        </form>

                        {{-- أزرار التواصل المباشر والحفظ (تتجاوب لتصبح عامودية على الهواتف أو أفقية مريحة) --}}
                        <div class="space-y-3 sm:space-y-4">
                            @php
                                $whatsappNum = $ad->contact_whatsapp ?? '0659719027';
                                $phoneNum = $ad->contact_phone ?? '0795632144';
                            @endphp
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsappNum) }}" 
                                   target="_blank"
                                   class="flex items-center justify-center gap-2 bg-emerald-500/10 hover:bg-emerald-500 text-emerald-600 hover:text-white py-4 sm:py-5 rounded-xl sm:rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all border border-emerald-500/20 shadow-sm">
                                   <i class="fab fa-whatsapp text-sm"></i> مراسلة واتساب
                                </a>

                                <a href="tel:{{ $phoneNum }}" class="flex items-center justify-center bg-zinc-100 dark:bg-white/5 text-zinc-900 dark:text-white py-4 sm:py-5 rounded-xl sm:rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all hover:bg-zinc-200 dark:hover:bg-white/10">
                                   <i class="fa-solid fa-phone-flip ml-2 text-[10px]"></i> اتصل بالبائع
                                </a>
                            </div>

                            <button class="w-full py-3 sm:py-4 text-[9px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-[0.3em] sm:tracking-[0.4em] hover:text-emerald-500 transition-colors">
                                <i class="far fa-bookmark ml-2"></i> حفظ الإعلان في المفضلة للمراجعة
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<h1 class="sr-only">2026</h1>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;500;800&family=Cairo:wght@400;700;900&display=swap');
    
    body { 
        font-family: 'Plus Jakarta Sans', 'Cairo', sans-serif;
    }

    select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: left 1rem center;
        background-size: 1em;
    }
</style>
@endsection