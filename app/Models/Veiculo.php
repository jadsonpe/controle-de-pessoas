<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospede_id',
        'carro',
        'cor',
        'placa',
    ];

    // Relacionamento com hóspede
    public function hospede()
    {
        return $this->belongsTo(Hospede::class);
    }
}
