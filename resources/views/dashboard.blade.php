@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <!-- Header con estadísticas -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-white border-0 shadow-sm">
                <div class="card-body py-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h4 class="mb-0">
                                <i class="fas fa-tachometer-alt text-primary"></i> 
                                ¡Hola, <span class="text-primary">{{ Auth::user()->name }}</span>!
                            </h4>
                            <p class="text-muted mt-2 mb-0">
                                <i class="fas fa-calendar-alt"></i> {{ now()->format('l, d F Y') }}
                            </p>
                        </div>
                        <div class="mt-2 mt-sm-0">
                            <button class="btn btn-outline-primary me-2" id="refreshBtn">
                                <i class="fas fa-sync-alt"></i> Actualizar
                            </button>
                            <a href="{{ route('history') }}" class="btn btn-primary">
                                <i class="fas fa-history"></i> Mi Historial
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Panel Izquierdo - Lista de Loterías -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="mb-0">
                        <i class="fas fa-list text-primary"></i> Loterías Disponibles
                        <span class="badge bg-primary ms-2" id="lotteryCount">0</span>
                    </h5>
                    <p class="text-muted small mt-2 mb-0">Selecciona una para analizar</p>
                </div>
                <div class="card-body lottery-list p-0" id="lottery-list">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-2 text-muted">Cargando loterías...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Derecho - Resultados y Predicción -->
        <div class="col-lg-8">
            <!-- Tarjeta de Resultados -->
            <div class="card border-0 shadow-sm mb-4" id="draws-card" style="display: none;">
                <div class="card-header bg-white border-0 pt-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-history text-primary"></i> 
                            Últimos 20 Resultados
                        </h5>
                        <span class="badge bg-success" id="selected-lottery-name"></span>
                    </div>
                </div>
                <div class="card-body" id="draws-container">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-2">Cargando resultados...</p>
                    </div>
                </div>
            </div>

            <!-- Tarjeta de Predicción -->
            <div class="card border-0 shadow-sm" id="predict-card" style="display: none;">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line text-primary"></i> 
                        Predicción Inteligente
                    </h5>
                    <p class="text-muted small mt-2 mb-0">
                        Basado en análisis de frecuencia, patrones y tendencias
                    </p>
                </div>
                <div class="card-body">
                    <div id="prediction-container" class="text-center">
                        <div class="py-5">
                            <i class="fas fa-chart-line fa-4x text-muted mb-3"></i>
                            <p class="text-muted">Selecciona una lotería para generar predicción</p>
                        </div>
                    </div>
                    <button class="btn btn-primary w-100 mt-3" id="generate-btn" style="display: none;">
                        <i class="fas fa-magic me-2"></i> Generar 20 Números de la Suerte
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .lottery-list {
        max-height: 550px;
        overflow-y: auto;
    }
    
    .lottery-item {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 12px 15px;
        margin: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
        background: white;
    }
    
    .lottery-item:hover {
        transform: translateX(5px);
        border-color: #667eea;
        box-shadow: 0 5px 15px rgba(102,126,234,0.1);
    }
    
    .lottery-item.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: transparent;
        color: white;
    }
    
    .lottery-item.active .text-muted {
        color: rgba(255,255,255,0.8) !important;
    }
    
    .lottery-item.active i {
        color: white !important;
    }
    
    .lottery-name {
        font-weight: 600;
        font-size: 1rem;
    }
    
    .lottery-schedule {
        font-size: 0.75rem;
        margin-top: 4px;
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
        color: #667eea;
    }
    
    .draw-number {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    .draw-ball {
        display: inline-flex;
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 50%;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
        margin: 0 3px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .prediction-ball {
        display: inline-flex;
        width: 65px;
        height: 65px;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border-radius: 50%;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
        margin: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .prediction-ball:hover {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    }
    
    .prediction-ball.copied {
        animation: pulse 0.5s ease;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); background: #28a745; }
        100% { transform: scale(1); }
    }
    
    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 15px;
        margin-bottom: 15px;
    }
    
    .btn-generate {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-generate:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    
    .badge-lottery {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 8px 15px;
        border-radius: 20px;
    }
</style>
@endpush

@push('scripts')
<script>
let currentLotteryId = null;
let currentLotteryName = null;
let token = localStorage.getItem('token');

// Verificar token
if (!token) {
    window.location.href = '/login';
}

// Cargar loterías
function loadLotteries() {
    $.ajax({
        url: '/api/lotteries',
        method: 'GET',
        success: function(response) {
            $('#lotteryCount').text(response.length);
            renderLotteries(response);
        },
        error: function() {
            $('#lottery-list').html('<div class="text-center py-5 text-danger"><i class="fas fa-exclamation-circle fa-3x mb-3"></i><p>Error al cargar loterías</p></div>');
        }
    });
}

// Renderizar lista de loterías
function renderLotteries(lotteries) {
    let html = '<div class="p-3">';
    lotteries.forEach(lottery => {
        html += `
            <div class="lottery-item" data-id="${lottery.id}" data-name="${lottery.name}">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-ticket-alt fa-2x" style="color: #667eea;"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="lottery-name">${lottery.name}</div>
                        <div class="lottery-schedule text-muted">
                            <i class="far fa-clock"></i> ${lottery.draw_schedule || 'Horario no disponible'}
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </div>
        `;
    });
    html += '</div>';
    $('#lottery-list').html(html);
    
    // Evento click en loterías
    $('.lottery-item').click(function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        
        $('.lottery-item').removeClass('active');
        $(this).addClass('active');
        
        currentLotteryId = id;
        currentLotteryName = name;
        
        $('#selected-lottery-name').text(name);
        $('#prediction-lottery-name').text(name);
        
        loadDraws(id);
        $('#predict-card').show();
        $('#generate-btn').show();
    });
}

// Cargar resultados
function loadDraws(lotteryId) {
    $('#draws-card').show();
    $('#draws-container').html(`
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2 text-muted">Analizando resultados...</p>
        </div>
    `);
    
    $.ajax({
        url: `/api/lotteries/${lotteryId}/draws`,
        method: 'GET',
        success: function(response) {
            renderDraws(response);
        },
        error: function() {
            $('#draws-container').html('<div class="text-center py-4 text-danger"><i class="fas fa-exclamation-circle fa-2x"></i><p>Error al cargar resultados</p></div>');
        }
    });
}

// Renderizar resultados
function renderDraws(draws) {
    if (!draws || draws.length === 0) {
        $('#draws-container').html('<div class="text-center py-4 text-muted">No hay resultados disponibles</div>');
        return;
    }
    
    let html = '<div class="timeline">';
    draws.forEach((draw, index) => {
        const digits = draw.results.toString().split('');
        
        html += `
            <div class="draw-item animate__animated animate__fadeInUp" style="animation-delay: ${index * 0.05}s">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="draw-date">
                            <i class="far fa-calendar-alt"></i> ${draw.draw_date}
                        </div>
                        <div class="draw-number">
                            <i class="fas fa-hashtag"></i> Sorteo ${draw.draw_number}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="draw-numbers d-flex justify-content-md-end mt-2 mt-md-0">
                            ${digits.map(d => `<div class="draw-ball">${d}</div>`).join('')}
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
    html += '</div>';
    $('#draws-container').html(html);
}

// Generar predicción
$('#generate-btn').click(function() {
    if (!currentLotteryId) {
        showAlert('Selecciona una lotería primero', 'warning');
        return;
    }
    
    const btn = $(this);
    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span> Analizando patrones...');
    
    $.ajax({
        url: '/api/predict',
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${token}`
        },
        data: JSON.stringify({ lottery_id: currentLotteryId }),
        contentType: 'application/json',
        success: function(response) {
            if (response.success) {
                renderPrediction(response.numbers);
                showAlert('🎯 Predicción generada exitosamente', 'success');
            } else {
                showAlert('Error al generar predicción', 'error');
            }
        },
        error: function(xhr) {
            if (xhr.status === 401) {
                showAlert('Sesión expirada, redirigiendo...', 'error');
                localStorage.removeItem('token');
                setTimeout(() => window.location.href = '/login', 2000);
            } else {
                showAlert('Error al generar predicción', 'error');
            }
        },
        complete: function() {
            btn.prop('disabled', false).html('<i class="fas fa-magic me-2"></i> Generar 20 Números de la Suerte');
        }
    });
});

