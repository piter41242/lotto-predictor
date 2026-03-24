@extends('layouts.app')

@section('title', 'Crear Cuenta')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg animate__animated animate__fadeInUp">
                <div class="card-header bg-white border-0 text-center pt-5">
                    <div class="mb-3">
                        <i class="fas fa-chart-line fa-4x text-primary"></i>
                    </div>
                    <h3 class="fw-bold">Crea tu cuenta</h3>
                    <p class="text-muted">Únete a LottoPredictor y comienza a predecir</p>
                </div>
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">Nombre Completo</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror border-start-0 ps-0" 
                                       id="name" name="name" value="{{ old('name') }}" placeholder="Tu nombre" required autofocus>
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror border-start-0 ps-0" 
                                       id="email" name="email" value="{{ old('email') }}" placeholder="ejemplo@correo.com" required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror border-start-0 ps-0" 
                                       id="password" name="password" placeholder="••••••••" required>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold">Confirmar Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-check-circle text-muted"></i>
                                </span>
                                <input type="password" class="form-control border-start-0 ps-0" 
                                       id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="fas fa-user-check me-2"></i> Registrarse
                        </button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="mb-0 text-muted">¿Ya tienes cuenta? 
                            <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Inicia sesión aquí</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .input-group-text {
        border-right: none;
        background-color: #f8f9fa;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #dee2e6;
    }
    .card {
        animation: fadeInUp 0.6s ease-out;
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush
@endsection