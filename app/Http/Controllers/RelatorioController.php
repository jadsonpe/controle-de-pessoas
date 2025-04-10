<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospede;
use App\Models\MovimentacaoHospede;
use App\Models\LeituraEnergia;
use App\Models\Apartamento;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;  

class RelatorioController extends Controller
{
    public function index()
    {
        return view('relatorios.index');
    }

    public function hospedesPorPeriodo(Request $request)
    {
        $dataInicio = Carbon::parse($request->input('data_inicio'));
        $dataFim = Carbon::parse($request->input('data_fim'));

        $hospedes = Hospede::whereBetween('data_entrada', [$dataInicio, $dataFim])
            ->orderBy('data_entrada')
            ->get();

            return view('relatorios.hospedes', [
                'hospedes' => $hospedes,
                'dataInicio' => $dataInicio,    
                'dataFim' => $dataFim
            ]);
    }

    public function movimentacoes(Request $request)
    {
        $dataInicio = Carbon::parse($request->input('data_inicio'));
        $dataFim = Carbon::parse($request->input('data_fim'));

        $movimentacoes = MovimentacaoHospede::whereBetween('data_entrada', [$dataInicio, $dataFim])
            ->orderBy('data_entrada')
            ->get();

        return view('relatorios.movimentacoes', compact('movimentacoes', 'dataInicio', 'dataFim'));
    }

    public function energia(Request $request)
    {
        // Ordenação natural dos apartamentos (considerando números e letras)
        $apartamentos = Apartamento::query()
            ->get()
            ->sortBy(function($apto) {
                preg_match('/(\d+)(\D*)/', $apto->numero, $matches);
                return [
                    (int)($matches[1] ?? 0),  // Parte numérica
                    $matches[2] ?? ''          // Parte alfabética
                ];
            });
    
        // Query principal com filtros
        $query = LeituraEnergia::with(['apartamento'])
            ->whereNotNull('leitura_saida')
            ->join('apartamentos', 'leituras_energia.apartamento_id', '=', 'apartamentos.id')
            ->select('leituras_energia.*');  // Garante que só campos da leitura são selecionados
    
        // Filtros
        $this->aplicarFiltros($query, $request);
    
        // Ordenação e paginação (se necessário)
        $dados = $query->get()
            ->sortBy(function($leitura) {
                preg_match('/(\d+)(\D*)/', $leitura->apartamento->numero, $matches);
                return [
                    (int)($matches[1] ?? 0),
                    $matches[2] ?? ''
                ];
            });
    
        return view('relatorios.energia', [
            'dados' => $dados,
            'apartamentos' => $apartamentos
        ]);
    }
    
    // Método auxiliar para aplicar filtros
    protected function aplicarFiltros($query, Request $request)
    {
        // Filtro por data de leitura
        if ($request->filled('data_inicio')) {
            $query->whereDate('leituras_energia.created_at', '>=', $request->data_inicio);
        }
    
        if ($request->filled('data_fim')) {
            $query->whereDate('leituras_energia.created_at', '<=', $request->data_fim);
        }
    
        // Filtro por apartamento
        if ($request->filled('apartamento')) {
            $query->where('apartamento_id', $request->apartamento);
        }
    
        // Filtro adicional para garantir datas não nulas
        $query->whereNotNull('leituras_energia.created_at');
    }
}
