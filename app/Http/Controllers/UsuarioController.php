<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function cadastrar()
    {
        // Lógica para cadastrar novos usuários
        return view('usuarios.cadastrar');
    }
}

class RelatorioController extends Controller
{
    public function index()
    {
        // Lógica para gerar relatórios
        return view('relatorios.index');
    }
}
