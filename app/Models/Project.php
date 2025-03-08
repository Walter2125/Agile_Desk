<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'sprint_number'];

    // Relación muchos a muchos con User
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}