@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nova Movimentação</h2>

    <form action="{{ route('movimentacoes.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Hóspede</label>
            <select name="hospede_id" id="hospede_id" class="form-control" required>
                <option value="" selected disabled>Selecione um hóspede</option>
                @foreach($hospedes as $hospede)
                    <option value="{{ $hospede->id }}" data-apartamento-id="{{ $hospede->apartamento_id }}">{{ $hospede->nome }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label>Apartamento</label>
            <select name="apartamento_id" id="apartamento_id" class="form-control" required>
                {{-- <option value="" selected disabled>Selecione um apartamento</option> --}}
            </select>
        </div>

        <div class="form-group">
            <label>Data de Entrada</label>
            <input type="datetime-local" name="data_entrada" class="form-control" required>
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
    // Quando o hóspede for selecionado, preenche o apartamento
    document.getElementById('hospede_id').addEventListener('change', function() {
        var hospedeId = this.value;
        var apartamentoSelect = document.getElementById('apartamento_id');
        var apartamentoId = this.selectedOptions[0].getAttribute('data-apartamento-id'); // ID do apartamento do hóspede
        
        // Limpar o select de apartamentos
        // apartamentoSelect.innerHTML = '<option value="" selected disabled>Selecione um apartamento</option>';
        apartamentoSelect.innerHTML = apartamentoId;


        if (apartamentoId) {
            // Criar uma opção com o apartamento atual
            var option = document.createElement('option');
            option.value = apartamentoId;
            option.textContent = 'Apartamento ' + apartamentoId;  // Aqui você pode customizar o texto
            apartamentoSelect.appendChild(option);
        }
    });
</script>
@endsection
