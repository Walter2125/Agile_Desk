<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tablero extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'fecha_inicio', 'fecha_fin', 'status'];

    /**
     * Relación: Un sprint tiene un tablero.
     */
    public function tablero()
    {
        return $this->hasOne(Tablero::class);
    }
}
