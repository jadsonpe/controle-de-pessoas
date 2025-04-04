@extends('layouts.app')

@section('content')
<div class="container" data-aos="fade-up">
    <div class="section-title">
        <h2>Apartamentos Disponíveis</h2>
        <p>Período: {{ \Carbon\Carbon::parse($data_entrada)->format('d/m/Y') }} até {{ \Carbon\Carbon::parse($data_saida)->format('d/m/Y') }}</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($apartamentos->isEmpty())
                <div class="alert alert-warning">Nenhum apartamento disponível no período selecionado.</div>
            @else
                <div class="row">
                    @foreach($apartamentos as $apt)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 border-success">
                            <div class="card-body">
                                <h5 class="card-title">Apto #{{ $apt->numero }}</h5>
                                <p class="card-text">{{ $apt->descricao }}</p>
                                <span class="badge bg-success">Disponível</span>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="{{ route('hospedes.create', [
                                    'apartamento_id' => $apt->id,
                                    'data_entrada' => $data_entrada,
                                    'data_saida' => $data_saida
                                ]) }}" class="btn btn-sm btn-primary w-100">
                                    Reservar Agora
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
            <div class="mt-3">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar ao Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection