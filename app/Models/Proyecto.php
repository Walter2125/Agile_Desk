<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];
    
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function sprints()
    {
        return $this->hasMany(Sprint::class);
    }
    
    // Calcular el progreso del proyecto basado en sprints completados
    public function getProgresoAttribute()
    {
        $totalSprints = $this->sprints()->count();
        
        if ($totalSprints === 0) {
            return 0;
        }
        
        $sprintsCompletados = $this->sprints()->where('estado', 'completado')->count();
        
        return round(($sprintsCompletados / $totalSprints) * 100);
    }
    
    // Obtener días restantes para finalizar el proyecto
    public function getDiasRestantesAttribute()
    {
        return now()->diffInDays($this->fecha_fin, false);
    }
}