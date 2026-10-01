<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Levering Informatie
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">


                @php
                    $aantalAanwezig = $product->magazijn?->AantalAanwezig;
                    $geenVoorraad = is_null($aantalAanwezig) || $aantalAanwezig == 0;
                @endphp

                @if ($geenVoorraad)
                    @php
                        $eerstVolgende = $leveringen->whereNotNull('DatumEerstVolgendeLevering')->first()?->DatumEerstVolgendeLevering;
                        $formattedDate = $eerstVolgende ? \Carbon\Carbon::parse($eerstVolgende)->format('d-m-Y') : '30-04-2023';
                    @endphp

                    <div class="mb-4 text-red-600 font-semibold">
                        Er is van dit product op dit moment geen voorraad aanwezig, de verwachte eerstvolgende levering is: {{ $formattedDate }}
                    </div>

                    <script>
                        setTimeout(function () {
                            window.location.href = "{{ route('magazijn.index') }}";
                        }, 4000);
                    </script>
                @else
                    <div class="mb-6 space-y-1">
                        <p><strong>Naam leverancier:</strong> {{ $leverancier->Naam ?? '-' }}</p>
                        <p><strong>Contactpersoon leverancier:</strong> {{ $leverancier->ContactPersoon ?? '-' }}</p>
                        <p><strong>Leveranciernummer:</strong> {{ $leverancier->LeverancierNummer ?? '-' }}</p>
                        <p><strong>Mobiel:</strong> {{ $leverancier->Mobiel ?? '-' }}</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2">Naam Product</th>
                                    <th class="border border-gray-300 px-4 py-2">Datum laatste levering</th>
                                    <th class="border border-gray-300 px-4 py-2">Aantal</th>
                                    <th class="border border-gray-300 px-4 py-2">Eerstvolgende levering</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leveringen as $levering)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">{{ $product->Naam }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ \Carbon\Carbon::parse($levering->DatumLevering)->format('d-m-Y') }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $levering->Aantal }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            {{ $levering->DatumEerstVolgendeLevering ? \Carbon\Carbon::parse($levering->DatumEerstVolgendeLevering)->format('d-m-Y') : '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
