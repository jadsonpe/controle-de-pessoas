<?php

namespace App\Http\Controllers;

use App\Models\LeituraEnergia;
use App\Models\Apartamento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class LeituraEnergiaController extends Controller
{
    public function index()
    {
        // Carrega todos os apartamentos com suas últimas leituras e hóspedes ativos
        $apartamentos = Apartamento::with(['ultimaLeitura', 'hospedeAtivo'])
            ->orderByRaw('CAST(numero AS UNSIGNED)')
            ->get();
    
        // Formata os dados para a view
        $leituras = $apartamentos->map(function($apto) {
            return [
                'apartamento' => $apto,
                'leitura' => $apto->ultimaLeitura,
                'hospede' => $apto->hospedeAtivo,
                'consumo' => $apto->ultimaLeitura ? 
                    ($apto->ultimaLeitura->leitura_atual - $apto->ultimaLeitura->leitura_anterior) : 0
            ];
        });
    
        return view('leituras_energia.index', compact('leituras'));
    }
    public function store(Request $request)
    {

        //dd($request->all());
        $request->validate([
            'apartamento_id' => 'required|exists:apartamentos,id',
            'leitura_entrada' => 'required|numeric|min:0',
            'leitura_saida' => 'required|numeric|min:0',
            'data_leitura' => 'required|date'
        ]);
    
        $apartamento = Apartamento::with(['hospedeAtivo'])->find($request->apartamento_id);
        // $ultimaLeitura = $apartamento->leiturasEnergia()->latest()->first();
    
        $leitura = new LeituraEnergia();
        $leitura->apartamento_id = $request->apartamento_id;
        $leitura->leitura_entrada = $request->leitura_entrada;
        $leitura->leitura_saida = $request->leitura_saida;
        $leitura->total_kw_h = ($leitura->leitura_saida ?? 0) - ($request->leitura_entrada ?? 0);
        $leitura->data_leitura = $request->data_leitura;
        
        // Associa o hóspede ativo se existir
        // if($apartamento->hospedeAtivo) {
        //     $leitura->hospede_id = $apartamento->hospedeAtivo->id;
        // }
        
        $leitura->save();
    
        return redirect()->route('leituras-energia.index')
            ->with('success', 'Leitura registrada com sucesso!');
    }

    public function create(Request $request)
    {
        // Carrega todos os apartamentos com hóspedes ativos e última leitura
        $apartamentos = Apartamento::with(['hospedeAtivo', 'ultimaLeitura'])
            ->orderByRaw('CAST(numero AS UNSIGNED)')
            ->get();
    
        // Se foi passado um ID de apartamento específico
        $apartamentoSelecionado = $request->input('apartamento_id');
    
        // Prepara os dados para o select2 (se estiver usando)
        $apartamentosFormatados = $apartamentos->map(function($apto) {
            return [
                'id' => $apto->id,
                'text' => 'Apto ' . $apto->numero . 
                          ($apto->hospedeAtivo ? ' - ' . $apto->hospedeAtivo->nome : '')
            ];
        });
    
        return view('leituras_energia.create', [
            'apartamentos' => $apartamentos,
            'apartamentosFormatados' => $apartamentosFormatados,
            'apartamentoSelecionado' => $apartamentoSelecionado
        ]);
    }
    public function ultimaLeitura(Apartamento $apartamento)
    {
        $ultimaLeitura = $apartamento->leiturasEnergia()
            ->orderBy('id', 'desc')
            ->first();
    //dd($ultimaLeitura->toArray());
        return response()->json([
            'leitura_saida' => $ultimaLeitura ? $ultimaLeitura->leitura_saida : null
        ]);
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'apartamento_id' => 'required|exists:apartamentos,id',
    //         'leitura_atual' => 'required|numeric|min:0',
    //         'data_leitura' => 'required|date'
    //     ]);

    //     $apartamento = Apartamento::find($request->apartamento_id);
    //     $ultimaLeitura = $apartamento->leiturasEnergia()->latest()->first();

    //     $leitura = new LeituraEnergia();
    //     $leitura->apartamento_id = $request->apartamento_id;
    //     $leitentradatura_anterior = $ultimaLeitura ? $ultimaLeitura->leitura_atual : 0;
    //     $leitura->leitura_atual = $request->leitura_atual;
    //     $leitura->consumo = $request->leitura_atual - $leitura->leitura_anterior;
    //     $leitura->data_leitura = $request->data_leitura;
    //     $leitura->save();

    //     return redirect()->route('leituras-energia.index')
    //         ->with('success', 'Leitura registrada com sucesso!');
    // }

    public function edit(LeituraEnergia $leiturasEnergium)
    {
        $apartamentos = Apartamento::all();
        return view('leituras_energia.edit', [
            'leitura' => $leiturasEnergium,
            'apartamentos' => $apartamentos
        ]);
    }

    public function update(Request $request, LeituraEnergia $leiturasEnergium)
    {
        $request->validate([
            'leitura_atual' => 'required|numeric|min:0',
            'data_leitura' => 'required|date'
        ]);

        $leiturasEnergium->update([
            'leitura_atual' => $request->leitura_atual,
            'consumo' => $request->leitura_atual - $leiturasEnergium->leitura_anterior,
            'data_leitura' => $request->data_leitura
        ]);

        return redirect()->route('leituras-energia.index')
            ->with('success', 'Leitura atualizada com sucesso!');
    }

    public function destroy(LeituraEnergia $leiturasEnergium)
    {
        $leiturasEnergium->delete();
        return redirect()->route('leituras-energia.index')
            ->with('success', 'Leitura removida com sucesso!');
    }
}