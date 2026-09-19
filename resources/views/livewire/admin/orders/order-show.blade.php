<div class="p-8 bg-slate-50 dark:bg-slate-950 min-h-screen transition-colors duration-300" dir="rtl">
    <div class="max-w-4xl mx-auto">
        
        {{-- زر العودة --}}
        <a href="{{ route('admin.orders.index') }}" 
           class="inline-flex items-center text-slate-500 hover:text-orange-500 mb-8 font-bold transition-all group">
            <i class="fas fa-arrow-right ml-2 group-hover:ml-4 transition-all"></i> 
            العودة لقائمة الطلبيات
        </a>

        <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800 overflow-hidden">
            
            {{-- الهيدر --}}
            <div class="p-8 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-black text-slate-800 dark:text-white leading-tight">
                        تفاصيل الطلب <span class="text-orange-500">#{{ $order->id }}</span>
                    </h2>
                    <p class="text-slate-400 text-sm mt-1">تاريخ الطلب: {{ $order->created_at->format('Y-m-d H:i') }}</p>
                </div>
                <span class="px-6 py-2 rounded-2xl text-xs font-black border uppercase tracking-widest {{ $order->status_color }}">
                    {{ $order->status_label }}
                </span>
            </div>

            <div class="p-8 lg:p-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    
                    {{-- كرت معلومات الزبون --}}
                    <div class="space-y-6">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-orange-500"></span> معلومات المشتري
                        </h3>
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-600 dark:text-orange-400 text-xl font-bold">
                                {{ mb_substr($order->buyer->name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-xl font-black text-slate-800 dark:text-white">{{ $order->buyer->name ?? 'غير معروف' }}</p>
                                <p class="text-slate-500 font-medium" dir="ltr">{{ $order->phone }}</p>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-slate-50 dark:border-slate-800">
                            <p class="text-slate-400 text-xs font-bold uppercase">عنوان التوصيل</p>
                            <p class="text-slate-700 dark:text-slate-300 mt-2 font-bold">{{ $order->city }}</p>
                        </div>
                    </div>

                    {{-- كرت ملخص الدفع --}}
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-[2rem] p-8 border border-slate-100 dark:border-slate-800 flex flex-col justify-center">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-4">إجمالي المبلغ المطلوب</h3>
                        <div class="flex items-baseline gap-2">
                            <span class="text-5xl font-black text-slate-900 dark:text-white tracking-tight">
                                {{ number_format($order->total_price) }}
                            </span>
                            <span class="text-xl font-bold text-orange-500 uppercase">د.ج</span>
                        </div>
                        <p class="text-slate-400 text-xs mt-4 italic">* يشمل هذا المبلغ سعر المنتجات مع مصاريف التوصيل المعلنة.</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>