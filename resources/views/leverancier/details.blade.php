<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Leverancier Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">

                <h3 class="text-xl font-bold mb-4 underline">Leverancier Details</h3>

                {{-- Wireframe 03: Tabel met leverancier- en adresgegevens --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse border border-gray-300">
                        <tbody>
                            <tr class="hover:bg-gray-50">
                                <th class="border border-gray-300 px-4 py-2 bg-gray-100 w-1/3">Naam</th>
                                <td class="border border-gray-300 px-4 py-2">{{ $leverancier->Naam }}</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="border border-gray-300 px-4 py-2 bg-gray-100">Contactpersoon</th>
                                <td class="border border-gray-300 px-4 py-2">{{ $leverancier->ContactPersoon }}</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="border border-gray-300 px-4 py-2 bg-gray-100">Leveranciernummer</th>
                                <td class="border border-gray-300 px-4 py-2">{{ $leverancier->LeverancierNummer }}</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="border border-gray-300 px-4 py-2 bg-gray-100">Mobiel</th>
                                <td class="border border-gray-300 px-4 py-2">{{ $leverancier->Mobiel }}</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="border border-gray-300 px-4 py-2 bg-gray-100">Straatnaam</th>
                                <td class="border border-gray-300 px-4 py-2">{{ $leverancier->Straat }}</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="border border-gray-300 px-4 py-2 bg-gray-100">Huisnummer</th>
                                <td class="border border-gray-300 px-4 py-2">{{ $leverancier->Huisnummer }}</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="border border-gray-300 px-4 py-2 bg-gray-100">Postcode</th>
                                <td class="border border-gray-300 px-4 py-2">{{ $leverancier->Postcode }}</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <th class="border border-gray-300 px-4 py-2 bg-gray-100">Stad</th>
                                <td class="border border-gray-300 px-4 py-2">{{ $leverancier->Stad }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex items-center justify-between gap-4">
                    <a href="{{ route('leverancier.edit', $leverancier->Id) }}"
                       class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-sm transition-colors">
                        Wijzig
                    </a>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('leverancier.wijzigen') }}"
                           class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md shadow-sm">
                            Terug
                        </a>
                        <a href="{{ route('dashboard') }}"
                           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm">
                            Home
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
