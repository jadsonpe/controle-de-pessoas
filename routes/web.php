<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApartamentoController;
use App\Http\Controllers\HospedeController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\AcompanhanteController;
use App\Http\Controllers\LeituraEnergiaController;
use App\Http\Controllers\MovimentacaoHospedeController;

// Route::middleware(['auth'])->group(function () {
    // Dashboard
    
    
    // Rota para administradores
    // Route::middleware(['role:administrador'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('apartamentos', ApartamentoController::class);
        Route::resource('veiculos', VeiculoController::class);
        Route::resource('acompanhantes', AcompanhanteController::class);
        Route::resource('leituras-energia', LeituraEnergiaController::class);
        
        Route::resource('hospedes', HospedeController::class);
        //Route::get('/hospedes/registro', [HospedeController::class, 'create'])->name('hospedes.registro');
        //Route::post('/hospedes/registro', [HospedeController::class, 'store'])->name('hospedes.store');

        Route::resource('movimentacoes', MovimentacaoHospedeController::class);
        // Funções adicionais para relatórios, usuários e registros
        Route::get('relatorios', [DashboardController::class, 'relatorios'])->name('relatorios');
        Route::get('usuarios', [DashboardController::class, 'usuarios'])->name('usuarios');
    // });
        // Route::get('leituras-energia/ultima-leitura/{apartamento}', [LeituraEnergiaController::class, 'ultimaLeitura']);
        Route::get('/leituras-energia/ultima-leitura/{apartamento}', [LeituraEnergiaController::class, 'ultimaLeitura']);
    // Rota para porteiros
    // // Route::middleware(['role:porteiro'])->group(function () {
    //     Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.porteiro');
    //     Route::get('hospedes/ativos', [HospedeController::class, 'ativos'])->name('hospedes.ativos');
    // });
// });


// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AuthController;
// use App\Http\Controllers\CondominioController;
// use App\Http\Controllers\ApartamentoController;
// use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return redirect()->route('condominios.index');
// });

// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');


Route::get('/', function () {
    return view('day.index');
});

// Route::get('/portifolio', function () {
//     return view('day.portifolio-detail');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware('auth');


// // Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// // Route::post('/login', [AuthController::class, 'login'])->name('login.process');
// // Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

