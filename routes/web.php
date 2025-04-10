<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApartamentoController;
use App\Http\Controllers\HospedeController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\AcompanhanteController;
use App\Http\Controllers\LeituraEnergiaController;
use App\Http\Controllers\MovimentacaoHospedeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('day.index');
});

/*
|--------------------------------------------------------------------------
| Rotas de Autenticação (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Rotas Autenticadas
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // // Perfil
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Dashboard (Acessível por admin e porteiro)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:administrador,porteiro'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/disponibilidade', [DashboardController::class, 'verificarDisponibilidade'])
            ->name('disponibilidade.verificar');
            Route::resource('hospedes', HospedeController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | Rotas de Administrador
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'role:administrador'])->group(function () {
        Route::resource('apartamentos', ApartamentoController::class);
        Route::resource('veiculos', VeiculoController::class);
        Route::resource('acompanhantes', AcompanhanteController::class);
        
        // Leituras de Energia
        Route::resource('leituras-energia', LeituraEnergiaController::class);
        Route::get('/leituras-energia/ultima-leitura/{apartamento}', 
            [LeituraEnergiaController::class, 'ultimaLeitura'])
            ->name('leituras-energia.ultima-leitura');
        
        // Gestão Completa
       
        Route::resource('movimentacoes', MovimentacaoHospedeController::class);
        
        // Relatórios
        // Route::resource('relatorios', [DashboardController::class, 'relatorios']);
        Route::prefix('relatorios')->group(function () {
            Route::get('/', [RelatorioController::class, 'index'])->name('relatorios.index');
            Route::get('/hospedes', [RelatorioController::class, 'hospedesPorPeriodo'])->name('relatorios.hospedes');
            Route::get('/movimentacoes', [RelatorioController::class, 'movimentacoes'])->name('relatorios.movimentacoes');
            Route::get('/energia', [RelatorioController::class, 'energia'])->name('relatorios.energia');
        });
        Route::prefix('relatorios')->name('relatorios.')->group(function () {

            // Página inicial dos relatórios
            Route::get('/', [RelatorioController::class, 'index'])->name('index');
        
            // Relatório de hóspedes por período (HTML)
            Route::get('/hospedes', [RelatorioController::class, 'hospedesPorPeriodo'])->name('hospedes');
        
            // Exportar hóspedes em PDF
            Route::get('/hospedes/pdf', [RelatorioController::class, 'exportHospedesPdf'])->name('hospedes.pdf');
        
            // Relatório de movimentações por período (HTML)
            Route::get('/movimentacoes', [RelatorioController::class, 'movimentacoes'])->name('movimentacoes');
        
            // Exportar movimentações em PDF
            Route::get('/movimentacoes/pdf', [RelatorioController::class, 'exportMovimentacoesPdf'])->name('movimentacoes.pdf');
        
            // Relatório de leitura de energia (HTML)
            Route::get('/energia', [RelatorioController::class, 'energia'])->name('energia');
        
            // Exportar leitura de energia em PDF
            Route::get('/energia/pdf', [RelatorioController::class, 'exportEnergiaPdf'])->name('energia.pdf');
        });

        
        // Gestão de Usuários
        Route::prefix('usuarios')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('usuarios.index');
            Route::get('/create', [UserController::class, 'create'])->name('usuarios.create');
            Route::post('/', [UserController::class, 'store'])->name('usuarios.store');
            Route::get('/{user}', [UserController::class, 'show'])->name('usuarios.show');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('usuarios.edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('usuarios.update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('usuarios.destroy');
        });

        Route::prefix('hospedes')->group(function () {
            Route::get('/ativos', [HospedeController::class, 'ativos'])->name('hospedes.ativos');
            Route::post('/registrar', [HospedeController::class, 'store'])->name('hospedes.registrar');
        });

        // Movimentações (acesso limitado)
        Route::prefix('movimentacoes')->group(function () {
            Route::get('/', [MovimentacaoHospedeController::class, 'index'])->name('movimentacoes.index');
            Route::post('/', [MovimentacaoHospedeController::class, 'store'])->name('movimentacoes.store');
        });
    });
});
