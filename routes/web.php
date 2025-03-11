<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\FormatohistoriaControler;
use App\Http\Controllers\FullCalendarController;

// Redirección a login por defecto
Route::get('/', function () {
    return redirect('/login');

});

// Rutas para formulario de historias
Route::get('/form', function () {
    return view('formato.index');
})->name('form.index');
Route::get('/form/create', [FormatohistoriaControler::class, 'create'])->name('formulario.create');
Route::post('/form/store', [FormatohistoriaControler::class, 'store'])->name('formulario.store');

// Rutas de autenticación personalizadas
Route::get('/login', [CustomLoginController::class, 'showLoginForm'])->name('custom.login.form');
Route::post('/login', [CustomLoginController::class, 'login'])->name('custom.login');
Route::post('/logout', [CustomLoginController::class, 'logout'])->name('custom.logout');

// Ruta principal para usuario normal
Route::get('/Homeuser', function () {
    return view('HomeUser');
})->name('homeuser')->middleware('auth');

// Ruta para la vista de administrador
Route::get('/homeadmin', function () {
    return view('homeadmin');
})->name('homeadmin')->middleware('auth');

// Rutas protegidas para Sprints
Route::get('/sprints/create', function () {
    return view('sprints.create');
})->name('sprints.create')->middleware('auth');
Route::get('/sprints', [SprintController::class, 'index'])->name('sprints.index')->middleware('auth');
Route::get('/sprints/detalle', [SprintController::class, 'detalleSprint'])->name('sprints.detalle')->middleware('auth');

// Ruta para el tablero
Route::get('/tab', function () {
    return view('tablero');
})->name('tablero')->middleware('auth');

// Buscar usuarios (protegido por autenticación)
Route::get('/users/search', [UserController::class, 'search'])->name('users.search')->middleware('auth');

// Rutas para proyectos
Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create')->middleware('auth');
Route::post('/projects/store', [ProjectController::class, 'store'])->name('projects.store')->middleware('auth');

// Ruta principal después del login
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Rutas para calendario
Route::controller(FullCalendarController::class)->group(function () {
    Route::get('fullcalendar', 'index');
    Route::get('fullcalendar/ajax', 'ajax');     
    Route::post('fullcalendar/store', 'store'); 
    Route::delete('fullcalendar/destroy/{id}', 'destroy');
    Route::put('fullcalendar/update/{id}', 'update');   
});
