@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Leituras de Energia</h1>
        <a href="{{ route('leituras-energia.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nova Leitura
        </a>
    </div>

    @include('partials.alerts')

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Apartamento</th>
                        <th>Hóspede Atual</th>
                        <th class="text-end">Anterior (kWh)</th>
                        <th class="text-end">Atual (kWh)</th>
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
                        <td class="text-end">{{ $item['leitura'] ? $item['leitura']->leitura_entrada : '0' }}</td>
                        <td class="text-end">{{ $item['leitura'] ? $item['leitura']->leitura_saida : '0' }}</td>
                        <td class="text-end fw-bold">
                            {{ $item['leitura'] ? ($item['leitura']->leitura_saida - $item['leitura']->leitura_entrada) : '0' }}
                        </td>
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
</style>
@endsection