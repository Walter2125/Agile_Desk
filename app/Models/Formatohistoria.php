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
    ];
}
