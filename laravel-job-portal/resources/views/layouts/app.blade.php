<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'IT Job Portal')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #540d6e;
            --secondary-color: #ee4266;
            --accent-color: #ffd23f;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        body { background-color: #f8f9fa; min-height: 100vh; display: flex; flex-direction: column; }
        .navbar { background-color: var(--primary-color) !important; }
        .navbar-brand, .navbar .nav-link { color: white !important; }
        .navbar .nav-link:hover { color: var(--accent-color) !important; opacity: 1; }
        
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); }
        .btn-primary:hover { background-color: var(--secondary-color); border-color: var(--secondary-color); }
        .btn-outline-primary { color: var(--primary-color); border-color: var(--primary-color); }
        .btn-outline-primary:hover { background-color: var(--primary-color); color: white; border-color: var(--primary-color); }
        
        .card { box-shadow: var(--card-shadow); border: none; border-radius: 12px; }
        .job-card { transition: transform 0.2s; }
        .job-card:hover { transform: translateY(-4px); }
        
        .tag-badge { background: #e9ecef; color: #495057; font-size: 0.8rem; }
        .salary-badge { background: #d4edda; color: #155724; }
        .work-type-badge { background: #cce5ff; color: #004085; }
        
        footer { margin-top: auto; background: #343a40; color: white; }
        
        .sidebar { min-height: calc(100vh - 56px); background: #ffffff; border-right: 1px solid #dee2e6; box-shadow: 2px 0 5px rgba(0,0,0,0.05); }
        .sidebar .nav-link { color: #495057; padding: 12px 20px; border-radius: 8px; margin: 4px 8px; font-weight: 500; }
        .sidebar .nav-link:hover { background: #f8f9fa; color: var(--secondary-color); }
        .sidebar .nav-link.active { background-color: var(--primary-color); color: white !important; }
        .sidebar .nav-link i { margin-right: 10px; width: 20px; color: var(--primary-color); }
        .sidebar .nav-link:hover i { color: var(--secondary-color); }
        .sidebar .nav-link.active i { color: white; }
        
        .stat-card { border-left: 4px solid var(--secondary-color); }
        .filter-section { background: white; border-radius: 12px; padding: 20px; }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="bi bi-briefcase-fill me-2"></i>IT Job Portal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Oferty</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Zaloguj</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Zarejestruj</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(auth()->user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Panel Admina</a></li>
                                @elseif(auth()->user()->isEmployer())
                                    <li><a class="dropdown-item" href="{{ route('employer.dashboard') }}">Panel Pracodawcy</a></li>
                                @elseif(auth()->user()->isCandidate())
                                    <li><a class="dropdown-item" href="{{ route('candidate.dashboard') }}">Mój Panel</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Wyloguj</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <footer class="py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} IT Job Portal.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
