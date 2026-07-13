<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConsultoriaController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/consultoria', [ConsultoriaController::class, 'show'])->name('consultoria.show');
Route::post('/consultoria', [ConsultoriaController::class, 'store'])->name('consultoria.store');
