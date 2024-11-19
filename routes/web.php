<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('landing.index');
})->name('raiz');

Route::get('/login', function () {
    return view('usuario.login');
})->name('usuario.login');

Route::post('/login', [UserController::class, 'login'])->name('usuario.validar');

Route::post('/logout', [UserController::class, 'logout'])->name('usuario.logout');

Route::get('/backoffice', [DashboardController::class, 'index'])->name('backoffice.dashboard');


Route::get('/backoffice/proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');
Route::get('/backoffice/proyectos/get/{_id}', [ProyectoController::class, 'getById']);
Route::post('/backoffice/proyectos/new', [ProyectoController::class, 'create'])->name('proyectos.create');
Route::post('/backoffice/proyectos/down/{_id}', [ProyectoController::class, 'disable'])->name('proyectos.disable');
Route::post('/backoffice/proyectos/up/{_id}', [ProyectoController::class, 'enable'])->name('proyectos.enable');
Route::put('/backoffice/proyectos/update/{_id}', [ProyectoController::class, 'update'])->name('proyectos.update');
Route::post('/backoffice/proyectos/delete/{_id}', [ProyectoController::class, 'delete'])->name('proyectos.delete');

Route::get('/backoffice/usuarios', [UserController::class, 'index'])->name('usuarios.index');
Route::get('/backoffice/usuarios/get/{_id}', [UserController::class, 'getById']);
Route::post('/backoffice/usuarios/new', [UserController::class, 'create'])->name('usuarios.create');
Route::post('/backoffice/usuarios/down/{_id}', [UserController::class, 'disable'])->name('usuarios.disable');
Route::post('/backoffice/usuarios/up/{_id}', [UserController::class, 'enable'])->name('usuarios.enable');
Route::put('/backoffice/usuarios/update/{_id}', [UserController::class, 'update'])->name('usuarios.update');
Route::post('/backoffice/usuarios/delete/{_id}', [UserController::class, 'delete'])->name('usuarios.delete');

Route::get('/backoffice/clientes', [ClienteController::class, 'index'])->name('clientes.index');
Route::get('/backoffice/clientes/get/{_id}', [ClienteController::class, 'getById']);
Route::post('/backoffice/clientes/new', [ClienteController::class, 'create'])->name('clientes.create');
Route::post('/backoffice/clientes/down/{_id}', [ClienteController::class, 'disable'])->name('clientes.disable');
Route::post('/backoffice/clientes/up/{_id}', [ClienteController::class, 'enable'])->name('clientes.enable');
Route::put('/backoffice/clientes/update/{_id}', [ClienteController::class, 'update'])->name('clientes.update');
Route::post('/backoffice/clientes/delete/{_id}', [ClienteController::class, 'delete'])->name('clientes.delete');

Route::get('/backoffice/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::get('/backoffice/productos/get/{_id}', [ProductoController::class, 'getById']);
Route::post('/backoffice/productos/new', [ProductoController::class, 'create'])->name('productos.create');
Route::post('/backoffice/productos/down/{_id}', [ProductoController::class, 'disable'])->name('productos.disable');
Route::post('/backoffice/productos/up/{_id}', [ProductoController::class, 'enable'])->name('productos.enable');
Route::put('/backoffice/productos/update/{_id}', [ProductoController::class, 'update'])->name('productos.update');
Route::post('/backoffice/productos/delete/{_id}', [ProductoController::class, 'delete'])->name('productos.delete');
