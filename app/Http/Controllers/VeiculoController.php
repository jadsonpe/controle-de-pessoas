<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Models\Hospede;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    public function index()
    {
        $veiculos = Veiculo::paginate(20);
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
            'veiculo' => 'required',
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
            'veiculo' => 'required',
            'placa' => 'required',
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
