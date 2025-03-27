<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroHospedagem extends Model
{
    use HasFactory;

    // Definir a tabela associada a este model
    protected $table = 'registros_hospedagem';

    // Definir os campos que podem ser preenchidos (mass assignment)
    protected $fillable = [
        'hospede_id',
        'apartamento_id',
        'data_entrada',
        'data_saida',
    ];

    // Relacionamento com o modelo Hospede
    public function hospede()
    {
        return $this->belongsTo(Hospede::class);
    }

    // Relacionamento com o modelo Apartamento
    public function apartamento()
    {
        return $this->belongsTo(Apartamento::class);
    }
}
