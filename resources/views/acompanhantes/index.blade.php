@extends('layouts.app')

@section('content')
<div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Lista de Acompanhantes</h2>
        <a href="{{ route('acompanhantes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Adicionar Acompanhante
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
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
                            <th width="80">ID</th>
                            <th>Nome</th>
                            <th>Hóspede</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($acompanhantes as $acompanhante)
                            <tr>
                                <td>{{ $acompanhante->id }}</td>
                                <td>{{ $acompanhante->nome }}</td>
                                <td>{{ $acompanhante->hospede->nome ?? 'Não associado' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('acompanhantes.edit', $acompanhante->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('acompanhantes.destroy', $acompanhante->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este acompanhante?');">
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
                    @foreach ($acompanhantes as $acompanhante)
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">{{ $acompanhante->nome }}</h5>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('acompanhantes.edit', $acompanhante->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('acompanhantes.destroy', $acompanhante->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este acompanhante?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <small class="text-muted">ID:</small>
                                        <p class="mb-0">{{ $acompanhante->id }}</p>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Hóspede:</small>
                                        <p class="mb-0">{{ $acompanhante->hospede->nome ?? 'Não associado' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Paginação com setas ajustadas -->
    @if($acompanhantes instanceof \Illuminate\Pagination\LengthAwarePaginator && $acompanhantes->total() > $acompanhantes->perPage())
        <div class="mt-3 d-flex justify-content-center">
            {{ $acompanhantes->onEachSide(1)->links('pagination.custom') }}
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
    }

    /* Estilo customizado para a paginação */
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
</style>
@endsection