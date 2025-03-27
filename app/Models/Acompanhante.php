<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Acompanhante extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'hospede_id',
        'nome',
        'documento',
    ];

    // Relacionamento com hóspede
    public function hospede()
    {
        return $this->belongsTo(Hospede::class);
    }
}
