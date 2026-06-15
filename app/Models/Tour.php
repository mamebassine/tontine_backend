<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = [
        'tontine_id',
        'numero_tour',
        'date_tour',
        'beneficiaire_id',
        'montant_recu',
        'status',
        'est_paye'
    ];

    public function tontine()
    {
        return $this->belongsTo(Tontine::class);
    }

    public function beneficiaire()
    {
        return $this->belongsTo(User::class, 'beneficiaire_id');
    }

    public function cotisations()
    {
        return $this->hasMany(Cotisation::class);
    }
    
}