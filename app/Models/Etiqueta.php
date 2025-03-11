<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nombre',
        'color',
        'tipo',
        'descripcion',
        'sprint_id'
    ];
    
    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }
}