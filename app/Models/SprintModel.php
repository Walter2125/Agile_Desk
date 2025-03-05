<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SprintModel extends Model
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
