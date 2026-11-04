<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Levering Product
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">

                <h3 class="text-xl font-bold mb-4">Levering Product</h3>

                @if (isset($data))
                    <div class="mb-6 space-y-1 bg-gray-50 p-4 rounded-md border border-gray-200">
                        <p><strong>Naam product:</strong> {{ $data->ProductNaam }}</p>
                        <p><strong>Leverancier:</strong> {{ $data->LeverancierNaam }}</p>
                        <p><strong>Contactpersoon:</strong> {{ $data->ContactPersoon }}</p>
                        <p><strong>Leveranciernummer:</strong> {{ $data->LeverancierNummer }}</p>
                        <p><strong>Mobiel:</strong> {{ $data->Mobiel }}</p>
                    </div>
                @endif

                {{-- Scenario 02 melding --}}
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 font-semibold rounded">
                    {{ $melding }}
                </div>

                <div class="text-sm text-gray-500 mb-6">
                    U wordt over 4 seconden automatisch teruggestuurd naar de geleverde producten...
                </div>

                <div class="flex justify-end items-center gap-3">
                    <a href="{{ route('leverancier.producten', $leverancierId) }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md shadow-sm">
                        Terug
                    </a>
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm">
                        Home
                    </a>
                </div>

                {{-- Automatische redirect na 4 seconden --}}
                <script>
                    setTimeout(function () {
                        window.location.href = "{{ route('leverancier.producten', $leverancierId) }}";
                    }, 4000);
                </script>

            </div>
        </div>
    </div>
</x-app-layout>
