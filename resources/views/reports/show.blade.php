<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report Details') }} - {{ $report->part_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Date</span>
                            <span class="block text-lg">{{ $report->report_date->format('d F Y') }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Submitted By</span>
                            <span class="block text-lg">{{ $report->user->name ?? 'Unknown' }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Section</span>
                            <span class="block text-lg">{{ $report->section }}</span>
                        </div>
                        @if($report->section === '2W' && $report->comp_name_2w)
                            <div>
                                <span class="block text-sm font-medium text-gray-500">Component Name (2W)</span>
                                <span class="block text-lg capitalize">{{ $report->comp_name_2w }}</span>
                            </div>
                        @endif
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Part Info</span>
                            <span class="block text-lg">{{ $report->part_number }} - {{ $report->part_name }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Customer</span>
                            <span class="block text-lg">{{ $report->customer }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Line Problem</span>
                            <span class="block text-lg">{{ $report->line_problem }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Category & Type</span>
                            <span class="block text-lg">{{ $report->category }} ({{ $report->type }})</span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Problem Type</span>
                            <span class="block text-lg capitalize">{{ $report->problem_type }}
                                ({{ ucfirst($report->problem_status) }})</span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Quantity</span>
                            <span class="block text-lg">{{ $report->quantity }} Pcs</span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Vendor</span>
                            <span class="block text-lg">{{ $report->vendor }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500">PIC QC</span>
                            <span class="block text-lg">{{ $report->pic_qc }}</span>
                        </div>
                    </div>

                    <div class="mt-6 border-t pt-4">
                        <span class="block text-sm font-medium text-gray-500 mb-1">Detail Problem</span>
                        <p class="whitespace-pre-line text-lg">{{ $report->detail }}</p>
                    </div>

                    <div class="mt-6 border-t pt-4">
                        <span class="block text-sm font-medium text-gray-500">Verification Status</span>
                        @if($report->status === 'pending')
                            <span
                                class="inline-flex items-center mt-1 px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">Pending
                                Verification</span>
                        @elseif($report->status === 'accepted')
                            <span
                                class="inline-flex items-center mt-1 px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                Accepted by {{ $report->verifier->name ?? 'Unknown' }} on
                                {{ $report->verified_at->format('d M Y H:i') }}
                            </span>
                        @else
                            <span
                                class="inline-flex items-center mt-1 px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">
                                Rejected by {{ $report->verifier->name ?? 'Unknown' }} on
                                {{ $report->verified_at->format('d M Y H:i') }}
                            </span>
                        @endif
                    </div>
                </div>

                @if(auth()->user()->role === 'section_head' && $report->status === 'pending')
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Section Head Action</h3>
                        <form action="{{ route('reports.verify', ['report' => $report->id]) }}" method="POST"
                            class="flex gap-4">
                            @csrf
                            @method('PATCH')
                            <button type="submit" name="status" value="accepted"
                                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded shadow">
                                Accept Report
                            </button>
                            <button type="submit" name="status" value="rejected"
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow border border-red-700">
                                Reject Report
                            </button>
                        </form>
                    </div>
                @endif

                <div class="p-6 bg-gray-100 flex justify-between items-center">
                    <a href="{{ route('reports.index') }}"
                        class="text-indigo-600 hover:text-indigo-900 font-medium">&larr; Back to List</a>

                    @if($report->status === 'accepted')
                        <div class="flex gap-4">
                            <a href="{{ route('reports.export.excel', ['report' => $report->id]) }}"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
                                Export Excel
                            </a>
                            <a href="{{ route('reports.export.pdf', ['report' => $report->id]) }}"
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow">
                                Export PDF
                            </a>
                        </div>
                    @else
                        <span class="text-sm text-gray-500 italic">Export available after verification</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>