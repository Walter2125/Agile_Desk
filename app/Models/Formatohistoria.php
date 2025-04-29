<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formatohistoria extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'sprint',
        'trabajo_estimado',
        'responsable',
        'prioridad',
        'descripcion',
        'columna_id'
    ];

    public function archivo()
    {
        return $this->hasOne(ArchivoHistoria::class, 'historia_id');
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
