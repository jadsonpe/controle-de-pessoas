@extends('layouts.app')

@section('content')
<div class="container" data-aos="fade-up" data-aos-delay="100">
    <h2>Editar Movimentação</h2>

    <!-- Mensagens de Sucesso ou Erro -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('movimentacoes.update', $movimentacao->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="hospede_id">Hóspede</label>
            <select name="hospede_id" class="form-control" required>
                @foreach($hospedes as $hospede)
                    <option value="{{ $hospede->id }}" {{ $movimentacao->hospede_id == $hospede->id ? 'selected' : '' }}>
                        {{ $hospede->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="apartamento_id">Apartamento</label>
            <select name="apartamento_id" class="form-control" required>
                @foreach($apartamentos as $apartamento)
                    <option value="{{ $apartamento->id }}" {{ $movimentacao->apartamento_id == $apartamento->id ? 'selected' : '' }}>
                        {{ $apartamento->numero }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="data_entrada">Data de Entrada</label>
            <input type="datetime-local" name="data_entrada" class="form-control" 
                value="{{ $movimentacao->data_entrada ? \Carbon\Carbon::parse($movimentacao->data_entrada)->format('Y-m-d\TH:i') : '' }}" required>
        </div>

        <div class="form-group">
            <label for="data_saida">Data de Saída</label>
            <input type="datetime-local" name="data_saida" class="form-control" 
                value="{{ $movimentacao->data_saida ? \Carbon\Carbon::parse($movimentacao->data_saida)->format('Y-m-d\TH:i') : '' }}">
        </div>

        <div class="form-group text-left">
            <button type="submit" class="btn btn-primary">Atualizar Movimentação</button>
        </div>
    </form>
</div>
@endsection
