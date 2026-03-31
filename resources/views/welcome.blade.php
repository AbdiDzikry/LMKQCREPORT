<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Quality Control Report System</title>

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
            .glass {
                background: rgba(255, 255, 255, 0.03);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            .glass-dark {
                background: rgba(15, 23, 42, 0.8);
                backdrop-filter: blur(16px);
                border: 1px solid rgba(255, 255, 255, 0.05);
            }
            .bg-industrial {
                background-image: linear-gradient(rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.8)), 
                                  url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
            }
            .animate-float {
                animation: float 6s ease-in-out infinite;
            }
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
                100% { transform: translateY(0px); }
            }
        </style>
    </head>
    <body class="antialiased bg-slate-950 text-slate-200 min-h-screen">
        <div class="relative bg-industrial min-h-screen flex flex-col">
            
            <!-- Navbar -->
            <nav class="sticky top-0 z-50 transition-all duration-300">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-20 items-center">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-indigo-600 rounded-xl shadow-lg shadow-indigo-500/30">
                                <x-application-logo class="w-8 h-8 fill-current text-white" />
                            </div>
                            <span class="text-2xl font-bold tracking-tight text-white">LMK <span class="text-indigo-400">QC</span></span>
                        </div>
                        <div class="flex items-center gap-4">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all shadow-lg shadow-indigo-500/20">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="text-slate-300 hover:text-white font-medium transition-colors">Log in</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all shadow-lg shadow-indigo-500/20 text-sm">Register</a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </nav>

            <main class="flex-grow flex items-center">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
                    <div class="grid lg:grid-cols-2 gap-16 items-center">
                        
                        <!-- Left Content -->
                        <div class="space-y-8">
                            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-indigo-500/30 bg-indigo-500/10 text-indigo-400 text-sm font-medium">
                                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                                Digital QC Reporting System v2.0
                            </div>
                            <h1 class="text-6xl lg:text-7xl font-extrabold text-white leading-tight">
                                Monitor Kualitas <br>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-emerald-400">Secara Instan.</span>
                            </h1>
                            <p class="text-xl text-slate-400 leading-relaxed max-w-lg">
                                Platform pelaporan Quality Control terpadu untuk tim LMK. Input laporan masalah, verifikasi berjenjang, dan ekspor data dalam satu dashboard intuitif.
                            </p>
                            <div class="flex flex-wrap gap-4 pt-4">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl transition-all shadow-xl shadow-indigo-600/30 flex items-center gap-2 text-lg group">
                                        Mulai Sekarang
                                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="px-8 py-4 bg-white hover:bg-slate-100 text-slate-900 font-bold rounded-2xl transition-all shadow-xl flex items-center gap-2 text-lg">
                                        Login ke Sistem
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                    </a>
                                @endauth
                                <a href="#features" class="px-8 py-4 glass text-white font-bold rounded-2xl transition-all hover:bg-white/10 flex items-center gap-2 text-lg">
                                    Lihat Fitur
                                </a>
                            </div>
                        </div>

                        <!-- Right Content (Visual) -->
                        <div class="relative hidden lg:block">
                            <div class="absolute -inset-4 bg-indigo-500/20 blur-3xl rounded-full"></div>
                            <div class="relative glass rounded-3xl p-8 shadow-2xl animate-float">
                                <div class="space-y-6">
                                    <div class="flex items-center justify-between border-b border-white/10 pb-4">
                                        <div class="h-4 w-32 bg-slate-700 rounded-full"></div>
                                        <div class="h-8 w-8 bg-indigo-500/20 rounded-lg"></div>
                                    </div>
                                    <div class="space-y-4">
                                        <div class="h-12 w-full bg-slate-800/50 rounded-xl"></div>
                                        <div class="h-12 w-3/4 bg-slate-800/50 rounded-xl"></div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="h-24 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center justify-center">
                                                <div class="text-center">
                                                    <div class="text-emerald-400 font-bold text-2xl">98%</div>
                                                    <div class="text-xs text-emerald-500/60 uppercase tracking-widest font-bold">Accuracy</div>
                                                </div>
                                            </div>
                                            <div class="h-24 bg-indigo-500/10 border border-indigo-500/20 rounded-2xl flex items-center justify-center">
                                                <div class="text-center">
                                                    <div class="text-indigo-400 font-bold text-2xl">450+</div>
                                                    <div class="text-xs text-indigo-500/60 uppercase tracking-widest font-bold">Reports</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-2">
                                        <div class="h-10 w-full bg-indigo-600/50 rounded-xl border border-indigo-400/30"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </main>

            <!-- Features Section -->
            <section id="features" class="bg-slate-900/50 backdrop-blur-md py-24 border-t border-white/5">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-16 space-y-4">
                        <h2 class="text-indigo-400 font-bold uppercase tracking-widest text-sm">Key Features</h2>
                        <p class="text-4xl font-bold text-white">Segala kemudahan dalam satu platform.</p>
                    </div>
                    <div class="grid md:grid-cols-3 gap-8 text-center">
                        <div class="p-8 rounded-3xl bg-slate-800/30 border border-white/5 hover:border-indigo-500/30 transition-all group">
                            <div class="w-16 h-16 bg-indigo-500/10 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-4">Input Digital</h3>
                            <p class="text-slate-400">Leader dapat menginput laporan masalah QC secara langsung melalui form yang didesain pintar.</p>
                        </div>
                        <div class="p-8 rounded-3xl bg-slate-800/30 border border-white/5 hover:border-purple-500/30 transition-all group">
                            <div class="w-16 h-16 bg-purple-500/10 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-4">Verifikasi Berlapis</h3>
                            <p class="text-slate-400">Section Head melakukan validasi laporan dengan otentikasi aman untuk akurasi data maksimal.</p>
                        </div>
                        <div class="p-8 rounded-3xl bg-slate-800/30 border border-white/5 hover:border-emerald-500/30 transition-all group">
                            <div class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-4">Ekspor Premium</h3>
                            <p class="text-slate-400">Unduh data laporan dalam format Excel atau PDF yang siap diteruskan ke manajemen perusahaan.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer -->
            <footer class="py-12 border-t border-white/5 bg-slate-950">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-slate-500 text-sm">
                    &copy; {{ date('Y') }} PT LMK Quality Control Team. Designed for performance.
                </div>
            </footer>
        </div>
    </body>
</html>
