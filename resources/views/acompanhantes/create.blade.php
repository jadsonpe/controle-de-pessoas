@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Adicionar Acompanhante</h2>
    <form action="{{ route('acompanhantes.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="hospede_id">Hóspede</label>
            <select name="hospede_id" class="form-control" required>
                <option value="">Selecione um hóspede</option>
                @foreach($hospedes as $hospede)
                    <option value="{{ $hospede->id }}">
                        {{ $hospede->id }} - {{ $hospede->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="nome">Nome do Acompanhante</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success mt-3">Salvar</button>
    </form>
</div>
@endsection
    