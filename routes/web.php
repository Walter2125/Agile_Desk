my<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/login');
});


// Rutas de autenticación personalizadas
Route::get('/login', [CustomLoginController::class, 'showLoginForm'])->name('custom.login.form');
Route::post('/login', [CustomLoginController::class, 'login'])->name('custom.login');
Route::post('/logout', [CustomLoginController::class, 'logout'])->name('custom.logout');

// Ruta para la vista principal del usuario (HomeUser)
Route::get('/Homeuser', function () {
    return view('HomeUser'); // Vista principal del usuario
})->name('homeuser')->middleware('auth'); // Protege la ruta con autenticación

// Ruta para la creación de un Sprint
Route::get('/sprints/create', function () {
    return view('sprints.create'); // Vista de creación de Sprint
})->name('sprints.create')->middleware('auth'); // Protege la ruta con autenticación

// Ruta para la vista de administrador
Route::get('/home', function () {
    return view('homeadmin'); // Vista de administrador
})->middleware('auth'); // Protege la ruta con autenticación

// Ruta para el tablero
Route::get('/tab', function () {
    return view('tablero'); // Vista del tablero
})->middleware('auth'); // Protege la ruta con autenticación

// Ruta para buscar usuarios
Route::get('/users/search', [UserController::class, 'search'])->name('users.search');

// Ruta para crear un proyecto
Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create')->middleware('auth');
Route::post('/projects/store', [ProjectController::class, 'store'])->name('projects.store')->middleware('auth');

// Ruta para el home después del login (puedes eliminarla si no la usas)
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
