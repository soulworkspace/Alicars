<div>
    {{-- العنصر الرئيسي الذي يجمع كل شيء --}}
    <div class="p-4 md:p-8 bg-slate-50 dark:bg-slate-950 min-h-screen transition-colors duration-300" dir="rtl">
        <div class="max-w-5xl mx-auto">
            
            {{-- الرأس: العنوان وأزرار التحكم --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8 no-print">
                <div>
                    <h2 class="text-3xl font-black text-slate-800 dark:text-white flex items-center gap-3">
                        <span class="bg-orange-500 w-2 h-8 rounded-full"></span>
                        تفاصيل الطلب <span class="text-orange-500">#{{ $order->id }}</span>
                    </h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">تاريخ الطلب: {{ $order->created_at->format('Y/m/d - H:i') }}</p>
                </div>
                
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <button onclick="window.print()" class="flex-1 md:flex-none flex items-center justify-center gap-2 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 px-5 py-2.5 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all font-bold text-sm">
                        <i class="fas fa-print"></i> طباعة الفاتورة
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 bg-slate-800 dark:bg-orange-600 text-white px-5 py-2.5 rounded-xl shadow-lg shadow-slate-200 dark:shadow-none hover:opacity-90 transition-all font-bold text-sm">
                        العودة للملفات <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>

            @if (session()->has('success'))
                <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 rounded-2xl flex items-center gap-3 no-print">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- الجانب الأيمن: المعلومات الأساسية --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- كرت معلومات الزبون --}}
                    <div class="bg-white dark:bg-slate-900 p-8 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-800 text-right relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-32 h-32 bg-orange-500/5 rounded-full -translate-x-16 -translate-y-16"></div>
                        
                        <h3 class="font-bold text-xl mb-6 text-slate-800 dark:text-white flex items-center gap-3 justify-end">
                            معلومات الزبون <i class="fas fa-user-tag text-orange-500"></i>
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                            <div class="space-y-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">الاسم الكامل</p>
                                <p class="text-lg font-bold text-slate-700 dark:text-slate-200">{{ $order->buyer->name ?? 'مستخدم غير معروف' }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">رقم الهاتف</p>
                                <p class="text-lg font-bold text-slate-700 dark:text-slate-200" dir="ltr">{{ $order->phone }}</p>
                            </div>
                            <div class="md:col-span-2 space-y-1">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">عنوان التوصيل</p>
                                <p class="text-lg font-bold text-slate-700 dark:text-slate-200 leading-relaxed">
                                    {{ $order->shipping_address ?? 'لم يحدد العنوان' }}، 
                                    <span class="text-orange-600 dark:text-orange-400">{{ $order->city }}</span>
                                </p>
                                <a href="https://www.google.com/maps/search/{{ urlencode($order->shipping_address . ' ' . $order->city) }}" 
                                   target="_blank" class="inline-flex items-center gap-2 text-blue-500 dark:text-blue-400 text-xs font-bold hover:underline mt-2">
                                    <i class="fas fa-map-marked-alt"></i> فتح الموقع في خرائط جوجل
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- كرت تفاصيل المنتج المطلوب --}}
                    <div class="bg-white dark:bg-slate-900 p-8 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-800 text-right">
                        <h3 class="font-bold text-xl mb-6 text-slate-800 dark:text-white flex items-center gap-3 justify-end">
                            المنتج المطلوب <i class="fas fa-shopping-bag text-orange-500"></i>
                        </h3>
                        
                        <div class="flex flex-col md:flex-row-reverse items-center gap-8">
                            <div class="relative group">
                                @if($order->ad && $order->ad->images->count() > 0)
                                    <img src="{{ asset('storage/' . $order->ad->images->first()->image_path) }}" 
                                         class="w-32 h-32 rounded-2xl object-cover shadow-md group-hover:scale-105 transition-transform">
                                @else
                                    <div class="w-32 h-32 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center border-2 border-dashed border-slate-200 dark:border-slate-700">
                                        <i class="fas fa-image text-3xl text-slate-300"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex-1 text-center md:text-right space-y-2">
                                <p class="font-black text-2xl text-slate-800 dark:text-white leading-tight">
                                    {{ $order->ad->title ?? $order->listing->title ?? 'منتج غير متوفر' }}
                                </p>
                                <div class="flex flex-wrap justify-center md:justify-end gap-2 mt-3">
                                    @if($order->color) 
                                        <span class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-3 py-1 rounded-lg text-sm font-bold border border-slate-200 dark:border-slate-700">اللون: {{ $order->color }}</span> 
                                    @endif
                                    @if($order->size) 
                                        <span class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-3 py-1 rounded-lg text-sm font-bold border border-slate-200 dark:border-slate-700">المقاس: {{ $order->size }}</span> 
                                    @endif
                                    <span class="bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 px-3 py-1 rounded-lg text-sm font-bold border border-orange-200 dark:border-orange-800">الكمية: {{ $order->quantity }}</span>
                                </div>
                            </div>
                            
                            <div class="w-full md:w-auto p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-700 text-center">
                                <p class="text-xs text-slate-400 font-bold uppercase mb-1">المبلغ الإجمالي</p>
                                <p class="text-3xl font-black text-slate-800 dark:text-white">
                                    {{ number_format($order->total_price) }} <span class="text-sm font-normal text-slate-500">د.ج</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- الجانب الأيسر: الإجراءات --}}
                <div class="space-y-8 no-print">
                    {{-- كرت الحالة --}}
                    <div class="bg-white dark:bg-slate-900 p-8 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-800">
                        <h3 class="font-bold text-slate-800 dark:text-white mb-5 flex items-center gap-2 justify-end">
                            الحالة الحالية <i class="fas fa-stream text-orange-500"></i>
                        </h3>
                        <select wire:model.live="status" class="w-full rounded-xl bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 font-bold py-3 text-right focus:ring-2 focus:ring-orange-500 transition-all">
                            <option value="pending">⏳ قيد الانتظار</option>
                            <option value="processing">⚙️ جاري التجهيز</option>
                            <option value="shipped">🚚 تم الشحن</option>
                            <option value="completed">✅ تم التسليم</option>
                            <option value="cancelled">❌ ملغي</option>
                        </select>
                    </div>

                    {{-- كرت التواصل --}}
                    <div class="bg-slate-900 dark:bg-orange-600 p-8 rounded-3xl shadow-xl shadow-slate-200 dark:shadow-none relative overflow-hidden">
                        <div class="absolute bottom-0 right-0 w-24 h-24 bg-white/5 rounded-full translate-x-10 translate-y-10"></div>
                        
                        <h3 class="font-bold text-white mb-6 flex items-center gap-2 justify-end">
                            تواصل سريع <i class="fas fa-comments"></i>
                        </h3>
                        <div class="space-y-4 relative z-10">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->phone) }}?text={{ urlencode('مرحباً '.$order->buyer->name.'، معك إدارة MB MOTORS بخصوص طلبك رقم #'.$order->id) }}" 
                               target="_blank" 
                               class="flex items-center justify-center gap-3 w-full bg-[#25D366] text-white py-4 rounded-2xl font-black hover:scale-105 transition-transform shadow-lg shadow-emerald-500/20">
                                <i class="fab fa-whatsapp text-2xl"></i> واتساب
                            </a>
                            
                            <a href="tel:{{ $order->phone }}" 
                               class="flex items-center justify-center gap-3 w-full bg-white dark:bg-slate-900 text-slate-900 dark:text-white py-4 rounded-2xl font-black hover:scale-105 transition-transform shadow-lg">
                                <i class="fas fa-phone-alt"></i> إتصال هاتفي
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- الـ STYLE أصبح الآن داخل الـ DIV الرئيسي --}}
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; color: black !important; }
            .p-4, .p-8 { padding: 0 !important; }
            .bg-slate-50, .bg-slate-950, .dark\:bg-slate-950 { background: white !important; }
            .shadow-sm, .shadow-xl { box-shadow: none !important; }
            .border, .border-slate-100 { border: 1px solid #e2e8f0 !important; }
            .rounded-3xl { border-radius: 12px !important; }
            .text-white { color: black !important; }
            .max-w-5xl { max-width: 100% !important; margin: 0 !important; }
        }
    </style>
</div>