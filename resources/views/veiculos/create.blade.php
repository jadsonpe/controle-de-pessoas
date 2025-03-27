@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cadastrar Veículo</h1>
    <form action="{{ route('veiculos.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="hospede_id">Hóspede</label>
            <select class="form-control" id="hospede_id" name="hospede_id" required>
                @foreach ($hospedes as $hospede)
                    <option value="{{ $hospede->id }}">{{ $hospede->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="carro">Carro</label>
            <input type="text" class="form-control" id="carro" name="carro" required>
        </div>
        <div class="form-group">
            <label for="cor">Cor</label>
            <input type="text" class="form-control" id="cor" name="cor" required>
        </div>
        <div class="form-group">
            <label for="placa">Placa</label>
            <input type="text" class="form-control" id="placa" name="placa" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Cadastrar</button>
    </form>
</div>
@endsection
