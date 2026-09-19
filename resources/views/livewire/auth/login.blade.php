<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HADJ AISSA — Sign In</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
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
                            bg: '#080C14'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* CSS Reset & Direct Styles to guarantee visibility */
        body, html {
            background-color: #080C14 !important;
            color: #ffffff !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        /* Glassmorphism Background Card */
        .glass-container {
            background: rgba(24, 41, 69, 0.65) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(59, 154, 225, 0.2) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.85) !important;
        }

        /* Input Form Styles */
        .ha-input {
            background-color: #080C14 !important;
            border: 1px solid #27272a !important;
            color: #ffffff !important;
            transition: all 0.2s ease-in-out !important;
        }

        .ha-input:focus {
            border-color: #3B9AE1 !important;
            box-shadow: 0 0 0 3px rgba(59, 154, 225, 0.2) !important;
            outline: none !important;
        }

        .ha-input::placeholder {
            color: #71717a !important;
        }

        /* Action Button */
        .ha-btn {
            background: linear-gradient(135deg, #3B9AE1 0%, #182945 100%) !important;
            color: #ffffff !important;
            transition: all 0.2s ease-in-out !important;
        }

        .ha-btn:hover {
            opacity: 0.95 !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 10px 20px -5px rgba(59, 154, 225, 0.3) !important;
        }

        .ha-btn:active {
            transform: translateY(0) !important;
        }
    </style>
</head>
<body>

<div class="relative min-h-screen w-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 overflow-hidden">
    
    <!-- Ambient Background Glows -->
    <div class="absolute top-1/4 -right-32 w-96 h-96 bg-[#3B9AE1]/15 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute bottom-1/4 -left-32 w-96 h-96 bg-[#D9383A]/10 rounded-full blur-[140px] pointer-events-none"></div>

    <!-- Main Card Container -->
    <div class="glass-container relative w-full max-w-md p-8 sm:p-10 rounded-3xl text-center my-auto transition-all duration-300">
        
        <!-- Header & Brand Logo -->
        <div class="mb-8">
            <div class="inline-flex items-center justify-center py-2.5 px-6 rounded-2xl bg-[#182945] border border-[#3B9AE1]/30 shadow-lg mb-4 mx-auto">
                <span class="text-2xl font-black italic tracking-wider text-white uppercase">
                    HADJ <span class="text-[#3B9AE1]">H</span><span class="text-[#D9383A]">A</span>ISSA
                </span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black text-white uppercase italic tracking-tight mt-2">
                Welcome Back
            </h2>
            <p class="text-xs text-zinc-400 font-medium mt-1">Sign in to your secure account</p>
        </div>

        <!-- Livewire Form -->
        <form wire:submit.prevent="authenticate" class="space-y-5">
            
            <!-- Email or Phone Field -->
            <div class="space-y-1.5 text-left">
                <label class="text-[11px] font-bold text-zinc-300 uppercase tracking-wider block ml-1">
                    Phone or Email Address
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-zinc-500">
                        <svg class="w-4 h-4" style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <input wire:model="login" type="text" placeholder="05XXXXXXXX / example@email.com" class="ha-input w-full py-3.5 pl-11 pr-4 rounded-xl text-sm font-medium">
                </div>
                @error('login') <span class="text-[#D9383A] text-xs ml-1 font-semibold block mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Password Field -->
            <div class="space-y-1.5 text-left">
                <label class="text-[11px] font-bold text-zinc-300 uppercase tracking-wider block ml-1">
                    Password
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-zinc-500">
                        <svg class="w-4 h-4" style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <input wire:model="password" type="password" placeholder="••••••••" class="ha-input w-full py-3.5 pl-11 pr-4 rounded-xl text-sm font-medium">
                </div>
                @error('password') <span class="text-[#D9383A] text-xs ml-1 font-semibold block mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="ha-btn w-full mt-4 py-4 rounded-xl font-black text-xs uppercase tracking-[0.2em] shadow-xl cursor-pointer">
                Secure Login
            </button>
        </form>

        <!-- Register Link -->
        <p class="mt-8 text-xs font-semibold text-zinc-400">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-[#3B9AE1] hover:text-white underline underline-offset-4 decoration-[#3B9AE1] transition-colors font-bold ml-1">
                Sign up
            </a>
        </p>
    </div>
</div>

</body>
</html>