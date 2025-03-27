@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Apartamento</h2>
    <form action="{{ route('apartamentos.update', $apartamento->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="numero" class="form-label">Número</label>
            <input type="text" class="form-control" id="numero" name="numero" value="{{ $apartamento->numero }}" required>
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <input type="text" class="form-control" id="descricao" name="descricao" value="{{ $apartamento->descricao }}">
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>
