<div class="list-group">
    {{-- <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">Dashboard</a> --}}
    @can('administrador')
        <a href="{{ route('apartamentos.index') }}" class="list-group-item list-group-item-action">Apartamentos</a>
        <a href="{{ route('hospedes.index') }}" class="list-group-item list-group-item-action">Hóspedes</a>
        <a href="{{ route('veiculos.index') }}" class="list-group-item list-group-item-action">Veículos</a>
        <a href="{{ route('acompanhantes.index') }}" class="list-group-item list-group-item-action">Acompanhantes</a>
        <a href="{{ route('leituras-energia.index') }}" class="list-group-item list-group-item-action">Leituras de Energia</a>
    @endcan
    @can('porteiro')
        <a href="{{ route('hospedes.ativos') }}" class="list-group-item list-group-item-action">Hóspedes Ativos</a>
    @endcan
</div>
