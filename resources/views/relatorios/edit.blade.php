@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Editar Veículo</h2>
        </div>
        
        <div class="card-body">
            <form action="{{ route('veiculos.update', $veiculo->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Campo Hóspede -->
                <div class="mb-3">
                    <label for="hospede_id" class="form-label">Hóspede <span class="text-danger">*</span></label>
                    <select name="hospede_id" id="hospede_id" class="form-select @error('hospede_id') is-invalid @enderror" required>
                        <option value="">Selecione um hóspede</option>
                        @foreach($hospedes as $hospede)
                            <option value="{{ $hospede->id }}" 
                                {{ old('hospede_id', $veiculo->hospede_id) == $hospede->id ? 'selected' : '' }}>
                                {{ $hospede->nome }} (Apto: {{ $hospede->apartamento->numero ?? 'N/I' }})
                            </option>
                        @endforeach
                    </select>
                    @error('hospede_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo Modelo do Veículo -->
                <div class="mb-3">
                    <label for="veiculo" class="form-label">Modelo do Veículo <span class="text-danger">*</span></label>
                    <input type="text" name="veiculo" id="veiculo" 
                           class="form-control @error('veiculo') is-invalid @enderror" 
                           value="{{ old('veiculo', $veiculo->veiculo) }}" 
                           required
                           placeholder="Ex: Ford Ka 1.0">
                    @error('veiculo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo Cor -->
                <div class="mb-3">
                    <label for="cor" class="form-label">Cor <span class="text-danger">*</span></label>
                    <input type="text" name="cor" id="cor" 
                           class="form-control @error('cor') is-invalid @enderror" 
                           value="{{ old('cor', $veiculo->cor) }}" 
                           required
                           placeholder="Ex: Prata">
                    @error('cor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo Placa -->
                <div class="mb-3">
                    <label for="placa" class="form-label">Placa <span class="text-danger">*</span></label>
                    <input type="text" name="placa" id="placa" 
                           class="form-control placa-mask @error('placa') is-invalid @enderror" 
                           value="{{ old('placa', $veiculo->placa) }}" 
                           required
                           placeholder="AAA-0000">
                    @error('placa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('veiculos.index') }}" class="btn btn-secondary me-md-2">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function() {
        // Máscara para placa de veículo (padrão Mercosul)
        $('.placa-mask').mask('AAA-0A00', {
            translation: {
                'A': { pattern: /[A-Za-z]/ },
                '0': { pattern: /[0-9]/ }
            },
            reverse: true
        });
    });
</script>
@endpush