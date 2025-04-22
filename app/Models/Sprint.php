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
        'color',
        'tipo',
        'descripcion',
        'todo_el_dia',
        'project_id'
    ];
    
    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'todo_el_dia' => 'boolean',
    ];
    
    
    public function etiquetas()
    {
        return $this->hasMany(Etiqueta::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    
    public function tareas()
    {
        return $this->hasMany(Tareas::class, 'historia_id');
    }
}