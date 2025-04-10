<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Hóspedes</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h1>Relatório de Hóspedes</h1>
    <p>Período: {{ $dataInicio->format('d/m/Y') }} até {{ $dataFim->format('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Data Entrada</th>
                <th>Telefone</th>
                <th>Documento</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hospedes as $h)
                <tr>
                    <td>{{ $h->nome }}</td>
                    <td>{{ \Carbon\Carbon::parse($h->data_entrada)->format('d/m/Y') }}</td>
                    <td>{{ $h->telefone }}</td>
                    <td>{{ $h->documento }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
