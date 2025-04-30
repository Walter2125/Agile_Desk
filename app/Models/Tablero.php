<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tablero extends Model
{
    protected $table = 'tablero';
    protected $fillable = ['nombre', 'project_id', 'sprint_id'];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    // Cada tablero tiene muchas columnas
    public function columnas()
    {
        return $this->hasMany(Columna::class);
    }
    // Cada tablero tiene muchas historias
    public function historias()
    {
        return $this->hasMany(Formatohistoria::class, 'tablero_id');
    }


    // Relación corregida: un tablero pertenece a un sprint
    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }


