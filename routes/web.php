<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicioController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/servicios/{slug}', [ServicioController::class, 'show'])->name('servicios.show');
