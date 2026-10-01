<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Overzicht Magazijn Jamin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">


                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border border-gray-300 px-4 py-2">Barcode</th>
                                <th class="border border-gray-300 px-4 py-2">Naam</th>
                                <th class="border border-gray-300 px-4 py-2">Verpakkingseenheid</th>
                                <th class="border border-gray-300 px-4 py-2">Aantal aanwezig</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Allergenen Info</th>
                                <th class="border border-gray-300 px-4 py-2 text-center">Leverantie Info</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($producten as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="border border-gray-300 px-4 py-2">{{ $product->Barcode }}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $product->Naam }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ $product->magazijn?->VerpakkingsEenheid ? number_format($product->magazijn->VerpakkingsEenheid, 1, ',', '') . ' kg' : '-' }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">{{ $product->magazijn?->AantalAanwezig ?? '-' }}</td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <a href="{{ route('allergeen.show', $product->Id) }}" title="Allergenen Info" class="text-red-500 hover:text-red-700 text-lg">
                                            ❌
                                        </a>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <a href="{{ route('levering.show', $product->Id) }}" title="Leverantie Info" class="text-blue-500 hover:text-blue-700 text-lg">
                                            ❓
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
