<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Overzicht Leveranciers
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">

                <h3 class="text-xl font-bold mb-4 underline">Overzicht Leveranciers</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">Naam</th>
                                <th class="border border-gray-300 px-4 py-2">Contactpersoon</th>
                                <th class="border border-gray-300 px-4 py-2">Leveranciernummer</th>
                                <th class="border border-gray-300 px-4 py-2">Mobiel</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Leverancier Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leveranciers as $leverancier)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-4 py-2 font-medium">{{ $leverancier->Naam }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $leverancier->ContactPersoon }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $leverancier->LeverancierNummer }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $leverancier->Mobiel }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <a href="{{ route('leverancier.details', $leverancier->Id) }}"
                                           title="Leverancier Details"
                                           class="inline-block hover:scale-125 transition-transform text-xl text-blue-600">
                                            ✏️
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                                        Geen leveranciers gevonden.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Server-side pagination links (maximaal 4 records per pagina) --}}
                <div class="mt-4">
                    {{ $leveranciers->links() }}
                </div>

                <div class="mt-6 flex justify-end items-center">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm">
                        Home
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
