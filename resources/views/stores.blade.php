@extends('layouts.app')

@section('title', 'المتاجر الموثوقة | TRICO - وجهة الموضة في الجزائر')

@section('content')
<div class="bg-[#0f172a] text-white min-h-screen">
    <div class="container mx-auto px-6 py-24">
        
        <div class="max-w-3xl mb-16">
            <h1>resources\views\stores.blade.php</h1>
            <h2 class="text-6xl font-black tracking-tighter leading-tight mb-6 uppercase">
                المتاجر <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">الموثوقة</span>
            </h2>
            <p class="text-gray-400 text-lg leading-relaxed border-r-4 border-emerald-500 pr-4">
                اكتشف نخبة بائعي الملابس والتريكو في الجزائر. بائعونا يضمنون الجودة، التصميم، وسرعة التوصيل.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            
            {{-- بطاقة المتجر - مثال --}}
            @forelse($stores as $store)
            <div class="group relative bg-white/5 backdrop-blur-sm border border-white/10 rounded-[2rem] p-8 hover:bg-white/10 transition-all duration-500 hover:-translate-y-2 overflow-hidden">
                <div class="absolute -bottom-12 -left-12 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl group-hover:bg-emerald-500/20 transition-all"></div>
                
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-8">
                        <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/20 group-hover:scale-110 transition-transform duration-500">
                            {{-- يمكن وضع شعار المتجر هنا --}}
                            <span class="text-2xl font-bold">TR</span> 
                        </div>
                        <span class="bg-emerald-500/10 text-emerald-400 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest border border-emerald-500/20">
                            Verified Seller
                        </span>
                    </div>

                    <h3 class="text-2xl font-bold mb-3 group-hover:text-emerald-400 transition-colors">{{ $store->name ?? 'اسم المتجر الاحترافي' }}</h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-8 line-clamp-2 italic">
                        "أفضل التشكيلات الحصرية من التيشرتات القطنية والهوديز بتصاميم محلية وعالمية."
                    </p>

                    <div class="flex items-center justify-between pt-6 border-t border-white/5">
                        <div class="flex -space-x-2 space-x-reverse">
                             {{-- أيقونات توضح تقييم أو فئات المتجر --}}
                             <div class="w-8 h-8 rounded-full border-2 border-[#0f172a] bg-gray-700 flex items-center justify-center text-[10px]">+12</div>
                        </div>
                        <a href="#" class="inline-flex items-center gap-2 text-emerald-400 font-bold text-xs uppercase tracking-[0.2em] group/link">
                            زيارة المتجر 
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover/link:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @empty
                {{-- في حال لم توجد بيانات --}}
                <div class="col-span-full text-center py-20 border-2 border-dashed border-white/10 rounded-[2rem]">
                    <p class="text-gray-500">لا يوجد بائعون متاحون حالياً.</p>
                </div>
            @endforelse

        </div>
    </div>
</div>

<style>
    .heavy-title {
        letter-spacing: -0.05em;
    }
</style>
@endsection