<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero', 'descricao',
    ];

    // Relacionamento com hóspedes
    public function hospedes()
    {
        return $this->hasMany(Hospede::class);
    }

    // Relacionamento com leituras de energia
    public function leiturasEnergia()
    {
        return $this->hasMany(LeituraEnergia::class);
    }
}
