<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tablero extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'sprint_id'];

    /**
     * Relación: Un tablero pertenece a un sprint.
     */
    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }

    /**
     * Relación: Un tablero tiene muchas columnas.
     */
    public function columnas()
    {
        return $this->hasMany(Columna::class);
    }
}
