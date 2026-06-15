<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembreTontine extends Model
{
    protected $fillable = [
        'tontine_id',
        'user_id',
        'role',
        'status',
        'ordre_passage',
        'date_adhesion',
        'date_sortie'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tontine()
    {
        return $this->belongsTo(Tontine::class);
    }
    
}