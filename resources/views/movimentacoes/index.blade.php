@extends('layouts.app')

@section('content')
<div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row display-flex justify-content-center">
        <h2>Movimentações de Hóspedes</h2>

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

        <div class="col-4 text-left">
            <a href="{{ route('movimentacoes.create') }}" class="btn btn-success mb-3">
                <i class="fa fa-plus"></i> Nova Movimentação
            </a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Hóspede</th>
                    <th>Apartamento</th>
                    <th>Entrada</th>
                    <th>Saída</th>
                    <th>Ações</th> <!-- Nova coluna para ações -->
                </tr>
            </thead>
            <tbody>
                @foreach($movimentacoes as $movimentacao)
                    <tr>
                        <td>{{ $movimentacao->hospede->nome }}</td>
                        <td>{{ $movimentacao->apartamento->numero ?? 'N/A' }}</td>
                        <td>{{ date('d/m/Y H:i', strtotime($movimentacao->data_entrada)) }}</td>
                        <td>
                            @if($movimentacao->data_saida)
                                {{ date('d/m/Y H:i', strtotime($movimentacao->data_saida)) }}
                            @else
                                <span class="text-danger">Ainda hospedado</span>
                            @endif
                        </td>
                        <td>
                            <!-- Botões de Ação -->
                            <a href="{{ route('movimentacoes.edit', $movimentacao->id) }}" class="btn btn-warning btn-sm">
                                <i class="fa fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('movimentacoes.destroy', $movimentacao->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i> Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
