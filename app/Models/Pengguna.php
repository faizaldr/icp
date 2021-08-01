<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable implements JWTSubject
{
    use HasFactory;

    public $table = "pengguna"; 
   
    protected $fillable = [
        'nama', 'email', 'password','alamat'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'create_at' => 'datetime',
    ];
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
