<?php

namespace App\Http\Controllers\Auth; // Asegúrate de definir el namespace

use App\Http\Controllers\Controller; // Agregar esta línea para importar la clase Controller
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function redirectTo()
    {
        if (Auth::user()->role === 'admin') {
            return '/HomeAdmin';
        }

        return '/Homeuser';
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
