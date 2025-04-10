@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Movimentações entre {{ $dataInicio->format('d/m/Y') }} e {{ $dataFim->format('d/m/Y') }}</h2>

    @if($movimentacoes->isEmpty())
        <p>Nenhuma movimentação encontrada no período selecionado.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Hóspede</th>
                    <th>Apartamento</th>
                    <th>Tipo</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach($movimentacoes as $item)
                    <tr>
                        <td>{{ $item->hospede->nome ?? '---' }}</td>
                        <td>{{ $item->apartamento ?? '---' }}</td>
                        <td>{{ ucfirst($item->tipo) }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->data_entrada)->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
