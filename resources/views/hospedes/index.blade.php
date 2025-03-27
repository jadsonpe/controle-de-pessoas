@extends('layouts.app')

@section('content')
<div class="container" data-aos="fade-up">
    <div class="section-title">
        <h2>Gestão de Hóspedes</h2>
        <p>Lista completa de hóspedes cadastrados</p>
    </div>

    <!-- Mensagens de Feedback -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Lista de Hóspedes</h5>
            <a href="{{ route('hospedes.create') }}" class="btn btn-light btn-sm">
                <i class="bi bi-plus-circle"></i> Novo Hóspede
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Nome</th>
                            <th>Acompanhantes</th>
                            <th>Apto</th>
                            <th>Período</th>
                            <th width="120">Foto</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hospedes as $hospede)
                            <tr>
                                <td>{{ $loop->iteration + (($hospedes->currentPage() - 1) * $hospedes->perPage()) }}</td>
                                <td>
                                    <strong>{{ $hospede->nome }}</strong>
                                    @if($hospede->celular)
                                        <div class="text-muted small">{{ $hospede->celular }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if($hospede->acompanhantes->isNotEmpty())
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
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
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-muted">Entrada:</small>
                                        <span>{{ $hospede->data_entrada ? \Carbon\Carbon::parse($hospede->data_entrada)->format('d/m/Y') : '-' }}</span>
                                        
                                        <small class="text-muted mt-1">Saída:</small>
                                        <span>{{ $hospede->data_saida ? \Carbon\Carbon::parse($hospede->data_saida)->format('d/m/Y') : '-' }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($hospede->foto && Storage::disk('public')->exists($hospede->foto))
                                        <a href="{{ asset('storage/' . $hospede->foto) }}" data-gallery="gallery" data-glightbox="description: .custom-desc{{ $hospede->id }}">
                                            <img src="{{ asset('storage/' . $hospede->foto) }}" alt="Foto" class="img-thumbnail" width="60">
                                        </a>
                                    @else
                                        <span class="badge bg-secondary">Sem foto</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('hospedes.edit', $hospede->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('hospedes.destroy', $hospede->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este hóspede?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">Nenhum hóspede cadastrado ainda.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Paginação -->
            @if($hospedes instanceof \Illuminate\Pagination\LengthAwarePaginator && $hospedes->total() > $hospedes->perPage())
                <div class="mt-3 d-flex justify-content-center">
                    <nav aria-label="Page navigation">
                        {{ $hospedes->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializa GLightbox para as fotos
        if(typeof GLightbox !== 'undefined') {
            const lightbox = GLightbox({
                selector: '[data-gallery="gallery"]'
            });
        }
    });
</script>
@endpush