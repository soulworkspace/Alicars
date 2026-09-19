@extends('layouts.app')

@section('title', 'تم الحجز بنجاح | MB MOTORS')

@section('content')
{{-- استدعاء مفسر التنسيق لضمان تشغيل كافة الكلاسات التجاوبية والتأثيرات الحركية بسلاسة --}}
<script src="https://cdn.tailwindcss.com"></script>

<div class="bg-zinc-50 dark:bg-zinc-950 min-h-screen flex items-center justify-center py-24 px-4 font-sans" dir="rtl">
    <div class="max-w-lg w-full relative">
        
        {{-- تأثيرات ضوئية خلفية فاخرة --}}
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-emerald-500/10 blur-[120px] rounded-full"></div>
        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-emerald-500/5 blur-[120px] rounded-full"></div>

        <div class="relative bg-white dark:bg-zinc-900 rounded-[3rem] border border-zinc-200 dark:border-white/5 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)] overflow-hidden">
            
            {{-- الجزء العلوي: أيقونة النجاح الحركية --}}
            <div class="pt-12 pb-8 text-center">
                <div class="w-24 h-24 bg-emerald-500 rounded-[2rem] flex items-center justify-center mx-auto mb-6 rotate-12 shadow-2xl shadow-emerald-500/40 animate-bounce">
                    <i class="fa-solid fa-check text-4xl text-white"></i>
                </div>
                <h1 class="text-4xl font-black text-zinc-900 dark:text-white uppercase tracking-tighter">تم طلب الحجز بنجاح!</h1>
                <p class="text-zinc-500 dark:text-zinc-400 mt-3 font-medium px-8 leading-relaxed">
                    شكراً لثقتك في **MB MOTORS**. تم إرسال تفاصيل طلب المعاينة والحجز إلى المعرض/البائع وسيتواصل معك مستشارك قريباً.
                </p>
            </div>

            {{-- تذكرة الطلب والحجز الفاخرة (Ticket Style) --}}
            <div class="px-8 pb-10">
                <div class="bg-zinc-50 dark:bg-white/5 rounded-3xl border border-dashed border-zinc-200 dark:border-white/10 p-6 relative">
                    
                    {{-- فتحات التذكرة الجانبية الجمالية --}}
                    <div class="absolute top-1/2 -left-3 w-6 h-6 bg-white dark:bg-zinc-900 rounded-full border border-zinc-200 dark:border-white/5 -translate-y-1/2"></div>
                    <div class="absolute top-1/2 -right-3 w-6 h-6 bg-white dark:bg-zinc-900 rounded-full border border-zinc-200 dark:border-white/5 -translate-y-1/2"></div>

                    <div class="flex justify-between items-center mb-6">
                        <div class="text-right">
                            <span class="block text-[9px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest mb-1">رقم الحجز</span>
                            <span class="text-lg font-black text-zinc-900 dark:text-white font-international italic">#MBM-{{ strtoupper(Str::random(6)) }}</span>
                        </div>
                        <div class="text-left">
                            <span class="block text-[9px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest mb-1">التاريخ</span>
                            <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ now()->format('Y/m/d') }}</span>
                        </div>
                    </div>

                    {{-- مسار حالة الحجز والمعاينة التوضيحي --}}
                    <div class="space-y-4">
                        <span class="block text-[9px] font-black text-emerald-500 uppercase tracking-[0.3em] text-center mb-4">المراحل المتوقعة للحجز</span>
                        <div class="flex justify-between items-center px-2">
                            <div class="flex flex-col items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center text-white text-[10px] font-bold">1</div>
                                <span class="text-[8px] font-black text-zinc-900 dark:text-white uppercase">طلب معلق</span>
                            </div>
                            <div class="h-[2px] flex-1 bg-zinc-200 dark:bg-white/10 mx-2 mb-4"></div>
                            <div class="flex flex-col items-center gap-2 opacity-30">
                                <div class="w-8 h-8 rounded-full bg-zinc-200 dark:bg-white/10 flex items-center justify-center text-zinc-500 text-[10px] font-bold">2</div>
                                <span class="text-[8px] font-black text-zinc-500 uppercase tracking-tighter">المعاينة والتأكيد</span>
                            </div>
                            <div class="h-[2px] flex-1 bg-zinc-200 dark:bg-white/10 mx-2 mb-4"></div>
                            <div class="flex flex-col items-center gap-2 opacity-30">
                                <div class="w-8 h-8 rounded-full bg-zinc-200 dark:bg-white/10 flex items-center justify-center text-zinc-500 text-[10px] font-bold">3</div>
                                <span class="text-[8px] font-black text-zinc-500 uppercase tracking-tighter">تسليم المركبة</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- أزرار التحكم والعودة --}}
            <div class="p-8 pt-0 space-y-4">
                <a href="{{ route('orders.index') }}" class="flex items-center justify-center gap-3 w-full bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 py-6 rounded-[2rem] font-black text-[11px] uppercase tracking-[0.2em] transition-all hover:bg-emerald-500 hover:text-white shadow-xl shadow-zinc-900/10 dark:shadow-none">
                    <i class="fa-solid fa-car-side text-lg"></i> متابعة طلبات الحجز
                </a>
                
                <a href="{{ route('home') }}" class="block text-center text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-widest hover:text-emerald-500 transition-colors">
                    العودة لمعرض MB MOTORS الرئيسي
                </a>
            </div>
        </div>

        {{-- رسالة الأمان والضمان الفاخرة --}}
        <p class="text-center mt-8 text-[10px] text-zinc-400 dark:text-zinc-500 font-black uppercase tracking-widest">
            <i class="fa-solid fa-shield-halved ml-2 text-emerald-500"></i> حجز آمن وموثوق بنسبة 100% مع ضمان MB MOTORS
        </p>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,800;1,800&family=Cairo:wght@400;700;900&display=swap');
    
    body { 
        font-family: 'Plus Jakarta Sans', 'Cairo', sans-serif;
    }
    
    .font-international { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>
@endsection