<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Geleverde Producten
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

                <div class="mb-6 space-y-1">
                    <p><strong>Naam leverancier:</strong> {{ $leverancier->Naam }}</p>
                    <p><strong>Contactpersoon:</strong> {{ $leverancier->ContactPersoon }}</p>
                    <p><strong>Leveranciernummer:</strong> {{ $leverancier->LeverancierNummer }}</p>
                    <p><strong>Mobiel:</strong> {{ $leverancier->Mobiel }}</p>
                </div>

                @if (empty($producten) || count($producten) === 0)
                    {{-- Wireframe 03: Geen geleverde producten melding --}}
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 font-semibold rounded">
                        Dit bedrijf heeft tot nu toe geen producten geleverd aan Jamin
                    </div>

                    <div class="text-sm text-gray-500 mb-4">
                        U wordt over 3 seconden automatisch teruggestuurd naar het overzicht...
                    </div>

                    <script>
                        setTimeout(function () {
                            window.location.href = "{{ route('leverancier.index') }}";
                        }, 3000);
                    </script>
                @else
                    {{-- Wireframe 02: Tabel met geleverde producten --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2">Naam product</th>
                                    <th class="border border-gray-300 px-4 py-2">Aantal in magazijn</th>
                                    <th class="border border-gray-300 px-4 py-2">Verpakkingseenheid</th>
                                    <th class="border border-gray-300 px-4 py-2">Laatste levering</th>
                                    <th class="border border-gray-300 px-4 py-2 text-center">Nieuwe levering</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($producten as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2 font-medium">{{ $product->ProductNaam }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $product->AantalAanwezig ?? '-' }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $product->VerpakkingsEenheid ? number_format($product->VerpakkingsEenheid, 1, ',', '') . ' kg' : '-' }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $product->LaatsteLevering ? \Carbon\Carbon::parse($product->LaatsteLevering)->format('d-m-Y') : '-' }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">
                                            <a href="{{ Route::has('levering.create') ? route('levering.create', ['leverancierId' => $leverancier->Id, 'productId' => $product->ProductId]) : url('/levering/' . $leverancier->Id . '/' . $product->ProductId . '/create') }}" 
                                               title="Nieuwe levering toevoegen" 
                                               class="inline-block hover:scale-125 transition-transform text-xl text-green-600 font-bold">
                                                ➕
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="mt-6 flex justify-between items-center">
                    <a href="{{ route('leverancier.index') }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md shadow-sm">
                        Terug naar Overzicht Leveranciers
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
