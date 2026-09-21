<div class="p-4 md:p-8 bg-slate-50 dark:bg-slate-950 min-h-screen transition-colors duration-300" 
     dir="rtl"
     x-data="{ 
         toast: { show: false, message: '', type: 'success' },
         triggerToast(msg, type = 'success') {
             this.toast.message = msg;
             this.toast.type = type;
             this.toast.show = true;
             setTimeout(() => { this.toast.show = false; }, 3500);
         }
     }"
     x-on:status-updated.window="triggerToast($event.detail.message, 'success')"
     x-on:status-error.window="triggerToast($event.detail.message, 'danger')">

    {{-- Toast Notification --}}
    <div x-cloak 
         x-show="toast.show" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-[-20px] scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-[-20px] scale-95"
         class="fixed top-5 left-5 z-50 flex items-center gap-3 px-5 py-4 rounded-2xl shadow-xl border text-sm font-bold backdrop-blur-md"
         :class="{
             'bg-emerald-500/90 text-white border-emerald-400': toast.type === 'success',
             'bg-red-500/90 text-white border-red-400': toast.type === 'danger'
         }">
        <i class="fas text-lg" :class="toast.type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'"></i>
        <span x-text="toast.message"></span>
    </div>

    <div class="max-w-7xl mx-auto space-y-6">

        @if (session()->has('success'))
            <div class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
            <div>
                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800 dark:text-white flex items-center gap-3 tracking-tight">
                    <span class="bg-gradient-to-b from-orange-400 to-orange-600 w-2.5 h-8 rounded-full"></span>
                    إدارة <span class="text-orange-500">الطلبيات</span>
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-xs md:text-sm mt-1 font-medium">عرض، تصنيف، ومتابعة سجل حالات جميع عمليات الشراء</p>
            </div>

            {{-- Controls --}}
            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="relative flex-1 md:w-80">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-slate-400">
                        <i class="fas fa-search text-xs"></i>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text" 
                        class="block w-full pr-10 pl-4 py-2.5 text-xs font-medium text-slate-900 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 dark:text-white transition-all placeholder:text-slate-400" 
                        placeholder="ابحث برقم الطلب، المدينة، أو الهاتف...">
                </div>

                <button wire:click="$refresh" wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold active:scale-95 transition-all shadow-md shadow-orange-500/20 shrink-0">
                    <i class="fas fa-sync-alt" wire:loading.class="fa-spin"></i>
                    <span>تحديث</span>
                </button>
            </div>
        </div>

        {{-- Table Container --}}
        <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200/80 dark:border-slate-800 relative">
            
            {{-- Loading Bar --}}
            <div wire:loading.delay class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-orange-400 to-amber-500 animate-pulse z-10 rounded-t-3xl"></div>

            <div class="overflow-x-auto min-h-[400px]">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-200/80 dark:border-slate-800 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">
                            <th class="p-4 text-center w-20">الطلب</th>
                            <th class="p-4">الزبون</th>
                            <th class="p-4 text-center">المدينة</th>
                            <th class="p-4 text-center">المبلغ</th>
                            <th class="p-4 text-center">حالة الطلب</th>
                            <th class="p-4 text-center">السجل</th>
                            <th class="p-4 text-center w-20">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                        @forelse($orders as $order)
                        <tr wire:key="order-row-{{ $order->id }}" class="hover:bg-slate-50/60 dark:hover:bg-slate-800/30 transition-colors">
                            
                            {{-- ID --}}
                            <td class="p-4 text-center">
                                <span class="bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 py-1 px-2.5 rounded-lg font-mono font-bold">
                                    #{{ $order->id }}
                                </span>
                            </td>

                            {{-- Buyer --}}
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-orange-500 to-amber-400 flex items-center justify-center text-white font-bold text-xs shadow-sm shrink-0">
                                        {{ mb_substr($order->buyer->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div class="truncate">
                                        <p class="font-bold text-slate-800 dark:text-slate-200">{{ $order->buyer->name ?? 'مستخدم غير معروف' }}</p>
                                        <p class="text-[11px] text-slate-400 font-mono" dir="ltr">{{ $order->phone }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- City --}}
                            <td class="p-4 text-center">
                                <span class="text-slate-600 dark:text-slate-400 font-medium inline-flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-xs text-orange-500"></i>
                                    {{ $order->city }}
                                </span>
                            </td>

                            {{-- Total Price --}}
                            <td class="p-4 text-center font-bold text-slate-800 dark:text-white">
                                {{ number_format($order->total_price) }} <span class="text-[10px] font-normal text-slate-400">د.ج</span>
                            </td>
                            
                            {{-- Status Select & Save Button --}}
                            <td class="p-4 text-center">
                                @if(auth()->user()->isAdmin() || $order->seller_id === auth()->id())
                                    <div class="flex items-center justify-center gap-2">
                                        <select 
                                            wire:model="statuses.{{ $order->id }}"
                                            wire:loading.attr="disabled"
                                            wire:target="openStatusModal({{ $order->id }})"
                                            class="block w-32 px-2.5 py-1.5 text-xs font-bold border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all cursor-pointer"
                                        >
                                            <option value="pending">⏳ قيد الانتظار</option>
                                            <option value="processing">⚙️ جاري التحضير</option>
                                            <option value="shipped">🚚 تم الشحن</option>
                                            <option value="delivered">✅ تم التسليم</option>
                                            <option value="completed">🎉 مكتمل</option>
                                            <option value="cancelled">❌ ملغي</option>
                                        </select>

                                        <button
                                            type="button"
                                            wire:click="openStatusModal({{ $order->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="openStatusModal({{ $order->id }})"
                                            class="inline-flex items-center justify-center gap-1.5 min-w-20 px-3 py-1.5 rounded-xl bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold transition-colors disabled:cursor-not-allowed disabled:opacity-60 shrink-0"
                                        >
                                            <span wire:loading.remove wire:target="openStatusModal({{ $order->id }})">تحديث</span>
                                            <span wire:loading wire:target="openStatusModal({{ $order->id }})">
                                                <i class="fas fa-circle-notch fa-spin"></i>
                                            </span>
                                        </button>
                                    </div>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold border {{ $order->status_color }}">
                                        {{ $order->status_label }}
                                    </span>
                                @endif
                            </td>

                            {{-- History Dropdown --}}
                            <td class="p-4 text-center">
                                <div x-data="{ open: false }" class="relative inline-block text-right">
                                    <button @click="open = !open" @click.away="open = false" type="button" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                                        <i class="fas fa-history text-orange-500"></i>
                                        <span>السجل</span>
                                    </button>

                                    <div x-show="open" x-cloak
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="absolute z-50 left-0 mt-2 w-64 p-3 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-2xl">
                                        
                                        @forelse($order->statusHistories->take(5) as $history)
                                            <div class="flex items-start gap-2 py-2 {{ !$loop->last ? 'border-b border-slate-100 dark:border-slate-800' : '' }}">
                                                <span class="w-2 h-2 mt-1 rounded-full bg-orange-500 shrink-0"></span>
                                                <div class="text-right space-y-0.5">
                                                    <p class="text-xs font-bold text-slate-700 dark:text-slate-200">{{ $history->status_label ?? $history->status }}</p>
                                                    <p class="text-[10px] text-slate-400 font-mono">{{ $history->created_at->format('Y-m-d H:i') }}</p>
                                                    @if($history->note)
                                                        <p class="text-[10px] text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-800/60 p-1.5 rounded-lg mt-1 border border-slate-100 dark:border-slate-800/80">
                                                            {{ $history->note }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-xs text-slate-400 text-center py-1">لا يوجد سجل بعد.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td class="p-4 text-center">
                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-orange-500 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center">
                                <div class="flex flex-col items-center max-w-xs mx-auto">
                                    <div class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-3">
                                        <i class="fas fa-inbox text-slate-400 text-lg"></i>
                                    </div>
                                    <p class="text-slate-700 dark:text-slate-300 font-bold text-sm">لا توجد طلبات</p>
                                    <p class="text-slate-400 text-xs mt-1">لم نتمكن من العثور على أي نتائج مطابقة للبحث.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            @if($orders->hasPages())
            <div class="p-4 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-200/80 dark:border-slate-800 rounded-b-3xl">
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </div>

    {{-- Status Update Confirmation Modal --}}
    @if($showStatusModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" wire:click="closeModal"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-3xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200 dark:border-slate-800 p-6 space-y-5">
                
                {{-- Modal Header --}}
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                    <h3 class="text-lg font-extrabold text-slate-800 dark:text-white flex items-center gap-2">
                        <i class="fas fa-edit text-orange-500"></i>
                        تأكيد تحديث حالة الطلب #{{ $selectedOrderId }}
                    </h3>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                        <i class="fas fa-times text-base"></i>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">الحالة الجديدة المحددة:</label>
                        <select wire:model="selectedStatus" class="block w-full px-3 py-2.5 text-xs font-bold border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all cursor-pointer">
                            <option value="pending">⏳ قيد الانتظار</option>
                            <option value="processing">⚙️ جاري التحضير</option>
                            <option value="shipped">🚚 تم الشحن</option>
                            <option value="delivered">✅ تم التسليم</option>
                            <option value="completed">🎉 مكتمل</option>
                            <option value="cancelled">❌ ملغي</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">ملاحظة أو سبب التغيير (اختياري):</label>
                        <textarea wire:model="statusNote" rows="3" class="block w-full p-3 text-xs border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 placeholder:text-slate-400 transition-all" placeholder="أدخل سبب تعديل الحالة أو رقم التتبع..."></textarea>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button wire:click="closeModal" type="button" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                        إلغاء
                    </button>
                    <button wire:click="confirmUpdateStatus" wire:loading.attr="disabled" type="button" class="inline-flex items-center justify-center gap-2 px-5 py-2 rounded-xl bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold shadow-md shadow-orange-500/20 transition-all disabled:opacity-60">
                        <span wire:loading.remove wire:target="confirmUpdateStatus">تأكيد وحفظ</span>
                        <span wire:loading wire:target="confirmUpdateStatus"><i class="fas fa-spinner fa-spin"></i></span>
                    </button>
                </div>

            </div>
        </div>
    </div>
    @endif
</div>