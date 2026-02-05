@extends('admin.layouts.master')

@section('title', 'Control Pedagógico')

@section('content_header')
    <h1><i class="fas fa-chart-bar"></i> Control Pedagógico</h1>
@stop

@section('content')
<div class="gradebook-container">
    <!-- Selector de Curso -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <label class="font-weight-bold mb-2">
                        <i class="fas fa-book-open text-primary"></i> Seleccionar Curso
                    </label>
                    <select id="cursoSelector" class="form-control form-control-lg">
                        @foreach($cursos as $curso)
                            <option value="{{ $curso->id }}" {{ $curso->id == $cursoActual->id ? 'selected' : '' }}>
                                {{ $curso->titulo }} - {{ $curso->codigo_acceso }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-icon bg-primary">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Estudiantes</span>
                                <span class="stat-value">{{ count($estudiantes) }}</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon bg-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">Aprobados</span>
                                <span class="stat-value">{{ collect($estudiantes)->where('estado', 'passed')->count() }}</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon bg-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-label">En Riesgo</span>
                                <span class="stat-value">{{ collect($estudiantes)->where('estado', 'at_risk')->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Estructura de Evaluación -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-clipboard-list"></i> Estructura de Evaluación</h5>
        </div>
        <div class="card-body">
            <div class="evaluation-structure">
                @foreach($estructuraEvaluacion as $item)
                    <div class="eval-item">
                        <div class="eval-header">
                            <span class="eval-name">
                                <i class="fas fa-{{ $item['tipo'] == 'material' ? 'file-alt' : 'tasks' }}"></i>
                                {{ $item['nombre'] }}
                            </span>
                            <span class="eval-weight badge badge-primary">{{ number_format($item['peso'], 2) }}%</span>
                        </div>
                        @if(!empty($item['componentes']))
                            <div class="eval-components">
                                @foreach($item['componentes'] as $componente)
                                    <span class="component-badge">
                                        <i class="fas fa-{{ $componente['tipo'] == 'tarea' ? 'clipboard-check' : ($componente['tipo'] == 'quiz' ? 'question-circle' : 'file-alt') }}"></i>
                                        {{ Str::limit($componente['nombre'], 20) }} 
                                        <strong class="text-primary">({{ number_format($componente['peso'], 2) }}%)</strong>
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Gradebook Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-table"></i> Libro de Calificaciones</h5>
            <div class="header-actions">
                <button class="btn btn-sm btn-light" onclick="exportarGradebook()">
                    <i class="fas fa-download"></i> Exportar
                </button>
                <button class="btn btn-sm btn-light" onclick="imprimirGradebook()">
                    <i class="fas fa-print"></i> Imprimir
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive gradebook-scroll">
                <table class="table table-hover gradebook-table mb-0">
                    <thead class="thead-light sticky-header">
                        <!-- Fila 1: Nombres de Materiales (agrupados) -->
                        <tr class="material-header-row">
                            <th class="student-col sticky-col" rowspan="2">
                                <i class="fas fa-user"></i> Estudiante
                            </th>
                            @foreach($estructuraEvaluacion as $item)
                                @if($item['tipo'] == 'material')
                                    @if(!empty($item['componentes']))
                                        <th class="material-group-header text-center" colspan="{{ count($item['componentes']) }}">
                                            <div class="material-group-title">
                                                <i class="fas fa-folder-open"></i> {{ $item['nombre'] }}
                                                <span class="badge badge-primary ml-2">{{ number_format($item['peso'], 1) }}%</span>
                                            </div>
                                        </th>
                                    @else
                                        {{-- Material sin actividades --}}
                                        <th class="material-group-header text-center" rowspan="2">
                                            <div class="material-group-title">
                                                <i class="fas fa-folder"></i> {{ $item['nombre'] }}
                                                <span class="badge badge-secondary ml-2">{{ number_format($item['peso'], 1) }}%</span>
                                                <br><small class="text-white-50">Sin actividades</small>
                                            </div>
                                        </th>
                                    @endif
                                @else
                                    <th class="activity-group-header text-center" rowspan="2">
                                        <div class="col-header">
                                            <i class="fas fa-tasks"></i>
                                            <span class="col-title">{{ Str::limit($item['nombre'], 15) }}</span>
                                            <small class="col-subtitle">{{ $item['peso'] }}%</small>
                                        </div>
                                    </th>
                                @endif
                            @endforeach
                            <th class="final-col text-center sticky-right" rowspan="2">
                                <div class="col-header">
                                    <span class="col-title">Promedio</span>
                                    <small class="col-subtitle">Final</small>
                                </div>
                            </th>
                            <th class="status-col text-center sticky-right-2" rowspan="2">
                                <i class="fas fa-flag"></i> Estado
                            </th>
                        </tr>
                        <!-- Fila 2: Nombres de Actividades -->
                        <tr class="activity-header-row">
                            @foreach($estructuraEvaluacion as $item)
                                @if($item['tipo'] == 'material' && !empty($item['componentes']))
                                    @foreach($item['componentes'] as $componente)
                                        <th class="grade-col text-center" title="{{ $item['nombre'] }} - {{ $componente['nombre'] }}">
                                            <div class="col-header">
                                                <i class="fas fa-{{ $componente['tipo'] == 'tarea' ? 'clipboard-check' : ($componente['tipo'] == 'quiz' ? 'question-circle' : 'file-alt') }}"></i>
                                                <span class="col-title">{{ Str::limit($componente['nombre'], 12) }}</span>
                                                <small class="col-subtitle">{{ $componente['peso'] }}%</small>
                                            </div>
                                        </th>
                                    @endforeach
                                @endif
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($estudiantes as $estudiante)
                            <tr class="student-row">
                                <td class="student-col sticky-col">
                                    <div class="student-info">
                                        <div class="student-avatar">
                                            @if($estudiante['avatar'])
                                                <img src="{{ asset('storage/' . $estudiante['avatar']) }}" alt="{{ $estudiante['nombre'] }}">
                                            @else
                                                <div class="avatar-placeholder">
                                                    {{ substr($estudiante['nombre'], 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="student-details">
                                            <span class="student-name">{{ $estudiante['nombre'] }}</span>
                                            <small class="student-email">{{ $estudiante['email'] }}</small>
                                        </div>
                                    </div>
                                </td>
                                @foreach($estructuraEvaluacion as $item)
                                    @if($item['tipo'] == 'material')
                                        @if(!empty($item['componentes']))
                                            {{-- Material con actividades --}}
                                            @php
                                                $califs = $estudiante['calificaciones']['material_' . $item['id']] ?? [];
                                            @endphp
                                            @foreach($item['componentes'] as $componente)
                                                @php
                                                    $key = $componente['tipo'] . '_' . $componente['id'];
                                                    $nota = $califs[$key] ?? 0;
                                                    // Convertir a porcentaje para determinar color
                                                    $porcentaje = ($nota / 5.0) * 100;
                                                @endphp
                                                <td class="grade-col text-center grade-cell-interactive" 
                                                    data-estudiante-id="{{ $estudiante['id'] }}"
                                                    data-actividad-id="{{ $componente['id'] }}"
                                                    data-actividad-tipo="{{ $componente['tipo'] }}"
                                                    data-actividad-nombre="{{ $componente['nombre'] }}"
                                                    data-estudiante-nombre="{{ $estudiante['nombre'] }}"
                                                    onclick="abrirDetalleCalificacion(this)"
                                                    style="cursor: pointer;"
                                                    title="Click para ver detalles y calificar">
                                                    @if($nota > 0)
                                                        <span class="grade-badge grade-{{ $porcentaje >= 60 ? 'good' : ($porcentaje >= 50 ? 'warning' : 'poor') }}">
                                                            {{ number_format($nota, 1) }}/5.0
                                                        </span>
                                                    @else
                                                        <span class="text-muted"><i class="fas fa-edit"></i> -</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                        @else
                                            {{-- Material sin actividades --}}
                                            <td class="grade-col text-center">
                                                <span class="text-muted"><i class="fas fa-minus"></i></span>
                                            </td>
                                        @endif
                                    @else
                                        {{-- Actividad independiente --}}
                                        @php
                                            $nota = $estudiante['calificaciones']['actividad_' . $item['id']] ?? 0;
                                            // Convertir a porcentaje para determinar color
                                            $porcentaje = ($nota / 5.0) * 100;
                                        @endphp
                                        <td class="grade-col text-center grade-cell-interactive"
                                            data-estudiante-id="{{ $estudiante['id'] }}"
                                            data-actividad-id="{{ $item['id'] }}"
                                            data-actividad-tipo="{{ $item['tipo_actividad'] }}"
                                            data-actividad-nombre="{{ $item['nombre'] }}"
                                            data-estudiante-nombre="{{ $estudiante['nombre'] }}"
                                            onclick="abrirDetalleCalificacion(this)"
                                            style="cursor: pointer;"
                                            title="Click para ver detalles y calificar">
                                            @if($nota > 0)
                                                <span class="grade-badge grade-{{ $porcentaje >= 60 ? 'good' : ($porcentaje >= 50 ? 'warning' : 'poor') }}">
                                                    {{ number_format($nota, 1) }}/5.0
                                                </span>
                                            @else
                                                <span class="text-muted"><i class="fas fa-edit"></i> -</span>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                                <td class="final-col text-center sticky-right">
                                    @php
                                        $porcentajeProgreso = ($estudiante['progreso'] / 5.0) * 100;
                                    @endphp
                                    <span class="final-grade grade-{{ $porcentajeProgreso >= 60 ? 'good' : ($porcentajeProgreso >= 50 ? 'warning' : 'poor') }}">
                                        {{ number_format($estudiante['progreso'], 2) }}/5.0
                                    </span>
                                </td>
                                <td class="status-col text-center sticky-right-2">
                                    <span class="status-badge status-{{ $estudiante['estado'] }}">
                                        @if($estudiante['estado'] == 'passed')
                                            <i class="fas fa-check-circle"></i> Aprobado
                                        @elseif($estudiante['estado'] == 'at_risk')
                                            <i class="fas fa-exclamation-triangle"></i> En Riesgo
                                        @else
                                            <i class="fas fa-times-circle"></i> Reprobado
                                        @endif
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="100" class="text-center py-5">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay estudiantes inscritos en este curso</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    /* Variables de colores corporativos */
    :root {
        --corp-primary: #2c4370;
        --corp-primary-dark: #1e2f4d;
        --corp-primary-light: #3d5a8a;
        --corp-success: #27ae60;
        --corp-warning: #f39c12;
        --corp-danger: #e74c3c;
    }

    .gradebook-container {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Card Styles */
    .card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    .card-header.bg-primary {
        background: linear-gradient(135deg, var(--corp-primary), var(--corp-primary-dark)) !important;
        border: none;
        padding: 1.25rem 1.5rem;
    }

    .card-header h5 {
        font-weight: 600;
        font-size: 1.1rem;
    }

    .header-actions .btn {
        margin-left: 0.5rem;
        border-radius: 6px;
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-top: 0.5rem;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .stat-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
    }

    .stat-icon.bg-primary {
        background: linear-gradient(135deg, var(--corp-primary), var(--corp-primary-light));
    }

    .stat-icon.bg-success {
        background: linear-gradient(135deg, #27ae60, #2ecc71);
    }

    .stat-icon.bg-warning {
        background: linear-gradient(135deg, #f39c12, #f1c40f);
    }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 0.75rem;
        color: #6c757d;
        font-weight: 500;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
    }

    /* Evaluation Structure */
    .evaluation-structure {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1rem;
    }

    .eval-item {
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .eval-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .eval-name {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.95rem;
    }

    .eval-name i {
        color: var(--corp-primary);
        margin-right: 0.5rem;
    }

    .eval-weight {
        font-size: 0.875rem;
        padding: 0.25rem 0.75rem;
        background: var(--corp-primary) !important;
        font-weight: 700;
    }

    .eval-components {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .component-badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        color: #495057;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .component-badge i {
        font-size: 0.875rem;
    }

    .component-badge strong {
        font-weight: 700;
        margin-left: 0.25rem;
    }

    /* Gradebook Table */
    .gradebook-scroll {
        overflow-x: auto;
        position: relative;
    }

    .gradebook-table {
        min-width: 100%;
        width: max-content;
        font-size: 0.875rem;
        margin-bottom: 0;
    }

    .gradebook-table thead th {
        background: #f8f9fa;
        border-bottom: 2px solid var(--corp-primary);
        font-weight: 600;
        color: #2c3e50;
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }

    /* Fila de materiales (agrupación) */
    .material-header-row th {
        background: linear-gradient(135deg, var(--corp-primary), var(--corp-primary-dark));
        color: white;
        font-weight: 700;
        border-bottom: 2px solid var(--corp-primary-dark);
    }

    .material-group-header {
        padding: 0.75rem 0.5rem;
    }

    .material-group-title {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 0.95rem;
        font-weight: 700;
    }

    .material-group-title .badge {
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
    }

    /* Fila de actividades */
    .activity-header-row th {
        background: #e9ecef;
        border-bottom: 1px solid #dee2e6;
    }

    .activity-group-header {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
    }

    .sticky-header {
        position: sticky;
        top: 0;
        z-index: 10;
        background: #f8f9fa;
    }

    .material-header-row {
        position: sticky;
        top: 0;
        z-index: 11;
    }

    .activity-header-row {
        position: sticky;
        top: 60px; /* Altura aproximada de la primera fila */
        z-index: 10;
    }

    .sticky-col {
        position: sticky;
        left: 0;
        background: white;
        z-index: 5;
        box-shadow: 2px 0 5px rgba(0,0,0,0.05);
    }

    /* Sticky col en headers debe tener mayor z-index */
    thead .sticky-col {
        z-index: 12;
        background: #f8f9fa;
    }

    .material-header-row .sticky-col {
        background: linear-gradient(135deg, var(--corp-primary), var(--corp-primary-dark));
        z-index: 13;
    }

    .sticky-right {
        position: sticky;
        right: 120px;
        background: white;
        z-index: 5;
        box-shadow: -2px 0 5px rgba(0,0,0,0.05);
    }

    /* Sticky right en headers */
    thead .sticky-right {
        z-index: 12;
        background: #f8f9fa;
    }

    .material-header-row .sticky-right {
        background: linear-gradient(135deg, var(--corp-primary), var(--corp-primary-dark));
        z-index: 13;
    }

    .sticky-right-2 {
        position: sticky;
        right: 0;
        background: white;
        z-index: 5;
        box-shadow: -2px 0 5px rgba(0,0,0,0.05);
    }

    /* Sticky right-2 en headers */
    thead .sticky-right-2 {
        z-index: 12;
        background: #f8f9fa;
    }

    .material-header-row .sticky-right-2 {
        background: linear-gradient(135deg, var(--corp-primary), var(--corp-primary-dark));
        z-index: 13;
    }

    .student-col {
        min-width: 250px;
        max-width: 250px;
    }

    .grade-col {
        min-width: 100px;
        max-width: 100px;
    }

    .final-col {
        min-width: 120px;
        max-width: 120px;
    }

    .status-col {
        min-width: 120px;
        max-width: 120px;
    }

    .col-header {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .col-title {
        font-weight: 600;
        font-size: 0.875rem;
    }

    .col-subtitle {
        font-size: 0.75rem;
        color: #6c757d;
        font-weight: 400;
    }

    /* Student Info */
    .student-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
    }

    .student-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--corp-primary), var(--corp-primary-light));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.125rem;
    }

    .student-details {
        display: flex;
        flex-direction: column;
    }

    .student-name {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.9rem;
    }

    .student-email {
        color: #6c757d;
        font-size: 0.75rem;
    }

    /* Grade Badges */
    .grade-badge {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .grade-good {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .grade-warning {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .grade-poor {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .final-grade {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 1.125rem;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.875rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8125rem;
    }

    .status-passed {
        background: #d4edda;
        color: #155724;
    }

    .status-at_risk {
        background: #fff3cd;
        color: #856404;
    }

    .status-failed {
        background: #f8d7da;
        color: #721c24;
    }

    /* Row Hover */
    .student-row:hover {
        background: #f8f9fa;
    }

    /* Celdas interactivas */
    .grade-cell-interactive:hover {
        background: #e3f2fd !important;
        transform: scale(1.05);
        transition: all 0.2s ease;
    }

    .grade-cell-interactive {
        position: relative;
    }

    .grade-cell-interactive:hover::after {
        content: '\f044'; /* fa-edit */
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        top: 2px;
        right: 2px;
        font-size: 0.7rem;
        color: var(--corp-primary);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .evaluation-structure {
            grid-template-columns: 1fr;
        }
    }
</style>
@stop

@section('js')
<script>
    $(document).ready(function() {
        // Cambiar curso
        $('#cursoSelector').on('change', function() {
            const cursoId = $(this).val();
            window.location.href = '{{ route("academico.control-pedagogico.index") }}?curso_id=' + cursoId;
        });

        console.log('Control Pedagógico cargado correctamente');
    });

    function exportarGradebook() {
        Swal.fire({
            icon: 'info',
            title: 'Exportar Gradebook',
            text: 'Funcionalidad en desarrollo',
            confirmButtonColor: '#2c4370'
        });
    }

    function imprimirGradebook() {
        window.print();
    }

    // Función para abrir modal de detalle de calificación
    function abrirDetalleCalificacion(cell) {
        const estudianteId = $(cell).data('estudiante-id');
        const actividadId = $(cell).data('actividad-id');
        const actividadTipo = $(cell).data('actividad-tipo');
        const actividadNombre = $(cell).data('actividad-nombre');
        const estudianteNombre = $(cell).data('estudiante-nombre');
        const cursoId = $('#cursoSelector').val();

        // Mostrar loading
        Swal.fire({
            title: 'Cargando...',
            text: 'Obteniendo información de la entrega',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Obtener detalles de la entrega
        $.ajax({
            url: '{{ route("academico.control-pedagogico.index") }}',
            method: 'GET',
            data: {
                action: 'get_entrega',
                curso_id: cursoId,
                estudiante_id: estudianteId,
                actividad_id: actividadId
            },
            success: function(response) {
                mostrarModalCalificacion(response, {
                    estudianteId,
                    actividadId,
                    actividadTipo,
                    actividadNombre,
                    estudianteNombre,
                    cursoId
                });
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo obtener la información de la entrega',
                    confirmButtonColor: '#2c4370'
                });
            }
        });
    }

    // Función para mostrar modal de calificación
    function mostrarModalCalificacion(entrega, datos) {
        let contenidoHTML = '';
        
        // Información del estudiante y actividad
        contenidoHTML += `
            <div class="mb-3 text-left">
                <h5><i class="fas fa-user"></i> ${datos.estudianteNombre}</h5>
                <p class="mb-1"><strong>Actividad:</strong> ${datos.actividadNombre}</p>
                <p class="mb-1"><strong>Tipo:</strong> <span class="badge badge-info">${datos.actividadTipo}</span></p>
            </div>
            <hr>
        `;

        // Según el tipo de actividad
        if (datos.actividadTipo === 'quiz' || datos.actividadTipo === 'evaluacion') {
            // Quiz o Evaluación - Mostrar nota automática
            if (entrega && entrega.calificacion) {
                contenidoHTML += `
                    <div class="alert alert-success">
                        <h4><i class="fas fa-check-circle"></i> Calificación Automática</h4>
                        <h2 class="mb-0">${entrega.calificacion} / 5.0</h2>
                        <small>Equivalente a: ${(entrega.calificacion * 20).toFixed(1)}%</small>
                    </div>
                `;
                
                if (entrega.respuestas) {
                    contenidoHTML += `
                        <div class="mt-3">
                            <h6>Respuestas del estudiante:</h6>
                            <div style="max-height: 300px; overflow-y: auto; text-align: left;">
                                ${formatearRespuestas(entrega.respuestas)}
                            </div>
                        </div>
                    `;
                }
            } else {
                contenidoHTML += `
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        El estudiante aún no ha completado esta evaluación
                    </div>
                `;
            }
        } else {
            // Tarea - Permitir calificar manualmente
            if (entrega && entrega.archivo_path) {
                contenidoHTML += `
                    <div class="mb-3">
                        <h6><i class="fas fa-file"></i> Archivo Entregado:</h6>
                        <a href="/storage/${entrega.archivo_path}" target="_blank" class="btn btn-primary btn-sm">
                            <i class="fas fa-download"></i> Descargar Archivo
                        </a>
                    </div>
                `;
            }
            
            if (entrega && entrega.comentario) {
                contenidoHTML += `
                    <div class="mb-3">
                        <h6><i class="fas fa-comment"></i> Comentario del estudiante:</h6>
                        <div class="alert alert-light">${entrega.comentario}</div>
                    </div>
                `;
            }
            
            if (entrega && entrega.fecha_entrega) {
                contenidoHTML += `
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="fas fa-clock"></i> Entregado: ${entrega.fecha_entrega}
                        </small>
                    </div>
                `;
            }
            
            // Formulario de calificación
            const notaActual = entrega && entrega.calificacion ? entrega.calificacion : '';
            contenidoHTML += `
                <hr>
                <div class="form-group text-left">
                    <label for="calificacion"><strong>Calificación (0.0 - 5.0):</strong></label>
                    <input type="number" class="form-control" id="calificacion" 
                           min="0" max="5" step="0.1" value="${notaActual}"
                           placeholder="Ingrese la calificación">
                </div>
                <div class="form-group text-left">
                    <label for="retroalimentacion"><strong>Retroalimentación:</strong></label>
                    <textarea class="form-control" id="retroalimentacion" rows="3"
                              placeholder="Comentarios para el estudiante">${entrega && entrega.retroalimentacion ? entrega.retroalimentacion : ''}</textarea>
                </div>
            `;
            
            if (!entrega || !entrega.archivo_path) {
                contenidoHTML += `
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle"></i>
                        El estudiante aún no ha entregado esta actividad
                    </div>
                `;
            }
        }

        // Mostrar modal
        Swal.fire({
            title: 'Detalle de Calificación',
            html: contenidoHTML,
            width: '700px',
            showCancelButton: datos.actividadTipo !== 'quiz' && datos.actividadTipo !== 'evaluacion',
            confirmButtonText: datos.actividadTipo === 'quiz' || datos.actividadTipo === 'evaluacion' ? 'Cerrar' : '<i class="fas fa-save"></i> Guardar Calificación',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#2c4370',
            preConfirm: () => {
                if (datos.actividadTipo === 'quiz' || datos.actividadTipo === 'evaluacion') {
                    return true;
                }
                
                const calificacion = document.getElementById('calificacion').value;
                const retroalimentacion = document.getElementById('retroalimentacion').value;
                
                if (!calificacion) {
                    Swal.showValidationMessage('Por favor ingrese una calificación');
                    return false;
                }
                
                if (parseFloat(calificacion) < 0 || parseFloat(calificacion) > 5) {
                    Swal.showValidationMessage('La calificación debe estar entre 0.0 y 5.0');
                    return false;
                }
                
                return { calificacion, retroalimentacion };
            }
        }).then((result) => {
            if (result.isConfirmed && result.value !== true) {
                guardarCalificacion(datos, result.value);
            }
        });
    }

    // Función para formatear respuestas de quiz
    function formatearRespuestas(respuestas) {
        let html = '<div class="list-group">';
        
        if (typeof respuestas === 'string') {
            try {
                respuestas = JSON.parse(respuestas);
            } catch (e) {
                return '<p>No se pudieron cargar las respuestas</p>';
            }
        }
        
        if (Array.isArray(respuestas)) {
            respuestas.forEach((resp, index) => {
                const esCorrecta = resp.correcta || resp.is_correct || resp.es_correcta;
                const clase = esCorrecta ? 'list-group-item-success' : 'list-group-item-danger';
                const icono = esCorrecta ? 'fa-check-circle' : 'fa-times-circle';
                const pregunta = resp.pregunta || resp.question || 'N/A';
                const respuesta = resp.respuesta || resp.answer || 'N/A';
                const puntos = resp.puntos || resp.points || 0;
                
                html += `
                    <div class="list-group-item ${clase}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>Pregunta ${index + 1}:</strong> ${pregunta}<br>
                                <strong>Respuesta:</strong> ${respuesta}
                            </div>
                            <div class="text-right">
                                <i class="fas ${icono} fa-2x"></i><br>
                                <small>${puntos} pts</small>
                            </div>
                        </div>
                    </div>
                `;
            });
        } else {
            html += '<p class="text-muted">No hay respuestas disponibles</p>';
        }
        
        html += '</div>';
        return html;
    }

    // Función para guardar calificación
    function guardarCalificacion(datos, valores) {
        Swal.fire({
            title: 'Guardando...',
            text: 'Guardando calificación',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '{{ route("academico.control-pedagogico.guardar-calificacion") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                curso_id: datos.cursoId,
                estudiante_id: datos.estudianteId,
                actividad_id: datos.actividadId,
                calificacion: valores.calificacion,
                retroalimentacion: valores.retroalimentacion
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Guardado!',
                    text: 'La calificación ha sido guardada correctamente',
                    confirmButtonColor: '#2c4370'
                }).then(() => {
                    // Recargar la página para actualizar las calificaciones
                    location.reload();
                });
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo guardar la calificación',
                    confirmButtonColor: '#2c4370'
                });
            }
        });
    }
</script>
@stop
