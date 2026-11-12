<?php

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\ConsultoriaController;
use App\Http\Controllers\FacturadorController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/facturador', [FacturadorController::class, 'index'])->name('facturador');
Route::post('/facturador/consultar-documento', [FacturadorController::class, 'consultarDocumento'])
    ->middleware('throttle:20,1')
    ->name('facturador.consultar');

Route::get('/blog', [ArticuloController::class, 'blog'])->name('blog');
Route::get('/articulo/{slug}', [ArticuloController::class, 'show'])->name('articulo.show');

Route::get('/consultoria', [ConsultoriaController::class, 'show'])->name('consultoria.show');
Route::post('/consultoria', [ConsultoriaController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('consultoria.store');
