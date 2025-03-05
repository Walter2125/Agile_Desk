<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CustomLoginController extends Controller
{
    // Mostrar el formulario de login personalizado
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar el login personalizado
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Buscar al usuario por su email
        $user = User::where('email', $request->email)->first();

        // Verificar si el usuario existe y si la contraseña es correcta
        if ($user && Hash::check($request->password, $user->password)) {
            // Iniciar sesión manualmente
            Auth::login($user);

            // Redirigir al usuario según su rol
            if ($user->role == 'admin') {
                return redirect()->route('home');
            } else {
                return redirect()->route('homeuser');
            }
        }

        // Si las credenciales son incorrectas, mostrar un mensaje de error
        return redirect()->route('custom.login.form')->with('error', 'Credenciales incorrectas.');
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('custom.login.form');
    }
}