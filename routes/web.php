<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/',function(){
        return view('formato.index');
});*/



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|

Los modales solo son para hacer avisos no para hacer formularios
No usar en exceso los modales
prohiido los alerts de javascript , se pueden usar los de bostrap pero no utilizar los alerts de javascript
Ya que los botones estan programados por si solos
Nada de alerts
*/

// Ruta para la vista principal
Route::get('/Homeuser', function () {
    return view('HomeUser'); // Asegúrate de que la vista se llame 'HomeUser.blade.php'
})->name('home');

// Ruta para la creación de un Sprint
Route::get('/sprints/create', function () {
    return view('sprints.create'); // Crea la vista 'sprints/create.blade.php'
})->name('sprints.create');

// Ruta para el inicio de sesión
Route::get('/login', function () {
    return view('auth.login'); // Laravel usa 'auth/login.blade.php' para login
})->name('login');
//plantilla
Route::get('/home', function () {
    return view('homeadmin');
});
