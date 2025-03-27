<?php

namespace App\Http\Controllers;

use App\Models\LeituraEnergia;
use App\Models\Apartamento;
use Illuminate\Http\Request;

class LeituraEnergiaController extends Controller
{
    public function index()
    {
        $leiturasEnergia = LeituraEnergia::all();
        return view('leituras_energia.index', compact('leiturasEnergia'));
    }

    public function create()
    {
        $apartamentos = Apartamento::all();
        return view('leituras_energia.create', compact('apartamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'apartamento_id' => 'required|exists:apartamentos,id',
            'leitura_entrada' => 'required|integer',
        ]);

        LeituraEnergia::create($request->all());
        return redirect()->route('leituras-energia.index');
    }

    public function edit(LeituraEnergia $leituraEnergia)
    {
        return view('leituras_energia.edit', compact('leituraEnergia'));
    }

    public function update(Request $request, LeituraEnergia $leituraEnergia)
    {
        $request->validate([
            'leitura_entrada' => 'required|integer',
        ]);

        $leituraEnergia->update($request->all());
        return redirect()->route('leituras-energia.index');
    }

    public function destroy(LeituraEnergia $leituraEnergia)
    {
        $leituraEnergia->delete();
        return redirect()->route('leituras-energia.index');
    }
}
