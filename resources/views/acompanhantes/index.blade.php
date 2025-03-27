@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista de Acompanhantes</h2>
    <a href="{{ route('acompanhantes.create') }}" class="btn btn-primary">Adicionar Acompanhante</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Hóspede</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($acompanhantes as $acompanhante)
                <tr>
                    <td>{{ $acompanhante->id }}</td>
                    <td>{{ $acompanhante->nome }}</td>
                    <td>{{ $acompanhante->hospede->nome ?? 'Não associado' }}</td>
                    <td>
                        <a href="{{ route('acompanhantes.edit', $acompanhante->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('acompanhantes.destroy', $acompanhante->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
