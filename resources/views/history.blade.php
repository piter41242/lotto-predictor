@extends('layouts.app')

@section('title', 'Mi Historial')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-white border-0 shadow-sm">
                <div class="card-body py-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 class="mb-0">
                                <i class="fas fa-history text-primary"></i> 
                                Mi Historial de Predicciones
                            </h4>
                            <p class="text-muted mt-2 mb-0">
                                <i class="fas fa-chart-line"></i> Todas las predicciones que has generado
                            </p>
                        </div>
                        <div class="mt-2 mt-sm-0">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-chart-line me-2"></i> Nueva Predicción
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4" id="stats-row" style="display: none;">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <i class="fas fa-chart-line fa-3x text-primary mb-2"></i>
                    <h3 id="totalPredictions" class="mb-0">0</h3>
                    <p class="text-muted mb-0">Predicciones Generadas</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <i class="fas fa-ticket-alt fa-3x text-primary mb-2"></i>
                    <h3 id="totalLotteries" class="mb-0">0</h3>
                    <p class="text-muted mb-0">Loterías Consultadas</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <i class="fas fa-calendar-alt fa-3x text-primary mb-2"></i>
                    <h3 id="lastPrediction" class="mb-0">-</h3>
                    <p class="text-muted mb-0">Última Predicción</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Predicciones -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body" id="history-container">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-2 text-muted">Cargando historial...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .history-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 15px;
        color: white;
        transition: transform 0.3s;
        margin-bottom: 15px;
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
    }
    
    .history-number:hover {
        background: rgba(255,255,255,0.3);
        transform: scale(1.05);
        cursor: pointer;
    }
    
    .lottery-badge {
        background: rgba(255,255,255,0.25);
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .date-badge {
        background: rgba(0,0,0,0.2);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
    }
    
    .empty-state {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 60px 20px;
    }
</style>
@endpush

@push('scripts')
<script>
let token = localStorage.getItem('token');

if (!token) {
    window.location.href = '/login';
}

function loadHistory() {
    $.ajax({
        url: '/api/predictions',
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`
        },
        success: function(response) {
            renderHistory(response.data);
            renderStats(response.data);
        },
        error: function(xhr) {
            if (xhr.status === 401) {
                localStorage.removeItem('token');
                window.location.href = '/login';
            } else {
                $('#history-container').html(`
                    <div class="text-center py-5">
                        <i class="fas fa-exclamation-circle fa-4x text-danger mb-3"></i>
                        <h5>Error al cargar el historial</h5>
                        <p class="text-muted">Por favor, intenta nuevamente</p>
                        <button class="btn btn-primary mt-3" onclick="loadHistory()">
                            <i class="fas fa-sync-alt me-2"></i> Reintentar
                        </button>
                    </div>
                `);
            }
        }
    });
}

function renderStats(predictions) {
    if (!predictions || predictions.length === 0) return;
    
    $('#stats-row').show();
    $('#totalPredictions').text(predictions.length);
    
    // Loterías únicas
    const uniqueLotteries = [...new Set(predictions.map(p => p.lottery_id))];
    $('#totalLotteries').text(uniqueLotteries.length);
    
    // Última predicción
    const lastPred = new Date(predictions[0].created_at);
    $('#lastPrediction').text(lastPred.toLocaleDateString());
}

function renderHistory(predictions) {
    if (!predictions || predictions.length === 0) {
        $('#history-container').html(`
            <div class="empty-state text-center">
                <i class="fas fa-chart-line fa-5x text-muted mb-4"></i>
                <h4 class="text-muted">No tienes predicciones guardadas</h4>
                <p class="text-muted mb-4">Genera tu primera predicción desde el Dashboard</p>
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-chart-line me-2"></i> Generar mi Primera Predicción
                </a>
            </div>
        `);
        return;
    }
    
    let html = '<div class="timeline">';
    
    predictions.forEach((pred, index) => {
        const numbers = pred.predicted_numbers;
        const date = new Date(pred.created_at);
        const formattedDate = date.toLocaleDateString('es-CO', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        
        html += `
            <div class="history-card p-4 animate__animated animate__fadeInUp" style="animation-delay: ${index * 0.05}s">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
                    <div>
                        <h5 class="mb-1">
                            <i class="fas fa-ticket-alt me-2"></i> ${pred.lottery.name}
                        </h5>
                        <div class="date-badge d-inline-block mt-1">
                            <i class="far fa-calendar-alt me-1"></i> ${formattedDate}
                        </div>
                    </div>
                    <div class="lottery-badge mt-2 mt-sm-0">
                        <i class="fas fa-magic me-1"></i> Predicción #${pred.id}
                    </div>
                </div>
                <div class="numbers-container mt-3">
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start">
        `;
        
        numbers.forEach(num => {
            html += `<span class="history-number" onclick="copyNumber('${num}')" title="Click para copiar">${num}</span>`;
        });
        
        html += `
                    </div>
                </div>
                <div class="mt-3 text-end">
                    <small class="opacity-75">
                        <i class="fas fa-chart-line me-1"></i> Análisis de 20 sorteos
                    </small>
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    $('#history-container').html(html);
}

function copyNumber(number) {
    navigator.clipboard.writeText(number).then(() => {
        showAlert(`✅ Número ${number} copiado al portapapeles`, 'success');
    });
}

$(document).ready(function() {
    loadHistory();
});
</script>
@endpush
@endsection