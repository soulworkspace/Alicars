<div class="p-4 md:p-8 bg-slate-50 dark:bg-slate-950 min-h-screen transition-colors duration-300" dir="rtl">
    <div class="max-w-6xl mx-auto space-y-6">

        {{-- Toast / Alert Notification --}}
        @if (session()->has('success'))
            <div class="no-print flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">
                <i class="fas fa-check-circle text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Header & Action Buttons --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm no-print">
            <div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800 dark:text-white flex items-center gap-3 tracking-tight">
                    <span class="bg-gradient-to-b from-orange-400 to-orange-600 w-2.5 h-8 rounded-full"></span>
                    تفاصيل الطلب <span class="text-orange-500 font-mono">#{{ $order->id }}</span>
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-xs md:text-sm mt-1 font-medium">
                    تاريخ الطلب: <span class="font-mono" dir="ltr">{{ $order->created_at ? $order->created_at->format('Y-m-d H:i') : '' }}</span>
                </p>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <a href="{{ route('admin.orders.index') }}" 
                   class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold transition-all shrink-0">
                    <i class="fas fa-arrow-right"></i>
                    <span>العودة للطلبات</span>
                </a>

                <button onclick="window.print()" 
                        class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold transition-all shadow-md shadow-orange-500/20 shrink-0">
                    <i class="fas fa-print"></i>
                    <span>طباعة الفاتورة</span>
                </button>
            </div>
        </div>

        {{-- Main Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Right Column: Order & Customer Information --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Customer Information Card --}}
                <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-base text-orange-500 border-b border-slate-100 dark:border-slate-800 pb-3 flex items-center gap-2">
                        <i class="fas fa-user-circle text-lg"></i>
                        <span>معلومات الزبون</span>
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div class="p-3 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                            <span class="text-slate-400 block mb-1">الاسم الكامل</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200 text-sm">{{ $order->buyer->name ?? 'مستخدم غير معروف' }}</span>
                        </div>

                        <div class="p-3 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                            <span class="text-slate-400 block mb-1">رقم الهاتف</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200 text-sm font-mono" dir="ltr">{{ $order->phone }}</span>
                        </div>

                        <div class="md:col-span-2 p-3 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800 space-y-2">
                            <span class="text-slate-400 block">عنوان الشحن</span>
                            <p class="font-bold text-slate-800 dark:text-slate-200 text-sm">
                                {{ $order->address ?? $order->shipping_address }}, {{ $order->city ?? $order->wilaya }}
                            </p>

                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode(($order->address ?? $order->shipping_address) . ' ' . ($order->city ?? $order->wilaya)) }}" 
                               target="_blank" 
                               class="no-print text-orange-500 hover:text-orange-600 font-bold inline-flex items-center gap-1.5 transition-colors pt-1">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>عرض الموقع الجغرافي على الخريطة</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Product Details Card --}}
                <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-base text-orange-500 border-b border-slate-100 dark:border-slate-800 pb-3 flex items-center gap-2">
                        <i class="fas fa-box-open text-lg"></i>
                        <span>المنتج المطلوب</span>
                    </h3>

                    <div class="flex flex-col sm:flex-row items-center gap-5">
                        {{-- Image Display --}}
                        @if($order->ad && $order->ad->images && $order->ad->images->count() > 0)
                            <img src="{{ asset('storage/' . $order->ad->images->first()->image_path) }}" 
                                 alt="Product Image"
                                 class="w-24 h-24 rounded-2xl object-cover border border-slate-200 dark:border-slate-700 shadow-sm shrink-0">
                        @else
                            <div class="w-24 h-24 rounded-2xl bg-slate-100 dark:bg-slate-800 border border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center shrink-0">
                                <i class="fas fa-image text-3xl text-slate-400"></i>
                            </div>
                        @endif

                        {{-- Item Info --}}
                        <div class="flex-1 text-center sm:text-right space-y-2">
                            <h4 class="font-bold text-base text-slate-800 dark:text-white">
                                {{ $order->ad->title ?? $order->listing->title ?? 'منتج غير متوفر' }}
                            </h4>

                            <div class="flex flex-wrap justify-center sm:justify-start gap-2">
                                @if($order->color)
                                    <span class="bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs px-3 py-1 rounded-xl font-bold">
                                        اللون: {{ $order->color }}
                                    </span>
                                @endif

                                @if($order->size)
                                    <span class="bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs px-3 py-1 rounded-xl font-bold">
                                        المقاس: {{ $order->size }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Total Price Box --}}
                        <div class="w-full sm:w-auto bg-orange-500/10 border border-orange-500/20 p-4 rounded-2xl text-center sm:text-left shrink-0">
                            <span class="text-[10px] text-orange-600 dark:text-orange-400 font-extrabold uppercase tracking-wider block mb-0.5">إجمالي المبلغ</span>
                            <span class="font-black text-2xl text-orange-600 dark:text-orange-400 font-mono">
                                {{ number_format($order->total_price, 2) }}
                            </span>
                            <span class="text-xs font-bold text-orange-500 mr-1">د.ج</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Left Column: Actions & Communication --}}
            <div class="space-y-6 no-print">

                {{-- Status Update Card --}}
                <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4">
                    <h3 class="font-bold text-sm text-slate-800 dark:text-slate-200 flex items-center gap-2">
                        <i class="fas fa-sync-alt text-orange-500"></i>
                        <span>تحديث حالة الطلب</span>
                    </h3>

                    <select wire:model.live="status" 
                            class="block w-full px-3 py-2.5 text-xs font-bold border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all cursor-pointer">
                        <option value="pending">⏳ قيد الانتظار</option>
                        <option value="processing">⚙️ قيد التجهيز</option>
                        <option value="shipped">🚚 تم الشحن</option>
                        <option value="delivered">✅ تم التسليم</option>
                        <option value="completed">🎉 مكتمل</option>
                        <option value="cancelled">❌ ملغي</option>
                    </select>
                </div>

                {{-- Contact Options Card --}}
                <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4">
                    <h3 class="font-bold text-sm text-slate-800 dark:text-slate-200 flex items-center gap-2">
                        <i class="fas fa-headset text-orange-500"></i>
                        <span>تواصل سريع مع الزبون</span>
                    </h3>

                    <div class="grid gap-3">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->phone) }}?text={{ urlencode('مرحباً ' . ($order->buyer->name ?? '') . '، نحن نتواصل معك بخصوص طلبك رقم #' . $order->id) }}" 
                           target="_blank" 
                           class="w-full bg-[#25D366] hover:bg-[#128C7E] text-white py-3 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 transition-all shadow-md shadow-emerald-500/10">
                            <i class="fab fa-whatsapp text-lg"></i>
                            <span>تواصل عبر الواتساب</span>
                        </a>

                        <a href="tel:{{ $order->phone }}" 
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-2xl font-bold text-xs flex items-center justify-center gap-2 transition-all shadow-md shadow-blue-500/10">
                            <i class="fas fa-phone-alt text-sm"></i>
                            <span>اتصال هاتفي</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { 
            display: none !important; 
        }
        body, main { 
            background: #ffffff !important; 
            color: #000000 !important;
            padding: 0 !important;
        }
        .shadow-sm, .shadow-md, .shadow-2xl { 
            box-shadow: none !important; 
        }
        .border, .border-b { 
            border-color: #e2e8f0 !important; 
        }
        .bg-white, .bg-slate-50, .bg-slate-900, .bg-slate-800 { 
            background-color: transparent !important; 
        }
        .max-w-6xl { 
            max-width: 100% !important; 
        }
    }
</style>