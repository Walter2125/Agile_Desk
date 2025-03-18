<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    public function isAdmin()
    {
        return $this->role == '1';
    }
    
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

}
