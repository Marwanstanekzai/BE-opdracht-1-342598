<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Home
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>Welkom!</p>

                    <br>

                    @if (auth()->user()->role === 'magazijnmedewerker')
                        <div class="space-y-2">
                            <div>
                                <a href="{{ route('magazijn.index') }}" class="text-blue-600 hover:underline font-semibold">
                                    Overzicht producten Jamin
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('leverancier.index') }}" class="text-blue-600 hover:underline font-semibold">
                                    Overzicht Leveranciers
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
