<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPerLeverancier;

class LeveringController extends Controller
{
    public function show($id)
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
}
