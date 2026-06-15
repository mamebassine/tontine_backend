<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MembreTontine;
use App\Models\Tontine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembreTontineController extends Controller
{
    /**
     * Liste des membres
     */
    public function index(Request $request)
    {
        $query = MembreTontine::with([
            'user',
            'tontine'
        ]);

        // Filtrer les membres d'une tontine spécifique
        if ($request->has('tontine_id')) {
            $query->where('tontine_id', $request->tontine_id);
        }

        $membres = $query->get();

        return response()->json($membres);
    }

    /**
     * Rejoindre une tontine
     */
    public function store(Request $request)
    {
        $request->validate([
            'tontine_id' => 'required|exists:tontines,id'
        ]);

        $tontine = Tontine::findOrFail($request->tontine_id);

        // Vérifier le nombre maximum de membres
        $nombreActuel = MembreTontine::where(
            'tontine_id',
            $tontine->id
        )->count();

        if ($nombreActuel >= $tontine->nombre_max_membres) {
            return response()->json([
                'message' => 'La tontine est complète'
            ], 400);
        }

        // Vérifier si l'utilisateur est déjà membre
        $existe = MembreTontine::where('tontine_id', $tontine->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($existe) {
            return response()->json([
                'message' => 'Vous êtes déjà membre de cette tontine'
            ], 400);
        }

        $membre = MembreTontine::create([
            'tontine_id' => $tontine->id,
            'user_id' => Auth::id(),
            'role' => 'membre',
            'status' => 'actif',
            'date_adhesion' => now()->toDateString()
        ]);

        return response()->json([
            'message' => 'Tontine rejointe avec succès',
            'membre' => $membre
        ], 201);
    }

    /**
     * Afficher un membre
     */
    public function show(string $id)
    {
        $membre = MembreTontine::with([
            'user',
            'tontine'
        ])->findOrFail($id);

        return response()->json($membre);
    }

    /**
     * Modifier un membre
     */
    public function update(Request $request, string $id)
    {
        $membre = MembreTontine::findOrFail($id);

        $request->validate([
            'role' => 'nullable|in:createur,admin,membre',
            'status' => 'nullable|in:actif,suspendu,exclu',
            'ordre_passage' => 'nullable|integer|min:1'
        ]);

        $membre->update($request->only([
            'role',
            'status',
            'ordre_passage'
        ]));

        return response()->json([
            'message' => 'Membre mis à jour avec succès',
            'membre' => $membre
        ]);
    }

    /**
     * Supprimer un membre
     */
    public function destroy(string $id)
    {
        $membre = MembreTontine::findOrFail($id);

        $membre->update([
            'date_sortie' => now()->toDateString(),
            'status' => 'exclu'
        ]);

        $membre->delete();

        return response()->json([
            'message' => 'Membre supprimé avec succès'
        ]);
    }
}