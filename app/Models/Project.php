<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'nuevo_proyecto'; // Asegúrate de que el nombre sea el correcto

    protected $fillable = ['name', 'sprint_number'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user', 'nuevo_proyecto_id', 'user_id');
    }
}