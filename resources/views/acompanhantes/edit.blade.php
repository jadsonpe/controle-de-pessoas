@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Acompanhante</h2>
    <form action="{{ route('acompanhantes.update', $acompanhante->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="hospede_id">Hóspede</label>
            <select name="hospede_id" class="form-control" required>
                @foreach($hospedes as $hospede)
                    <option value="{{ $hospede->id }}" {{ $acompanhante->hospede_id == $hospede->id ? 'selected' : '' }}>
                        {{ $hospede->id }} - {{ $hospede->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="nome">Nome do Acompanhante</label>
            <input type="text" name="nome" class="form-control" value="{{ $acompanhante->nome }}" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Atualizar</button>
    </form>
</div>
@endsection
