@extends('layouts.app')

@section('title', 'Relatórios')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Relatórios</h2>

    {{-- Filtros de período --}}
    <form method="GET" action="{{ route('relatorios.hospedes') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="data_inicio" class="form-label">Data Início</label>
            <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
        </div>
        <div class="col-md-4">
            <label for="data_fim" class="form-label">Data Fim</label>
            <input type="date" class="form-control" id="data_fim" name="data_fim" required>
        </div>
        <div class="col-md-4 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary">Relatório de Hóspedes</button>
            <a id="btnExportHospedes" href="#" class="btn btn-outline-primary">Exportar PDF</a>
        </div>
    </form>

    <form method="GET" action="{{ route('relatorios.movimentacoes') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="data_inicio_mov" class="form-label">Data Início</label>
            <input type="date" class="form-control" id="data_inicio_mov" name="data_inicio" required>
        </div>
        <div class="col-md-4">
            <label for="data_fim_mov" class="form-label">Data Fim</label>
            <input type="date" class="form-control" id="data_fim_mov" name="data_fim" required>
        </div>
        <div class="col-md-4 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-secondary">Relatório de Movimentações</button>
            <a id="btnExportMovimentacoes" href="#" class="btn btn-outline-secondary">Exportar PDF</a>
        </div>
    </form>

    {{-- Filtro para Energia --}}
    <form method="GET" action="{{ route('relatorios.energia') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="data_inicio_energia" class="form-label">Data Início</label>
            <input type="date" class="form-control" id="data_inicio_energia" name="data_inicio" required>
        </div>
        <div class="col-md-4">
            <label for="data_fim_energia" class="form-label">Data Fim</label>
            <input type="date" class="form-control" id="data_fim_energia" name="data_fim" required>
        </div>
        <div class="col-md-4 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-info">Relatório de Energia</button>
            <a id="btnExportEnergia" href="#" class="btn btn-outline-info">Exportar PDF</a>
        </div>
    </form>
</div>

<script>
    // Configura os links de exportação com as datas selecionadas
    function configurarExportacao(btnId, dataInicioId, dataFimId, rotaBase) {
        document.getElementById(btnId).addEventListener('click', function(e) {
            const dataInicio = document.getElementById(dataInicioId).value;
            const dataFim = document.getElementById(dataFimId).value;
            if (!dataInicio || !dataFim) {
                alert("Preencha as datas!");
                e.preventDefault();
                return;
            }
            this.href = `${rotaBase}?data_inicio=${dataInicio}&data_fim=${dataFim}`;
        });
    }

    configurarExportacao('btnExportHospedes', 'data_inicio', 'data_fim', '{{ route("relatorios.hospedes.pdf") }}');
    configurarExportacao('btnExportMovimentacoes', 'data_inicio_mov', 'data_fim_mov', '{{ route("relatorios.movimentacoes.pdf") }}');
    configurarExportacao('btnExportEnergia', 'data_inicio_energia', 'data_fim_energia', '{{ route("relatorios.energia.pdf") }}');
</script>

<style>
    h5 {
        color: black;
    }
    h2 {
        margin-top: 10px;
        color: #007bff;
    }
    .btn {
        min-width: 120px;
    }
</style>
@endsection