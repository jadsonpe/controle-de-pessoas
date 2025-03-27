@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Apartamentos</h2>
    <a href="{{ route('apartamentos.create') }}" class="btn btn-primary">Novo Apartamento</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Numero</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($apartamentos as $apartamento)
                <tr>
                    <td>{{ $apartamento->numero }}</td>
                    <td>{{ $apartamento->descricao }}</td>
                    <td>
                        <a href="{{ route('apartamentos.edit', $apartamento->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('apartamentos.destroy', $apartamento->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
