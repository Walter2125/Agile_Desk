<?php

use App\Http\Controllers\FormatohistoriaControler;
use Illuminate\Support\Facades\Route;
/*
Route::get('/',function(){
    return view('welcome');
}); */


Route::get('/form',function(){
        return view('formato.index');
});
Route::get('/form/create',[FormatohistoriaControler::class,'create'])->name('formulario.create');//creasion de nuevahistoria
Route::post('form/store',[FormatohistoriaControler::class,'store'])->name('formulario.store');

// Ruta para la vista principal usuario
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


//ruta para vista de administrador
Route::get('/home', function () {
    return view('homeadmin');
});

//ruta tablero
Route::get('/tab', function () {
    return view('tablero');
});

