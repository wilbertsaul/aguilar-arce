<?php

use App\Http\Controllers\ConsultoriaController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/consultoria', [ConsultoriaController::class, 'show'])->name('consultoria.show');
Route::post('/consultoria', [ConsultoriaController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('consultoria.store');
