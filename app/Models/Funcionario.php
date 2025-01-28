<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'email', 'password', 'condominio_id'];

    // Relacionamento com o condomínio
    public function condominio()
    {
        return $this->belongsTo(Condominio::class);
    }

    // Relacionamento com as pessoas
    public function pessoas()
    {
        return $this->hasMany(Pessoa::class);
    }
}
