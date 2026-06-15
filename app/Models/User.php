<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'type_piece',
        'numero_piece',
        'photo',
        'adresse',
        'password',
        'role',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'email_verified_at' => 'datetime',
    ];

    // JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function membreTontines()
{
    return $this->hasMany(MembreTontine::class);
}

public function membres()
{
    return $this->hasMany(MembreTontine::class);
}

public function toursBeneficiaire()
{
    return $this->hasMany(Tour::class, 'beneficiaire_id');
}

public function cotisations()
{
    return $this->hasMany(Cotisation::class);
}

public function notifications()
{
    return $this->hasMany(Notification::class);
}
}