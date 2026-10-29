<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Overzicht Leverancier
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">Naam</th>
                                <th class="border border-gray-300 px-4 py-2">Contactpersoon</th>
                                <th class="border border-gray-300 px-4 py-2">Leveranciernummer</th>
                                <th class="border border-gray-300 px-4 py-2">Mobiel</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Aantal verschillende producten</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Toon producten</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leveranciers as $leverancier)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-4 py-2 font-medium">{{ $leverancier->Naam }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $leverancier->ContactPersoon }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $leverancier->LeverancierNummer }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $leverancier->Mobiel }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">{{ $leverancier->AantalVerschillendeProducten }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <a href="{{ route('leverancier.producten', $leverancier->Id) }}" 
                                           title="Toon producten" 
                                           class="inline-block hover:scale-125 transition-transform text-xl text-blue-600">
                                            📦
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border border-gray-300 px-4 py-2 text-center text-gray-500">
                                        Geen leveranciers gevonden.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
