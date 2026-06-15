<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Liste des notifications
     */
    public function index(Request $request)
    {
        $query = Notification::with([
            'user',
            'tontine'
        ]);

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        return response()->json($query->latest()->get());
    }

    /**
     * Créer une notification
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'titre' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:paiement,invitation,rappel,information',
            'tontine_id' => 'nullable|exists:tontines,id'
        ]);

        $notification = Notification::create([
            'user_id' => $request->user_id,
            'tontine_id' => $request->tontine_id,
            'titre' => $request->titre,
            'message' => $request->message,
            'type' => $request->type,
            'lu' => false
        ]);

        return response()->json([
            'message' => 'Notification créée avec succès',
            'notification' => $notification
        ], 201);
    }

    /**
     * Afficher une notification
     */
    public function show(string $id)
    {
        $notification = Notification::with([
            'user',
            'tontine'
        ])->findOrFail($id);

        return response()->json($notification);
    }

    /**
     * Marquer comme lue
     */
    public function update(Request $request, string $id)
    {
        $notification = Notification::findOrFail($id);

        $notification->update([
            'lu' => $request->lu ?? true
        ]);

        return response()->json([
            'message' => 'Notification mise à jour',
            'notification' => $notification
        ]);
    }

    /**
     * Supprimer une notification
     */
    public function destroy(string $id)
    {
        $notification = Notification::findOrFail($id);

        $notification->delete();

        return response()->json([
            'message' => 'Notification supprimée avec succès'
        ]);
    }

    /**
     * Mes notifications
     */
    public function mesNotifications()
    {
        $notifications = Notification::where(
            'user_id',
            Auth::id()
        )
        ->latest()
        ->get();

        return response()->json($notifications);
    }
}