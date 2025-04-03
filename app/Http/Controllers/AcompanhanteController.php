<?php

namespace App\Http\Controllers;

use App\Models\Acompanhante;
use App\Models\Hospede;
use Illuminate\Http\Request;

class AcompanhanteController extends Controller
{
    public function index()
    {
        $acompanhantes = Acompanhante::with('hospede')->paginate(10);
        return view('acompanhantes.index', compact('acompanhantes'));
    }

    public function create()
    {
        $hospedes = Hospede::all();
        return view('acompanhantes.create', compact('hospedes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hospede_id' => 'required|exists:hospedes,id',
            'nome' => 'required|string|max:255',
        ]);

        Acompanhante::create($request->all());

        return redirect()->route('acompanhantes.index')->with('success', 'Acompanhante cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $acompanhante = Acompanhante::findOrFail($id);
        $hospedes = Hospede::all();
        return view('acompanhantes.edit', compact('acompanhante', 'hospedes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hospede_id' => 'required|exists:hospedes,id',
            'nome' => 'required|string|max:255',
        ]);

        $acompanhante = Acompanhante::findOrFail($id);
        $acompanhante->update($request->all());

        return redirect()->route('acompanhantes.index')->with('success', 'Acompanhante atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $acompanhante = Acompanhante::findOrFail($id);
        $acompanhante->delete();

        return redirect()->route('acompanhantes.index')->with('success', 'Acompanhante removido com sucesso!');
    }
}
