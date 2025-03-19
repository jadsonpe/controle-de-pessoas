<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CondominioController;
use App\Http\Controllers\ApartamentoController;
use App\Http\Controllers\EntradaSaidaController;

Route::get('/', function () {
    return redirect()->route('condominios.index');
});

Route::resource('condominios', CondominioController::class);
Route::resource('apartamentos', ApartamentoController::class);
Route::resource('entradas', EntradaSaidaController::class);
Route::post('entradas/{id}/checkout', [EntradaSaidaController::class, 'checkout'])->name('entradas.checkout');


Route::get('/', function () {
    return view('day.index');
});

Route::get('/portifolio', function () {
    return view('day.portifolio-detail');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

