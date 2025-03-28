@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Editar Leitura de Energia</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('leituras-energia.update', $leitura->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Apartamento</label>
                            <input type="text" class="form-control" 
                                   value="Apartamento {{ $leitura->apartamento->numero }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Leitura Anterior (kWh)</label>
                            <input type="number" step="0.01" class="form-control" 
                                   value="{{ $leitura->leitura_anterior }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="leitura_atual" class="form-label">Leitura Atual (kWh) *</label>
                            <input type="number" step="0.01" class="form-control" id="leitura_atual" 
                                   name="leitura_atual" value="{{ $leitura->leitura_atual }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="data_leitura" class="form-label">Data da Leitura *</label>
                            <input type="date" class="form-control" id="data_leitura" 
                            name="data_leitura" value="{{ \Carbon\Carbon::parse($leitura->data_leitura)->format('Y-m-d') }}" required>  
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('leituras-energia.index') }}" class="btn btn-secondary">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Atualizar Leitura
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection