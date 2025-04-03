<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // Gate genérica que permite admin acessar qualquer coisa
        Gate::before(function ($user, $ability) {
            if ($user->role === 'administrador') {
                return true;
            }
        });
        
        // Gate para admin (acesso total)
        Gate::define('admin-access', function ($user) {
            return $user->role === 'administrador';
        });
    
    
        // Demais Gates específicas
        Gate::define('porteiro-access', function ($user) {
            return $user->role === 'porteiro';
        });
        
        // Gates para recursos específicos
        Gate::define('gerenciar-apartamentos', function ($user) {
            return $user->role === 'administrador' || $user->role === 'porteiro';
        });
    }
}