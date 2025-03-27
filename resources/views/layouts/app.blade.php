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
        
        /* Ajustes para o menu mobile */
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
            }
            
            .navmenu.mobile-nav-active {
                right: 0;
            }
            
            .navmenu ul {
                padding: 20px;
            }
            
            .mobile-nav-toggle {
                display: block !important;
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

            <!-- Menu Principal -->
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ route('hospedes.index') }}" class="{{ request()->routeIs('hospedes.*') ? 'active' : '' }}">Hóspedes</a></li>
                    <li><a href="{{ route('movimentacoes.index') }}" class="{{ request()->routeIs('movimentacoes.*') ? 'active' : '' }}">Movimentações</a></li>
                    <li><a href="{{ route('apartamentos.index') }}" class="{{ request()->routeIs('apartamentos.*') ? 'active' : '' }}">Aptos</a></li>
                    <li><a href="{{ route('veiculos.index') }}" class="{{ request()->routeIs('veiculos.*') ? 'active' : '' }}">Veículos</a></li>
                    <li><a href="{{ route('acompanhantes.index') }}" class="{{ request()->routeIs('acompanhantes.*') ? 'active' : '' }}">Acompanhantes</a></li>
                    <li><a href="{{ route('leituras-energia.index') }}" class="{{ request()->routeIs('leituras-energia.*') ? 'active' : '' }}">Energia</a></li>
                    {{-- <li><a href="{{ route('usuarios.index') }}" class="{{ request()->routeIs('usuarios.*') ? 'active' : '' }}">Usuários</a></li> --}}
                </ul>
            </nav>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
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