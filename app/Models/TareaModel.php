<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TareaModel extends Model
{
    use HasFactory;

    protected $table = 'tareas';

    protected $fillable = [
        'historia_id',
        'titulo',
        'estado'
    ];

    public function historia()
    {
        return $this->belongsTo(HistoriaModel::class, 'historia_id');
    }
}
