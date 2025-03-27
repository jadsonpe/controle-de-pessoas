<!-- resources/views/dashboard/administrador.blade.php -->
<div>
    <h1>Bem-vindo, Administrador</h1>
    <h3>Gerenciar sistema:</h3>
    <ul>
        <li><a href="{{ route('usuarios.cadastrar') }}">Cadastrar Usuários</a></li>
        <li><a href="{{ route('relatorios.index') }}">Gerar Relatórios</a></li>
    </ul>
</div>
