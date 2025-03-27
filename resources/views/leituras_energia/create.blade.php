@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cadastrar Leitura de Energia</h1>
    <form action="{{ route('leituras-energia.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="apartamento_id">Apartamento</label>
            <select class="form-control" id="apartamento_id" name="apartamento_id" required>
                @foreach ($apartamentos as $apartamento)
                    <option value="{{ $apartamento->id }}">{{ $apartamento->numero }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="leitura_entrada">Leitura de Entrada (kWh)</label>
            <input type="number" class="form-control" id="leitura_entrada" name="leitura_entrada" required>
        </div>
        <div class="form-group">
            <label for="leitura_saida">Leitura de Saída (kWh)</label>
            <input type="number" class="form-control" id="leitura_saida" name="leitura_saida">
        </div>
        <div class="form-group">
            <label for="total_kw_h">Total (kWh)</label>
            <input type="number" class="form-control" id="total_kw_h" name="total_kw_h" readonly>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Registrar Leitura</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const entrada = document.getElementById('leitura_entrada');
        const saida = document.getElementById('leitura_saida');
        const total = document.getElementById('total_kw_h');

        function calcularTotal() {
            const valorEntrada = parseFloat(entrada.value) || 0;
            const valorSaida = parseFloat(saida.value) || 0;
            total.value = valorSaida -  valorEntrada;
        }

        entrada.addEventListener('input', calcularTotal);
        saida.addEventListener('input', calcularTotal);
    });
</script>
@endsection
