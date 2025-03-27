@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registrar Entrada/Saída de Hóspede</h2>

    <form action="{{ route('hospedes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="hospede_id" class="form-label">Hóspede</label>
            <select name="hospede_id" id="hospede_id" class="form-control" required>
                <option value="">Selecione um hóspede</option>
                @foreach($hospedes as $hospede)
                    <option value="{{ $hospede->id }}">{{ $hospede->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="acompanha_id" class="form-label">Acompanhantes</label>
            <select name="acompanha_id[]" id="acompanha_id" class="form-control" multiple>
                @foreach($acompanhantes as $acomp)
                    <option value="{{ $acomp->id }}">{{ $acomp->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="apartamento_id" class="form-label">Apartamento</label>
            <select name="apartamento_id" id="apartamento_id" class="form-control" required>
                <option value="">Selecione um apartamento</option>
                @foreach($apartamentos as $apt)
                    <option value="{{ $apt->id }}">{{ $apt->numero }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="veiculo_id" class="form-label">Veículo</label>
            <select name="veiculo_id[]" id="veiculo_id" class="form-control" multiple>
                @foreach($veiculos as $veiculo)
                    <option value="{{ $veiculo->id }}">{{ $veiculo->placa }} - {{ $veiculo->carro }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="data_entrada" class="form-label">Data de Entrada</label>
            <input type="date" name="data_entrada" id="data_entrada" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="data_saida" class="form-label">Data de Saída</label>
            <input type="date" name="data_saida" id="data_saida" class="form-control">
        </div>

        <div class="mb-3">
            <label for="leitura_entrada" class="form-label">Leitura de Energia (kWh)</label>
            <input type="number" step="0.1" name="leitura_entrada" id="leitura_entrada" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Registro</button>
    </form>
</div>
@endsection
