@extends('layouts.app')

@section('content')
<div class="container" data-aos="fade-up">
    <div class="section-title">
        <h2>Dashboard</h2>
        <p>Visão geral do sistema</p>
    </div>

    <!-- Mensagens de Feedback -->
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

    <div class="row">
        <!-- Hóspedes Recentes -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Hóspedes Recentes</h5>
                    <a href="{{ route('hospedes.create') }}" class="btn btn-sm btn-light">
                        <i class="bi bi-plus-circle"></i> Novo
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Apto</th>
                                    <th>Celular</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hospedesRecentes as $hospede)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $hospede->nome }}</td>
                                        <td>{{ $hospede->apartamento->numero ?? 'N/A' }}</td>
                                        <td>{{ $hospede->celular }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Movimentações Recentes -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Movimentações Recentes</h5>
                    <a href="{{ route('movimentacoes.create') }}" class="btn btn-sm btn-light">
                        <i class="bi bi-plus-circle"></i> Nova
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Hóspede</th>
                                    <th>Apto</th>
                                    <th>Entrada</th>
                                    <th>Saída</th>
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
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leituras de Energia -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Leituras de Energia Recentes</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($leiturasRecentes as $leitura)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong>Apto {{ $leitura->apartamento->numero ?? 'N/A' }}</strong>
                                    {{-- <span class="text-muted">{{ $leitura->created_at->format('d/m/Y') }}</span> --}}
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <span>Entrada: {{ $leitura->leitura_entrada }} kWh</span>
                                    <span>Saída: {{ $leitura->leitura_saida }} kWh</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Adicione isso após o fechamento da div row existente -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Status dos Apartamentos</h5>
                        <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#disponibilidadeModal">
                            <i class="bi bi-calendar-check"></i> Verificar Disponibilidade
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($apartamentos as $apt)
                                @php
                                    $ocupado = $apartamentosOcupados->contains($apt->id);
                                @endphp
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100 border-{{ $ocupado ? 'danger' : 'success' }}">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Apto #{{ $apt->numero }}</h5>
                                            <p class="card-text small">{{ $apt->descricao }}</p>
                                            <span class="badge bg-{{ $ocupado ? 'danger' : 'success' }}">
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

        <!-- Modal para verificação de disponibilidade -->
        <div class="modal fade" id="disponibilidadeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Verificar Disponibilidade</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <button type="submit" class="btn btn-primary">Verificar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection