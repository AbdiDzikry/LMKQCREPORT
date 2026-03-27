<!-- Permanent Sidebar -->
<nav
    class="bg-indigo-900 border-r border-indigo-800 w-64 shrink-0 min-h-screen flex flex-col text-white transition-all duration-300">
    <!-- Logo -->
    <div class="h-16 flex items-center px-6 border-b border-indigo-800 bg-indigo-950">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <x-application-logo class="w-8 h-8 fill-current text-white" />
            <span class="font-bold text-lg tracking-wider">LMK QC</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 py-6 px-4 space-y-2 overflow-y-auto">

        <a href="{{ route('dashboard') }}"
            class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-800 text-white' : 'text-indigo-200 hover:bg-indigo-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            {{ __('Dashboard') }}
        </a>

        @if(auth()->user()->role === 'leader')
            <div class="pt-4 pb-2">
                <p class="px-3 text-xs font-semibold text-indigo-300 uppercase tracking-wider">Laporan Problem</p>
            </div>

            <a href="{{ route('reports.create') }}"
                class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('reports.create') ? 'bg-indigo-800 text-white' : 'text-indigo-200 hover:bg-indigo-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ __('Input Laporan Baru') }}
            </a>

            <a href="{{ route('reports.index') }}"
                class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('reports.index') && !request()->routeIs('reports.create') ? 'bg-indigo-800 text-white' : 'text-indigo-200 hover:bg-indigo-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                {{ __('Laporan Saya') }}
            </a>
        @endif

        @if(auth()->user()->role === 'section_head')
            <div class="pt-4 pb-2">
                <p class="px-3 text-xs font-semibold text-indigo-300 uppercase tracking-wider">Verifikasi</p>
            </div>

            <a href="{{ route('reports.index') }}"
                class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('reports.index') ? 'bg-indigo-800 text-white' : 'text-indigo-200 hover:bg-indigo-800 hover:text-white' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ __('Kotak Masuk') }}
            </a>
        @endif
    </div>

    <!-- User & Settings -->
    <div class="border-t border-indigo-800 p-4 bg-indigo-950">
        <x-dropdown align="top" width="48">
            <x-slot name="trigger">
                <button
                    class="w-full flex items-center justify-between px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-200 hover:text-white hover:bg-indigo-800 focus:outline-none transition ease-in-out duration-150">
                    <div class="flex items-center gap-2 overflow-hidden">
                        <div
                            class="w-8 h-8 rounded-full bg-indigo-700 flex items-center justify-center font-bold text-white uppercase shrink-0">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="text-left truncate">
                            <p class="truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-indigo-400 capitalize truncate">{{ Auth::user()->role }}</p>
                        </div>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile Settings') }}
                </x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</nav>