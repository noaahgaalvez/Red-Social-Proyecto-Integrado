<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interaccion extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'publicacion_id',
        'type', 
        'user_id',
    ];
}
