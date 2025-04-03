@extends('layouts.app')

@section('content')
<div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Movimentações de Hóspedes</h2>
        <a href="{{ route('movimentacoes.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Nova Movimentação
        </a>
    </div>

    <!-- Mensagens de Sucesso ou Erro -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <!-- Tabela para desktop -->
                <table class="table d-none d-md-table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Hóspede</th>
                            <th>Apto</th>
                            <th>Entrada</th>
                            <th>Saída</th>
                            <th width="150">Ações</th>
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
                                        <span class="badge bg-warning text-dark">Ativo</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('movimentacoes.edit', $movimentacao->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('movimentacoes.destroy', $movimentacao->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Cards para mobile -->
                <div class="d-md-none">
                    @foreach($movimentacoes as $movimentacao)
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">{{ $movimentacao->hospede->nome }}</h5>
                                    <span class="badge bg-primary">{{ $movimentacao->apartamento->numero ?? 'N/A' }}</span>
                                </div>
                                
                                <div class="row g-2 mb-2">
                                    <div class="col-6">
                                        <small class="text-muted">Entrada:</small>
                                        <p class="mb-0">{{ date('d/m/Y H:i', strtotime($movimentacao->data_entrada)) }}</p>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Saída:</small>
                                        <p class="mb-0">
                                            @if($movimentacao->data_saida)
                                                {{ date('d/m/Y H:i', strtotime($movimentacao->data_saida)) }}
                                            @else
                                                <span class="badge bg-warning text-dark">Ativo</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <a href="{{ route('movimentacoes.edit', $movimentacao->id) }}" class="btn btn-sm btn-warning flex-grow-1">
                                        <i class="bi bi-pencil me-1"></i> Editar
                                    </a>
                                    <form action="{{ route('movimentacoes.destroy', $movimentacao->id) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger w-100">
                                            <i class="bi bi-trash me-1"></i> Excluir
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Paginação - Verifica se é uma instância de paginador -->
    @if($movimentacoes instanceof \Illuminate\Pagination\LengthAwarePaginator && $movimentacoes->total() > $movimentacoes->perPage())
        <div class="mt-3 d-flex justify-content-center">
            {{ $movimentacoes->onEachSide(1)->links('pagination.custom') }}
        </div>
    @endif
</div>

<style>
    @media (max-width: 767.98px) {
        .table-responsive {
            border: none;
        }
        
        .card-title {
            font-size: 1rem;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }
        
        .pagination {
            font-size: 0.875rem;
        }
        
        .page-link {
            padding: 0.375rem 0.75rem;
        }
        
        .page-item:first-child .page-link,
        .page-item:last-child .page-link {
            font-size: 0.875rem;
        }
        
        .pagination .bi {
            font-size: 1rem !important;
        }
    }
</style>
@endsection