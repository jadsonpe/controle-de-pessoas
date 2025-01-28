<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['nome', 'email', 'password', 'condominio_id', 'is_admin'];

    protected $hidden = ['password', 'remember_token'];

    // Para login via email e senha
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Método para verificar se o usuário é administrador
    public function isAdmin()
    {
        return $this->is_admin;
    }
}
