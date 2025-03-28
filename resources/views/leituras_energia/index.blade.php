@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Leituras de Energia</h1>
            <a href="{{ route('leituras-energia.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nova Leitura
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th width="50">#</th>
                        <th>Apartamento</th>
                        <th>Hóspede na Leitura</th>
                        <th>Leitura Anterior (kWh)</th>
                        <th>Leitura Atual (kWh)</th>
                        <th>Consumo (kWh)</th>
                        <th>Data da Leitura</th>
                        <th width="150">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leiturasEnergia as $leitura)
                        <tr>
                            <td>{{ ($leiturasEnergia->currentPage() - 1) * $leiturasEnergia->perPage() + $loop->iteration }}</td>
                            <td>Apto {{ $leitura->apartamento->numero }}</td>
                            <td>
                                @if($leitura->hospede)
                                    {{ $leitura->hospede->nome }}
                                    @if($leitura->apartamento->hospedeAtivo && $leitura->hospede->id != $leitura->apartamento->hospedeAtivo->id)
                                        <br><small class="text-danger">(Hóspede diferente do atual)</small>
                                    @endif
                                @elseif($leitura->apartamento->hospedeAtivo)
                                    {{ $leitura->apartamento->hospedeAtivo->nome }}
                                @else
                                    Nenhum hóspede
                                @endif
                            </td>
                            <td class="text-end">{{ number_format($leitura->leitura_anterior, 2) }}</td>
                            <td class="text-end">{{ number_format($leitura->leitura_atual, 2) }}</td>
                            <td class="text-end fw-bold">{{ number_format($leitura->consumo, 2) }}</td>
                            <td>{{ \Carbon\carbon::parse($leitura->data_leitura)->format('d/m/Y') }}</td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('leituras-energia.edit', $leitura->id) }}" 
                                   class="btn btn-sm btn-warning" 
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                
                                <form action="{{ route('leituras-energia.destroy', $leitura->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger" 
                                            title="Excluir"
                                            onclick="return confirm('Tem certeza que deseja excluir esta leitura?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">Nenhuma leitura de energia cadastrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginação Corrigida -->
        @if($leiturasEnergia->hasPages())
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    {{ $leiturasEnergia->onEachSide(1)->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        @endif
    </div>

    <style>
        .table th {
            white-space: nowrap;
        }
        .table td {
            vertical-align: middle;
        }
        .btn-sm {
            padding: 0.25rem 0.5rem;
        }
        .text-muted {
            font-size: 0.8rem;
        }
        .text-danger {
            font-size: 0.75rem;
        }
        .pagination {
            margin-bottom: 0;
        }
    </style>
@endsection