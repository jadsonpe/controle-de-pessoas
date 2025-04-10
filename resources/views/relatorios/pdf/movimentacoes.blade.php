<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Movimentações</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h1>Relatório de Movimentações</h1>
    <p>Período: {{ $dataInicio->format('d/m/Y') }} até {{ $dataFim->format('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Hóspede</th>
                <th>Apartamento</th>
                <th>Data Entrada</th>
                <th>Data Saída</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movimentacoes as $m)
                <tr>
                    <td>{{ $m->hospede->nome ?? '—' }}</td>
                    <td>{{ $m->apartamento->identificacao ?? '—' }}</td>
                    <td>{{ \Carbon\Carbon::parse($m->data_entrada)->format('d/m/Y') }}</td>
                    <td>{{ $m->data_saida ? \Carbon\Carbon::parse($m->data_saida)->format('d/m/Y') : '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
