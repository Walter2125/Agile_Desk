<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// Ruta para la vista principal
Route::get('/', function () {
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