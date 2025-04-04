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
    // Dashboard comum para todos usuários autenticados
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
        Route::get('/dashboard/disponibilidade', [DashboardController::class, 'verificarDisponibilidade'])
        ->name('disponibilidade.verificar');

    /*
    |--------------------------------------------------------------------------
    | Rotas de Administrador (Acesso Total)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['can:admin-access'])->group(function () {
        // Gestão de Apartamentos
        Route::resource('apartamentos', ApartamentoController::class);
        
        // Gestão de Veículos
        Route::resource('veiculos', VeiculoController::class);
        
        // Gestão de Acompanhantes
        Route::resource('acompanhantes', AcompanhanteController::class);
        
        // Leituras de Energia
        Route::resource('leituras-energia', LeituraEnergiaController::class);
        Route::get('/leituras-energia/ultima-leitura/{apartamento}', 
            [LeituraEnergiaController::class, 'ultimaLeitura'])
            ->name('leituras-energia.ultima-leitura');
        
        // Gestão de Hóspedes
        Route::resource('hospedes', HospedeController::class);
        
        // Movimentações de Hóspedes
        Route::resource('movimentacoes', MovimentacaoHospedeController::class);
        
        // Relatórios
        Route::get('relatorios', [DashboardController::class, 'relatorios'])
            ->name('relatorios');
        
        // Gestão de Usuários
        Route::middleware(['auth', 'verified'])->group(function () {
            // Rotas de usuários
            Route::get('usuarios', [UserController::class, 'index'])
                ->name('usuarios.index');
            Route::get('usuarios/create', [UserController::class, 'create'])
                ->name('usuarios.create');
            Route::post('usuarios', [UserController::class, 'store'])
                ->name('usuarios.store');
            Route::get('usuarios/{user}', [UserController::class, 'show'])
                ->name('usuarios.show');
            Route::get('usuarios/{user}/edit', [UserController::class, 'edit'])
                ->name('usuarios.edit');
            Route::put('usuarios/{user}', [UserController::class, 'update'])
                ->name('usuarios.update');
            Route::delete('usuarios/{user}', [UserController::class, 'destroy'])
                ->name('usuarios.destroy');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Rotas Específicas para Porteiros
    |--------------------------------------------------------------------------
    */
    Route::middleware(['can:porteiro-access'])->group(function () {
        // Lista de Hóspedes Ativos
        Route::get('hospedes/ativos', [HospedeController::class, 'ativos'])
            ->name('hospedes.ativos');
            
        // Registro de Hóspedes
        Route::post('hospedes/registrar', [HospedeController::class, 'store'])
            ->name('hospedes.registrar');
    });

    /*
    |--------------------------------------------------------------------------
    | Rotas de Perfil (Acessíveis por Todos Usuários Autenticados)
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Rotas de API (Opcional)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum'])->group(function () {
    // Rotas de API aqui, se necessário
});
// Rotas de autenticação (geradas pelo Laravel Breeze)
// require __DIR__.'/auth.php';    