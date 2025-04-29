<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\TareasController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TableroController;
use App\Http\Controllers\ColumnasController;
use App\Http\Controllers\HistoriaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FullCalendarController;
use App\Http\Controllers\FormatohistoriaControler;
use App\Http\Controllers\NotificacionesController;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\HistorialCambiosController;
use App\Http\Controllers\ReasignarHistoriaController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ArchivoHistoriaController;
use App\Http\Controllers\ColumnaController;
use App\Http\Controllers\ListaHistoriaController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Aquí se registran todas las rutas web de la aplicación.
*/

// --------------------- Rutas Públicas ---------------------
Route::get('/', fn() => redirect('/login'));
Route::get('/login',    [CustomLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',   [CustomLoginController::class, 'login']);
Route::post('logout',  [CustomLoginController::class, 'logout'])->name('logout');
Route::get('/register', [CustomLoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register',[CustomLoginController::class, 'register']);


// Recuperación de contraseña
Route::get('forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Restablecer contraseña
Route::get('reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// --------------------- Rutas Protegidas (Auth) ---------------------
Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return Auth::user()->usertype === 'admin'
            ? redirect()->route('homeadmin')
            : redirect()->route('HomeUser');
    })->name('dashboard');

    // Home de usuario normal
    Route::get('/HomeUser', [HomeController::class, 'index'])->name('HomeUser');


    // Logout
    Route::post('logout', [CustomLoginController::class, 'logout'])->name('logout');


    // Rutas para formulario de historias
    //Route::get('/form',[FormatohistoriaControler::class,'index'])->name('form.index');
 //   Route::get('/create', [FormatohistoriaControler::class, 'create'])->name('formulario.create');
    Route::post('/form/store', [FormatohistoriaControler::class, 'store'])->name('formulario.store');
    Route::get('/form/{formulario}/edit',[FormatohistoriaControler::class,'edit'])->name('formulario.edit');
    Route::patch('/form/{id}/update', [FormatohistoriaControler::class, 'update'])->name('formulario.update');
    Route::delete('/form/{formulario}/destroy',[FormatohistoriaControler::class,'destroy'])->name('formulario.destroy');
    Route::get('/form/{historia}/show', [FormatohistoriaControler::class, 'show'])->name('formulario.show');
    // Para mostrar el form de creación de historias dentro de un tablero concreto
    Route::get('tableros/{tablero}/historias/create', [FormatohistoriaControler::class, 'create'])->name('formulario.create');
    // Para almacenar la nueva historia asociada a ese mismo tablero
    Route::post('tableros/{tablero}/historias', [FormatohistoriaControler::class, 'store'])->name('formulario.store');

    //Lista de historias por cada usuarios
    Route::get('/mis-historias', [FormatohistoriaControler::class, 'index'])->name('mis_historias');

    // tareas por historia
    Route::get('/historias/{id}/tareas', [TareasController::class, 'indexPorHistoria'])->name('tareas.porHistoria');
    //Rutas para tareas
    Route::get('/tareas',[TareasController::class,'index'])->name('tareas.index');
    Route::get('/tareas/create',[TareasController::class,'create'])->name('tareas.create');
    Route::POST('/tareas/store',[TareasController::class,'store'])->name('tareas.store');
    Route::get('/tareas/{id}/edit',[TareasController::class,'edit'])->name('tareas.edit');
    Route::patch('/tareas/{id}',[TareasController::class,'update'])->name('tareas.update');
    Route::delete('/tareas/{id}', [TareasController::class, 'destroy'])->name('tareas.destroy');
    Route::get('/tareas/{id}/ver', [TareasController::class, 'show'])->name('tareas.show');



    /*
    Route::get('sprints/create', [SprintController::class, 'create'])->name('sprints.create');
    Route::post('sprints', [SprintController::class, 'store'])->name('sprints.store');
    //Route::get('sprints/create', fn() => view('sprints.create'))->name('sprints.create');
    Route::get('sprints', [SprintController::class, 'index'])->name('sprints.index');
    Route::get('sprints/detalle', [SprintController::class, 'detalleSprint'])->name('sprints.detalle');
*/
    // Rutas para Sprints
    Route::get('sprints', [SprintController::class, 'index'])->name('sprints.index');
    Route::get('sprints/create', [SprintController::class, 'create'])->name('sprints.create')->middleware('role:admin');
    Route::post('sprints', [SprintController::class, 'store'])->name('sprints.store')->middleware('role:admin');;
    Route::get('sprints/{sprint}/edit', [SprintController::class, 'edit'])->name('sprints.edit')->middleware('role:admin');;
    Route::put('sprints/{sprint}', [SprintController::class, 'update'])->name('sprints.update')->middleware('role:admin');;
    Route::delete('sprints/{sprint}', [SprintController::class, 'destroy'])->name('sprints.destroy')->middleware('role:admin');;
    Route::get('tableros/{sprint}', [TableroController::class, 'show'])->name('tableros.show');

    // Proyectos (solo mis proyectos)
    Route::get('projects', [ProjectController::class, 'myProjects'])->name('projects.my');

    /*
    Route::get('proyectos/{proyecto}/tableros/create', [TableroController::class, 'create'])->name('tableros.create');
    Route::post('proyectos/{proyecto}/tableros', [TableroController::class, 'store'])->name('tableros.store');
    Route::get('tableros/{tablero}', [TableroController::class, 'show'])->name('tableros.show');
    */
// Rutas para columnas (para uso vía AJAX)
    Route::post('columnas', [ColumnaController::class, 'store'])->name('columnas.store');
    Route::put('columnas/{columna}', [ColumnaController::class, 'update'])->name('columnas.update');
    Route::delete('columnas/{columna}', [ColumnaController::class, 'destroy'])->name('columnas.destroy');
    Route::post('/tableros/{tablero}/columnas', [ColumnaController::class, 'store'])->name('columnas.store');
    Route::put('/tableros/{tablero}/columnas/{columna}', [ColumnaController::class, 'update'])->name('columnas.update');
    Route::delete('/tableros/{tablero}/columnas/{columna}', [ColumnaController::class, 'destroy'])->name('columnas.destroy');
    Route::post('/columna/store', [ColumnaController::class, 'store'])->name('columna.store');

    // Calendario
    Route::controller(FullCalendarController::class)->prefix('fullcalendar')->group(function () {
        Route::get('/', 'index')->name('fullcalendar.index');
        Route::get('ajax', 'ajax')->name('fullcalendar.ajax');
        Route::post('store', 'store')->name('fullcalendar.store');
        Route::put('update/{id}', 'update')->name('fullcalendar.update');
        Route::delete('destroy/{id}', 'destroy')->name('fullcalendar.destroy');
    });

    // Columnas y estados (AJAX)
    Route::post('actualizar-estado', [HistoriaController::class, 'actualizarEstado'])->name('actualizar.estado');
    Route::post('actualizar-nombre-columna', [ColumnasController::class, 'actualizarNombre'])->name('columnas.updateName');

    // Notificaciones
    Route::get('notificaciones', [NotificacionesController::class, 'index'])->name('notificaciones.index');
    Route::post('notificaciones/{id}/read', [NotificacionesController::class, 'markAsRead'])->name('notificaciones.markAsRead');
    Route::post('notificaciones/read-all', [NotificacionesController::class, 'markAllAsRead'])->name('notificaciones.markAllAsRead');
    Route::delete('notificaciones/{id}', [NotificacionesController::class, 'destroy'])->name('notificaciones.destroy');

    // Historial de cambios
    Route::get('/historialcambios',                  [HistorialCambiosController::class, 'index'])->name('historialcambios.index');
    Route::get('/historialcambios/{id}',             [HistorialCambiosController::class, 'show'])->name('historialcambios.show');
    Route::post('/historialcambios',                 [HistorialCambiosController::class, 'store'])->name('historialcambios.store');
    Route::match(['post','delete'], '/historialcambios/revertir/{id}',
         [HistorialCambiosController::class, 'revertir'])->name('historialcambios.revertir');

    // Reasignación de historias
    Route::get('/reasignacion-historias',           [ReasignarHistoriaController::class, 'index'])->name('reasinarhistoria.index');
    Route::post('/reasignacion-historias/reasignar',[ReasignarHistoriaController::class, 'reasignar']);

    //ruta para miembros
    Route::get('/miembros', [UserController::class, 'index'])->name('admin.users.index');

    // En tu archivo routes/web.php, dentro del grupo middleware('auth')

// Lista de todos los tableros del usuario
    Route::get('/tab',            [TableroController::class, 'index'])->name('tablero');
    Route::get('/tableros/{id}',  [TableroController::class, 'show'])->name('tableros.show');
    Route::delete('/tableros/{tablero}', [TableroController::class, 'destroy'])->name('tableros.destroy');


    Route::delete('/projects/{project}',                   [ProjectController::class, 'destroy'])->name('projects.destroy');

    // **Rutas de administrador** (solo usuarios con usertype = 'admin')
   Route::middleware('role:admin')->group(function () {
        // Home de admin
        Route::get('/homeadmin', [AdminController::class, 'index'])->name('homeadmin');

            // Gestión de usuarios
            Route::get('admin/users', [UserController::class, 'index'])->name('admin.users.index');
            Route::get('admin/users/search', [UserController::class, 'search'])->name('admin.users.search');

        // CRUD de proyectos
        Route::get('/projects/create',                         [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects/store',                         [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/projects/{project}/edit',                 [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{project}',                      [ProjectController::class, 'update'])->name('projects.update');

        Route::delete('/projects/{project}/remove-user/{user}',[ProjectController::class, 'removeUser'])->name('projects.removeUser');
        Route::get('/projects/search-users',                   [ProjectController::class, 'searchUsers'])->name('projects.searchUsers');

        // Gestión de usuarios
        Route::get('/miembros',    [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/search',[UserController::class, 'search'])->name('users.search');


    });

    //Rutas de aarchivar historias
    Route::get('/archivo/seleccionar', [ArchivoHistoriaController::class, 'mostrarHistoriasDisponibles'])->name('archivo.seleccionar');
        Route::post('/archivo/archivar/{id}', [ArchivoHistoriaController::class, 'archivar'])->name('archivo.archivar');
        Route::get('/archivo', [ArchivoHistoriaController::class, 'index'])->name('archivo.index');
        Route::post('/archivo/desarchivar/{id}', [ArchivoHistoriaController::class, 'desarchivar'])->name('archivo.desarchivar');

    //Lista de historias por cada usuarios
    Route::get('/mis-historias', [FormatohistoriaControler::class, 'misHistorias'])->name('mis_historias');
});

