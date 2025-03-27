<?php

namespace App\Http\Controllers;

use App\Models\Hospede;
use App\Models\LeituraEnergia;
use App\Models\MovimentacaoHospede;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $movimentacoes = MovimentacaoHospede::with(['hospede', 'apartamento'])
        ->orderBy('data_entrada', 'desc')
        ->get();
        $hospedesRecentes = Hospede::limit(10)->get();
        $leiturasRecentes = LeituraEnergia::limit(10)->get();

        return view('dashboard.index', compact('hospedesRecentes', 'leiturasRecentes', 'movimentacoes'));
    }

    public function relatorios()
    {
        // Aqui você pode gerar relatórios
        return view('dashboard.relatorios');
    }

    public function usuarios()
    {
        // Gerenciamento de usuários para administradores
        return view('dashboard.usuarios');
    }
}
