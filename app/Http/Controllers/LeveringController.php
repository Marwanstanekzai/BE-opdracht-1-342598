<?php

namespace App\Http\Controllers;

use App\Models\Leverancier;
use App\Models\Product;
use App\Models\ProductPerLeverancier;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LeveringController
{
    // Laat de leveringen van een product zien

    public function show($id): View
    {
        // Zoek het product en de magazijngegevens op
        $product = Product::with('magazijn')->findOrFail($id);

        // Haal de leveringen op en sorteer ze op datum
        $leveringen = ProductPerLeverancier::with('leverancier')
            ->where('ProductId', $id)
            ->orderBy('DatumLevering', 'asc')
            ->get();

        $leverancier = $leveringen->first()?->leverancier;

        return view('levering.show', compact('product', 'leveringen', 'leverancier'));
    }

    // Laat het formulier zien om een levering toe te voegen

    public function create(int $leverancierId, int $productId): View
    {
        // Haal het product en de leverancier op
        $data = Leverancier::getProductVoorLevering($leverancierId, $productId);

        // Controleer of het product en de leverancier bestaan
        if (! $data) {
            abort(404, 'Product of leverancier niet gevonden');
        }

        return view('levering.create', compact('data'));
    }

    // Verwerk de nieuwe levering

    public function store(Request $request, int $leverancierId, int $productId): View|RedirectResponse
    {
        // Controleer of het aantal en de datum goed zijn ingevuld
        $request->validate([
            'aantal' => 'required|integer|min:1',
            'datum_eerstvolgende_levering' => [
                'nullable',
                'string',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if ($value === null || $value === '') {
                        return;
                    }

                    if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $value)) {
                        [$d, $m, $y] = array_map('intval', explode('-', $value));
                        if (! checkdate($m, $d, $y)) {
                            $fail('Voer een geldige datum in (dd-mm-jjjj).');
                        }

                        return;
                    }

                    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
                        [$y, $m, $d] = array_map('intval', explode('-', $value));
                        if (! checkdate($m, $d, $y)) {
                            $fail('Voer een geldige datum in (dd-mm-jjjj).');
                        }

                        return;
                    }

                    try {
                        Carbon::parse($value);
                    } catch (\Exception) {
                        $fail('Voer een geldige datum in (dd-mm-jjjj).');
                    }
                },
            ],
        ]);

        // Haal het product en de leverancier opnieuw op
        $data = Leverancier::getProductVoorLevering($leverancierId, $productId);

        // Controleer of het product en de leverancier bestaan
        if (! $data) {
            abort(404, 'Product of leverancier niet gevonden');
        }

        // Controleer of het product nog actief is
        if (! $data->ProductIsActief || (isset($data->LeveringIsActief) && (int) $data->LeveringIsActief === 0)) {
            $melding = "Het product {$data->ProductNaam} van de leverancier {$data->LeverancierNaam} wordt niet meer geproduceerd";

            return view('levering.niet_actief', [
                'melding' => $melding,
                'leverancierId' => $leverancierId,
                'data' => $data,
            ]);
        }

        // Haal de ingevulde datum op
        $datumInput = $request->input('datum_eerstvolgende_levering');
        $datumEerstvolgende = null;

        // Zet de datum om naar het juiste formaat
        if ($request->filled('datum_eerstvolgende_levering')) {
            if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $datumInput)) {
                $datumEerstvolgende = Carbon::createFromFormat('d-m-Y', $datumInput)->format('Y-m-d');
            } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $datumInput)) {
                $datumEerstvolgende = Carbon::createFromFormat('Y-m-d', $datumInput)->format('Y-m-d');
            } else {
                $datumEerstvolgende = Carbon::parse($datumInput)->format('Y-m-d');
            }
        }

        // Sla de nieuwe levering op
        Leverancier::voegLeveringToe(
            $leverancierId,
            $productId,
            (int) $request->input('aantal'),
            $datumEerstvolgende
        );

        return redirect()
            ->route('leverancier.producten', $leverancierId)
            ->with('success', 'Levering succesvol opgeslagen en voorraad bijgewerkt.');
    }
}
