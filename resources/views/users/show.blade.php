@extends('layouts.app')

@section('content')
<div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Detalhes do Usuário') }}</span>
                    <div>
                        <a href="{{ route('usuarios.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        @can('update', $user)
                        <a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-sm btn-warning ms-2">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        @endcan
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Nome:</div>
                        <div class="col-md-8">{{ $user->name }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">E-mail:</div>
                        <div class="col-md-8">{{ $user->email }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Tipo:</div>
                        <div class="col-md-8">
                            @if ($user->role === 'administrador')
                                <span class="badge bg-primary">Administrador</span>
                            @else
                                <span class="badge bg-secondary">Porteiro</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Cadastrado em:</div>
                        <div class="col-md-8">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Última atualização:</div>
                        <div class="col-md-8">{{ $user->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection