@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>Acesso negado</h1>
        <p>Você não tem permissão para acessar esta página.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary mt-4">Voltar para o painel</a>
    </div>
@endsection
