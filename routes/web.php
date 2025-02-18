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

Los modales solo son para hacer avisos no para hacer formularios
No usar en exceso los modales
prohiido los alerts de javascript , se pueden usar los de bostrap pero no utilizar los alerts de javascript
Ya que los botones estan programados por si solos
Nada de alerts
*/

Route::get('/', function () {
    return view('welcome');
});
