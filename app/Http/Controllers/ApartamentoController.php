<?php

namespace App\Http\Controllers;

use App\Models\Apartamento;
use Illuminate\Http\Request;

class ApartamentoController extends Controller
{
    public function index()
    {
        $apartamentos = Apartamento::paginate(10);
        return view('apartamentos.index', compact('apartamentos'));
    }

    public function create()
    {
        return view('apartamentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|unique:apartamentos,numero',
        ]);

        Apartamento::create($request->all());
        return redirect()->route('apartamentos.index');
    }

    public function edit(Apartamento $apartamento)
    {
        return view('apartamentos.edit', compact('apartamento'));
    }

    public function update(Request $request, Apartamento $apartamento)
    {
        $request->validate([
            'numero' => 'required|unique:apartamentos,numero,' . $apartamento->id,
        ]);

        $apartamento->update($request->all());
        return redirect()->route('apartamentos.index');
    }

    public function destroy(Apartamento $apartamento)
    {
        $apartamento->delete();
        return redirect()->route('apartamentos.index');
    }
}
