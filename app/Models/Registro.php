<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;

    protected $fillable = ['pessoa_id', 'status', 'hora_registro'];

    // Relacionamento com a pessoa
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }
}
