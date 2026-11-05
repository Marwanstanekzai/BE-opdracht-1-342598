<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Wijzig Leveranciergegevens
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">

                <h3 class="text-xl font-bold mb-4 underline">Wijzig Leveranciergegevens</h3>

                {{-- Melding na het opslaan (Scenario 01 succes of Scenario 02 technische storing) --}}
                @if (isset($melding))
                    <div class="mb-4 p-4 rounded font-semibold {{ ($status ?? '') === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700' }}">
                        {{ $melding }}
                    </div>

                    <div class="text-sm text-gray-500 mb-6">
                        U wordt over 3 seconden automatisch doorgestuurd naar Leverancier Details...
                    </div>

                    <script>
                        setTimeout(function () {
                            window.location.href = "{{ $redirectUrl }}";
                        }, 3000);
                    </script>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Wireframe 04: Formulier Wijzig Leveranciergegevens --}}
                <form method="POST" action="{{ route('leverancier.update', $leverancier->Id) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-2">
                        <label for="naam" class="text-sm font-medium text-gray-700">Naam:</label>
                        <input
                            type="text"
                            name="naam"
                            id="naam"
                            value="{{ old('naam', $leverancier->Naam) }}"
                            required
                            class="md:col-span-2 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-2">
                        <label for="contactpersoon" class="text-sm font-medium text-gray-700">Contactpersoon:</label>
                        <input
                            type="text"
                            name="contactpersoon"
                            id="contactpersoon"
                            value="{{ old('contactpersoon', $leverancier->ContactPersoon) }}"
                            required
                            class="md:col-span-2 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-2">
                        <label for="leveranciernummer" class="text-sm font-medium text-gray-700">Leveranciernummer:</label>
                        <input
                            type="text"
                            name="leveranciernummer"
                            id="leveranciernummer"
                            value="{{ old('leveranciernummer', $leverancier->LeverancierNummer) }}"
                            required
                            class="md:col-span-2 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-2">
                        <label for="mobiel" class="text-sm font-medium text-gray-700">Mobiel:</label>
                        <input
                            type="text"
                            name="mobiel"
                            id="mobiel"
                            value="{{ old('mobiel', $leverancier->Mobiel) }}"
                            required
                            class="md:col-span-2 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-2">
                        <label for="straat" class="text-sm font-medium text-gray-700">Straatnaam:</label>
                        <input
                            type="text"
                            name="straat"
                            id="straat"
                            value="{{ old('straat', $leverancier->Straat) }}"
                            required
                            class="md:col-span-2 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-2">
                        <label for="huisnummer" class="text-sm font-medium text-gray-700">Huisnummer:</label>
                        <input
                            type="text"
                            name="huisnummer"
                            id="huisnummer"
                            value="{{ old('huisnummer', $leverancier->Huisnummer) }}"
                            required
                            class="md:col-span-2 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-2">
                        <label for="postcode" class="text-sm font-medium text-gray-700">Postcode:</label>
                        <input
                            type="text"
                            name="postcode"
                            id="postcode"
                            value="{{ old('postcode', $leverancier->Postcode) }}"
                            required
                            class="md:col-span-2 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-2">
                        <label for="stad" class="text-sm font-medium text-gray-700">Stad:</label>
                        <input
                            type="text"
                            name="stad"
                            id="stad"
                            value="{{ old('stad', $leverancier->Stad) }}"
                            required
                            class="md:col-span-2 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div class="pt-4 flex items-center justify-between gap-4">
                        <button
                            type="submit"
                            class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow-sm transition-colors"
                        >
                            Sla op
                        </button>

                        <div class="flex items-center gap-3">
                            <a
                                href="{{ route('leverancier.details', $leverancier->Id) }}"
                                class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md shadow-sm"
                            >
                                Terug
                            </a>
                            <a
                                href="{{ route('dashboard') }}"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm"
                            >
                                Home
                            </a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
