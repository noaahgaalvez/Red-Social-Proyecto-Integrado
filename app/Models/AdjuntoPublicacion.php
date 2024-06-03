<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntoPublicacion extends Model
{
    use HasFactory;

    CONST UPDATED_AT = null;

    protected $fillable = [
        'publicacion_id',
        'name',
        'path',
        'image',
        'tamanio',
        'created_by',
    ];
}
