<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Overzicht Allergenen
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">


                <div class="mb-6 space-y-1">
                    <p><strong>Naam Product:</strong> {{ $product->Naam }}</p>
                    <p><strong>Barcode:</strong> {{ $product->Barcode }}</p>
                </div>

                @if ($allergenen->isEmpty())
                    <div class="mb-4 text-red-600 font-semibold">
                        In dit product zitten geen stoffen die een allergische reactie kunnen veroorzaken
                    </div>

                    <script>
                        setTimeout(function () {
                            window.location.href = "{{ route('magazijn.index') }}";
                        }, 4000);
                    </script>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 px-4 py-2">Naam</th>
                                    <th class="border border-gray-300 px-4 py-2">Omschrijving</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allergenen as $allergeen)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">{{ $allergeen->Naam }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $allergeen->Omschrijving }}</td>
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
