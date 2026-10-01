<?php

namespace App\Http\Controllers;

use App\Models\Product;

class MagazijnController extends Controller
{
    public function index()
    {
        // Haal alle producten op en sorteer op barcode
        $producten = Product::with('magazijn')
            ->orderBy('Barcode', 'asc')
            ->get();

        // var_dump($producten->all());exit();
        // Stuur de producten naar de overzichtspagina
        return view('magazijn.index', compact('producten'));
    }
}
