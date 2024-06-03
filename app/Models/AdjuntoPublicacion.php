<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public static function boot()
    {
        parent::boot();

        static::deleted(function (self $adjuntoPublicacion) {
            Storage::disk('public')->delete($adjuntoPublicacion->path);
        });
    }
}