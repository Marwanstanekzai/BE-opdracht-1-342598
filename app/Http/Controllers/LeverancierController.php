<?php

namespace App\Http\Controllers;

use App\Models\Leverancier;
use Illuminate\Contracts\View\View;

class LeverancierController extends Controller
{
    /**
     * Scherm: Overzicht Leverancier (Wireframe 01)
     * Toont alle leveranciers gesorteerd op aantal verschillende geleverde producten aflopend.
     */
    public function index(): View
    {
        $leveranciers = Leverancier::getLeveranciersOverzicht();

        return view('leverancier.index', compact('leveranciers'));
    }

    /**
     * Scherm: Geleverde producten (Wireframe 02 & Wireframe 03)
     * Toont geleverde producten van een leverancier of melding indien geen leveringen.
     */
    public function producten(int $id): View
    {
        $leverancier = Leverancier::getLeverancierById($id);

        if (! $leverancier) {
            abort(404, 'Leverancier niet gevonden');
        }

        $producten = Leverancier::getGeleverdeProductenByLeverancierId($id);

        return view('leverancier.producten', compact('leverancier', 'producten'));
    }
}
