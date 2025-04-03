<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;  
use App\Models\User;                  

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configuração para evitar problemas de tamanho de string
        Schema::defaultStringLength(191);
        
        // Definição global que permite admin acessar tudo
        Gate::before(function ($user, $ability) {
            if ($user->role === 'administrador') {
                return true;
            }
        });
        
        // Definição de escopo para visualizações
        view()->composer('*', function ($view) {
            $view->with('currentUser', \Illuminate\Support\Facades\Auth::user());
        });
    }
}