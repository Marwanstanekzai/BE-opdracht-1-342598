<?php

namespace App\Http\Controllers;

use App\Models\Product;

class AllergeenController extends Controller
{
    public function show($id)
    {
        // Zoek het gekozen product
        $product = Product::with('allergenen')->findOrFail($id);

        // Sorteer de allergenen op naam
        $allergenen = $product->allergenen->sortBy('Naam');

        return view('allergeen.show', compact('product', 'allergenen'));
    }
}
