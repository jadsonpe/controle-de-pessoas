<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PessoaController extends Controller
{
    public function store(Request $request)
    {
        // Lógica para armazenar as informações da pessoa e acompanhantes
        // Salvar os dados da pessoa principal
        // Salvar os dados dos acompanhantes
        return redirect()->back()->with('success', 'Pessoa registrada com sucesso!');
    }
}
