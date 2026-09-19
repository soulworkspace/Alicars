<div class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto">
        {{-- العنوان وأزرار التحكم --}}
        <div class="flex justify-between items-center mb-6 no-print">
            <h2 class="text-2xl font-bold text-gray-800">تفاصيل الطلب #{{ $order->id }}</h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.orders.index') }}" class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                    <i class="fas fa-arrow-right ml-1"></i> العودة
                </a>
                <button onclick="window.print()" class="bg-white border px-4 py-2 rounded-lg shadow-sm hover:bg-gray-100 transition">
                    <i class="fas fa-print ml-2 text-gray-600"></i> طباعة الفاتورة
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- الجانب الأيمن: المعلومات الأساسية --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- معلومات المشتري --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-lg mb-4 border-b pb-2 text-orange-600 flex items-center gap-2">
                        <i class="fas fa-user-circle"></i> معلومات الزبون
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500">الاسم الكامل</p>
                            <p class="font-semibold text-gray-800">{{ $order->buyer->name ?? 'مستخدم غير معروف' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">رقم الهاتف</p>
                            <p class="font-semibold text-gray-800" dir="ltr">{{ $order->phone }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500">عنوان الشحن</p>
                            <p class="font-semibold text-gray-800">{{ $order->address ?? $order->shipping_address }}, {{ $order->city ?? $order->wilaya }}</p>
                            
                            {{-- تصحيح رابط الخريطة --}}
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode(($order->address ?? $order->shipping_address) . ' ' . ($order->city ?? $order->wilaya)) }}" 
                               target="_blank" class="text-blue-500 text-xs hover:underline mt-2 inline-flex items-center gap-1">
                                <i class="fas fa-map-marker-alt"></i> عرض الموقع الجغرافي على الخريطة
                            </a>
                        </div>
                    </div>
                </div>

                {{-- تفاصيل المنتج --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-lg mb-4 border-b pb-2 text-orange-600 flex items-center gap-2">
                        <i class="fas fa-box-open"></i> المنتج المطلوب
                    </h3>
                    <div class="flex flex-col md:flex-row items-center gap-4">
                        @if($order->ad && $order->ad->images->count() > 0)
                            <img src="{{ asset('storage/' . $order->ad->images->first()->image_path) }}" 
                                 class="w-24 h-24 rounded-lg object-cover border border-gray-200">
                        @else
                            <div class="bg-gray-100 w-24 h-24 rounded-lg flex items-center justify-center border border-dashed border-gray-300">
                                <i class="fas fa-image text-2xl text-gray-400"></i>
                            </div>
                        @endif
                        
                        <div class="flex-1 text-center md:text-right">
                            <p class="font-bold text-xl text-gray-900">{{ $order->ad->title ?? $order->listing->title ?? 'منتج غير متوفر' }}</p>
                            <p class="text-sm text-gray-600 mt-1">
                                @if($order->color) <span class="bg-gray-100 px-2 py-0.5 rounded">اللون: {{ $order->color }}</span> @endif
                                @if($order->size) <span class="bg-gray-100 px-2 py-0.5 rounded mr-2">المقاس: {{ $order->size }}</span> @endif
                            </p>
                        </div>
                        
                        <div class="text-left bg-orange-50 p-4 rounded-xl border border-orange-100">
                            <p class="text-xs text-orange-600 font-bold mb-1 uppercase">إجمالي المبلغ</p>
                            <p class="font-black text-2xl text-orange-700">{{ number_format($order->total_price, 2) }} <span class="text-sm">د.ج</span></p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- الجانب الأيسر: الإجراءات (Actions) --}}
            <div class="space-y-6 no-print">
                {{-- تحديث الحالة --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold mb-4 flex items-center gap-2 text-gray-700">
                        <i class="fas fa-sync-alt"></i> تحديث حالة الطلب
                    </h3>
                    {{-- استخدام wire:model.live لتحديث فوري في قاعدة البيانات --}}
                    <select wire:model.live="status" class="w-full rounded-lg border-gray-300 focus:ring-orange-500 focus:border-orange-500 text-sm">
                        <option value="pending">⏳ قيد الانتظار</option>
                        <option value="processing">⚙️ قيد التجهيز</option>
                        <option value="shipped">🚚 تم الشحن</option>
                        <option value="completed">✅ مكتمل</option>
                        <option value="cancelled">❌ ملغي</option>
                    </select>
                </div>

                {{-- تواصل سريع --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold mb-4 flex items-center gap-2 text-gray-700">
                        <i class="fas fa-headset"></i> تواصل مع الزبون
                    </h3>
                    <div class="grid gap-3">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->phone) }}?text={{ urlencode('مرحباً ' . ($order->buyer->name ?? '') . '، نحن نتواصل معك من OasisDev بخصوص طلبك رقم ' . $order->id) }}" 
                           target="_blank" 
                           class="w-full bg-[#25D366] text-white py-3 rounded-lg font-bold flex items-center justify-center gap-2 hover:bg-[#128C7E] transition shadow-md shadow-green-100">
                            <i class="fab fa-whatsapp text-xl"></i> واتساب
                        </a>
                        
                        <a href="tel:{{ $order->phone }}" 
                           class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold flex items-center justify-center gap-2 hover:bg-blue-700 transition shadow-md shadow-blue-100">
                            <i class="fas fa-phone"></i> اتصال هاتفي
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
        .p-6 { padding: 0 !important; }
        .bg-gray-50 { background: white !important; }
        .shadow-sm { box-shadow: none !important; border: 1px solid #eee !important; }
        .max-w-5xl { max-width: 100% !important; }
    }
</style>