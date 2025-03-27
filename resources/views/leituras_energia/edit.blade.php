@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Leitura de Energia - Apartamento {{ $leitura->apartamento->numero }}</h1>
    <form action="{{ route('leituras_energia.update', $leitura->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="leitura_entrada">Leitura de Entrada (kWh)</label>
            <input type="number" class="form-control" id="leitura_entrada" name="leitura_entrada" value="{{ $leitura->leitura_entrada }}" required>
        </div>
        <div class="form-group">
            <label for="leitura_saida">Leitura de Saída (kWh)</label>
            <input type="number" class="form-control" id="leitura_saida" name="leitura_saida" value="{{ $leitura->leitura_saida }}">
        </div>
        <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
    </form>
</div>
@endsection
