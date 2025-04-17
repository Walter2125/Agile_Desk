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
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Procesar el login personalizado
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intentar iniciar sesión con las credenciales proporcionadas
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            
            // Redirigir al usuario según su rol
            if (Auth::user()->usertype == 'admin') {
                return redirect()->route('homeadmin');
            } else {
                return redirect()->route('HomeUser');
            }
        }

        // Si las credenciales son incorrectas, mostrar un mensaje de error
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no son válidas.',
        ])->withInput($request->only('email'));
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'usertype' => 'user',
        ]);
    
        Auth::login($user); 
    
        return redirect()->route('HomeUser')->with('success', 'Registro exitoso. Bienvenido!');
    }
}