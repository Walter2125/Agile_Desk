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
Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Restablecer contraseña
Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [CustomLoginController::class, 'logout'])->name('logout');

    // Home de usuario normal
    Route::get('/HomeUser', [HomeController::class, 'index'])->name('HomeUser');

       // Dashboard principal (Usuario)
       Route::get('dashboard', [HomeController::class, 'index'])->name('user.dashboard');

    // Historias de usuario
    
    Route::get('/create',                    [FormatohistoriaControler::class, 'create'])->name('formulario.create');
    Route::post('/form/store',               [FormatohistoriaControler::class, 'store'])->name('formulario.store');
    Route::get('/form/{formulario}/edit',    [FormatohistoriaControler::class, 'edit'])->name('formulario.edit');
    Route::patch('/form/{formulario}/update',[FormatohistoriaControler::class, 'update'])->name('formulario.update');
    Route::delete('/form/{formulario}/destroy',[FormatohistoriaControler::class, 'destroy'])->name('formulario.destroy');
    Route::get('/form/{historia}/show',      [FormatohistoriaControler::class, 'show'])->name('formulario.show');

    // Tareas
    Route::get('/tareas',         [TareasController::class, 'index'])->name('tareas.index');
    Route::get('/tareas/create',  [TareasController::class, 'create'])->name('tareas.create');
    Route::post('/tareas/store',  [TareasController::class, 'store'])->name('tareas.store');
    Route::get('/tareas/{id}/edit',[TareasController::class, 'edit'])->name('tareas.edit');
    Route::patch('/tareas/{id}',  [TareasController::class, 'update'])->name('tareas.update');
    Route::delete('/tareas/{id}', [TareasController::class, 'destroy'])->name('tareas.destroy');
    Route::get('/tareas/{id}/ver', [TareasController::class, 'show'])->name('tareas.show');
    // tareas por historia 
    Route::get('/historias/{id}/tareas', [TareasController::class, 'indexPorHistoria'])->name('tareas.porHistoria')->middleware('auth');

    
    // Sprints
    Route::get('/sprints/create', fn() => view('sprints.create'))->name('sprints.create');
    Route::get('/sprints',        [SprintController::class, 'index'])->name('sprints.index');
    Route::get('/sprints/detalle',[SprintController::class, 'detalleSprint'])->name('sprints.detalle');

    // Proyectos (solo ver los propios)
    Route::get('/projects', [ProjectController::class, 'myProjects'])->name('projects.my');

    // Calendario
    Route::controller(FullCalendarController::class)->group(function () {
        Route::get('fullcalendar',      'index');
        Route::get('fullcalendar/ajax', 'ajax');
        Route::post('fullcalendar/store','store');
        Route::delete('fullcalendar/destroy/{id}','destroy');
        Route::put('fullcalendar/update/{id}','update');
    });

    // Actualizaciones AJAX de columnas y estados
    Route::post('/actualizar-estado',        [HistoriaController::class, 'actualizarEstado'])->name('actualizar.estado');
    Route::post('/actualizar-nombre-columna',[ColumnasController::class, 'actualizarNombre']);
    Route::post('/columnas',                 [ColumnasController::class, 'store'])->name('columnas.store');

    // Notificaciones
    Route::get('/notificaciones',               [NotificacionesController::class, 'index'])->name('notificaciones.index');
    Route::post('/notificaciones/{id}/read',    [NotificacionesController::class, 'markAsRead'])->name('notificaciones.markAsRead');
    Route::post('/notificaciones/read-all',     [NotificacionesController::class, 'markAllAsRead'])->name('notificaciones.markAllAsRead');
    Route::delete('/notificaciones/{id}',       [NotificacionesController::class, 'destroy'])->name('notificaciones.destroy');

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

    // Tablero Kanban
    Route::get('/tab',            [TableroController::class, 'index'])->name('tablero');
    Route::get('/tableros/{id}',  [TableroController::class, 'show'])->name('tableros.show');
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
});
