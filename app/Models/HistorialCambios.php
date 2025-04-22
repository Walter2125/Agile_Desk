<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialCambios extends Model
{
    use HasFactory;

    protected $table = 'historialcambios';
    protected $fillable = ['fecha', 'usuario', 'accion', 'detalles', 'sprint'];
    public $timestamps = false; // Ya tienes `fecha` en la migración
}
