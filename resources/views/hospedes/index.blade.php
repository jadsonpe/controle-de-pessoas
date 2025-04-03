@extends('layouts.app')

@section('content')
<div class="hospedes-container" data-aos="fade-up">
    <div class="hospedes-header section-title">
        <h2>Gestão de Hóspedes</h2>
        <p>Lista completa de hóspedes cadastrados</p>
    </div>

    @include('partials.alerts')

    <div class="hospedes-card card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Lista de Hóspedes</h5>
            <a href="{{ route('hospedes.create') }}" class="btn btn-light btn-sm" aria-label="Adicionar novo hóspede">
                <i class="bi bi-plus-circle me-1"></i> Novo Hóspede
            </a>
        </div>
        <div class="card-body border-bottom">
            <div class="row">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('hospedes.index') }}" id="searchForm">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar por nome ou apartamento..." 
                                   value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                            @if(request('search') || request('ativos'))
                                <a href="{{ route('hospedes.index') }}" class="btn btn-outline-danger">
                                    <i class="bi bi-x-circle"></i> Limpar
                                </a>
                            @endif
                        </div>
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end align-items-center">
                        <div class="form-check form-switch me-3">
                            <input class="form-check-input" type="checkbox" id="filterAtivos" name="ativos" 
                                   value="1" {{ request('ativos') ? 'checked' : '' }}>
                            <label class="form-check-label" for="filterAtivos">
                                Mostrar apenas ativos
                            </label>
                        </div>
                        <div class="legenda-status">
                            <span class="badge bg-success me-2"><i class="bi bi-circle-fill"></i> Ativo</span>
                            <span class="badge bg-secondary"><i class="bi bi-circle-fill"></i> Inativo</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="hospedes-table table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>
                                <a href="{{ route('hospedes.index', [
                                    'search' => request('search'),
                                    'sort' => 'nome',
                                    'direction' => request('sort') === 'nome' && request('direction') === 'asc' ? 'desc' : 'asc',
                                    'ativos' => request('ativos')
                                ]) }}" class="text-decoration-none text-dark">
                                    Nome
                                    @if(request('sort') === 'nome')
                                        <i class="bi bi-caret-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="d-none d-md-table-cell">Acompanhantes</th>
                            <th>
                                <a href="{{ route('hospedes.index', [
                                    'search' => request('search'),
                                    'sort' => 'apartamento',
                                    'direction' => request('sort') === 'apartamento' && request('direction') === 'asc' ? 'desc' : 'asc',
                                    'ativos' => request('ativos')
                                ]) }}" class="text-decoration-none text-dark">
                                    Apto
                                    @if(request('sort') === 'apartamento'))
                                        <i class="bi bi-caret-{{ request('direction') === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="d-none d-sm-table-cell">Período</th>
                            <th width="120">Foto</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hospedes as $hospede)
                            <tr class="{{ is_null($hospede->data_saida) ? 'table-success' : '' }}">
                                <td>{{ $loop->iteration + (($hospedes->currentPage() - 1) * $hospedes->perPage()) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if(is_null($hospede->data_saida))
                                            <span class="badge bg-success me-2"><i class="bi bi-circle-fill"></i></span>
                                        @else
                                            <span class="badge bg-secondary me-2"><i class="bi bi-circle-fill"></i></span>
                                        @endif
                                        <div>
                                            <strong>{{ $hospede->nome }}</strong>
                                            @if($hospede->celular)
                                                <div class="text-muted small">{{ $hospede->celular }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell">
                                    @if($hospede->acompanhantes->isNotEmpty())
                                        <div class="dropdown acompanhantes-dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ $hospede->acompanhantes->count() }} acompanhante(s)
                                            </button>
                                            <ul class="dropdown-menu">
                                                @foreach($hospede->acompanhantes as $acompanhante)
                                                    <li><a class="dropdown-item" href="#">{{ $acompanhante->nome }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <span class="badge bg-secondary">Sem acompanhante</span>
                                    @endif
                                </td>
                                <td>
                                    @if($hospede->apartamento)
                                        <span class="badge bg-primary">{{ $hospede->apartamento->numero }}</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Não informado</span>
                                    @endif
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <div class="d-flex flex-column">
                                        <small class="text-muted">Entrada:</small>
                                        <span>{{ $hospede->data_entrada ? \Carbon\Carbon::parse($hospede->data_entrada)->format('d/m/Y') : '-' }}</span>
                                        
                                        <small class="text-muted mt-1">Saída:</small>
                                        <span>{{ $hospede->data_saida ? \Carbon\Carbon::parse($hospede->data_saida)->format('d/m/Y') : '-' }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($hospede->foto && Storage::disk('public')->exists($hospede->foto))
                                        <a href="{{ asset('storage/' . $hospede->foto) }}" data-gallery="gallery" data-glightbox="description: .custom-desc{{ $hospede->id }}" aria-label="Ver foto">
                                            <img src="{{ asset('storage/' . $hospede->foto) }}" alt="Foto do hóspede" class="img-thumbnail" width="60" loading="lazy">
                                        </a>
                                    @else
                                        <span class="badge bg-secondary">Sem foto</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('hospedes.edit', $hospede->id) }}" class="btn btn-sm btn-warning" title="Editar" aria-label="Editar hóspede">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('hospedes.destroy', $hospede->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Excluir" aria-label="Excluir hóspede" onclick="return confirm('Tem certeza que deseja excluir este hóspede?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bi bi-people fs-4 text-muted"></i>
                                    <p class="text-muted mt-2">Nenhum hóspede cadastrado ainda.</p>
                                    <a href="{{ route('hospedes.create') }}" class="btn btn-sm btn-primary mt-2">
                                        Cadastrar primeiro hóspede
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Paginação -->
            @if($hospedes instanceof \Illuminate\Pagination\LengthAwarePaginator && $hospedes->total() > $hospedes->perPage())
            <div class="hospedes-pagination px-4 pb-3">
                <nav aria-label="Navegação de hóspedes">
                    {{ $hospedes->appends([
                        'search' => request('search'),
                        'sort' => request('sort'),
                        'direction' => request('direction'),
                        'ativos' => request('ativos')
                    ])->onEachSide(1)->links('pagination::bootstrap-5') }}
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .legenda-status {
        font-size: 0.85rem;
    }
    .table-success {
        --bs-table-bg: rgba(25, 135, 84, 0.05);
        --bs-table-hover-bg: rgba(25, 135, 84, 0.1);
    }
    .hospedes-table tr {
        vertical-align: middle;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializa GLightbox para as fotos
        if(typeof GLightbox !== 'undefined') {
            const lightbox = GLightbox({
                selector: '[data-gallery="gallery"]',
                touchNavigation: true,
                loop: true
            });
        }

        // Filtro de hóspedes ativos
        const filterAtivos = document.getElementById('filterAtivos');
        const searchForm = document.getElementById('searchForm');
        
        if(filterAtivos && searchForm) {
            filterAtivos.addEventListener('change', function() {
                // Cria um input hidden para o filtro ativos
                let ativosInput = searchForm.querySelector('input[name="ativos"]');
                if(!ativosInput) {
                    ativosInput = document.createElement('input');
                    ativosInput.type = 'hidden';
                    ativosInput.name = 'ativos';
                    searchForm.appendChild(ativosInput);
                }
                
                ativosInput.value = this.checked ? '1' : '';
                searchForm.submit();
            });
        }
    });
</script>
@endpush