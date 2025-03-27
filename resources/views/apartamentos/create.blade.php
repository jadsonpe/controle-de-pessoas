@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Criar Apartamento</h2>
    <form action="{{ route('apartamentos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="numero" class="form-label">Número</label>
            <input type="text" class="form-control" id="numero" name="numero" required>
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao">
        </div>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
</div>
@endsection
