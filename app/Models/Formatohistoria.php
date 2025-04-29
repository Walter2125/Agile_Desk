<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formatohistoria extends Model
{
    protected $fillable = [
        'nombre',
        'sprint',
        'trabajo_estimado',
        'responsable',
        'prioridad',
        'descripcion',
        'sprint_id'
    ];

    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }

    // Pertenece a una columna
    public function columna()
    {
        return $this->belongsTo(Columna::class, 'columna_id');
    }
    // Pertenece a un tablero
    public function tablero()
    {
        return $this->belongsTo(Tablero::class, 'tablero_id');
    }
}
