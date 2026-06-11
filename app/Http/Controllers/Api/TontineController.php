<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tontine;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TontineController extends Controller
{
    /**
     * LISTE DES TONTINES
     */
    public function index()
    {
        $tontines = Tontine::with('createur')->get();

        return response()->json($tontines);
    }

    /**
     * CREER UNE TONTINE
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'description' => 'nullable',
            'montant_cotisation' => 'required',
            'frequence' => 'required|in:journalier,hebdo,mensuel',
            'nombre_max_membres' => 'required|integer',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date'
        ]);

        $tontine = Tontine::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'code' => strtoupper(Str::random(8)),
            'createur_id' => Auth::id(),
            'montant_cotisation' => $request->montant_cotisation,
            'penalite_retard' => 0,
            'frequence' => $request->frequence,
            'nombre_max_membres' => $request->nombre_max_membres,
            'tour_actuel' => 1,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'status' => 'ouverte'
        ]);

        return response()->json([
            'message' => 'Tontine créée avec succès',
            'tontine' => $tontine
        ]);
    }

    /**
     * AFFICHER UNE TONTINE
     */
    public function show(string $id)
    {
        $tontine = Tontine::with([
            'createur',
            'membres',
            'tours',
            'cotisations'
        ])->findOrFail($id);

        return response()->json($tontine);
    }

    /**
     * MODIFIER UNE TONTINE
     */
    public function update(Request $request, string $id)
    {
        $tontine = Tontine::findOrFail($id);

        $tontine->update($request->all());

        return response()->json([
            'message' => 'Tontine mise à jour',
            'tontine' => $tontine
        ]);
    }

    /**
     * SUPPRIMER UNE TONTINE
     */
    public function destroy(string $id)
    {
        $tontine = Tontine::findOrFail($id);
        $tontine->delete();

        return response()->json([
            'message' => 'Tontine supprimée'
        ]);
    }
}