// Renderizar predicción
function renderPrediction(numbers) {
    let html = `
        <div class="stats-card mb-4 text-center">
            <i class="fas fa-chart-line fa-2x mb-2"></i>
            <h5>Análisis Completado</h5>
            <p class="mb-0 small">Basado en 20 sorteos anteriores</p>
        </div>
        <div class="text-center mb-3">
            <h6 class="text-muted">Tus números de la suerte</h6>
        </div>
        <div class="prediction-grid text-center">
    `;
    
    numbers.forEach((num, index) => {
        html += `
            <div class="prediction-ball" onclick="copyNumber('${num}')" title="Click para copiar">
                ${num}
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success" style="font-size: 8px;">
                    <i class="fas fa-copy"></i>
                </span>
            </div>
        `;
    });
    
    html += `
        </div>
        <div class="alert alert-info mt-4 text-center small">
            <i class="fas fa-info-circle"></i> Click en cualquier número para copiarlo al portapapeles
        </div>
    `;
    
    $('#prediction-container').html(html);
}

// Copiar número al portapapeles
window.copyNumber = function(number) {
    navigator.clipboard.writeText(number).then(() => {
        showAlert(`✅ Número ${number} copiado al portapapeles`, 'success');
        
        // Animación visual
        $('.prediction-ball').each(function() {
            if ($(this).text().trim() === number) {
                $(this).addClass('copied');
                setTimeout(() => $(this).removeClass('copied'), 500);
            }
        });
    });
};

// Refresh button
$('#refreshBtn').click(function() {
    if (currentLotteryId) {
        loadDraws(currentLotteryId);
        showAlert('Resultados actualizados', 'info');
    } else {
        loadLotteries();
        showAlert('Lista de loterías actualizada', 'info');
    }
});

// Inicializar
$(document).ready(function() {
    loadLotteries();
});
</script>
@endpush
@endsection