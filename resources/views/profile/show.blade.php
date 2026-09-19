@extends('layouts.app')

@section('title', 'الملف الشخصي | TRICO')

@section('content')
<div class="min-h-screen bg-white dark:bg-[#0a0a0a] text-right py-16 transition-colors duration-500" dir="rtl">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        
        {{-- Header Section --}}
        <div class="mb-16 border-r-4 border-emerald-500 pr-6">
            <h1 class="text-5xl font-[900] text-zinc-900 dark:text-white tracking-tighter italic uppercase">الحساب الشخصي</h1>
            <p class="text-zinc-500 dark:text-zinc-400 mt-2 font-black uppercase tracking-[0.3em] text-[10px]">Manage your premium fashion profile</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- Sidebar: User Info Card --}}
            <div class="lg:col-span-4">
                <div class="bg-zinc-50 dark:bg-white/[0.03] border border-zinc-200 dark:border-white/10 rounded-[2.5rem] p-10 sticky top-28 shadow-xl backdrop-blur-sm">
                    <div class="text-center">
                        <div class="relative inline-block group">
                            <div class="w-40 h-40 bg-white dark:bg-[#121212] rounded-full mx-auto mb-8 flex items-center justify-center border border-zinc-200 dark:border-white/10 overflow-hidden shadow-inner">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-user-ninja text-6xl text-zinc-300 dark:text-zinc-700"></i>
                                @endif
                            </div>
                            <button class="absolute bottom-2 right-4 bg-emerald-500 text-black w-10 h-10 rounded-2xl flex items-center justify-center text-sm hover:rotate-12 hover:scale-110 transition-all shadow-lg shadow-emerald-500/20">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        
                        <h2 class="text-3xl font-black text-zinc-900 dark:text-white tracking-tight leading-none">{{ auth()->user()->name }}</h2>
                        <p class="text-emerald-500 font-bold text-xs mt-3 uppercase tracking-wider">{{ auth()->user()->email }}</p>
                        
                        <div class="mt-6 inline-flex items-center px-6 py-2 rounded-full text-[9px] font-[900] uppercase tracking-[0.2em]
                            @if(auth()->user()->role == 'admin') bg-rose-500/10 text-rose-500 border border-rose-500/20
                            @elseif(auth()->user()->role == 'vendor') bg-emerald-500/10 text-emerald-500 border border-emerald-500/20
                            @else bg-zinc-200 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 @endif">
                            {{ auth()->user()->role == 'admin' ? 'System Director' : (auth()->user()->role == 'vendor' ? 'Verified Vendor' : 'Premium Member') }}
                        </div>
                    </div>

                    <div class="mt-10 space-y-5 border-t border-zinc-200 dark:border-white/5 pt-8">
                        <div class="flex justify-between items-center">
                            <span class="text-zinc-400 dark:text-zinc-500 font-bold text-[10px] uppercase tracking-widest">الإعلانات النشطة</span>
                            <span class="text-zinc-900 dark:text-white font-black text-lg font-mono tracking-tighter">04</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-zinc-400 dark:text-zinc-500 font-bold text-[10px] uppercase tracking-widest">عضو منذ</span>
                            <span class="text-zinc-900 dark:text-white font-black text-sm uppercase tracking-tighter">{{ auth()->user()->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Content: Settings Form --}}
            <div class="lg:col-span-8">
                <div class="bg-zinc-50 dark:bg-white/[0.03] border border-zinc-200 dark:border-white/10 rounded-[2.5rem] p-10 lg:p-14 shadow-2xl backdrop-blur-sm">
                    <h3 class="text-2xl font-black text-zinc-900 dark:text-white mb-12 flex items-center gap-4 italic uppercase tracking-tighter">
                        <span class="w-3 h-10 bg-emerald-500 rounded-full"></span>
                        Account Settings
                    </h3>

                    <form action="#" method="POST" class="space-y-10">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Full Name --}}
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-zinc-500 dark:text-zinc-400 uppercase tracking-[0.2em] pr-2">الاسم الكامل</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}"
                                       class="w-full bg-white dark:bg-[#121212] border border-zinc-200 dark:border-white/5 rounded-2xl p-5 text-sm text-zinc-900 dark:text-zinc-100 font-bold focus:border-emerald-500/50 focus:ring-4 focus:ring-emerald-500/5 transition-all outline-none">
                            </div>

                            {{-- Email --}}
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-zinc-500 dark:text-zinc-400 uppercase tracking-[0.2em] pr-2">البريد الإلكتروني</label>
                                <input type="email" name="email" value="{{ auth()->user()->email }}"
                                       class="w-full bg-white dark:bg-[#121212] border border-zinc-200 dark:border-white/5 rounded-2xl p-5 text-sm text-zinc-900 dark:text-zinc-100 font-bold focus:border-emerald-500/50 focus:ring-4 focus:ring-emerald-500/5 transition-all outline-none">
                            </div>

                            {{-- Phone --}}
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-zinc-500 dark:text-zinc-400 uppercase tracking-[0.2em] pr-2">رقم الهاتف</label>
                                <input type="tel" name="phone" value="{{ auth()->user()->phone }}"
                                       class="w-full bg-white dark:bg-[#121212] border border-zinc-200 dark:border-white/5 rounded-2xl p-5 text-sm text-zinc-900 dark:text-zinc-100 font-bold focus:border-emerald-500/50 transition-all outline-none">
                            </div>

                            {{-- Whatsapp --}}
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-zinc-500 dark:text-zinc-400 uppercase tracking-[0.2em] pr-2">واتساب</label>
                                <input type="tel" name="whatsapp" value="{{ auth()->user()->whatsapp }}"
                                       class="w-full bg-white dark:bg-[#121212] border border-zinc-200 dark:border-white/5 rounded-2xl p-5 text-sm text-zinc-900 dark:text-zinc-100 font-bold focus:border-emerald-500/50 transition-all outline-none">
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-zinc-500 dark:text-zinc-400 uppercase tracking-[0.2em] pr-2">العنوان الحالي</label>
                            <textarea name="address" rows="3"
                                      class="w-full bg-white dark:bg-[#121212] border border-zinc-200 dark:border-white/5 rounded-2xl p-5 text-sm text-zinc-900 dark:text-zinc-100 font-bold focus:border-emerald-500/50 transition-all outline-none">{{ auth()->user()->address }}</textarea>
                        </div>

                        {{-- Password Section --}}
                        <div class="pt-12 border-t border-zinc-200 dark:border-white/5">
                            <h4 class="text-xs font-[900] text-zinc-900 dark:text-white mb-8 uppercase tracking-[0.3em] italic">Security & Password</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <input type="password" name="current_password" placeholder="كلمة المرور الحالية"
                                       class="w-full bg-white dark:bg-[#121212] border border-zinc-200 dark:border-white/5 rounded-2xl p-5 text-sm text-zinc-900 dark:text-zinc-100 font-bold focus:border-emerald-500/50 transition-all outline-none">
                                <input type="password" name="new_password" placeholder="كلمة المرور الجديدة"
                                       class="w-full bg-white dark:bg-[#121212] border border-zinc-200 dark:border-white/5 rounded-2xl p-5 text-sm text-zinc-900 dark:text-zinc-100 font-bold focus:border-emerald-500/50 transition-all outline-none">
                            </div>
                        </div>

                        <div class="flex justify-start pt-6">
                            <button type="submit" class="relative group overflow-hidden bg-zinc-900 dark:bg-white text-white dark:text-black px-16 py-5 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] transition-all hover:scale-[1.05] active:scale-95 shadow-2xl shadow-emerald-500/20">
                                <span class="absolute inset-0 w-full h-full bg-emerald-500 transition-transform duration-500 translate-y-full group-hover:translate-y-0"></span>
                                <span class="relative z-10 group-hover:text-black transition-colors duration-500">Update Profile</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection