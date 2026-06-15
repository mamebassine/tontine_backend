<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cotisation;
use Illuminate\Http\Request;

class CotisationController extends Controller
{
    /**
     * Liste des cotisations
     */
    public function index(Request $request)
    {
        $query = Cotisation::with([
            'user',
            'tour'
        ]);

        if ($request->has('tour_id')) {
            $query->where('tour_id', $request->tour_id);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return response()->json($query->get());
    }

    /**
     * Créer une cotisation
     */
    public function store(Request $request)
    {
        $request->validate([
            'tour_id' => 'required|exists:tours,id',
            'user_id' => 'required|exists:users,id',
            'montant' => 'required|numeric|min:0',
            'date_limite' => 'required|date'
        ]);

        $existe = Cotisation::where('tour_id', $request->tour_id)
            ->where('user_id', $request->user_id)
            ->exists();

        if ($existe) {
            return response()->json([
                'message' => 'Cette cotisation existe déjà'
            ], 422);
        }

        $cotisation = Cotisation::create([
            'tour_id' => $request->tour_id,
            'user_id' => $request->user_id,
            'montant' => $request->montant,
            'date_limite' => $request->date_limite,
            'status' => 'impaye'
        ]);

        return response()->json([
            'message' => 'Cotisation créée avec succès',
            'cotisation' => $cotisation
        ], 201);
    }

    /**
     * Afficher une cotisation
     */
    public function show(string $id)
    {
        $cotisation = Cotisation::with([
            'user',
            'tour'
        ])->findOrFail($id);

        return response()->json($cotisation);
    }

    /**
     * Modifier une cotisation
     */
    public function update(Request $request, string $id)
    {
        $cotisation = Cotisation::findOrFail($id);

        $request->validate([
            'montant' => 'nullable|numeric|min:0',
            'date_limite' => 'nullable|date',
            'date_paiement' => 'nullable|date',
            'status' => 'nullable|in:paye,impaye,en_retard',
            'reference_paiement' => 'nullable|string'
        ]);

        $cotisation->update($request->only([
            'montant',
            'date_limite',
            'date_paiement',
            'status',
            'reference_paiement'
        ]));

        return response()->json([
            'message' => 'Cotisation modifiée avec succès',
            'cotisation' => $cotisation
        ]);
    }

    /**
     * Enregistrer un paiement
     */
    public function payer(string $id, Request $request)
    {
        $cotisation = Cotisation::findOrFail($id);

        $cotisation->update([
            'date_paiement' => now(),
            'status' => 'paye',
            'reference_paiement' => $request->reference_paiement
        ]);

        return response()->json([
            'message' => 'Paiement enregistré avec succès',
            'cotisation' => $cotisation
        ]);
    }

    /**
     * Supprimer une cotisation
     */
    public function destroy(string $id)
    {
        $cotisation = Cotisation::findOrFail($id);

        $cotisation->delete();

        return response()->json([
            'message' => 'Cotisation supprimée avec succès'
        ]);
    }
}