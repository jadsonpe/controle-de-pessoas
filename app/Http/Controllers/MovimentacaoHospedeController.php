<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospede;
use App\Models\Apartamento;
use App\Models\MovimentacaoHospede;

class MovimentacaoHospedeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Recuperar todas as movimentações com hóspede e apartamento associados
        $movimentacoes = MovimentacaoHospede::with(['hospede', 'apartamento'])->get();

        // Passar as movimentações para a view
        return view('movimentacoes.index', compact('movimentacoes'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hospedes = Hospede::with('apartamento')->get();
        $apartamentos = Apartamento::all();
        return view('movimentacoes.create', compact('hospedes', 'apartamentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hospede_id' => 'required|exists:hospedes,id',
            'apartamento_id' => 'required|exists:apartamentos,id',
            'data_entrada' => 'required|date',
            'data_saida' => 'nullable|date|after:data_entrada',
        ]);
    
        MovimentacaoHospede::create($request->all());
    
        return redirect()->route('movimentacoes.index')->with('success', 'Movimentação registrada com sucesso!');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $hospedes = Hospede::all();
        $apartamentos = Apartamento::all();
        $movimentacao = MovimentacaoHospede::findOrFail($id);
        // Passar para a view os dados necessários
        return view('movimentacoes.edit', compact('movimentacao', 'hospedes', 'apartamentos'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar os dados
        $request->validate([
            'hospede_id' => 'required|exists:hospedes,id',
            'apartamento_id' => 'required|exists:apartamentos,id',
            'data_entrada' => 'required|date',
            'data_saida' => 'nullable|date|after_or_equal:data_entrada',
        ]);
    
        // Obter a movimentação
        $movimentacao = MovimentacaoHospede::findOrFail($id);
    
        // Atualizar a movimentação
        $movimentacao->update([
            'hospede_id' => $request->hospede_id,
            'apartamento_id' => $request->apartamento_id,
            'data_entrada' => $request->data_entrada,
            'data_saida' => $request->data_saida,
        ]);
    
        // Redirecionar com mensagem de sucesso
        return redirect()->route('movimentacoes.index')->with('success', 'Movimentação atualizada com sucesso!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Encontre a movimentação pelo ID
        $movimentacao = MovimentacaoHospede::find($id);
    
        // Verifique se a movimentação existe
        if (!$movimentacao) {
            return redirect()->route('movimentacoes.index')->with('error', 'Movimentação não encontrada!');
        }
    
        // Obtenha o nome do apartamento
        $apartamentoNome = $movimentacao->apartamento->numero ?? 'N/A';
    
        // Realize o soft delete (marque como excluído)
        $movimentacao->delete();
    
        // Redirecione com uma mensagem de sucesso incluindo o nome do apartamento
        return redirect()->route('movimentacoes.index')->with('success', "Movimentação do apartamento {$apartamentoNome} excluída com sucesso!");
    }
    
    
}
