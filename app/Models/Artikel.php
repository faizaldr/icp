<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    public $table = "artikel"; 
   
    protected $fillable = [
        'isi', 'judul'
    ];

    protected $hidden = [
        'moddified_at'
    ];

    protected $casts = [
        'create_at' => 'datetime',
    ];
}
