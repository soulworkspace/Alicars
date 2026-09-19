<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HADJ AISSA — Register</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN & Palette Configuration -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        ha: {
                            blue: '#3B9AE1',
                            navy: '#182945',
                            red: '#D9383A',
                            dark: '#080C14'
                        }
                    }
                }
            }
        }
    </script>
    @livewireStyles
    
    <style>
        svg { max-width: 100%; height: auto; }
        .glass-card {
            background: rgba(24, 41, 69, 0.45);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(59, 154, 225, 0.15);
        }
    </style>
</head>
<body class="bg-[#080C14] text-zinc-100 font-sans min-h-screen antialiased selection:bg-[#3B9AE1] selection:text-white">

<div class="relative min-h-screen w-full flex items-center justify-center bg-[#080C14] py-12 px-4 sm:px-6 lg:px-8 overflow-hidden">
    
    <!-- Ambient Background Glows matching HADJ AISSA Colors -->
    <div class="absolute top-1/4 -right-32 w-96 h-96 bg-[#3B9AE1]/15 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute bottom-1/4 -left-32 w-96 h-96 bg-[#D9383A]/10 rounded-full blur-[140px] pointer-events-none"></div>

    <!-- Main Card Container -->
    <div class="relative w-full max-w-lg glass-card p-8 sm:p-10 rounded-3xl shadow-[0_30px_70px_-15px_rgba(0,0,0,0.9)] text-center my-auto transition-all duration-300">
        
        <!-- Header / Logo -->
        <div class="mb-8">
            <div class="inline-flex items-center justify-center py-2 px-6 rounded-2xl bg-[#182945]/80 border border-[#3B9AE1]/20 shadow-lg shadow-[#3B9AE1]/10 mb-4 mx-auto">
                <span class="text-2xl font-black italic tracking-wider text-white uppercase">
                    HADJ <span class="text-[#3B9AE1]">H</span><span class="text-[#D9383A]">A</span>ISSA
                </span>
            </div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-white uppercase italic tracking-tight">
                Create Your Account
            </h2>
            <p class="text-xs text-zinc-400 font-medium mt-1">Welcome to HADJ AISSA Automotive Portal</p>
        </div>

        <form wire:submit.prevent="register" class="space-y-4">
            
            <!-- Full Name -->
            <div class="space-y-1 text-left">
                <label class="text-[11px] font-bold text-zinc-400 uppercase tracking-wider block ml-1">Full Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-zinc-500">
                        <svg style="width:16px; height:16px;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <input wire:model="name" type="text" placeholder="John Doe" class="w-full bg-[#080C14]/80 border border-zinc-800 focus:border-[#3B9AE1] py-3.5 pl-11 pr-4 rounded-xl text-sm text-white placeholder-zinc-600 outline-none transition-all duration-200 shadow-inner focus:ring-2 focus:ring-[#3B9AE1]/20">
                </div>
                @error('name') <span class="text-[#D9383A] text-xs ml-1 font-medium">{{ $message }}</span> @enderror
            </div>

            <!-- Phone & Email Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Phone Number -->
                <div class="space-y-1 text-left">
                    <label class="text-[11px] font-bold text-zinc-400 uppercase tracking-wider block ml-1">Phone Number</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-zinc-500">
                            <svg style="width:16px; height:16px;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <input wire:model="phone" type="text" placeholder="05XXXXXXXX" class="w-full bg-[#080C14]/80 border border-zinc-800 focus:border-[#3B9AE1] py-3.5 pl-11 pr-4 rounded-xl text-sm text-white placeholder-zinc-600 outline-none transition-all duration-200 shadow-inner focus:ring-2 focus:ring-[#3B9AE1]/20">
                    </div>
                    @error('phone') <span class="text-[#D9383A] text-xs ml-1 font-medium">{{ $message }}</span> @enderror
                </div>

                <!-- Email Address -->
                <div class="space-y-1 text-left">
                    <label class="text-[11px] font-bold text-zinc-400 uppercase tracking-wider block ml-1">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-zinc-500">
                            <svg style="width:16px; height:16px;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <input wire:model="email" type="email" placeholder="example@email.com" class="w-full bg-[#080C14]/80 border border-zinc-800 focus:border-[#3B9AE1] py-3.5 pl-11 pr-4 rounded-xl text-sm text-white placeholder-zinc-600 outline-none transition-all duration-200 shadow-inner focus:ring-2 focus:ring-[#3B9AE1]/20">
                    </div>
                    @error('email') <span class="text-[#D9383A] text-xs ml-1 font-medium">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Password -->
            <div class="space-y-1 text-left">
                <label class="text-[11px] font-bold text-zinc-400 uppercase tracking-wider block ml-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-zinc-500">
                        <svg style="width:16px; height:16px;" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input wire:model="password" type="password" placeholder="••••••••" class="w-full bg-[#080C14]/80 border border-zinc-800 focus:border-[#3B9AE1] py-3.5 pl-11 pr-4 rounded-xl text-sm text-white placeholder-zinc-600 outline-none transition-all duration-200 shadow-inner focus:ring-2 focus:ring-[#3B9AE1]/20">
                </div>
                @error('password') <span class="text-[#D9383A] text-xs ml-1 font-medium">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full mt-4 bg-gradient-to-r from-[#3B9AE1] to-[#182945] hover:from-[#3B9AE1]/90 hover:to-[#182945]/90 text-white py-4 rounded-xl font-black text-xs uppercase tracking-[0.2em] shadow-lg shadow-[#3B9AE1]/20 active:scale-[0.98] transition-all duration-200 block">
                Create Account
            </button>
        </form>

        <!-- Footer Link -->
        <p class="mt-8 text-xs font-semibold text-zinc-500">
            Already have an account? 
            <a href="{{ route('login') }}" class="text-white hover:text-[#3B9AE1] underline underline-offset-4 decoration-[#3B9AE1]/50 hover:decoration-[#3B9AE1] transition-colors duration-200 ml-1">
                Sign In
            </a>
        </p>
    </div>
</div>

@livewireScripts
</body>
</html>