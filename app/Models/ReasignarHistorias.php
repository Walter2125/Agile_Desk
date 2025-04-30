<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReasignarHistorias extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'descripcion', 'responsable_id'];

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
