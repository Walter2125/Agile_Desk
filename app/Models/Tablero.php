<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tablero extends Model
{
    protected $fillable = ['proyecto_id', 'nombre'];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    // Cada tablero tiene muchas columnas
    public function columna()
    {
        return $this->hasMany(Columna::class);
    }
}
