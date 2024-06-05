<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Interaccion;
use App\Models\AdjuntoPublicacion;
use App\Models\Comentario;

class Publicacion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['body', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(AdjuntoPublicacion::class);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(Interaccion::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comentario::class);
    }
}
