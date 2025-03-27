<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Models\Hospede;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    public function index()
    {
        $veiculos = Veiculo::all();
        $hospedes = Hospede::all();
        return view('veiculos.index', compact('veiculos', 'hospedes'));
    }

    public function create()
    {
        $hospedes = Hospede::all();
        return view('veiculos.create', compact('hospedes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hospede_id' => 'required|exists:hospedes,id',
            'carro' => 'required',
            'placa' => 'required|unique:veiculos,placa',
        ]);

        Veiculo::create($request->all());
        return redirect()->route('veiculos.index');
    }

    public function edit(Veiculo $veiculo)
    {
        $hospedes = Hospede::all();
        return view('veiculos.edit', compact('veiculo', 'hospedes'));
    }

    public function update(Request $request, Veiculo $veiculo)
    {
        $request->validate([
            'carro' => 'required',
            'placa' => 'required|unique:veiculos,placa,' . $veiculo->id,
        ]);

        $veiculo->update($request->all());
        return redirect()->route('veiculos.index');
    }

    public function destroy(Veiculo $veiculo)
    {
        $veiculo->delete();
        return redirect()->route('veiculos.index');
    }
}
