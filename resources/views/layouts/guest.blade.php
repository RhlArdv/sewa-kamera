<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CameraSewa') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-zinc-950 bg-zinc-50 antialiased selection:bg-[#9E1B22] selection:text-white" style="font-family: 'Outfit', sans-serif;">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-10 sm:pt-0 relative overflow-hidden px-4">
        <div class="relative z-10 mb-8 mt-10 sm:mt-0">
            <a href="/" class="inline-flex items-center justify-center p-3 bg-[#9E1B22] border-2 border-zinc-950 rounded-2xl shadow-[4px_4px_0_0_#7A151B] hover:-translate-y-1 hover:shadow-[6px_6px_0_0_#7A151B] transition-all duration-300">
                <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    <circle cx="12" cy="13" r="3" stroke-width="2" />
                </svg>
            </a>
        </div>

        <div class="w-full sm:max-w-md px-8 py-10 bg-white border-2 border-zinc-950 shadow-[8px_8px_0_0_#9E1B22] rounded-[2rem] relative z-10">
            @yield('content')
        </div>
    </div>
</body>

</html>
