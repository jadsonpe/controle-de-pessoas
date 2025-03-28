@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Nova Leitura de Energia</h4>
                    <a href="{{ route('leituras-energia.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Voltar
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('leituras-energia.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="apartamento_id" class="form-label">Apartamento *</label>
                            <select class="form-select @error('apartamento_id') is-invalid @enderror" 
                                    id="apartamento_id" name="apartamento_id" required>
                                <option value="">Selecione um apartamento</option>
                                @foreach($apartamentos as $apto)
                                    <option value="{{ $apto->id }}" {{ old('apartamento_id') == $apto->id ? 'selected' : '' }}>
                                        Apartamento {{ $apto->numero }}
                                        @if($apto->hospedeAtivo)
                                            - {{ $apto->hospedeAtivo->nome }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('apartamento_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="leitura_anterior" class="form-label">Leitura Anterior (kWh)</label>
                                <input type="number" step="0.01" class="form-control" 
                                       id="leitura_anterior" name="leitura_anterior" readonly>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="leitura_atual" class="form-label">Leitura Atual (kWh) *</label>
                                <input type="number" step="0.01" class="form-control @error('leitura_atual') is-invalid @enderror" 
                                       id="leitura_atual" name="leitura_atual" 
                                       value="{{ old('leitura_atual') }}" required>
                                @error('leitura_atual')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="data_leitura" class="form-label">Data da Leitura *</label>
                            <input type="date" class="form-control @error('data_leitura') is-invalid @enderror" 
                                   id="data_leitura" name="data_leitura" 
                                   value="{{ old('data_leitura', date('Y-m-d')) }}" required>
                            @error('data_leitura')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="reset" class="btn btn-outline-secondary me-md-2">
                                <i class="bi bi-eraser"></i> Limpar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Salvar Leitura
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const apartamentoSelect = document.getElementById('apartamento_id');
        const leituraAnteriorInput = document.getElementById('leitura_anterior');

        apartamentoSelect.addEventListener('change', function() {
            let apartamentoId = this.value;

            if (apartamentoId) {
                // Faz uma requisição AJAX para buscar a última leitura
                fetch(`/leituras-energia/ultima-leitura/${apartamentoId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.leitura_saida) {
                            leituraAnteriorInput.value = data.leitura_saida;
                        } else {
                            leituraAnteriorInput.value = "0.00";
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        leituraAnteriorInput.value = "0.00";
                    });
            } else {
                leituraAnteriorInput.value = "";
            }
        });

        // Dispara a mudança caso já tenha um apartamento selecionado
        if (apartamentoSelect.value) {
            apartamentoSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endpush