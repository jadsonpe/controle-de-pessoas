<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Leitura de Energia</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h1>Relatório de Leitura de Energia</h1>

    <table>
        <thead>
            <tr>
                <th>Apartamento</th>
                <th>Leitura Entrada</th>
                <th>Leitura Saída</th>
                <th>Consumo</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dados as $item)
                <tr>
                    <td>{{ $item->apartamento->identificacao ?? '—' }}</td>
                    <td>{{ $item->leitura_entrada }}</td>
                    <td>{{ $item->leitura_saida }}</td>
                    <td>{{ $item->leitura_saida - $item->leitura_entrada }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
