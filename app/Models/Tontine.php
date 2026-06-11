<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tontine extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'code',
        'createur_id',
        'montant_cotisation',
        'penalite_retard',
        'frequence',
        'nombre_max_membres',
        'tour_actuel',
        'date_debut',
        'date_fin',
        'status'
    ];

    public function createur()
    {
        return $this->belongsTo(User::class, 'createur_id');
    }

    public function membres()
    {
        return $this->hasMany(MembreTontine::class);
    }

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function cotisations()
{
    return $this->hasManyThrough(
        Cotisation::class,
        Tour::class,
        'tontine_id', // FK sur tours
        'tour_id',    // FK sur cotisations
        'id',
        'id'
    );
}
}