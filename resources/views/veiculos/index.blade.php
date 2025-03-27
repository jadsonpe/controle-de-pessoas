@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Veículos</h2>
        <!-- Mensagens de Sucesso ou Erro -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    <a href="{{ route('veiculos.create') }}" class="btn btn-primary">Novo Veículo</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>#</th> <!-- Número de Ordem -->
                <th>Hóspede</th>
                <th>Carro</th>
                <th>Placa</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($veiculos as $index => $veiculo)
                <tr>
                    <td>{{ $index + 1 }}</td> <!-- Exibe o número da linha -->
                    <td>
                        @php
                            $hospede = $hospedes->where('id', $veiculo->hospede_id)->first();
                        @endphp
                        {{ $hospede->nome ?? 'Não informado' }}
                    </td>
                    <td>{{ $veiculo->carro }}</td>
                    <td>{{ $veiculo->placa }}</td>
                    <td>
                        <a href="{{ route('veiculos.edit', $veiculo->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('veiculos.destroy', $veiculo->id) }}" method="POST" class="d-inline">
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
