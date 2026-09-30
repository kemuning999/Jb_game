<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ANDRA JB') }} - Autentikasi</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    </head>
    <body class="bg-[#f8fafc] text-slate-800 antialiased selection:bg-indigo-600 selection:text-white">
        <div class="min-h-screen flex flex-col justify-center items-center py-12 sm:px-6 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
                <a href="/" class="inline-flex items-center space-x-3 group">
                    <div class="w-12 h-12 rounded-2xl bg-slate-900 border border-slate-800 flex items-center justify-center p-2 shadow-md shadow-slate-900/10 group-hover:scale-105 transition-transform duration-200 text-white">
                        <x-andra-jb-logo />
                    </div>
                    <div class="text-left">
                        <span class="text-2xl font-black tracking-tight text-slate-900 block">ANDRA JB</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-indigo-600 block">Marketplace Akun Game</span>
                    </div>
                </a>
            </div>

            <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4 sm:px-0">
                <div class="bg-white py-8 px-6 sm:px-10 border border-slate-200 shadow-xs rounded-3xl">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
