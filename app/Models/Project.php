<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'nuevo_proyecto'; // Asegúrate de que el nombre sea el correcto

    protected $fillable = ['name', 'fecha_inicio', 'fecha_fin', 'user_id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user', 'nuevo_proyecto_id', 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id'); // O el campo que uses para almacenar el creador
    }
    
    public function sprints()
    {
        return $this->hasMany(Sprint::class, 'project_id');
    }
}