<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'tipo', 'condominio_id', 'funcionario_id'];

    // Relacionamento com o condomínio
    public function condominio()
    {
        return $this->belongsTo(Condominio::class);
    }

    // Relacionamento com o funcionário
    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

    // Relacionamento com os registros
    public function registros()
    {
        return $this->hasMany(Registro::class);
    }
}
