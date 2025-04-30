<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'color',
        'todo_el_dia',
        'project_id'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'todo_el_dia' => 'boolean'
    ];

    public function historias()
    {
        return $this->hasMany(Formatohistoria::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}