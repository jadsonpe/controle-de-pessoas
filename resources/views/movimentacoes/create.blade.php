@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nova Movimentação</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
    <form action="{{ route('movimentacoes.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Hóspede</label>
            <select name="hospede_id" id="hospede_id" class="form-control" required>
                <option value="" selected disabled>Selecione um hóspede</option>
                @foreach($hospedes->sortBy('apartamento_id') as $hospede)
                    <option value="{{ $hospede->id }}" 
                            data-apartamento-id="{{ $hospede->apartamento_id }}"
                            data-data-entrada="{{ $hospede->data_entrada ? \Carbon\Carbon::parse($hospede->data_entrada)->format('Y-m-d\TH:i') : '' }}">
                        Apto {{ $hospede->apartamento_id }} - {{ $hospede->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Apartamento</label>
            <select name="apartamento_id" id="apartamento_id" class="form-control" required>
                {{-- O conteúdo será preenchido via JavaScript --}}
            </select>
        </div>

        <div class="form-group">
            <label>Data de Entrada</label>
            <input type="datetime-local" name="data_entrada" id="data_entrada" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Data de Saída (Opcional)</label>
            <input type="datetime-local" name="data_saida" class="form-control">
        </div>

        <div class="form-group">
            <label>Observações</label>
            <textarea name="observacoes" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="fa fa-save"></i> Salvar Movimentação
        </button>
    </form>
</div>

<script>
    document.getElementById('hospede_id').addEventListener('change', function() {
        var selectedOption = this.selectedOptions[0];
        var apartamentoSelect = document.getElementById('apartamento_id');
        var dataEntradaInput = document.getElementById('data_entrada');
        
        // Obter dados do hóspede selecionado
        var apartamentoId = selectedOption.getAttribute('data-apartamento-id');
        var dataEntrada = selectedOption.getAttribute('data-data-entrada');

        // Preencher o apartamento
        apartamentoSelect.innerHTML = '';
        if (apartamentoId) {
            var option = document.createElement('option');
            option.value = apartamentoId;
            option.textContent = 'Apartamento ' + apartamentoId;
            apartamentoSelect.appendChild(option);
        }

        // Preencher a data de entrada
        dataEntradaInput.value = dataEntrada || '';
    });
</script>
@endsection