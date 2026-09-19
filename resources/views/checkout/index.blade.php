@extends('layouts.app')

@section('title', 'إنهاء الطلب | TRICO')

@section('content')
{{-- استدعاء مفسر التنسيق لضمان تشغيل الكلاسات التجاوبية وتفادي مشاكل الـ Purging --}}
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        darkMode: 'class',
    }
</script>

<div class="bg-zinc-50 dark:bg-[#0c0c0e] min-h-screen text-right pt-32 pb-20 transition-colors duration-500 font-sans w-full block" dir="rtl">
    <div class="max-w-7xl mx-auto px-6 lg:px-10 w-full">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 w-full items-start">
            
            {{-- الجانب الأيمن: نموذج بيانات الشحن --}}
            <div class="lg:col-span-7 space-y-10 w-full flex flex-col">
                <div class="space-y-4 w-full">
                    <span class="text-emerald-500 text-[10px] font-black uppercase tracking-[0.3em] block">الخطوة الأخيرة</span>
                    <h1 class="text-5xl lg:text-7xl font-black text-zinc-900 dark:text-zinc-50 tracking-tighter uppercase italic leading-none">
                        إنهاء الطلب
                    </h1>
                    <p class="text-zinc-500 dark:text-zinc-400 text-lg font-medium max-w-xl leading-relaxed italic">
                        أنت على بعد خطوة واحدة من الحصول على قطعتك المميزة. يرجى تزويدنا ببيانات التوصيل بدقة.
                    </p>
                </div>

                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-8 lg:p-12 rounded-[3rem] shadow-sm relative overflow-hidden w-full flex flex-col">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-l from-emerald-500 to-transparent opacity-50"></div>

                    {{-- عرض رسائل الخطأ العامة --}}
                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-500 rounded-2xl text-sm font-bold w-full">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('checkout.store') }}" method="POST" class="space-y-8 w-full flex flex-col" id="checkoutForm">
                        @csrf
                        
                        {{-- الحقول المخفية لضمان إرسال بيانات المنتج كاملة --}}
                        @foreach($cart as $item)
                            <input type="hidden" name="ad_id" value="{{ $item['id'] }}">
                            <input type="hidden" name="size" value="{{ $item['size'] }}">
                            <input type="hidden" name="color" value="{{ $item['color'] }}">
                            <input type="hidden" name="quantity" value="{{ $item['quantity'] }}">
                        @endforeach

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full">
                            {{-- رقم الهاتف --}}
                            <div class="space-y-3 w-full flex flex-col">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-zinc-400 dark:text-zinc-600 mr-2 block">رقم الهاتف للتواصل</label>
                                <div class="relative w-full">
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                           class="w-full bg-zinc-50 dark:bg-zinc-800/50 border-2 {{ $errors->has('phone') ? 'border-red-500' : 'border-transparent' }} focus:border-emerald-500 rounded-2xl py-5 pr-6 pl-14 text-zinc-900 dark:text-white font-bold transition-all outline-none placeholder:text-zinc-300 dark:placeholder:text-zinc-700" 
                                           placeholder="0XXXXXXXXX" required>
                                    <i class="fas fa-phone absolute left-6 top-1/2 -translate-y-1/2 text-zinc-300 dark:text-zinc-700 text-sm"></i>
                                </div>
                                @error('phone') <p class="text-red-500 text-[10px] font-bold mr-2 block">{{ $message }}</p> @enderror
                            </div>

                            {{-- الولاية --}}
                            <div class="space-y-3 w-full flex flex-col">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-zinc-400 dark:text-zinc-600 mr-2 block">الولاية</label>
                                <div class="relative w-full">
                                    <select name="city" class="w-full bg-zinc-50 dark:bg-zinc-800/50 border-2 border-transparent focus:border-emerald-500 rounded-2xl py-5 pr-6 pl-14 text-zinc-900 dark:text-white font-bold transition-all outline-none appearance-none cursor-pointer">
                                        <option value="الجزائر" {{ old('city') == 'الجزائر' ? 'selected' : '' }}>الجزائر العاصمة</option>
                                        <option value="وهران" {{ old('city') == 'وهران' ? 'selected' : '' }}>وهران</option>
                                        <option value="قسنطينة" {{ old('city') == 'قسنطينة' ? 'selected' : '' }}>قسنطينة</option>
                                        <option value="عنابة" {{ old('city') == 'عنابة' ? 'selected' : '' }}>عنابة</option>
                                        <option value="سطيف" {{ old('city') == 'سطيف' ? 'selected' : '' }}>سطيف</option>
                                        <option value="غرداية" {{ old('city') == 'غرداية' ? 'selected' : '' }}>غرداية</option>
                                        <option value="الأغواط" {{ old('city') == 'الأغواط' ? 'selected' : '' }}>الأغواط</option>
                                    </select>
                                    <i class="fas fa-chevron-down absolute left-6 top-1/2 -translate-y-1/2 text-zinc-300 dark:text-zinc-700 text-xs pointer-events-none"></i>
                                </div>
                            </div>
                        </div>

                        {{-- العنوان الكامل --}}
                        <div class="space-y-3 w-full flex flex-col">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-zinc-400 dark:text-zinc-600 mr-2 block">العنوان التفصيلي (البلدية، الشارع، رقم المنزل)</label>
                            <textarea name="shipping_address" 
                                      class="w-full bg-zinc-50 dark:bg-zinc-800/50 border-2 {{ $errors->has('shipping_address') ? 'border-red-500' : 'border-transparent' }} focus:border-emerald-500 rounded-[2rem] py-5 px-6 text-zinc-900 dark:text-white font-bold transition-all outline-none min-h-[150px] placeholder:text-zinc-300 dark:placeholder:text-zinc-700 leading-relaxed" 
                                      placeholder="مثلاً: بئر الجير، حي الياسمين، عمارة رقم 04..." required>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address') <p class="text-red-500 text-[10px] font-bold mr-2 block">{{ $message }}</p> @enderror
                        </div>

                        {{-- ملاحظات إضافية --}}
                        <div class="space-y-3 w-full flex flex-col">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-zinc-400 dark:text-zinc-600 mr-2 block">ملاحظات للبائع (اختياري)</label>
                            <input type="text" name="notes" value="{{ old('notes') }}"
                                   class="w-full bg-zinc-50 dark:bg-zinc-800/50 border-2 border-transparent focus:border-emerald-500 rounded-2xl py-5 px-6 text-zinc-900 dark:text-white font-bold transition-all outline-none placeholder:text-zinc-300 dark:placeholder:text-zinc-700" 
                                   placeholder="أفضل وقت للتوصيل، تعليمات خاصة...">
                        </div>

                        <button type="submit" id="confirmBtn" class="group relative flex items-center justify-center gap-4 w-full bg-emerald-600 hover:bg-emerald-700 text-white py-7 rounded-[2rem] font-black text-[12px] uppercase tracking-[0.4em] transition-all shadow-xl shadow-emerald-900/20 overflow-hidden">
                            <span class="relative z-10 flex items-center gap-3">
                                تأكيد الطلب الآن <i class="fas fa-arrow-left group-hover:-translate-x-2 transition-transform"></i>
                            </span>
                            <div class="absolute inset-0 bg-zinc-900 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                        </button>
                    </form>
                </div>
            </div>

            {{-- الجانب الأيسر: ملخص السلة --}}
            <div class="lg:col-span-5 w-full">
                <div class="sticky top-32 space-y-8 w-full flex flex-col">
                    <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-[3rem] p-10 shadow-sm w-full flex flex-col">
                        <h3 class="text-[10px] font-black text-zinc-400 dark:text-zinc-500 uppercase tracking-[0.3em] mb-10 flex items-center gap-3">
                            <i class="fas fa-shopping-bag text-emerald-500"></i> ملخص الطلبية
                        </h3>
                        
                        <div class="space-y-8 max-h-[450px] overflow-y-auto no-scrollbar px-2 w-full">
                            @forelse($cart as $item)
                                <div class="flex items-center gap-6 group w-full">
                                    <div class="w-24 h-28 flex-shrink-0 rounded-[1.5rem] overflow-hidden bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-800">
                                        <img src="{{ asset('storage/' . ($item['image'] ?? '')) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    </div>
                                    
                                    <div class="flex-1 space-y-2">
                                        <h4 class="text-sm font-black text-zinc-900 dark:text-white uppercase tracking-tight line-clamp-1 italic">{{ $item['title'] }}</h4>
                                        <div class="flex flex-wrap gap-2">
                                            <span class="text-[9px] font-black text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-3 py-1 rounded-full uppercase">{{ $item['size'] }}</span>
                                            <span class="text-[9px] font-black text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-3 py-1 rounded-full uppercase">{{ $item['color'] }}</span>
                                        </div>
                                        <div class="pt-2">
                                            <span class="text-lg font-black text-zinc-900 dark:text-white italic tracking-tighter">
                                                {{ number_format($item['price']) }} 
                                                <span class="text-[10px] text-emerald-500 not-italic uppercase ml-1">DZD</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10 w-full">
                                    <p class="text-zinc-400 font-bold italic">السلة فارغة</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-10 pt-10 border-t border-zinc-100 dark:border-zinc-800 w-full">
                            <div class="flex justify-between items-end w-full">
                                <div class="space-y-1">
                                    <span class="text-[10px] font-black text-zinc-400 uppercase tracking-widest block">المجموع النهائي</span>
                                    <span class="text-[9px] text-zinc-400 font-medium italic">الدفع نقداً عند الاستلام</span>
                                </div>
                                <div class="text-left">
                                    <span class="block text-5xl font-black text-emerald-500 tracking-tighter italic leading-none">
                                        {{ number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart))) }}
                                    </span>
                                    <span class="text-[10px] font-black text-zinc-400 uppercase tracking-widest block mt-1">دينار جزائري</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 px-8 text-zinc-400 dark:text-zinc-600 w-full">
                        <i class="fas fa-shield-alt text-2xl opacity-20 flex-shrink-0"></i>
                        <p class="text-[10px] font-bold leading-relaxed italic uppercase">حق المعاينة مكفول قبل الدفع. تسوق بكل ثقة مع تريكو.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // تفعيل تعطيل الزر عند الإرسال لمنع التكرار
    document.getElementById('checkoutForm').onsubmit = function() {
        let btn = document.getElementById('confirmBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="relative z-10 flex items-center gap-3 italic">جاري معالجة طلبك...</span>';
        btn.classList.add('opacity-70', 'cursor-not-allowed');
    };
</script>
@endsection