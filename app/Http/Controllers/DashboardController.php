<?php

namespace App\Http\Controllers;

use App\Models\Hospede;
use App\Models\LeituraEnergia;
use App\Models\MovimentacaoHospede;
use App\Models\Apartamento;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;

class DashboardController extends BaseController
{

    public function index(Request $request)
    {
        $movimentacoes = MovimentacaoHospede::with(['hospede', 'apartamento'])
            ->orderBy('data_entrada', 'desc')
            ->get();
        
        $hospedesRecentes = Hospede::limit(10)->get();
        $leiturasRecentes = LeituraEnergia::select('*')
        ->whereIn('id', function($query) {
            $query->selectRaw('MAX(id)')
                  ->from('leituras_energia')
                  ->groupBy('apartamento_id');
        })
        ->orderBy('updated_at', 'desc')
        ->limit(10)
        ->with('apartamento')
        ->get();

        // Novos dados para disponibilidade
        $apartamentos = Apartamento::all();
        $apartamentosOcupados = MovimentacaoHospede::whereNull('data_saida')
            ->orWhere('data_saida', '>', now())
            ->pluck('apartamento_id')
            ->unique();
    
        return view('dashboard.index', compact(
            'hospedesRecentes',
            'leiturasRecentes',
            'movimentacoes',
            'apartamentos',
            'apartamentosOcupados'
        ));
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

    public function verificarDisponibilidade(Request $request)
    {
        $request->validate([
            'data_entrada' => 'required|date|after_or_equal:today',
            'data_saida' => 'required|date|after:data_entrada'
        ]);

        $apartamentosOcupados = MovimentacaoHospede::where(function($query) use ($request) {
            $query->whereNull('data_saida')
                ->orWhere('data_saida', '>', $request->data_entrada);
        })
        ->where('data_entrada', '<', $request->data_saida)
        ->pluck('apartamento_id')
        ->unique();

        $apartamentosDisponiveis = Apartamento::whereNotIn('id', $apartamentosOcupados)->get();

        return view('dashboard.disponibilidade', [
            'apartamentos' => $apartamentosDisponiveis,
            'data_entrada' => $request->data_entrada,
            'data_saida' => $request->data_saida
        ]);
    }
}
