<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tontine extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'montant_cotisation',
        'frequence',
        'nombre_membres',
        'date_debut',
        'date_fin',
        'status'
    ];

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
        return $this->hasMany(Cotisation::class);
    }
}