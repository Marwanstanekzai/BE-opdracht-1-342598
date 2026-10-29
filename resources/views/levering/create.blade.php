<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Levering Product
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-6 space-y-1 bg-gray-50 p-4 rounded-md border border-gray-200">
                    <p><strong>Naam leverancier:</strong> {{ $data->LeverancierNaam }}</p>
                    <p><strong>Contactpersoon:</strong> {{ $data->ContactPersoon }}</p>
                    <p><strong>Leveranciernummer:</strong> {{ $data->LeverancierNummer }}</p>
                    <p><strong>Mobiel:</strong> {{ $data->Mobiel }}</p>
                    <p><strong>Naam product:</strong> {{ $data->ProductNaam }}</p>
                </div>

                {{-- Wireframe 04 Formulier --}}
                <form method="POST" action="{{ route('levering.store', ['leverancierId' => $data->LeverancierId, 'productId' => $data->ProductId]) }}">
                    @csrf

                    <div class="mb-4">
                        <label for="aantal" class="block text-sm font-medium text-gray-700 mb-1">
                            Aantal producteenheden
                        </label>
                        <input 
                            type="number" 
                            name="aantal" 
                            id="aantal" 
                            value="{{ old('aantal') }}" 
                            min="1" 
                            required 
                            class="w-full md:w-1/2 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div class="mb-6">
                        <label for="datum_eerstvolgende_levering" class="block text-sm font-medium text-gray-700 mb-1">
                            Datum eerstvolgende levering
                        </label>
                        <input 
                            type="date" 
                            name="datum_eerstvolgende_levering" 
                            id="datum_eerstvolgende_levering" 
                            value="{{ old('datum_eerstvolgende_levering') }}" 
                            class="w-full md:w-1/2 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div class="flex items-center gap-4">
                        <button 
                            type="submit" 
                            class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-sm transition-colors"
                        >
                            Sla op
                        </button>
                        <a 
                            href="{{ route('leverancier.producten', $data->LeverancierId) }}" 
                            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm"
                        >
                            Terug
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
