<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialCambios extends Model
{
    use HasFactory;

    protected $table = 'historialcambios';
    protected $fillable = ['fecha', 'usuario', 'accion', 'detalles', 'sprint', 'project_id'];
    public $timestamps = false;

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
