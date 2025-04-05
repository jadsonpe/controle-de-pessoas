@extends('layouts.app')

@section('content')
<div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Leituras de Energia</h1>
        <a href="{{ route('leituras-energia.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nova Leitura
        </a>
    </div>

    @include('partials.alerts')

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <!-- Tabela para desktop -->
                <table class="table d-none d-md-table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Apartamento</th>
                            <th>Hóspede Atual</th>
                            <th class="text-end">Entrada (kWh)</th>
                            <th class="text-end">Saída (kWh)</th>
                            <th class="text-end">Consumo</th>
                            <th>Data</th>
                            <th width="120">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leituras as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>Apto {{ $item['apartamento']->numero }}</td>
                            <td>
                                @if($item['hospede'])
                                    {{ $item['hospede']->nome }}
                                @else
                                    <span class="text-muted">Nenhum</span>
                                @endif
                            </td>
                            <td class="text-end">{{ $item['leitura'] ? number_format($item['leitura']->leitura_entrada, 0, ',', '.') : '0' }}</td>
                            <td class="text-end">{{ $item['leitura'] ? number_format($item['leitura']->leitura_saida ?? '0', 0, ',', '.') : '0' }}</td>
                            <td class="text-end fw-bold">
                                {{ $item['leitura'] ? number_format($item['leitura']->leitura_saida - $item['leitura']->leitura_entrada, 0, ',', '.') : '0' }} kWh                            </td>
                            <td>
                                @if($item['leitura'])
                                    {{ \Carbon\Carbon::parse($item['leitura']->data_leitura)->format('d/m/Y') }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    @if($item['leitura'])
                                    <form action="{{ route('leituras-energia.destroy', $item['leitura']->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir esta leitura?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">Nenhum apartamento com leitura cadastrada</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Cards para mobile -->
                <div class="d-md-none">
                    @forelse($leituras as $index => $item)
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="card-title mb-0">#{{ $index + 1 }} - Apto {{ $item['apartamento']->numero }}</h5>
                                    <small class="text-muted">
                                        @if($item['hospede'])
                                            {{ $item['hospede']->nome }}
                                        @else
                                            Nenhum hóspede
                                        @endif
                                    </small>
                                </div>
                                @if($item['leitura'])
                                <form action="{{ route('leituras-energia.destroy', $item['leitura']->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir esta leitura?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                            
                            <div class="row g-2">
                                <div class="col-4">
                                    <small class="text-muted">Entrada:</small>
                                    <p class="mb-0 text-end">{{ $item['leitura'] ? number_format($item['leitura']->leitura_entrada, 0, ',', '.') : '0' }} kWh</p>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted">Saída:</small>
                                    <p class="mb-0 text-end">
                                        {{ $item['leitura'] ? number_format($item['leitura']->leitura_saida ?? '0', 0, ',', '.') : '0' }} kWh
                                    </p>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted">Consumo:</small>
                                    <p class="mb-0 text-end fw-bold">
                                        {{ number_format($item['consumo'], 0, ',', '.') }} kWh
                                    </p>
                                </div>
                                <div class="col-12">
                                    <small class="text-muted">Data:</small>
                                    <p class="mb-0">
                                        @if($item['leitura'])
                                            {{ \Carbon\Carbon::parse($item['leitura']->data_leitura)->format('d/m/Y') }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body text-center py-4">
                            <div class="text-muted">Nenhum apartamento com leitura cadastrada</div>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table th {
        white-space: nowrap;
        position: sticky;
        top: 0;
        background: white;
    }
    .table td {
        vertical-align: middle;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
    .table-responsive {
        max-height: calc(100vh - 250px);
        overflow-y: auto;
    }
    .card {
        border-radius: 8px;
    }
    
    @media (max-width: 767.98px) {
        .card-title {
            font-size: 1rem;
        }
        .table-responsive {
            max-height: none;
        }
    }
</style>
@endsection