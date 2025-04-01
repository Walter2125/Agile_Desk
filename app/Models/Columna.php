<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Columna extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = ['tablero_id', 'nombre', 'position'];

    /**
     * Relación: Una columna pertenece a un tablero.
     */
    public function tablero()
    {
        return $this->belongsTo(Tablero::class);
    }

    /**
     * Relación: Una columna tiene muchas historias.
     */
    public function historias()
    {
        return $this->hasMany(Historia::class);
    }
}
