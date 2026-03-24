<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LottoPredictor - @yield('title')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }
        
        .navbar-brand {
            font-weight: bold;
            color: var(--primary) !important;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 10px;
            padding: 10px 25px;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .btn-outline-light:hover {
            transform: translateY(-2px);
        }
        
        .lottery-ball {
            display: inline-block;
            width: 50px;
            height: 50px;
            line-height: 50px;
            text-align: center;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 50%;
            font-weight: bold;
            font-size: 18px;
            margin: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .prediction-ball {
            display: inline-block;
            width: 65px;
            height: 65px;
            line-height: 65px;
            text-align: center;
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
            border-radius: 50%;
            font-weight: bold;
            font-size: 18px;
            margin: 8px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .prediction-ball:hover {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
        
        .lottery-btn {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 12px;
            margin: 5px;
            transition: all 0.3s;
            background: white;
            width: 100%;
            text-align: left;
        }
        
        .lottery-btn.active {
            border-color: var(--primary);
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }
        
        .lottery-btn.active .text-muted {
            color: rgba(255,255,255,0.8) !important;
        }
        
        .lottery-btn:hover:not(.active) {
            border-color: var(--primary);
            transform: translateX(5px);
        }
        
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .alert-fixed {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 9999;
            animation: slideIn 0.3s ease-out;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .lottery-list {
            max-height: 550px;
            overflow-y: auto;
        }
        
        .draw-item {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 10px;
            transition: all 0.2s;
        }
        
        .draw-item:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }
        
        .draw-date {
            font-weight: 600;
            color: var(--primary);
        }
        
        .draw-number {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .draw-ball {
            display: inline-flex;
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 50%;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            margin: 0 3px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        footer {
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 20px 0;
            margin-top: 50px;
        }
        
        .stats-card {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 15px;
        }
        
        .badge-lottery {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 8px 15px;
            border-radius: 20px;
        }
        
        .history-card {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            color: white;
            transition: transform 0.3s;
        }
        
        .history-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        .history-number {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            padding: 5px 12px;
            margin: 4px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            cursor: pointer;
        }
        
        .history-number:hover {
            background: rgba(255,255,255,0.3);
            transform: scale(1.05);
        }
        
        .empty-state {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 60px 20px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-chart-line"></i> LottoPredictor
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('history') }}">
                                <i class="fas fa-history"></i> Historial
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus"></i> Registrarse
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <footer class="text-center">
        <div class="container">
            <p>&copy; {{ date('Y') }} LottoPredictor - Sistema inteligente de predicción de loterías</p>
            <p class="small">Las predicciones son generadas por algoritmos estadísticos. No garantizamos resultados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function showAlert(message, type = 'success') {
            const alert = $(`
                <div class="alert alert-${type} alert-dismissible fade show alert-fixed" role="alert">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);
            $('body').append(alert);
            setTimeout(() => alert.fadeOut(300, () => alert.remove()), 5000);
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @stack('scripts')
</body>
</html>