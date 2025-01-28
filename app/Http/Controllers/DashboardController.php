<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index($condominio_id)
    {
        // Lógica para exibir o painel do funcionário no condomínio
        return view('condominios.dashboard', ['condominio_id' => $condominio_id]);
    }
}
