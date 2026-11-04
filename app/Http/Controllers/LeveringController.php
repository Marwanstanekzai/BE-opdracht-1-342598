<?php

namespace App\Http\Controllers;

use App\Models\Leverancier;
use App\Models\Product;
use App\Models\ProductPerLeverancier;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LeveringController extends Controller
{
    /**
     * Bestaande show methode uit Opdracht 1 — niet wijzigen.
     */
    public function show($id): View
    {
        // Zoek het gekozen product inclusief magazijn gegevens
        $product = Product::with('magazijn')->findOrFail($id);

        // Haal alle leveringen van dit product op, gesorteerd op DatumLevering oplopend
        $leveringen = ProductPerLeverancier::with('leverancier')
            ->where('ProductId', $id)
            ->orderBy('DatumLevering', 'asc')
            ->get();

        $leverancier = $leveringen->first()?->leverancier;

        return view('levering.show', compact('product', 'leveringen', 'leverancier'));
    }

    /**
     * Scherm: Levering Product (Wireframe 04)
     * Toont gegevens van product en leverancier met invoervelden.
     */
    public function create(int $leverancierId, int $productId): View
    {
        $data = Leverancier::getProductVoorLevering($leverancierId, $productId);

        if (! $data) {
            abort(404, 'Product of leverancier niet gevonden');
        }

        return view('levering.create', compact('data'));
    }

    /**
     * Verwerk de nieuwe levering (User Story 02 — Scenario 01 & Scenario 02).
     */
    public function store(Request $request, int $leverancierId, int $productId): View|RedirectResponse
    {
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

        $data = Leverancier::getProductVoorLevering($leverancierId, $productId);

        if (! $data) {
            abort(404, 'Product of leverancier niet gevonden');
        }

        // Scenario 02: Als product niet meer actief is (bv. Winegums van Basset)
        if (! $data->ProductIsActief || (isset($data->LeveringIsActief) && (int) $data->LeveringIsActief === 0)) {
            $melding = "Het product {$data->ProductNaam} van de leverancier {$data->LeverancierNaam} wordt niet meer geproduceerd";

            return view('levering.niet_actief', [
                'melding' => $melding,
                'leverancierId' => $leverancierId,
                'data' => $data,
            ]);
        }

        $datumInput = $request->input('datum_eerstvolgende_levering');
        $datumEerstvolgende = null;

        if ($request->filled('datum_eerstvolgende_levering')) {
            if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $datumInput)) {
                $datumEerstvolgende = Carbon::createFromFormat('d-m-Y', $datumInput)->format('Y-m-d');
            } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $datumInput)) {
                $datumEerstvolgende = Carbon::createFromFormat('Y-m-d', $datumInput)->format('Y-m-d');
            } else {
                $datumEerstvolgende = Carbon::parse($datumInput)->format('Y-m-d');
            }
        }

        // Scenario 01: Product is actief (bv. Mintnopjes van Venco)
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
