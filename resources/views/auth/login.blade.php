<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Everest</title>
    
    <!-- Favicons -->
    <link href="/day/assets/img/favicon.png" rel="icon">
    <link href="/day/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/day/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/day/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        :root {
            --everest-primary: #2c3e50;
            --everest-secondary: #3498db;
            --everest-light: #ecf0f1;
            --everest-dark: #1a252f;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Open Sans', sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .login-container {
            max-width: 450px;
            width: 100%;
            margin: auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-logo {
            max-width: 180px;
            margin-bottom: 1.5rem;
        }
        
        .login-title {
            color: var(--everest-primary);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .login-subtitle {
            color: #7f8c8d;
            font-size: 1rem;
        }
        
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 6px;
            border: 1px solid #ddd;
        }
        
        .form-control:focus {
            border-color: var(--everest-secondary);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }
        
        .btn-everest {
            background-color: var(--everest-primary);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-everest:hover {
            background-color: var(--everest-dark);
        }
        
        .login-footer {
            text-align: center;
            margin-top: 2rem;
            color: #7f8c8d;
            font-size: 0.9rem;
        }
        
        .input-group-text {
            background-color: #f8f9fa;
        }
        
        .forgot-password {
            font-size: 0.9rem;
        }
        
        @media (max-width: 576px) {
            .login-container {
                padding: 1.5rem;
                margin: 1rem;
            }
            
            .login-logo {
                max-width: 140px;
            }
        }
    </style>
</head>
<body>
    <div class="container d-flex flex-column justify-content-center py-5">
        <div class="login-container">
            <div class="login-header">
                <img src="/day/assets/img/logo.jpg" alt="Everest" class="login-logo">
                <h2 class="login-title">Sistema Everest</h2>
                <p class="login-subtitle">Gestão de Hospedagem</p>
            </div>
            
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input id="email" type="email" name="email" class="form-control" 
                               value="{{ old('email') }}" required autofocus autocomplete="username">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
                </div>
                
                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input id="password" type="password" name="password" 
                               class="form-control" required autocomplete="current-password">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
                </div>
                
                <!-- Remember Me -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">Manter conectado</label>
                </div>
                
                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn btn-primary btn-everest">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Entrar
                    </button>
                </div>
                
                @if (Route::has('password.request'))
                    <div class="text-center">
                        <a href="{{ route('password.request') }}" class="forgot-password text-decoration-none">
                            Esqueceu sua senha?
                        </a>
                    </div>
                @endif
            </form>
        </div>
        
        <div class="login-footer">
            &copy; {{ date('Y') }} Sistema Everest. Todos os direitos reservados.
        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="/day/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>