<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'proyecto_id', // clave foránea hacia proyectos
    ];
    
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
}
