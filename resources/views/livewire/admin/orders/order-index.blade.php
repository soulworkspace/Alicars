<div class="p-4 md:p-8 bg-slate-50 dark:bg-slate-950 min-h-screen transition-colors duration-300" dir="rtl">
    <div class="max-w-7xl mx-auto">
        
        {{-- الرأس: العنوان والبحث --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-black text-slate-800 dark:text-white flex items-center gap-3">
                    <span class="bg-orange-500 w-2 h-8 rounded-full"></span>
                    إدارة <span class="text-orange-500">الطلبيات</span> الكلية
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">عرض وإدارة جميع عمليات الشراء في نظام تريكو</p>
            </div>

            <div class="relative w-full md:w-96">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="fas fa-search text-slate-400"></i>
                </div>
                <input wire:model.live="search" type="text" 
                    class="block w-full pr-10 py-3 text-sm text-slate-900 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:text-white transition-all shadow-sm" 
                    placeholder="ابحث برقم الطلب، المدينة، أو الهاتف...">
            </div>
        </div>

        {{-- الكروت السريعة (Stats Overview) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-2xl flex items-center justify-center text-orange-600 dark:text-orange-400">
                        <i class="fas fa-shopping-basket text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">إجمالي الطلبات</p>
                        <p class="text-2xl font-black text-slate-800 dark:text-white">{{ $orders->total() }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- حاوية الجدول --}}
        <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                            <th class="p-5 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">رقم الطلب</th>
                            <th class="p-5 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">الزبون</th>
                            <th class="p-5 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">المدينة</th>
                            <th class="p-5 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">المبلغ الإجمالي</th>
                            <th class="p-5 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">حالة الطلب</th>
                            <th class="p-5 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($orders as $order)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors group">
                            <td class="p-5 text-center">
                                <span class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 py-1 px-3 rounded-lg font-bold text-sm">
                                    #{{ $order->id }}
                                </span>
                            </td>
                            <td class="p-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-orange-500 to-orange-300 flex items-center justify-center text-white font-bold text-xs shadow-md shadow-orange-500/20">
                                        {{ mb_substr($order->buyer->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-700 dark:text-slate-200">{{ $order->buyer->name ?? 'مستخدم غير معروف' }}</p>
                                        <p class="text-xs text-slate-400" dir="ltr">{{ $order->phone }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-5 text-center">
                                <span class="text-slate-600 dark:text-slate-400 font-medium">
                                    <i class="fas fa-map-marker-alt text-xs ml-1 text-slate-300"></i> {{ $order->city }}
                                </span>
                            </td>
                            <td class="p-5 text-center">
                                <span class="font-black text-slate-800 dark:text-white">
                                    {{ number_format($order->total_price) }} <span class="text-[10px] font-normal text-slate-400 uppercase">د.ج</span>
                                </span>
                            </td>
                            
                            {{-- عمود حالة الطلب التفاعلي --}}
                            <td class="p-5 text-center">
                                @if(auth()->user()->role === 'admin' || $order->seller_id === auth()->id())
                                    <div class="relative inline-block w-40" wire:key="status-{{ $order->id }}">
                                        <select 
                                            wire:change="updateStatus({{ $order->id }}, $event.target.value)"
                                            class="block w-full px-3 py-2 text-[11px] font-black border-none rounded-xl cursor-pointer focus:ring-2 focus:ring-orange-500/20 transition-all appearance-none text-center
                                            @if($order->status == 'pending') bg-orange-100 text-orange-600 dark:bg-orange-900/30 dark:text-orange-400
                                            @elseif($order->status == 'processing') bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400
                                            @elseif($order->status == 'shipped') bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400
                                            @elseif($order->status == 'delivered') bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400
                                            @elseif($order->status == 'cancelled') bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400
                                            @endif"
                                        >
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ قيد الانتظار</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>⚙️ جاري التحضير</option>
                                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>🚚 تم الشحن</option>
                                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>✅ تم التسليم</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ ملغي</option>
                                        </select>
                                        {{-- سهم صغير مخصص للقائمة --}}
                                        <div class="absolute inset-y-0 left-2 flex items-center pointer-events-none opacity-40">
                                            <i class="fas fa-chevron-down text-[9px]"></i>
                                        </div>
                                        {{-- مؤشر تحميل يظهر عند التحديث --}}
                                        <div wire:loading wire:target="updateStatus({{ $order->id }}, ...)" class="absolute -right-6 top-2">
                                            <i class="fas fa-circle-notch fa-spin text-orange-500 text-xs"></i>
                                        </div>
                                    </div>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-bold border {{ $order->status_color }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current ml-2"></span>
                                        {{ $order->status_label }}
                                    </span>
                                @endif
                            </td>

                            <td class="p-5 text-center">
                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all shadow-sm">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-inbox text-3xl text-slate-200 dark:text-slate-700"></i>
                                    </div>
                                    <p class="text-slate-400 dark:text-slate-500 font-medium italic">لا توجد طلبيات مطابقة للبحث حالياً.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- الترقيم --}}
            @if($orders->hasPages())
            <div class="p-6 bg-slate-50/50 dark:bg-slate-800/30 border-t border-slate-100 dark:border-slate-800">
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </div>
</div>