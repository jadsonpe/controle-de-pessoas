@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cadastrar Novo Condomínio</h2>
    <form method="POST" action="{{ route('condominio.store') }}">
        @csrf
        <div class="form-group">
            <label for="nome">Nome do Condomínio</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</div>
@endsection
