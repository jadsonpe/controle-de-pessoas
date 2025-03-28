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
        $ultimasLeiturasIds = LeituraEnergia::select(DB::raw('MAX(leituras_energia.id) as id'))
            ->groupBy('apartamento_id')
            ->pluck('id');
    
        $leiturasEnergia = LeituraEnergia::with([
                'apartamento', 
                'apartamento.hospedeAtivo',
                'hospede'
            ])
            ->whereIn('leituras_energia.id', $ultimasLeiturasIds)
            ->join('apartamentos', 'leituras_energia.apartamento_id', '=', 'apartamentos.id')
            ->orderByRaw('CAST(apartamentos.numero AS UNSIGNED) ASC') // Ordenação numérica correta
            ->select('leituras_energia.*')
            ->paginate(15);
    
        return view('leituras_energia.index', compact('leiturasEnergia'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'apartamento_id' => 'required|exists:apartamentos,id',
            'leitura_atual' => 'required|numeric|min:0',
            'data_leitura' => 'required|date'
        ]);
    
        $apartamento = Apartamento::with(['hospedeAtivo'])->find($request->apartamento_id);
        $ultimaLeitura = $apartamento->leiturasEnergia()->latest()->first();
    
        $leitura = new LeituraEnergia();
        $leitura->apartamento_id = $request->apartamento_id;
        $leitura->leitura_anterior = $ultimaLeitura ? $ultimaLeitura->leitura_atual : 0;
        $leitura->leitura_atual = $request->leitura_atual;
        $leitura->consumo = $request->leitura_atual - $leitura->leitura_anterior;
        $leitura->data_leitura = $request->data_leitura;
        
        // Associa o hóspede ativo se existir
        if($apartamento->hospedeAtivo) {
            $leitura->hospede_id = $apartamento->hospedeAtivo->id;
        }
        
        $leitura->save();
    
        return redirect()->route('leituras-energia.index')
            ->with('success', 'Leitura registrada com sucesso!');
    }
    public function create()
    {
        $apartamentos = Apartamento::with(['hospedeAtivo'])
            ->orderByRaw('CAST(numero AS UNSIGNED)')
            ->get();
    
        return view('leituras_energia.create', compact('apartamentos'));
    }
    public function ultimaLeitura(Apartamento $apartamento)
    {
        $ultimaLeitura = $apartamento->leiturasEnergia()
            ->orderBy('data_leitura', 'desc')
            ->first();
    
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
    //     $leitura->leitura_anterior = $ultimaLeitura ? $ultimaLeitura->leitura_atual : 0;
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