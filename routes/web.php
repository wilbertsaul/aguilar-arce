<?php

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\ClienteAuthController;
use App\Http\Controllers\ClientePanelController;
use App\Http\Controllers\ConsultoriaController;
use App\Http\Controllers\DescargaSunatController;
use App\Http\Controllers\FacturadorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaqueteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/facturador', [FacturadorController::class, 'index'])->name('facturador');
Route::post('/facturador/consultar-documento', [FacturadorController::class, 'consultarDocumento'])
    ->middleware('throttle:20,1')
    ->name('facturador.consultar');

Route::get('/paquetes', [PaqueteController::class, 'index'])->name('paquetes');
Route::get('/descarga-sunat', [DescargaSunatController::class, 'index'])->name('descarga-sunat');
Route::post('/descarga-sunat/consultar', [DescargaSunatController::class, 'consultar'])
    ->middleware('throttle:5,1')
    ->name('descarga-sunat.consultar');

// Portal del cliente
Route::get('/acceder', [ClienteAuthController::class, 'showLogin'])->name('cliente.login');
Route::post('/acceder', [ClienteAuthController::class, 'login'])->middleware('throttle:10,1')->name('cliente.login.post');
Route::post('/salir', [ClienteAuthController::class, 'logout'])->name('cliente.logout');

Route::middleware(['auth', 'cliente.activo'])->group(function () {
    Route::get('/panel', [ClientePanelController::class, 'panel'])->name('cliente.panel');
    Route::post('/panel/descargar', [ClientePanelController::class, 'descargar'])
        ->middleware('throttle:5,1')
        ->name('cliente.descargar');
});

Route::get('/blog', [ArticuloController::class, 'blog'])->name('blog');
Route::get('/articulo/{slug}', [ArticuloController::class, 'show'])->name('articulo.show');

Route::get('/consultoria', [ConsultoriaController::class, 'show'])->name('consultoria.show');
Route::post('/consultoria', [ConsultoriaController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('consultoria.store');
