<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Authentication</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Outfit', sans-serif;
            }
            .bg-auth {
                background-image: linear-gradient(rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.85)), 
                                  url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
                background-size: cover;
                background-position: center;
            }
            .glass-card {
                background: rgba(255, 255, 255, 0.05);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            }
        </style>
    </head>
    <body class="antialiased bg-slate-950 text-slate-200">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-auth px-4">
            <div class="mb-8 animate-bounce-slow">
                <a href="/" class="flex flex-col items-center gap-4 group">
                    <div class="p-4 bg-indigo-600 rounded-2xl shadow-2xl shadow-indigo-500/40 group-hover:scale-110 transition-transform">
                        <x-application-logo class="w-12 h-12 fill-current text-white" />
                    </div>
                    <span class="text-3xl font-bold tracking-tight text-white">LMK <span class="text-indigo-400">QC</span></span>
                </a>
            </div>

            <div class="w-full sm:max-w-md glass-card p-8 rounded-3xl overflow-hidden">
                <div class="mb-6 text-center">
                    <h2 class="text-2xl font-bold text-white">Selamat Datang</h2>
                    <p class="text-slate-400 text-sm mt-1">Silakan login untuk mengakses dashboard QC.</p>
                </div>
                {{ $slot }}
            </div>

            <div class="mt-8 text-slate-500 text-xs">
                &copy; {{ date('Y') }} PT LMK Quality Control Team.
            </div>
        </div>
    </body>
</html>
