<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Google Fonts for Neobrutalism -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] text-[#1b1b18] font-['Inter'] antialiased min-h-screen flex flex-col relative overflow-x-hidden">
        <!-- Decorative Grid Background (Subtle) -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px] pointer-events-none z-0"></div>

        <!-- Navbar (Minimal Neobrutalist) -->
        <header class="w-full border-b-4 border-black bg-white relative z-50">
            <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="CameraSewa Logo" class="h-14 lg:h-16 w-auto object-contain drop-shadow-sm">
                    <span class="font-extrabold text-2xl lg:text-3xl tracking-tight" style="font-family: 'Syne', sans-serif;">CameraSewa</span>
                </div>
                @if (Route::has('login'))
                    <nav class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2 font-bold text-sm border-2 border-black rounded-lg shadow-[2px_2px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all bg-[#f8b803]">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="font-bold text-sm hover:underline underline-offset-4">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2 font-bold text-sm border-2 border-black rounded-lg shadow-[2px_2px_0px_rgba(0,0,0,1)] hover:shadow-none hover:translate-x-[2px] hover:translate-y-[2px] transition-all bg-white">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        <!-- Hero Section -->
        <main class="w-full max-w-7xl mx-auto px-6 py-16 lg:py-24 grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-8 items-center relative z-10 grow">
            
            <!-- Left Column: Content & CTA -->
            <div class="flex flex-col items-start z-20">
                <div class="inline-block px-4 py-1.5 mb-6 border-2 border-black rounded-full bg-[#f8b803] text-black font-bold text-xs sm:text-sm uppercase tracking-wider shadow-[4px_4px_0px_rgba(0,0,0,1)]">
                    #1 Camera Rental Service
                </div>
                
                <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-black leading-[1.1] mb-6 tracking-tight" style="font-family: 'Syne', sans-serif;">
                    Abadikan Momen <br>
                    <span class="text-[#9E1B22] relative inline-block">
                        Tanpa Batas
                        <!-- Decorative underline -->
                        <svg class="absolute w-full h-4 -bottom-1 left-0 text-[#f8b803] -z-10" fill="none" viewBox="0 0 100 10" preserveAspectRatio="none">
                            <path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="8" stroke-linecap="round"/>
                        </svg>
                    </span>
                </h1>
                
                <p class="text-lg text-gray-800 mb-10 max-w-lg font-medium leading-relaxed">
                    Pilihan kamera lengkap untuk kebutuhan fotografi dan videografi Anda. Bebas repot dengan syarat mudah dan peralatan 100% terawat.
                </p>
                
                <!-- USPs -->
                <div class="flex flex-col sm:flex-row gap-4 mb-10 w-full max-w-lg">
                    <div class="flex-1 border-2 border-black bg-white p-4 rounded-xl shadow-[4px_4px_0px_rgba(0,0,0,1)] flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#f8b803] border border-black flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="font-bold text-sm">Mulai Rp25rb/jam</span>
                    </div>
                    <div class="flex-1 border-2 border-black bg-white p-4 rounded-xl shadow-[4px_4px_0px_rgba(0,0,0,1)] flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-[#9E1B22] border border-black flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span class="font-bold text-sm">Same day pickup</span>
                    </div>
                </div>

                <!-- CTAs -->
                <div class="flex flex-wrap gap-4">
                    <a href="#" class="px-8 py-4 bg-[#9E1B22] text-white font-bold text-lg rounded-xl border-4 border-black shadow-[6px_6px_0px_rgba(0,0,0,1)] hover:shadow-[2px_2px_0px_rgba(0,0,0,1)] hover:translate-x-[4px] hover:translate-y-[4px] transition-all flex items-center gap-2">
                        Sewa Sekarang
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                    <a href="#" class="px-8 py-4 bg-white text-black font-bold text-lg rounded-xl border-4 border-black shadow-[6px_6px_0px_rgba(0,0,0,1)] hover:shadow-[2px_2px_0px_rgba(0,0,0,1)] hover:translate-x-[4px] hover:translate-y-[4px] transition-all">
                        Lihat Katalog
                    </a>
                </div>
            </div>

            <!-- Right Column: Product Showcase (Layered, Overflow-visible) -->
            <div class="relative w-full h-[500px] sm:h-[600px] bg-white border-4 border-black rounded-[24px] shadow-[12px_12px_0px_rgba(0,0,0,1)] lg:shadow-[16px_16px_0px_rgba(0,0,0,1)] p-8 overflow-visible mt-10 lg:mt-0 flex items-end justify-center">
                
                <!-- Decorative Elements escaping the frame -->
                <div class="absolute -top-6 -right-6 w-20 h-20 bg-[#f8b803] border-4 border-black rounded-full flex items-center justify-center shadow-[4px_4px_0px_rgba(0,0,0,1)] z-50 transform rotate-12">
                    <span class="font-bold text-sm leading-tight text-center">New<br>Arrival</span>
                </div>

                <!-- Abstract shape overlapping bottom left -->
                <svg class="absolute -bottom-8 -left-8 w-24 h-24 text-[#9E1B22] z-50 pointer-events-none drop-shadow-[4px_4px_0px_rgba(0,0,0,1)]" viewBox="0 0 100 100" fill="currentColor">
                    <polygon points="50,0 100,50 50,100 0,50" stroke="black" stroke-width="4" stroke-linejoin="round"/>
                </svg>

                <!-- Multi-level Podium Composition -->
                <div class="relative w-full h-full flex justify-center items-end pb-10">

                    <!-- BACKGROUND LAYER (Highest Podium) -->
                    <div class="absolute right-0 sm:right-10 bottom-24 w-32 sm:w-48 h-64 sm:h-80 bg-gray-50 border border-gray-200 rounded-t-lg shadow-xl flex flex-col items-center pt-6 z-10 transition-transform hover:-translate-y-2">
                        <!-- Camera 3 Container -->
                        <div class="w-full h-32 flex items-center justify-center overflow-visible relative group">
                            <!-- Soft Realistic Shadow -->
                            <div class="absolute -bottom-2 w-24 h-4 bg-black/25 blur-md rounded-[100%]"></div>
                            <!-- Camera Image -->
                            <img src="{{ asset('assets/img/camera-xa2.png') }}" onerror="this.src='https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=300&q=80'" class="w-[130%] max-w-none object-contain mix-blend-multiply absolute -top-8 drop-shadow-2xl transition-transform duration-500 group-hover:scale-110" alt="Fujifilm X-A2">
                        </div>
                        <!-- Floating Label -->
                        <div class="absolute -left-4 sm:-left-8 top-12 bg-white/90 backdrop-blur-md border border-gray-100 px-3 py-1.5 rounded-md shadow-lg text-xs font-semibold text-gray-800">
                            Fujifilm X-A2
                        </div>
                    </div>

                    <!-- MIDDLE GROUND LAYER (Medium Podium) -->
                    <div class="absolute left-0 sm:left-4 bottom-16 w-36 sm:w-56 h-48 sm:h-64 bg-white border border-gray-100 rounded-t-lg shadow-[0_20px_40px_-10px_rgba(0,0,0,0.15)] flex flex-col items-center pt-4 z-20 transition-transform hover:-translate-y-2">
                        <!-- Camera 2 Container -->
                        <div class="w-full h-36 flex items-center justify-center overflow-visible relative group">
                            <!-- Soft Realistic Shadow -->
                            <div class="absolute bottom-2 w-28 h-6 bg-black/20 blur-md rounded-[100%]"></div>
                            <!-- Camera Image -->
                            <img src="{{ asset('assets/img/camera-m10.png') }}" onerror="this.src='https://images.unsplash.com/photo-1564466809058-bf4114d55352?auto=format&fit=crop&w=300&q=80'" class="w-[120%] max-w-none object-contain mix-blend-multiply absolute -top-6 drop-shadow-2xl transition-transform duration-500 group-hover:scale-110" alt="Canon EOS M10">
                        </div>
                        <!-- Floating Label -->
                        <div class="absolute -right-4 sm:-right-8 top-16 bg-white/90 backdrop-blur-md border border-gray-100 px-3 py-1.5 rounded-md shadow-lg text-xs font-semibold text-gray-800">
                            Canon EOS M10
                        </div>
                    </div>

                    <!-- FOREGROUND LAYER (Lowest, Largest Podium) -->
                    <div class="relative w-64 sm:w-80 h-32 sm:h-48 bg-white border-t border-x border-gray-200 rounded-t-xl shadow-[0_-15px_40px_-15px_rgba(0,0,0,0.2)] flex flex-col items-center z-30 transition-transform hover:-translate-y-2">
                        <!-- Camera 1 Container -->
                        <div class="w-full h-full flex items-center justify-center overflow-visible relative group">
                            <!-- Soft Realistic Shadow -->
                            <div class="absolute top-10 w-48 h-8 bg-black/30 blur-xl rounded-[100%]"></div>
                            
                            <!-- INTENTIONAL OVERFLOW STRAP -->
                            <!-- This simulates a camera strap extending OUT of the hero card -->
                            <svg class="absolute -bottom-16 sm:-bottom-24 -right-16 sm:-right-32 w-32 sm:w-48 h-32 sm:h-48 text-[#1b1b18] z-50 pointer-events-none drop-shadow-2xl" fill="none" stroke="currentColor" viewBox="0 0 100 100">
                                <path d="M20,10 C40,80 80,60 95,95" stroke-width="6" stroke-linecap="round" class="animate-pulse"></path>
                            </svg>

                            <!-- Camera Image -->
                            <img src="{{ asset('assets/img/camera-m100.png') }}" onerror="this.src='https://images.unsplash.com/photo-1502920917128-1aa500764cbd?auto=format&fit=crop&w=500&q=80'" class="w-[140%] sm:w-[150%] max-w-none object-contain mix-blend-multiply absolute -top-24 sm:-top-32 drop-shadow-[0_25px_35px_rgba(0,0,0,0.4)] transition-transform duration-500 group-hover:scale-105" alt="Canon EOS M100">
                        </div>
                        <!-- Floating Label -->
                        <div class="absolute -top-10 bg-black text-white px-5 py-2.5 rounded-lg shadow-xl text-sm font-bold border border-gray-700">
                            Canon EOS M100
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </body>
</html>
