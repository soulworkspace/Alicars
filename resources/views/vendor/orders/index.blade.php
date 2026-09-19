@extends('layouts.app')

@section('content')
<div class="bg-zinc-50 dark:bg-zinc-950 min-h-screen py-24" dir="rtl">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-black text-zinc-900 dark:text-white mb-10 tracking-tighter uppercase">الطلبات الواردة</h1>

        <div class="grid gap-6">
            @forelse($orders as $order)
                <div class="bg-white dark:bg-zinc-900 p-6 rounded-[2rem] border border-zinc-200 dark:border-white/5 flex flex-wrap md:flex-nowrap items-center gap-8 shadow-xl">
                    {{-- صورة المنتج --}}
                    <div class="w-24 h-24 rounded-2xl overflow-hidden bg-zinc-100">
                        <img src="{{ asset('storage/' . $order->listing->image) }}" class="w-full h-full object-cover">
                    </div>

                    {{-- معلومات الطلب --}}
                    <div class="flex-1">
                        <h3 class="text-lg font-black text-zinc-900 dark:text-white">{{ $order->listing->title }}</h3>
                        <p class="text-xs text-zinc-400 font-bold mt-1 uppercase">المشتري: {{ $order->buyer->name }}</p>
                        <div class="flex gap-4 mt-3">
                            <span class="text-[10px] font-black px-3 py-1 bg-zinc-100 dark:bg-white/5 rounded-full text-zinc-500 uppercase italic">مقاس: {{ $order->size }}</span>
                            <span class="text-[10px] font-black px-3 py-1 bg-zinc-100 dark:bg-white/5 rounded-full text-zinc-500 uppercase italic">لون: {{ $order->color }}</span>
                        </div>
                    </div>

                    {{-- الحالة والتحكم --}}
                    <div class="flex flex-col items-end gap-3">
                        <span class="text-xl font-black text-emerald-500 italic font-international">{{ number_format($order->total_price) }} DZD</span>
                        
                        @if($order->status == 'pending')
                            <form action="{{ route('vendor.orders.update', $order->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="shipping">
                                <button class="bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 px-8 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-emerald-500 hover:text-white transition-all">
                                    تأكيد الشحن الآن
                                </button>
                            </form>
                        @else
                            <span class="text-[10px] font-black text-emerald-500 uppercase border border-emerald-500/20 px-4 py-2 rounded-xl">تم الشحن</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-20 opacity-30">
                    <i class="fa-solid fa-box-open text-6xl mb-4"></i>
                    <p class="font-black uppercase tracking-widest">لا توجد طلبات حالياً</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection