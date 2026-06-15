<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Tontine;
use Illuminate\Http\Request;

class TourController extends Controller
{
    /**
     * Liste des tours
     */
    public function index(Request $request)
    {
        $query = Tour::with([
            'tontine',
            'beneficiaire'
        ]);

        if ($request->has('tontine_id')) {
            $query->where('tontine_id', $request->tontine_id);
        }

        return response()->json($query->get());
    }

    /**
     * Créer un tour
     */
    public function store(Request $request)
    {
        $request->validate([
            'tontine_id' => 'required|exists:tontines,id',
            'numero_tour' => 'required|integer|min:1',
            'date_tour' => 'required|date',
            'beneficiaire_id' => 'required|exists:users,id'
        ]);

        $existe = Tour::where('tontine_id', $request->tontine_id)
            ->where('numero_tour', $request->numero_tour)
            ->exists();

        if ($existe) {
            return response()->json([
                'message' => 'Ce numéro de tour existe déjà dans cette tontine'
            ], 422);
        }

        $tour = Tour::create([
            'tontine_id' => $request->tontine_id,
            'numero_tour' => $request->numero_tour,
            'date_tour' => $request->date_tour,
            'beneficiaire_id' => $request->beneficiaire_id,
            'montant_recu' => $request->montant_recu ?? 0,
            'status' => 'en_attente',
            'est_paye' => false
        ]);

        return response()->json([
            'message' => 'Tour créé avec succès',
            'tour' => $tour
        ], 201);
    }

    /**
     * Afficher un tour
     */
    public function show(string $id)
    {
        $tour = Tour::with([
            'tontine',
            'beneficiaire',
            'cotisations'
        ])->findOrFail($id);

        return response()->json($tour);
    }

    /**
     * Modifier un tour
     */
    public function update(Request $request, string $id)
    {
        $tour = Tour::findOrFail($id);

        $request->validate([
            'date_tour' => 'nullable|date',
            'beneficiaire_id' => 'nullable|exists:users,id',
            'montant_recu' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:en_attente,en_cours,termine',
            'est_paye' => 'nullable|boolean'
        ]);

        $tour->update($request->only([
            'date_tour',
            'beneficiaire_id',
            'montant_recu',
            'status',
            'est_paye'
        ]));

        return response()->json([
            'message' => 'Tour modifié avec succès',
            'tour' => $tour
        ]);
    }

    /**
     * Supprimer un tour
     */
    public function destroy(string $id)
    {
        $tour = Tour::findOrFail($id);

        $tour->delete();

        return response()->json([
            'message' => 'Tour supprimé avec succès'
        ]);
    }
}