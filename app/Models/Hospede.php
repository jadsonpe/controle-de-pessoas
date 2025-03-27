<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospede extends Model
{
    use HasFactory;

    protected $fillable = [
        'apartamento_id',
        'nome',
        'endereco_residencial',
        'cidade',
        'estado',
        'telefone',
        'celular',
        'email',
        'doc_identidade',
        'org_expedidor',
        'passaporte',
        'cpf',
        'idade',
        'estado_civil',
        'profissao',
        'empresa',
        'endereco_comercial',
        'cidade_comercial',
        'estado_comercial',
        'telefone_comercial',
        'data_entrada',
        'data_saida',
        'foto',
    ];

    // Relacionamento com apartamento
    public function apartamento()
    {
        return $this->belongsTo(Apartamento::class);
    }

    // Relacionamento com veículos
    public function veiculos()
    {
        return $this->hasMany(Veiculo::class);
    }

    // Relacionamento com acompanhantes
    public function acompanhantes()
    {
        return $this->hasMany(Acompanhante::class);
    }

    // Registrar um hóspede com seus acompanhantes e veículos
    public static function cadastrarComRelacionados($data, $veiculos, $acompanhantes)
    {
        // Cadastrar o hóspede
        $hospede = self::create($data);

        // Cadastrar os veículos
        foreach ($veiculos as $veiculoData) {
            $hospede->veiculos()->create($veiculoData);
        }

        // Cadastrar os acompanhantes
        foreach ($acompanhantes as $acompanhanteData) {
            $hospede->acompanhantes()->create($acompanhanteData);
        }

        return $hospede;
    }
}
