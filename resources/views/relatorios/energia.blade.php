@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Relatório de Consumo de Energia</h2>
            <div class="no-print">
                <button onclick="window.print()" class="btn btn-light mr-2">
                    <i class="fas fa-print"></i> Imprimir
                </button>
            </div>
        </div>

        <div class="card-body">
            {{-- Filtros --}}
            <form method="GET" class="row g-3 mb-4 no-print">
                <div class="col-md-3">
                    <label for="data_inicio" class="form-label">Data Início</label>
                    <input type="date" class="form-control" id="data_inicio" name="data_inicio" 
                           value="{{ request('data_inicio') }}">
                </div>
                <div class="col-md-3">
                    <label for="data_fim" class="form-label">Data Fim</label>
                    <input type="date" class="form-control" id="data_fim" name="data_fim" 
                           value="{{ request('data_fim') }}">
                </div>
                <div class="col-md-4">
                    <label for="apartamento" class="form-label">Apartamento</label>
                    <select class="form-select" id="apartamento" name="apartamento">
                        <option value="">Todos</option>
                        @foreach($apartamentos as $apto)
                            <option value="{{ $apto->id }}" 
                                {{ request('apartamento') == $apto->id ? 'selected' : '' }}>
                                Apartamento {{ $apto->numero }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                </div>
            </form>

            @if($dados->isEmpty())
                <div class="alert alert-info">
                    Nenhuma leitura de energia encontrada para os filtros selecionados.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th class="align-middle">Apartamento</th>
                                <th class="align-middle">Leitura Inicial (kWh)</th>
                                <th class="align-middle">Leitura Final (kWh)</th>
                                <th class="align-middle">Consumo (kWh)</th>
                                <th class="align-middle">Período</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dados as $item)
                                <tr>
                                    <td class="align-middle">
                                        <span class="badge bg-primary">
                                            {{ $item->apartamento->numero ?? '---' }}
                                        </span>
                                    </td>
                                    <td class="align-middle">{{ number_format($item->leitura_entrada, 0, ',', '.') }}</td>
                                    <td class="align-middle">{{ number_format($item->leitura_saida, 0, ',', '.') }}</td>
                                    <td class="align-middle fw-bold">
                                        {{ number_format($item->leitura_saida - $item->leitura_entrada, 0, ',', '.') }}
                                    </td>
                                    <td class="align-middle">
                                        
                                        @if(!empty($item->created_at))
                                      
                                            {{ \Carbon\Carbon::parse($item->created_at) }}
                                            @if(!empty($item->updated_at) && $item->created_at != $item->updated_at)
                                                <br><small>até {{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y') }}</small>
                                            @endif
                                        @else
                                            N/D
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 no-print">
                    <div class="alert alert-secondary">
                        <strong>Total de registros:</strong> {{ $dados->count() }} |
                        <strong>Consumo total:</strong> {{ number_format($dados->sum(function($item) {
                            return $item->leitura_saida - $item->leitura_entrada;
                        }), 0, ',', '.') }} kWh
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .table {
            font-size: 11px;
            width: 100% !important;
        }
        .badge {
            border: 1px solid #ccc;
            background-color: transparent !important;
            color: #000 !important;
        }
        h2 {
            font-size: 1.3rem;
            margin-top: 0;
        }
        @page {
            size: auto;
            margin: 5mm;
        }
    }
    
    .badge {
        min-width: 60px;
    }
    .table th {
        background-color: #f8f9fa;
        white-space: nowrap;
    }
</style>
@endsection