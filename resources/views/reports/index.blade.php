<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if(auth()->user()->role === 'section_head')
                    {{ __('Verification Inbox (Problem Reports)') }}
                @else
                    {{ __('My Problem Reports') }}
                @endif
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full whitespace-no-wrap table-auto">
                        <thead>
                            <tr class="text-left font-bold border-b border-gray-200">
                                <th class="px-4 py-3">Date</th>
                                <th class="px-4 py-3">Part Info</th>
                                <th class="px-4 py-3">Problem</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="px-4 py-3">{{ $report->report_date->format('d M Y') }}</td>
                                    <td class="px-4 py-3">
                                        <strong>No:</strong> {{ $report->part_number }}<br>
                                        <strong>Name:</strong> {{ $report->part_name }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ ucfirst($report->problem_type) }}<br>
                                        <span class="text-sm text-gray-500">{{ Str::limit($report->detail, 30) }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($report->status === 'pending')
                                            <span
                                                class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-semibold">Pending</span>
                                        @elseif($report->status === 'accepted')
                                            <span
                                                class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">Accepted</span>
                                        @else
                                            <span
                                                class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs font-semibold">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        <a href="{{ route('reports.show', ['report' => $report->id]) }}"
                                            class="text-blue-500 hover:underline">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-3 text-center text-gray-500">No reports found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>