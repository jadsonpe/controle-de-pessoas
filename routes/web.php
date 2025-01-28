<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CondominioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\UserController;

// Página inicial (Home)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Cadastro de Condomínios
Route::get('/condominio/cadastrar', [CondominioController::class, 'create'])->name('condominio.create');
Route::post('/condominio', [CondominioController::class, 'store'])->name('condominio.store');

// Dashboard do Condomínio
Route::get('/condominio/{condominio_id}/dashboard', [DashboardController::class, 'index'])->name('condominio.dashboard');

// Registro de Pessoas (Entrada/Saída)
Route::post('/pessoa', [PessoaController::class, 'store'])->name('pessoa.store');


// Exibição do formulário de registro
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');

// Processa o registro do usuário
Route::post('/register', [UserController::class, 'store'])->name('register.store');

// Exibição do formulário de login
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');

// Processa o login
Route::post('/login', [UserController::class, 'login'])->name('login.store');

// Logout
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware(['admin'])->group(function () {
    // Rotas para administradores, como a visualização dos condomínios, por exemplo
});
