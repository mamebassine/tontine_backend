<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tontine;
use Illuminate\Http\Request;

class TontineController extends Controller
{
    /**
     * Liste des tontines
     */
    public function index()
    {
        return response()->json(Tontine::all(), 200);
    }

    /**
     * Création d'une tontine
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'montant_cotisation' => 'required|numeric',
            'frequence' => 'required|in:journalier,hebdo,mensuel',
            'nombre_membres' => 'required|integer|min:1',
            'date_debut' => 'required|date',
        ]);

        $tontine = Tontine::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'montant_cotisation' => $request->montant_cotisation,
            'frequence' => $request->frequence,
            'nombre_membres' => $request->nombre_membres,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'status' => $request->status ?? 'ouverte'
        ]);

        return response()->json([
            'message' => 'Tontine créée avec succès',
            'data' => $tontine
        ], 201);
    }

    /**
     * Afficher une tontine
     */
    public function show(string $id)
    {
        $tontine = Tontine::find($id);

        if (!$tontine) {
            return response()->json([
                'message' => 'Tontine introuvable'
            ], 404);
        }

        return response()->json($tontine, 200);
    }

    /**
     * Modifier une tontine
     */
    public function update(Request $request, string $id)
    {
        $tontine = Tontine::find($id);

        if (!$tontine) {
            return response()->json([
                'message' => 'Tontine introuvable'
            ], 404);
        }

        $request->validate([
            'nom' => 'sometimes|string|max:255',
            'montant_cotisation' => 'sometimes|numeric',
            'frequence' => 'sometimes|in:journalier,hebdo,mensuel',
            'nombre_membres' => 'sometimes|integer|min:1',
            'status' => 'sometimes|in:ouverte,en_cours,terminee'
        ]);

        $tontine->update($request->all());

        return response()->json([
            'message' => 'Tontine modifiée avec succès',
            'data' => $tontine
        ], 200);
    }

    /**
     * Supprimer une tontine
     */
    public function destroy(string $id)
    {
        $tontine = Tontine::find($id);

        if (!$tontine) {
            return response()->json([
                'message' => 'Tontine introuvable'
            ], 404);
        }

        $tontine->delete();

        return response()->json([
            'message' => 'Tontine supprimée avec succès'
        ], 200);
    }
}