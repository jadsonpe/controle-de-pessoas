<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
</head>
<body>
    <h1>Registrar Usuário</h1>

    <form action="{{ route('register.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Nome</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div>
            <label for="password">Senha</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="password_confirmation">Confirmar Senha</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        <div>
            <label for="is_admin">Administrador?</label>
            <input type="checkbox" id="is_admin" name="is_admin">
        </div>
        <button type="submit">Registrar</button>
    </form>

    <a href="{{ route('login') }}">Já tem uma conta? Faça login aqui.</a>
</body>
</html>
