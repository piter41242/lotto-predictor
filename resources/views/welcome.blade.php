@extends('layouts.app')

@section('title', 'Bienvenido')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-10 text-center text-white">
            <div class="animate__animated animate__fadeInUp">
                <h1 class="display-1 fw-bold mb-4">
                    🎲 LottoPredictor
                </h1>
                <p class="lead fs-3 mb-4">
                    La inteligencia artificial al servicio de tu suerte
                </p>
                <p class="fs-5 mb-5 text-white-50">
                    Analiza patrones, tendencias y frecuencias de más de 38 loterías colombianas<br>
                    para generarte los números con mayor probabilidad de salir.
                </p>
                @guest
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">
                            <i class="fas fa-user-plus me-2"></i> Comenzar Gratis
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5">
                            <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión
                        </a>
                    </div>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-chart-line me-2"></i> Ir al Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="row mt-5 g-4 pb-5">
        <div class="col-md-4">
            <div class="card h-100 text-center border-0 shadow-lg animate__animated animate__fadeInUp" style="animation-delay: 0.1s">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <i class="fas fa-chart-simple fa-4x text-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold">Análisis Estadístico</h5>
                    <p class="card-text text-muted">
                        Algoritmo avanzado que analiza frecuencias, patrones y tendencias de los últimos 20 sorteos.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 text-center border-0 shadow-lg animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <i class="fas fa-list fa-4x text-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold">+38 Loterías</h5>
                    <p class="card-text text-muted">
                        Todas las loterías y chances de Colombia: Dorado, Antioqueñita, Fantástica, Paisita y más.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 text-center border-0 shadow-lg animate__animated animate__fadeInUp" style="animation-delay: 0.3s">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <i class="fas fa-chart-line fa-4x text-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold">Actualización Diaria</h5>
                    <p class="card-text text-muted">
                        Resultados actualizados automáticamente para predicciones más precisas.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Cómo funciona -->
    <div class="row mt-5 pt-4 pb-5">
        <div class="col-12 text-center text-white mb-5">
            <h2 class="fw-bold">¿Cómo funciona?</h2>
            <p class="lead">3 pasos simples para obtener tus números de la suerte</p>
        </div>
        <div class="col-md-4 text-center text-white">
            <div class="display-1 fw-bold mb-3">1</div>
            <i class="fas fa-list fa-3x mb-3"></i>
            <h5>Selecciona una Lotería</h5>
            <p class="text-white-50">Elige entre más de 38 loterías y chances disponibles</p>
        </div>
        <div class="col-md-4 text-center text-white">
            <div class="display-1 fw-bold mb-3">2</div>
            <i class="fas fa-chart-line fa-3x mb-3"></i>
            <h5>Analiza Resultados</h5>
            <p class="text-white-50">Nuestro algoritmo analiza los últimos 20 sorteos</p>
        </div>
        <div class="col-md-4 text-center text-white">
            <div class="display-1 fw-bold mb-3">3</div>
            <i class="fas fa-magic fa-3x mb-3"></i>
            <h5>Obtén tu Predicción</h5>
            <p class="text-white-50">Recibe 20 números con alta probabilidad de salir</p>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
</style>
@endpush
@endsection