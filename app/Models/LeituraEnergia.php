<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeituraEnergia extends Model
{
    use HasFactory;

    protected $table = 'leituras_energia';

    protected $fillable = [
        'apartamento_id',
        'leitura_entrada',
        'leitura_saida',
        'total_kw_h',
        'data_leitura',
    ];

    // Relacionamento com apartamento
    public function apartamento()
    {
        return $this->belongsTo(Apartamento::class);
    }

    public function hospede()
    {
        return $this->belongsTo(Hospede::class);
    }
}
