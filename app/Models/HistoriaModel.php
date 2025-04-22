<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriaModel extends Model
{
    use HasFactory;

    protected $table = 'historias_usuarios';

    protected $fillable = [
        'sprint_id',
        'titulo',
        'descripcion',
        'trabajo_estimado',
        'responsable',
        'prioridad'
    ];

    // Relación con Sprint (opcional, si realmente existe la tabla sprints)
    public function sprint()
    {
        return $this->belongsTo(SprintModel::class, 'sprint_id');
    }

    // Relación con Tareas (opcional, si usas otra tabla para tareas)
    public function tareas()
    {
        return $this->hasMany(TareaModel::class, 'historia_id');
    }
    // Relación con Tablero (opcional, si usas otra tabla para tableros)

    public function columna()
    {
        return $this->belongsTo(Columna::class);
    }
}

/*
class HistoriaModel extends Model
{
    use HasFactory;

    protected $table = 'historias_usuarios';

    protected $fillable = [
        'sprint_id',
        'titulo',
        'descripcion'
    ];

    public function sprint()
    {
        return $this->belongsTo(SprintModel::class, 'sprint_id');
    }

    public function tareas()
    {
        return $this->hasMany(TareaModel::class, 'historia_id');
    }
}
*/
