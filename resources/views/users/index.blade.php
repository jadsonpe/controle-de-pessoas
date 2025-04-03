@extends('layouts.app')

@section('content')
<div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Lista de Usuários</h2>
        @can('create', App\Models\User::class)
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Novo Usuário
        </a>
        @endcan
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <!-- Tabela para desktop -->
                <table class="table d-none d-md-table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Tipo</th>
                            <th width="180">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->role === 'administrador')
                                    <span class="badge bg-primary">Administrador</span>
                                @else
                                    <span class="badge bg-secondary">Porteiro</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    @can('update', $user)
                                    <a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @endcan
                                    
                                    @can('delete', $user)
                                    <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Cards para mobile -->
                <div class="d-md-none">
                    @foreach ($users as $user)
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="card-title mb-0">{{ $user->name }}</h5>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </div>
                                <span class="badge {{ $user->role === 'administrador' ? 'bg-primary' : 'bg-secondary' }}">
                                    {{ $user->role === 'administrador' ? 'Admin' : 'Porteiro' }}
                                </span>
                            </div>
                            
                            <div class="d-flex gap-2 mt-3">
                                @can('update', $user)
                                <a href="{{ route('usuarios.edit', $user->id) }}" class="btn btn-sm btn-warning flex-grow-1">
                                    <i class="bi bi-pencil me-1"></i> Editar
                                </a>
                                @endcan
                                
                                @can('delete', $user)
                                <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger w-100">
                                        <i class="bi bi-trash me-1"></i> Excluir
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Paginação -->
    @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator && $users->total() > $users->perPage())
        <div class="mt-3 d-flex justify-content-center">
            {{ $users->onEachSide(1)->links('pagination.custom') }}
        </div>
    @endif
</div>

<style>
    @media (max-width: 767.98px) {
        .card-title {
            font-size: 1rem;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }
    }

    /* Estilo para a tabela */
    .table th {
        white-space: nowrap;
    }
    
    .table td {
        vertical-align: middle;
    }
</style>
@endsection