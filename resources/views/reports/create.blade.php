<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Problem Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>- {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('reports.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Basic Info -->
                            <div>
                                <x-input-label for="report_date" value="Date" />
                                <x-text-input id="report_date" name="report_date" type="date" class="mt-1 block w-full"
                                    :value="old('report_date', date('Y-m-d'))" required />
                            </div>

                            <div>
                                <x-input-label for="section" value="Section" />
                                <select name="section" id="section"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                    required>
                                    <option value="2W" {{ old('section') == '2W' ? 'selected' : '' }}>2W</option>
                                    <option value="4W" {{ old('section') == '4W' ? 'selected' : '' }}>4W</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="comp_name_2w" value="Component Name (2W only)" />
                                <div class="mt-1 flex flex-wrap gap-4">
                                    @php
                                        $comps = ['bar comp step', 'bracket comp l pillion set', 'bracket comp r pillion set', 'bracket comp rr cros', 'muffler assy exh', 'pipe comp luggage box', 'pipe comp steering handle', 'pipe comp steering head'];
                                    @endphp
                                    @foreach($comps as $comp)
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="comp_name_2w" value="{{ $comp }}"
                                                class="text-indigo-600 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                                {{ old('comp_name_2w') == $comp ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600 capitalize">{{ $comp }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <x-input-label for="part_number" value="Part Number" />
                                <x-text-input id="part_number" name="part_number" type="text" class="mt-1 block w-full"
                                    :value="old('part_number')" required />
                            </div>

                            <div>
                                <x-input-label for="part_name" value="Part Name" />
                                <x-text-input id="part_name" name="part_name" type="text" class="mt-1 block w-full"
                                    :value="old('part_name')" required />
                            </div>

                            <div>
                                <x-input-label for="customer" value="Customer" />
                                <select name="customer" id="customer"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                    required>
                                    <option value="AHM">AHM</option>
                                    <option value="ADM">ADM</option>
                                    <option value="HMMI">HMMI</option>
                                    <option value="HPM">HPM</option>
                                    <option value="MKM">MKM</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="line_problem" value="Line Problem" />
                                <x-text-input id="line_problem" name="line_problem" type="text"
                                    class="mt-1 block w-full" :value="old('line_problem')" required />
                            </div>

                            <div>
                                <x-input-label for="category" value="Category Problem" />
                                <select name="category" id="category"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                    required>
                                    <option value="Single Part">Single Part</option>
                                    <option value="Sub Assy">Sub Assy</option>
                                    <option value="Finishing">Finishing</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="quantity" value="Jumlah Temuan (Pcs)" />
                                <x-text-input id="quantity" name="quantity" type="number" min="1"
                                    class="mt-1 block w-full" :value="old('quantity')" required />
                            </div>

                            <div>
                                <x-input-label for="problem_status" value="Problem Status" />
                                <select name="problem_status" id="problem_status"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                    required>
                                    <option value="baru">Baru</option>
                                    <option value="berulang">Berulang</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="vendor" value="Vendor" />
                                <x-text-input id="vendor" name="vendor" type="text" class="mt-1 block w-full"
                                    :value="old('vendor')" required />
                            </div>

                            <div>
                                <x-input-label for="type" value="Type" />
                                <x-text-input id="type" name="type" type="text" class="mt-1 block w-full"
                                    :value="old('type')" required />
                            </div>

                            <div>
                                <x-input-label for="problem_type" value="Problem Type" />
                                <select name="problem_type" id="problem_type"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                    required>
                                    <option value="visual">Visual</option>
                                    <option value="dimensi">Dimensi</option>
                                    <option value="kelengkapan">Kelengkapan</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="pic_qc" value="PIC QC" />
                                <x-text-input id="pic_qc" name="pic_qc" type="text" class="mt-1 block w-full"
                                    :value="old('pic_qc')" required />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="detail" value="Detail Problem" />
                                <textarea id="detail" name="detail" rows="4"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                                    required>{{ old('detail') }}</textarea>
                            </div>

                        </div> <!-- end grid -->

                        <div class="mt-6 flex justify-end">
                            <x-primary-button>
                                {{ __('Submit Report') }}
                            </x-primary-button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>