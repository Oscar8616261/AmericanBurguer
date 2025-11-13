<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\OfertasController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendientesController;


/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/ofertas', [OfertasController::class, 'index'])->name('ofertas.index');
Route::get('/categoria',[CategoriaController::class,'listar'])->name('categoria.listar');

Route::middleware(['auth:web,clientes'])->group(function () {
    Route::get('/producto/create',[ProductoController::class,'create'])->name('producto.create');

    
    Route::get('/categoria/create',[CategoriaController::class,'create'])->name('categoria.create');

    Route::get('/cliente',[ClienteController::class,'listar'])->name('cliente.listar');
    Route::get('/cliente/create',[ClienteController::class,'create'])->name('cliente.create');

    Route::get('/empresa/listar',[EmpresaController::class,'listar'])->name('empresa.listar');

    Route::get('/empresa/create', [EmpresaController::class, 'create'])->name('empresa.create');
    Route::get('/ventas', [VentasController::class, 'index'])->name('ventas.index');
    Route::get('/usuario', [UsuarioController::class, 'index'])->name('usuarios.index');

    Route::get('/pendientes', [PendientesController::class, 'index'])->name('pendientes.index');
    
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');