<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema Everest</title>
    
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
    <link href="/day/assets/vendor/aos/aos.css" rel="stylesheet">
    
    <!-- Main CSS File -->
    <link href="/day/assets/css/main.css" rel="stylesheet">
    {{-- @if(request()->routeIs('dashboard'))
        <link href="/css/dashboard.css" rel="stylesheet">
    @endif
    @if(request()->routeIs('hospedes.*'))
        <link href="/css/hospedes.css" rel="stylesheet">
    @endif --}}
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>

        /* Ajustes para a paginação */
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }
        
        .page-link {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            line-height: 1.5;
        }
        
        .page-item:first-child .page-link,
        .page-item:last-child .page-link {
            font-size: 0.875rem;
        }
        
        /* Se ainda estiverem grandes, reduza mais */
        .pagination .bi {
            font-size: 1rem !important;
        }
        /* Estilos adicionais para garantir a exibição correta */
        body {
            padding-top: 70px;
            background-color: #f8f9fa;
        }
        
        .main-content {
            min-height: calc(100vh - 120px);
        }
        
        .table {
            background-color: white;
        }
        
    /* Ajustes para o menu mobile - VERSÃO CENTRALIZADA */
    @media (max-width: 1199px) {
        .navmenu {
            position: fixed;
            top: 70px;
            right: -100%;
            width: 80%;
            height: calc(100vh - 70px);
            background-color: #fff;
            transition: 0.3s;
            z-index: 999;
            overflow-y: auto;
            padding: 30px 25px; /* Aumentei o padding para mais espaçamento */
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1); /* Sombra suave */
        }
        
        .navmenu.mobile-nav-active {
            right: 0;
        }
        
        .navmenu ul {
            display: block !important;
            flex-direction: column !important;
            padding: 0;
            margin: 0 auto; /* Centraliza o conteúdo */
            max-width: 90%; /* Limita a largura máxima */
        }
        
        .navmenu li {
            width: 100%;
            padding: 12px 0; /* Aumentei o padding vertical */
            border-bottom: 1px solid #eee;
            text-align: center; /* Centraliza o texto */
        }
        
        .navmenu a {
            display: block;
            width: 100%;
            padding: 8px 0;
            color: #333 !important;
            font-size: 1.1rem; /* Aumentei um pouco o tamanho da fonte */
        }
        
        .user-area {
            margin: 25px auto 0 auto !important; /* Centraliza e dá margem no topo */
            padding: 15px 0;
            border-top: 1px solid #eee;
            width: 90%; /* Mantém a mesma largura que o menu */
            text-align: center; /* Centraliza o conteúdo */
        }
        
        .user-area .dropdown-toggle {
            justify-content: center; /* Centraliza ícone e texto */
            color: #ffffff !important;
            padding: 8px 0;
            font-size: 1.1rem; /* Tamanho consistente com os itens do menu */
        }
    }

    /* Melhorias para telas muito pequenas */
    @media (max-width: 480px) {
        .navmenu {
            width: 90%; /* Um pouco menor que a tela */
            padding: 25px 15px; /* Padding reduzido */
        }
        
        .navmenu ul,
        .user-area {
            max-width: 100%; /* Ocupa toda a largura disponível */
        }
    }
    </style>
</head>
<body class="index-page">
<!-- Header -->

<header id="header" class="header fixed-top bg-dark">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <!-- Logo -->
        <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('day/assets/img/logo.jpg') }}" alt="Logo Everest" class="logo-img">
            <h1 class="d-lg-block d-none text-white">Everest</h1>
        </a>

        <!-- Menu Principal e Área do Usuário -->
        <div class="d-flex align-items-center">
            <nav id="navmenu" class="navmenu">
                <ul class="d-flex align-items-center mb-0">
                    <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ route('hospedes.index') }}" class="{{ request()->routeIs('hospedes.*') ? 'active' : '' }}">Hóspedes</a></li>
                    <li><a href="{{ route('movimentacoes.index') }}" class="{{ request()->routeIs('movimentacoes.*') ? 'active' : '' }}">Movimentações</a></li>
                    <li><a href="{{ route('apartamentos.index') }}" class="{{ request()->routeIs('apartamentos.*') ? 'active' : '' }}">Aptos</a></li>
                    <li><a href="{{ route('veiculos.index') }}" class="{{ request()->routeIs('veiculos.*') ? 'active' : '' }}">Veículos</a></li>
                    <li><a href="{{ route('acompanhantes.index') }}" class="{{ request()->routeIs('acompanhantes.*') ? 'active' : '' }}">Acompanhantes</a></li>
                    <li><a href="{{ route('leituras-energia.index') }}" class="{{ request()->routeIs('leituras-energia.*') ? 'active' : '' }}">Energia</a></li>
                    @can('admin-access')
                    <li><a href="{{ route('usuarios.index') }}" class="{{ request()->routeIs('usuarios.*') ? 'active' : '' }}">Usuários</a></li>
                    @endcan
                </ul>
            </nav>
            
            <!-- Área do Usuário Logado -->
            @auth
            <div class="user-area ms-3">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-2"></i>
                        <span class="d-none d-lg-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
                        {{-- <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Meu Perfil</a></li> --}}
                        {{-- <li><hr class="dropdown-divider"></li> --}}
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right me-2"></i> Sair
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            @endauth
            
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </div>
    </div>
</header>
    <!-- Conteúdo principal -->
    <main id="main" class="main-content py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer id="footer" class="footer bg-dark text-white py-3">
        <div class="container">
            <div class="text-center">
                &copy; {{ date('Y') }} <strong>Sistema Everest</strong>. Todos os direitos reservados.
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="/day/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/day/assets/vendor/aos/aos.js"></script>
    <script src="/day/assets/js/main.js"></script>
    
    <!-- Script para o menu mobile -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
            const navmenu = document.querySelector('#navmenu');
            
            if(mobileNavToggle && navmenu) {
                mobileNavToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    navmenu.classList.toggle('mobile-nav-active');
                    this.classList.toggle('bi-list');
                    this.classList.toggle('bi-x');
                });
                
                // Fechar menu ao clicar em um link
                document.querySelectorAll('#navmenu ul li a').forEach(item => {
                    item.addEventListener('click', () => {
                        navmenu.classList.remove('mobile-nav-active');
                        mobileNavToggle.classList.add('bi-list');
                        mobileNavToggle.classList.remove('bi-x');
                    });
                });
            }
            
            // Inicializar AOS
            if(typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    easing: 'ease-in-out'
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>