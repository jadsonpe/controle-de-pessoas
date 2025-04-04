<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartamento extends Model
{
    use HasFactory;
    protected $table = 'apartamentos';
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
    public function hospedeAtivo()
    {
        return $this->hasOne(Hospede::class)
                    ->where(function($query) {
                        $query->where('data_saida', '>=', now())
                              ->orWhereNull('data_saida');
                    });
    }

    public function ultimaLeitura()
    {
        return $this->hasOne(LeituraEnergia::class)->latest('data_leitura');
    }
}
