<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    <div class="mb-4">
                        <h3 class="font-bold text-lg">Welcome back, {{ auth()->user()->name }}
                            ({{ ucfirst(auth()->user()->role) }})</h3>
                        <p class="text-gray-600">You're logged in.</p>
                    </div>

                    @if(auth()->user()->role === 'section_head')
                        <div class="mb-4 bg-blue-50 border-l-4 border-blue-400 p-4">
                            <p class="text-blue-700">
                                <strong>Section Head View:</strong> You are viewing system-wide statistics for problem reports. Pending reports require your verification.
                            </p>
                        </div>
                    @else
                        <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4">
                            <p class="text-green-700">
                                <strong>Leader View:</strong> You are viewing statistics for the problem reports you have submitted.
                            </p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-yellow-100 p-4 rounded-lg shadow border border-yellow-200">
                            <h4 class="font-bold text-yellow-800">Pending Reports</h4>
                            <p class="text-3xl font-semibold mt-2 text-yellow-900">{{ $stats['pending'] }}</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg shadow border border-green-200">
                            <h4 class="font-bold text-green-800">Accepted Reports</h4>
                            <p class="text-3xl font-semibold mt-2 text-green-900">{{ $stats['accepted'] }}</p>
                        </div>
                        <div class="bg-red-100 p-4 rounded-lg shadow border border-red-200">
                            <h4 class="font-bold text-red-800">Rejected Reports</h4>
                            <p class="text-3xl font-semibold mt-2 text-red-900">{{ $stats['rejected'] }}</p>
                        </div>
                    </div>

                    <a href="{{ route('reports.index') }}"
                        class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow mt-2">
                        @if(auth()->user()->role === 'section_head')
                            Verify Pending Problem Reports
                        @else
                            Manage My Problem Reports
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>