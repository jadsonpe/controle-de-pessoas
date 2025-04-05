@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" data-aos="fade-up">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header">
                <h2 class="fw-bold text-primary">Dashboard</h2>
                <p class="text-muted mb-0">Visão geral do sistema</p>
            </div>
        </div>
    </div>

    <!-- Feedback Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Content -->
    <div class="row">
        <!-- Recent Guests -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-people-fill me-2"></i>Hóspedes Recentes
                    </h5>
                    <div>
                        <a href="{{ route('hospedes.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Novo
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">#</th>
                                    <th>Nome</th>
                                    <th>Apto</th>
                                    <th class="pe-4">Celular</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hospedesRecentes as $hospede)
                                    <tr>
                                        <td class="ps-4">{{ $loop->iteration }}</td>
                                        <td>{{ $hospede->nome }}</td>
                                        <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                                {{ $hospede->apartamento->numero ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="pe-4">{{ $hospede->celular }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Movements -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-calendar-event-fill me-2"></i>Movimentações Recentes
                    </h5>
                    <a href="{{ route('movimentacoes.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Nova
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Hóspede</th>
                                    <th>Apto</th>
                                    <th>Entrada</th>
                                    <th class="pe-4">Saída</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($movimentacoes as $movimentacao)
                                    <tr>
                                        <td class="ps-4">{{ $movimentacao->hospede->nome }}</td>
                                        <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                                {{ $movimentacao->apartamento->numero ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>{{ date('d/m/Y H:i', strtotime($movimentacao->data_entrada)) }}</td>
                                        <td class="pe-4">
                                            @if($movimentacao->data_saida)
                                                {{ date('d/m/Y H:i', strtotime($movimentacao->data_saida)) }}
                                            @else
                                                <span class="badge bg-warning text-dark">Ativo</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="row">
        <!-- Energy Readings -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-lightning-charge-fill me-2"></i>Leituras de Energia Recentes
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($leiturasRecentes as $leitura)
                            <div class="list-group-item border-0 px-0 py-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h6 class="mb-0 fw-bold" style="color: #0d6efd">Apto {{ $leitura->apartamento->numero ?? 'N/A' }}</h6>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-clock-history me-1"></i>
                                        Leitura em: {{ $leitura->updated_at ? $leitura->updated_at->format('d/m/Y H:i') : 'Data não disponível' }}
                                    </small>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <div class="d-flex flex-column">
                                            <small class="text-muted mb-1">
                                                <i class="bi bi-arrow-down-circle me-1"></i>Entrada
                                            </small>
                                            <div class="p-2 bg-light rounded">
                                                <span class="fw-bold text-dark">{{ number_format($leitura->leitura_entrada, 0, ',', '.') }} kWh</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex flex-column">
                                            <small class="text-muted mb-1">
                                                <i class="bi bi-arrow-up-circle me-1"></i>Saída
                                            </small>
                                            <div class="p-2 bg-light rounded">
                                                <span class="fw-bold text-dark">{{ number_format($leitura->leitura_saida, 0, ',', '.') }} kWh</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Apartment Status -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-house-fill me-2"></i>Status dos Apartamentos
                    </h5>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#disponibilidadeModal">
                        <i class="bi bi-calendar-check me-1"></i> Verificar
                    </button>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($apartamentos as $apt)
                            @php
                                $ocupado = $apartamentosOcupados->contains($apt->id);
                            @endphp
                            <div class="col-6 col-md-4 col-lg-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body text-center p-3">
                                        <div class="mb-2">
                                            <i class="bi bi-house{{ $ocupado ? '-lock' : '' }}-fill fs-4 text-{{ $ocupado ? 'danger' : 'success' }}"></i>
                                        </div>
                                        <h6 class="mb-1" style="color: black">Apto #{{ $apt->numero }}</h6>
                                        <span class="badge bg-{{ $ocupado ? 'danger' : 'success' }}-subtle text-{{ $ocupado ? 'danger' : 'success' }}">
                                            {{ $ocupado ? 'Ocupado' : 'Disponível' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Availability Modal -->
<div class="modal fade" id="disponibilidadeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-calendar-check me-2"></i>Verificar Disponibilidade
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('disponibilidade.verificar') }}" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="data_entrada" class="form-label">Data de Entrada</label>
                        <input type="date" class="form-control" name="data_entrada" required min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="mb-3">
                        <label for="data_saida" class="form-label">Data de Saída</label>
                        <input type="date" class="form-control" name="data_saida" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Verificar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>

    .card {
        border-radius: 10px;
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .page-header {
        padding: 15px 0;
        border-bottom: 1px solid #eee;
    }
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    /* Versão reforçada */
    div.list-group-item div.row div.col-6 h6.mb-0 {
        color: #000 !important;
        min-height: 24px;
    }
    
    div.list-group-item div.row div.col-6 h6.mb-0:empty::before {
        content: "0 kWh";
        display: inline-block;
    }

</style>
@endpush