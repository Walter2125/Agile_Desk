<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tareas extends Model
{
    use HasFactory;
    protected $fillable = ['nombre','descripcion','historial','actividad','asignado','historia_id'];
    public function HistoriaModel(){
        return $this->belongsTo(HistoriaModel::class);
    }

    public function historia()
    {
            return $this->belongsTo(Formatohistoria::class, 'historia_id');
    }
}
