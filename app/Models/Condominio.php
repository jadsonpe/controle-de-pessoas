<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condominio extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];

    // Relacionamento com funcionários
    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }

    // Relacionamento com pessoas
    public function pessoas()
    {
        return $this->hasMany(Pessoa::class);
    }
}
