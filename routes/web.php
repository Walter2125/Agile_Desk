<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\FormatohistoriaControler;
use App\Http\Controllers\FullCalendarController;
use App\Http\Controllers\HistoriaController;
use App\Http\Controllers\HistorialCambiosController;

use App\Http\Controllers\TableroController;



// Redirección a login por defecto
Route::get('/', function () {
    return redirect('/login');

});

// Rutas para formulario de historias
//Route::get('/form',[FormatohistoriaControler::class,'index'])->name('form.index');
Route::get('/create', [FormatohistoriaControler::class, 'create'])->name('formulario.create')->middleware('auth');
Route::post('/form/store', [FormatohistoriaControler::class, 'store'])->name('formulario.store')->middleware('auth');
Route::get('/form/{formulario}/edit',[FormatohistoriaControler::class,'edit'])->name('formulario.edit')->middleware('auth');
Route::patch('/form/{formulario}/update',[FormatohistoriaControler::class,'update'])->name('formulario.update')->middleware('auth');
Route::delete('/form/{formulario}/destroy',[FormatohistoriaControler::class,'destroy'])->name('formulario.destroy')->middleware('auth');

// Rutas de autenticación personalizadas
Route::get('/login', [CustomLoginController::class, 'showLoginForm'])->name('custom.login.form');
Route::post('/login', [CustomLoginController::class, 'login'])->name('custom.login');
Route::post('/logout', [CustomLoginController::class, 'logout'])->name('custom.logout');



// Rutas protegidas para Sprints
Route::get('/sprints/create', function () {
    return view('sprints.create');
})->name('sprints.create')->middleware('auth');
Route::get('/sprints', [SprintController::class, 'index'])->name('sprints.index')->middleware('auth');
Route::get('/sprints/detalle', [SprintController::class, 'detalleSprint'])->name('sprints.detalle')->middleware('auth');

// Ruta para el tablero
Route::get('/tab', [TableroController::class, 'index'])->name('tablero')->middleware('auth');
/*Route::get('/tab', function () {
    return view('tablero');
})->name('tablero')->middleware('auth');*/


//listas de sprint
Route::get('/sprints', [SprintController::class, 'index'])->name('sprints.index');
Route::get('/sprints/detalle', [SprintController::class, 'detalleSprint'])->name('sprints.detalle');

//ruta para calendario
// Buscar usuarios (protegido por autenticación)
Route::get('/users/search', [UserController::class, 'search'])->name('users.search')->middleware('auth');

// Rutas para proyectos
Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create')->middleware('auth');
Route::post('/projects/store', [ProjectController::class, 'store'])->name('projects.store')->middleware('auth');

Route::get('/projects', [ProjectController::class, 'myProjects'])->name('projects.my')->middleware('auth');

// Rutas para calendario
Route::controller(FullCalendarController::class)->group(function () {
    Route::get('fullcalendar', 'index');
    Route::get('fullcalendar/ajax', 'ajax');     
    Route::post('fullcalendar/store', 'store'); 
    Route::delete('fullcalendar/destroy/{id}', 'destroy');
    Route::put('fullcalendar/update/{id}', 'update');   
});

//ruta para miembros
Route::get('/miembros', [UserController::class, 'index'])->name('admin.users.index');

//ruta de las vistas
Route::get('/homeadmin', [AdminController::class, 'index'])->name('homeadmin')->middleware('auth');
Route::get('/HomeUser', [HomeController::class, 'index'])->name('HomeUser')->middleware('auth');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register']);

Route::post('/actualizar-estado', [HistoriaController::class, 'actualizarEstado'])->name('actualizar.estado');

//Ruta para el historial de cambios
Route::get('/historialcambios', [HistorialCambiosController::class, 'index'])->name('historialcambios.index');
Route::post('/historialcambios', [HistorialCambiosController::class, 'store']);
Route::post('/historialcambios/revertir/{id}', [HistorialCambiosController::class, 'revertir'])
    ->name('historialcambios.revertir');