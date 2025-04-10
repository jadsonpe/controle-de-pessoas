@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Hóspedes entre: {{ $dataInicio->format('d/m/Y') }} e {{ $dataFim->format('d/m/Y') }}</h2>
        </div>

        <div class="card-body">
            @if($hospedes->isEmpty())
                <div class="alert alert-info">
                    Nenhum hóspede encontrado no período selecionado.
                </div>
            @else
                <a href="{{ view('relatorios.hospedes_print', ['dataInicio' => $dataInicio, 'dataFim' => $dataFim]) }}" 
                    class="btn btn-primary mb-3 no-print" 
                    target="_blank">
                    <i class="fas fa-print mr-2"></i> Imprimir Relatório
                </a>
                
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th class="align-middle">Nome do Hóspede</th>
                                <th class="align-middle">Apartamento</th>
                                <th class="align-middle">Data Entrada</th>
                                <th class="align-middle">Data Saída</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hospedes as $hospede)
                                <tr>
                                    <td class="align-middle">{{ $hospede->nome }}</td>
                                    <td class="align-middle">
                                        <span class="badge badge-secondary text-dark p-2">
                                            {{ $hospede->apartamento->numero }}
                                        </span>
                                    </td>
                                    <td class="align-middle">{{ \Carbon\Carbon::parse($hospede->data_entrada)->format('d/m/Y') }}</td>
                                    <td class="align-middle">
                                        @if($hospede->data_saida)
                                            <span class="badge badge-light text-dark p-2">
                                                {{ \Carbon\Carbon::parse($hospede->data_saida)->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="badge badge-warning p-2">Em estadia</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .print-area, .print-area * {
            visibility: visible;
        }
        .print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .no-print {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .table {
            font-size: 12px;
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
    
    /* Estilos normais (não-impressão) */
    .card {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .table th {
        background-color: #f8f9fa;
    }
    
    .badge {
        font-size: 0.9em;
        font-weight: 500;
    }
    
    h2 {
        font-size: 1.5em;
        margin-bottom: 20px;
    }
</style>
@endsection