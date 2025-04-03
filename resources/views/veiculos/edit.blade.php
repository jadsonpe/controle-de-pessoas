@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Veículo</h2>

    <form action="{{ route('veiculos.update', $veiculo->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="hospede_id" class="form-label">Hóspede</label>
            <select name="hospede_id" id="hospede_id" class="form-control">
                <option value="">Selecione um hóspede</option>
                @foreach($hospedes as $hospede)
                    <option value="{{ $hospede->id }}" {{ $veiculo->hospede_id == $hospede->id ? 'selected' : '' }}>
                        {{ $hospede->id . ' - '. $hospede->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="veiculo" class="form-label">Veiculo</label>
            <input type="text" name="veiculo" id="veiculo" class="form-control" value="{{ $veiculo->veiculo }}" required>
        </div>

        <div class="mb-3">
            <label for="placa" class="form-label">Placa</label>
            <input type="text" name="placa" id="placa" class="form-control" value="{{ $veiculo->placa }}" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar Alterações</button>
        <a href="{{ route('veiculos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
