<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovimentacaoHospede extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'movimentacoes_hospedes';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'hospede_id',
        'apartamento_id',
        'data_entrada',
        'data_saida',
        'observacoes',
    ];

    public function hospede()
    {
        return $this->belongsTo(Hospede::class);
    }

    public function apartamento()
    {
        return $this->belongsTo(Apartamento::class);
    }

    // No modelo MovimentacaoHospede.php
    protected static function booted()
    {
        static::updated(function ($movimentacao) {
            if ($movimentacao->wasChanged('data_saida')) {
                $hospede = $movimentacao->hospede;
                $hospede->data_saida = $movimentacao->data_saida;
                $hospede->save();
            }
        });
    }
}
