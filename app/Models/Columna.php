<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Columna extends Model
{
    protected $fillable = ['tablero_id', 'nombre', 'orden'];

    public function tablero()
    {
        return $this->belongsTo(Tablero::class);
    }

    // Cada columna tiene muchas historias
    public function historias()
    {
        return $this->hasMany(Formatohistoria::class, 'columna_id');
    }
}
