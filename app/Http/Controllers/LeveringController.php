<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPerLeverancier;

class LeveringController extends Controller
{
    public function show($id)
    {
        // Zoek het gekozen product
        $product = Product::findOrFail($id);

        // Haal alle leveringen van dit product op
        $leveringen = ProductPerLeverancier::with('leverancier')
            ->where('ProductId', $id)
            ->orderBy('DatumLevering', 'asc')
            ->get();

        // Controleer of het product geen voorraad heeft
        if ($product->magazijn->AantalAanwezig === null) {
            return view('levering.show', compact('product', 'leveringen'));
        }

        return view('levering.show', compact('product', 'leveringen'));
    }
}
