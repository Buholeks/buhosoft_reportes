<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegistroControlador;
use App\Http\Controllers\controladorequipos;
use App\Http\Controllers\ControladorChip;
use App\Http\Controllers\ControladorGarantia;
use App\Http\Controllers\ControladorSucursal;
use App\Http\Controllers\ControladorBuscar;
use App\Http\Controllers\ControladorListadePrecios;
use App\Http\Controllers\ControladorUsuario;
use App\Http\Controllers\ControladorRol;

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('home');
    });

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('layouts/app', function () {
        return view('layouts.app');
    })->name('app');

    Route::get('home', function () {
        return view('home');
    })->name('home')->middleware('auth');
});


Route::get('register', [RegistroControlador::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegistroControlador::class, 'register']);


Route::get('local/chip', [controladorchip::class, 'metodochip'])->name('chip');
Route::post('local/chip', [ControladorChip::class, 'guardarChip'])->name('guardar.Chip');
Route::get('local/chip', [ControladorChip::class, 'mostrarChip'])->name('chip');



// Primero tus rutas personalizadas
Route::get('/garantia/status', [ControladorGarantia::class, 'verStatus'])->name('garantia.status');
Route::post('/garantia/cambiar-status/{id}', [ControladorGarantia::class, 'cambiarStatus'])->name('garantia.cambiarStatus');
Route::get('/garantia/test', function () {
    return view('garantia.test');
})->name('garantia.test');
Route::resource('garantias', ControladorGarantia::class);


Route::get('autenticacion/registro', function () {
    return view('autenticacion/registro');
});


Route::get('/buscar-vendedores', [ControladorBuscar::class, 'buscarVendedores'])->name('buscar-vendedores');
Route::get('/buscar-clientes', [ControladorBuscar::class, 'buscarClientes'])->name('buscar-clientes');






Route::middleware(['auth'])->group(function () {
    // Usuarios
    Route::resource('usuarios', ControladorUsuario::class);
    Route::get('usuarios/{id}/roles', [ControladorUsuario::class, 'roles'])->name('usuarios.roles');
    Route::post('usuarios/{id}/roles', [ControladorUsuario::class, 'asignarRoles'])->name('usuarios.actualizarRoles');
    Route::get('usuarios/{id}/permisos', [ControladorUsuario::class, 'permisos'])->name('usuarios.permisos');
    Route::post('usuarios/{id}/permisos', [ControladorUsuario::class, 'asignarPermisos'])->name('usuarios.actualizarPermisos');

    // Roles
    Route::resource('roles', ControladorRol::class);
    Route::get('roles/{id}/permisos', [ControladorRol::class, 'permisos'])->name('roles.permisos');
    Route::post('roles/{id}/permisos', [ControladorRol::class, 'asignarPermisos'])->name('roles.asignarPermisos');

    Route::resource('listadeprecios', ControladorListadePrecios::class);
    Route::get('/listadeprecios/{id}/edit', [ControladorListadePrecios::class, 'edit']);

    // Agrupamos todas las rutas relacionadas a equipos
    Route::prefix('equipos')->name('equipos.')->group(function () {
        // Mostrar listado principal
        Route::get('/', [Controladorequipos::class, 'index'])->name('index');
        
        // Vista para registrar
        Route::get('/create', [Controladorequipos::class, 'create'])->name('create');
        // Guardar nuevo equipo
        Route::post('/', [Controladorequipos::class, 'store'])->name('store');
        // Mostrar detalles de un equipo (opcional)
        Route::get('/{equipo}', [Controladorequipos::class, 'show'])->name('show');
        // Editar equipo
        Route::get('/{equipo}/edit', [Controladorequipos::class, 'edit'])->name('edit');
        // Actualizar equipo
        Route::put('/{equipo}', [Controladorequipos::class, 'update'])->name('update');
        // Eliminar equipo
        Route::delete('/{equipo}', [Controladorequipos::class, 'destroy'])->name('destroy');
        // Exportar a Excel
        Route::post('/export/excel', [Controladorequipos::class, 'exportExcel'])->name('export.excel');
        // Exportar a PDF
        Route::post('/export/pdf', [Controladorequipos::class, 'exportPDF'])->name('export.pdf');
        // Procesar selección múltiple
        Route::post('/seleccionados', [Controladorequipos::class, 'procesarSeleccionados'])->name('seleccionados');
    });
});


Route::resource('sucursales', ControladorSucursal::class)->parameters([
    'sucursales' => 'sucursal'
]);


Route::get('vista_sucursal', [ControladorSucursal::class, 'showSelectSucursal'])->name('vista_sucursal');
Route::post('vista_sucursal', [ControladorSucursal::class, 'selectSucursal'])->name('vista_sucursal.post');
