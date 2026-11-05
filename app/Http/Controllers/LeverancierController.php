<?php

namespace App\Http\Controllers;

use App\Models\Leverancier;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LeverancierController extends Controller
{
    /**
     * Scherm: Overzicht Leverancier (BE-opdracht 02)
     * Toont alle leveranciers gesorteerd op aantal verschillende geleverde producten aflopend.
     */
    public function index(): View
    {
        $leveranciers = Leverancier::getLeveranciersOverzicht();

        return view('leverancier.index', compact('leveranciers'));
    }

    /**
     * Scherm: Geleverde producten (BE-opdracht 02)
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

    /**
     * Scherm: Overzicht Leveranciers voor Wijzigen (BE-opdracht 03 — Wireframe 02)
     * Toont leveranciers met server-side pagination van maximaal 4 records per pagina.
     */
    public function wijzigenIndex(): View
    {
        $leveranciers = Leverancier::getLeveranciersPaginated(4);

        return view('leverancier.wijzigen', compact('leveranciers'));
    }

    /**
     * Scherm: Leverancier Details (BE-opdracht 03 — Wireframe 03)
     * Toont alle gegevens van een leverancier en het bijbehorende adres uit Contact.
     */
    public function details(int $id): View
    {
        $leverancier = Leverancier::getLeverancierDetailsById($id);

        if (! $leverancier) {
            abort(404, 'Leverancier niet gevonden');
        }

        return view('leverancier.details', compact('leverancier'));
    }

    /**
     * Scherm: Wijzig Leveranciergegevens (BE-opdracht 03 — Wireframe 04)
     * Toont het formulier om de leverancier- en contactgegevens aan te passen.
     */
    public function edit(int $id): View
    {
        $leverancier = Leverancier::getLeverancierDetailsById($id);

        if (! $leverancier) {
            abort(404, 'Leverancier niet gevonden');
        }

        return view('leverancier.edit', compact('leverancier'));
    }

    /**
     * Verwerk het wijzigen van een leverancier (BE-opdracht 03 — Scenario 01 & Scenario 02).
     * Toont de verplichte melding en stuurt na 3 seconden terug naar Leverancier Details.
     */
    public function update(Request $request, int $id): View
    {
        $validated = $request->validate([
            'naam' => 'required|string|max:100',
            'contactpersoon' => 'required|string|max:100',
            'leveranciernummer' => 'required|string|max:20',
            'mobiel' => 'required|string|max:15',
            'straat' => 'required|string|max:100',
            'huisnummer' => 'required|string|max:10',
            'postcode' => 'required|string|max:10',
            'stad' => 'required|string|max:100',
        ]);

        $leverancier = Leverancier::getLeverancierDetailsById($id);

        if (! $leverancier) {
            abort(404, 'Leverancier niet gevonden');
        }

        $gelukt = Leverancier::updateLeverancier($id, $validated);

        if ($gelukt) {
            $melding = 'De wijzigingen zijn doorgevoerd';
            $status = 'success';
            // Haal bijgewerkte gegevens op
            $leverancier = Leverancier::getLeverancierDetailsById($id);
        } else {
            $melding = 'Door een technische storing is het niet mogelijk de wijziging door te voeren. Probeer het op een later moment nog eens';
            $status = 'error';
        }

        return view('leverancier.edit', [
            'leverancier' => $leverancier,
            'melding' => $melding,
            'status' => $status,
            'redirectUrl' => route('leverancier.details', $id),
        ]);
    }
}
