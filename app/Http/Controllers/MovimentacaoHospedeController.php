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
    public function index(Request $request)
    {
        $sortField = $request->get('sort', 'data_entrada');
        $sortDirection = $request->get('direction', 'desc');
    
        // Valida os campos de ordenação para prevenir SQL injection
        $validSortFields = ['data_entrada', 'data_saida', 'hospedes.nome', 'apartamentos.numero'];
        $sortField = in_array($sortField, $validSortFields) ? $sortField : 'data_entrada';
        
        // Verifica se o campo de ordenação é um relacionamento
        if (str_contains($sortField, '.')) {
            $relation = explode('.', $sortField)[0];
            $field = explode('.', $sortField)[1];
            
            $movimentacoes = MovimentacaoHospede::with(['hospede', 'apartamento'])
                ->join($relation, "{$relation}.id", '=', "movimentacao_hospedes.{$relation}_id")
                ->orderBy("{$relation}.{$field}", $sortDirection)
                ->select('movimentacao_hospedes.*')
                ->paginate(20);
        } else {
            $movimentacoes = MovimentacaoHospede::with(['hospede', 'apartamento'])
                ->orderBy($sortField, $sortDirection)
                ->paginate(20);
        }
    
        return view('movimentacoes.index', compact('movimentacoes', 'sortField', 'sortDirection'));
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

    public function store(Request $request)
    {
        logger()->info('Dados recebidos:', $request->all());
        $request->validate([
            'hospede_id' => 'required|exists:hospedes,id',
            'apartamento_id' => 'required|exists:apartamentos,id',
            'data_entrada' => 'required|date',
            'data_saida' => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && strtotime($value) <= strtotime($request->data_entrada)) {
                        $fail("A data de saída deve ser posterior à data de entrada");
                    }
                }
            ],
        ], [
            'data_saida.after' => 'A data de saída deve ser posterior à data de entrada'
        ]);

        // Cria a movimentação
        $movimentacao = MovimentacaoHospede::create($request->all());

        // Se tem data de saída, atualiza o hóspede
        if ($request->filled('data_saida')) {
            Hospede::where('id', $request->hospede_id)
                ->update(['data_saida' => $request->data_saida]);
        }

        return redirect()->route('movimentacoes.index')
            ->with('success', 'Movimentação registrada com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hospede_id' => 'required|exists:hospedes,id',
            'apartamento_id' => 'required|exists:apartamentos,id',
            'data_entrada' => 'required|date',
            'data_saida' => 'nullable|date|after_or_equal:data_entrada',
        ]);

        $movimentacao = MovimentacaoHospede::findOrFail($id);
        $movimentacao->update($request->all());

        // Atualiza o hóspede
        if ($request->filled('data_saida')) {
            Hospede::where('id', $request->hospede_id)
                ->update(['data_saida' => $request->data_saida]);
        } else {
            // Se a data de saída foi removida
            Hospede::where('id', $request->hospede_id)
                ->update(['data_saida' => null]);
        }

        return redirect()->route('movimentacoes.index')
            ->with('success', 'Movimentação atualizada com sucesso!');
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
