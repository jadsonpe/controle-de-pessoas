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
    </div>
</div>
@endsection