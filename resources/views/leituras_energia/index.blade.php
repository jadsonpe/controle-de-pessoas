@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Leituras de Energia</h1>
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
        <!-- Botão para adicionar uma nova leitura de energia -->
        <a href="{{ route('leituras-energia.create') }}" class="btn btn-primary mb-3">Adicionar Leitura de Energia</a>

        <!-- Tabela com as leituras de energia -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Apartamento</th>
                    <th>Hospede</th>
                    <th>Leitura de Entrada (kWh)</th>
                    <th>Leitura de Saída (kWh)</th>
                    <th>Total (kWh)</th>
                    <th>Data da Leitura</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leiturasEnergia as $leitura)
                    <tr>
                        <td>{{ $leitura->id }}</td>
                        <td>{{ $leitura->apartamento->numero }}</td>
                        <td>{{ $leitura->apartamento->numero }}</td>
                        <td>{{ $leitura->leitura_entrada }}</td>
                        <td>{{ $leitura->leitura_saida }}</td>
                        <td>{{ $leitura->total_kw_h }}</td>
                        <td>{{ $leitura->data_leitura }}</td>
                        <td>
                            <!-- Botão de edição -->
                            <a href="{{ route('leituras-energia.edit', $leitura->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            
                            <!-- Botão de exclusão -->
                            <form action="{{ route('leituras-energia.destroy', $leitura->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta leitura de energia?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginação, caso haja muitas leituras -->
        {{-- {{ $leiturasEnergia->links() }} --}}
    </div>
@endsection
