<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tablero extends Model
{
    protected $table = 'tablero';
    protected $fillable = ['nombre', 'tablero_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
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
    
}
