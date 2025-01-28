<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Condominio;

class CondominioController extends Controller
{
    public function showCondominioDashboard($id)
    {
        // Lógica para carregar o dashboard do condomínio
        return view('condominios.dashboard', compact('id'));
    }

    public function create()
    {
        // Mostrar a página de cadastro de condomínio
        return view('condominios.create');
    }

    public function store(Request $request)
    {
        // Lógica para salvar o novo condomínio
        $condominio = new Condominio();
        $condominio->nome = $request->nome;
        $condominio->save();
        
        return redirect()->route('home')->with('success', 'Condomínio cadastrado com sucesso!');
    }
}
