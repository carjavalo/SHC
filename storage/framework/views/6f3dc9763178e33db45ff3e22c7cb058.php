<!-- Vista de Actividades del Curso -->
<div class="row">
    <div class="col-md-8">
        <!-- Lista de Actividades -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tasks"></i> Actividades del Curso</h3>
            </div>
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $actividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actividad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="actividad-item mb-4 p-3 border rounded">
                        <div class="row">
                            <div class="col-md-1 text-center">
                                <i class="<?php echo e($actividad->tipo_icon); ?> fa-2x text-warning"></i>
                            </div>
                            <div class="col-md-11">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="mb-1"><?php echo e($actividad->titulo); ?></h5>
                                        <?php echo $actividad->tipo_badge; ?>

                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if($esInstructor && ($actividad->tipo === 'quiz' || $actividad->tipo === 'evaluacion')): ?>
                                            <label class="switch mb-0 mr-2" title="<?php echo e(e($actividad->habilitado ? 'Deshabilitar' : 'Habilitar')); ?> <?php echo e(e($actividad->tipo === 'quiz' ? 'quiz' : 'evaluación')); ?>">
                                                <input type="checkbox" class="toggle-actividad" data-actividad-id="<?php echo e($actividad->id); ?>" <?php echo e($actividad->habilitado ? 'checked' : ''); ?>>
                                                <span class="slider round"></span>
                                            </label>
                                        <?php endif; ?>
                                        <span class="badge badge-<?php echo e($actividad->estado_color); ?>"><?php echo e(ucfirst($actividad->estado)); ?></span>
                                    </div>
                                </div>
                                
                                <p class="text-muted mb-2"><?php echo e($actividad->descripcion); ?></p>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt"></i> 
                                            <strong>Apertura:</strong> <?php echo e($actividad->fecha_apertura ? $actividad->fecha_apertura->format('d/m/Y H:i') : 'No definida'); ?>

                                        </small>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-times"></i> 
                                            <strong>Cierre:</strong> <?php echo e($actividad->fecha_cierre ? $actividad->fecha_cierre->format('d/m/Y H:i') : 'No definida'); ?>

                                        </small>
                                    </div>
                                </div>

                                <?php if($actividad->puntos_maximos): ?>
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-star"></i> 
                                            <strong>Puntos máximos:</strong> <?php echo e($actividad->puntos_maximos); ?>

                                        </small>
                                    </div>
                                <?php endif; ?>

                                <?php if($actividad->duracion_minutos): ?>
                                    <div class="mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-clock"></i> 
                                            <strong>Duración:</strong> <?php echo e($actividad->duracion_minutos); ?> minutos
                                        </small>
                                    </div>
                                <?php endif; ?>

                                <!-- Formulario de entrega para estudiantes -->
                                <?php if(!$esInstructor): ?>
                                    <?php if($actividad->tipo === 'quiz' || $actividad->tipo === 'evaluacion'): ?>
                                        <?php
                                            $tipoLabel = $actividad->tipo === 'quiz' ? 'Quiz' : 'Evaluación';
                                            $tipoIcon = $actividad->tipo === 'quiz' ? 'fa-question-circle' : 'fa-clipboard-check';
                                            $bgGradient = $actividad->tipo === 'quiz' ? 'bg-gradient-info' : 'bg-gradient-warning';
                                        ?>
                                        <!-- Vista de Quiz/Evaluación -->
                                        <?php if($actividad->estado === 'abierta' && $actividad->habilitado): ?>
                                            <div class="mt-3 p-4 <?php echo e($bgGradient); ?> rounded shadow-sm">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h5 class="mb-0"><i class="fas <?php echo e($tipoIcon); ?> text-white"></i> <span class="text-white"><?php echo e($tipoLabel); ?> Interactivo</span></h5>
                                                    <?php if($actividad->contenido_json && isset($actividad->contenido_json['duration'])): ?>
                                                        <span class="badge badge-light">
                                                            <i class="fas fa-clock"></i> <?php echo e($actividad->contenido_json['duration']); ?> minutos
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <button type="button" class="btn btn-warning btn-lg btn-block" onclick="iniciarQuiz(<?php echo e($actividad->id); ?>)">
                                                    <i class="fas fa-play-circle"></i> Iniciar <?php echo e($tipoLabel); ?>

                                                </button>
                                            </div>
                                        <?php elseif(!$actividad->habilitado): ?>
                                            <div class="alert alert-warning">
                                                <i class="fas fa-lock"></i> Esta <?php echo e(strtolower($tipoLabel)); ?> no está habilitada por el instructor
                                            </div>
                                        <?php elseif($actividad->estado === 'cerrada'): ?>
                                            <div class="alert alert-danger">
                                                <i class="fas fa-times-circle"></i> Esta <?php echo e(strtolower($tipoLabel)); ?> ya está cerrada
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-info">
                                                <i class="fas fa-clock"></i> Esta <?php echo e(strtolower($tipoLabel)); ?> aún no está disponible
                                            </div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <!-- Formulario estándar para otras actividades -->
                                        <?php if($actividad->estado === 'abierta'): ?>
                                            <div class="mt-3 p-3 bg-light rounded">
                                                <h6><i class="fas fa-upload"></i> Entregar Actividad</h6>
                                                <form class="form-entrega-actividad" data-actividad-id="<?php echo e($actividad->id); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="form-group">
                                                        <label for="contenido_<?php echo e($actividad->id); ?>">Respuesta/Contenido:</label>
                                                        <textarea class="form-control" id="contenido_<?php echo e($actividad->id); ?>" name="contenido" rows="4" placeholder="Escribe tu respuesta aquí..."></textarea>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="archivo_<?php echo e($actividad->id); ?>">Archivo adjunto (opcional):</label>
                                                        <input type="file" class="form-control-file" id="archivo_<?php echo e($actividad->id); ?>" name="archivo">
                                                        <small class="form-text text-muted">Formatos permitidos: PDF, DOC, DOCX, JPG, PNG. Tamaño máximo: 5MB</small>
                                                    </div>
                                                    
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-paper-plane"></i> Entregar Actividad
                                                    </button>
                                                </form>
                                            </div>
                                        <?php elseif($actividad->estado === 'cerrada'): ?>
                                            <div class="alert alert-warning">
                                                <i class="fas fa-exclamation-triangle"></i> Esta actividad ya está cerrada
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-info">
                                                <i class="fas fa-clock"></i> Esta actividad aún no está disponible
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                                
                <?php if($esInstructor): ?>
                    <div class="mt-3">
                        <a href="<?php echo e(route('capacitaciones.cursos.classroom.actividades.entregas', [$curso->id, $actividad->id])); ?>" 
                           class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> Ver Entregas
                        </a>
                        <button type="button" class="btn btn-info btn-sm btn-editar-actividad" 
                                data-actividad-id="<?php echo e($actividad->id); ?>">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                        <button type="button" class="btn btn-danger btn-sm btn-eliminar-actividad" 
                                data-actividad-id="<?php echo e($actividad->id); ?>"
                                data-actividad-titulo="<?php echo e(e($actividad->titulo)); ?>">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </div>
                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-4">
                        <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No hay actividades disponibles</h5>
                        <p class="text-muted">Las actividades aparecerán aquí cuando el instructor las publique.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Estadísticas de Actividades -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-bar"></i> Estadísticas</h3>
            </div>
            <div class="card-body">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-tasks"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Actividades</span>
                        <span class="info-box-number"><?php echo e($actividades->count()); ?></span>
                    </div>
                </div>

                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Abiertas</span>
                        <span class="info-box-number"><?php echo e($actividades->where('estado', 'abierta')->count()); ?></span>
                    </div>
                </div>

                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pendientes</span>
                        <span class="info-box-number"><?php echo e($actividades->where('estado', 'pendiente')->count()); ?></span>
                    </div>
                </div>

                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="fas fa-times"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Cerradas</span>
                        <span class="info-box-number"><?php echo e($actividades->where('estado', 'cerrada')->count()); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Próximas fechas límite -->
        <?php if(!$esInstructor): ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Próximas Fechas Límite</h3>
                </div>
                <div class="card-body">
                    <?php
                        $proximasActividades = $actividades->where('estado', 'abierta')
                            ->where('fecha_cierre', '>', now())
                            ->sortBy('fecha_cierre')
                            ->take(3);
                    ?>
                    
                    <?php $__empty_1 = true; $__currentLoopData = $proximasActividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actividad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <strong><?php echo e(Str::limit($actividad->titulo, 20)); ?></strong><br>
                                <small class="text-muted"><?php echo e($actividad->fecha_cierre->format('d/m/Y H:i')); ?></small>
                            </div>
                            <span class="badge badge-warning">
                                <?php echo e($actividad->fecha_cierre->diffForHumans()); ?>

                            </span>
                        </div>
                        <?php if(!$loop->last): ?><hr><?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted text-center">
                            <i class="fas fa-calendar-check"></i><br>
                            No hay fechas límite próximas
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
/* Toggle Switch Styles */
.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
}

input:checked + .slider {
    background-color: #28a745;
}

input:checked + .slider:before {
    transform: translateX(26px);
}

.slider.round {
    border-radius: 24px;
}

.slider.round:before {
    border-radius: 50%;
}

/* Quiz Modal Styles */
.quiz-question {
    background: #f8f9fa;
    border-left: 4px solid #007bff;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
}

.quiz-option {
    padding: 12px;
    margin: 8px 0;
    background: white;
    border: 2px solid #dee2e6;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.quiz-option:hover {
    background: #e9ecef;
    border-color: #007bff;
}

.quiz-option input[type="radio"] {
    margin-right: 10px;
}

.quiz-option.selected {
    background: #cfe2ff;
    border-color: #007bff;
}

.quiz-timer {
    font-size: 24px;
    font-weight: bold;
    color: #dc3545;
}

.quiz-result-correct {
    background: #d4edda;
    border-left-color: #28a745;
}

.quiz-result-incorrect {
    background: #f8d7da;
    border-left-color: #dc3545;
}
</style>

<script>
var quizData = {};
var quizTimer = null;
var tiempoInicio = null;

$(document).ready(function() {
    // Manejar toggle de actividades
    $('.toggle-actividad').on('change', function() {
        const checkbox = $(this);
        const actividadId = checkbox.data('actividad-id');
        const habilitado = checkbox.is(':checked');
        
        $.ajax({
            url: `/capacitaciones/cursos/<?php echo e($curso->id); ?>/classroom/actividades/${actividadId}/toggle`,
            type: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>'
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    checkbox.prop('checked', !habilitado);
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function(xhr) {
                checkbox.prop('checked', !habilitado);
                const message = xhr.responseJSON?.message || 'Error al cambiar estado';
                Swal.fire('Error', message, 'error');
            }
        });
    });

    // Manejar envío de actividades
    $('.form-entrega-actividad').on('submit', function(e) {
        e.preventDefault();
        
        const form = $(this);
        const actividadId = form.data('actividad-id');
        const formData = new FormData(this);
        
        // Deshabilitar el botón de envío
        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Enviando...');
        
        $.ajax({
            url: `/capacitaciones/cursos/<?php echo e($curso->id); ?>/classroom/actividades/${actividadId}/entregar`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    Swal.fire('¡Éxito!', response.message, 'success').then(() => {
                        // Recargar la pestaña de actividades
                        loadTabContent('actividades', '#actividades');
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || 'Error al entregar la actividad';
                Swal.fire('Error', message, 'error');
            },
            complete: function() {
                // Rehabilitar el botón
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });
    
    // Manejar botón editar actividad
    $(document).on('click', '.btn-editar-actividad', function(e) {
        e.preventDefault();
        var actividadId = $(this).data('actividad-id');
        
        console.log('=== EDITAR ACTIVIDAD ===');
        console.log('Actividad ID:', actividadId);
        
        // Mostrar loading
        Swal.fire({
            title: 'Cargando...',
            html: '<i class="fas fa-spinner fa-spin fa-2x"></i>',
            showConfirmButton: false,
            allowOutsideClick: false
        });
        
        // Obtener datos de la actividad mediante AJAX
        $.ajax({
            url: '/capacitaciones/cursos/<?php echo e($curso->id); ?>/classroom/actividades/' + actividadId + '/obtener',
            type: 'GET',
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                Swal.close();
                if (response.success && response.actividad) {
                    console.log('Abriendo modal de edición...');
                    console.log('Datos de actividad:', response.actividad);
                    // Abrir modal de edición completo
                    editarActividadCompleta(actividadId, response.actividad);
                } else {
                    console.error('Error: No se pudo cargar la actividad');
                    Swal.fire('Error', 'No se pudo cargar la actividad', 'error');
                }
            },
            error: function(xhr) {
                console.error('Error AJAX:', xhr);
                Swal.fire('Error', 'Error al cargar la actividad: ' + (xhr.responseJSON?.message || xhr.statusText), 'error');
            }
        });
    });
    
    // Manejar botón eliminar actividad
    $(document).on('click', '.btn-eliminar-actividad', function() {
        const actividadId = $(this).data('actividad-id');
        const actividadTitulo = $(this).data('actividad-titulo');
        
        Swal.fire({
            title: '¿Estás seguro?',
            html: `¿Deseas eliminar la actividad <strong>"${actividadTitulo}"</strong>?<br><br>
                   <small class="text-danger">Esta acción no se puede deshacer.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
            cancelButtonText: '<i class="fas fa-times"></i> Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/capacitaciones/cursos/<?php echo e($curso->id); ?>/classroom/actividades/${actividadId}`,
                    type: 'DELETE',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Eliminado!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                loadTabContent('actividades', '#actividades');
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        const message = xhr.responseJSON?.message || 'Error al eliminar la actividad';
                        Swal.fire('Error', message, 'error');
                    }
                });
            }
        });
    });
});

// Función para iniciar el quiz
function iniciarQuiz(actividadId) {
    // Obtener datos del quiz
    $.ajax({
        url: `/capacitaciones/cursos/<?php echo e($curso->id); ?>/classroom/actividades`,
        type: 'GET',
        success: function(html) {
            // Parsear el HTML para obtener los datos del quiz
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Buscar la actividad específica mediante AJAX
            $.ajax({
                url: '/capacitaciones/cursos/<?php echo e($curso->id); ?>/classroom/actividades/' + actividadId + '/datos-quiz',
                type: 'GET',
                async: false,
                success: function(response) {
                    if (response.success && response.actividad) {
                        actividad = response.actividad;
                    }
                }
            });
            
            if (!actividad) {
                Swal.fire('Error', 'No se encontraron las preguntas del quiz', 'error');
                return;
            }
            
            mostrarModalQuiz(actividadId, actividad);
        },
        error: function() {
            Swal.fire('Error', 'No se pudo cargar el quiz', 'error');
        }
    });
}

// Mostrar modal del quiz
function mostrarModalQuiz(actividadId, actividad) {
    const quizData = actividad.contenido_json;
    const preguntas = quizData.questions || [];
    const duracion = quizData.duration || 30;
    
    if (preguntas.length === 0) {
        Swal.fire('Error', 'Este quiz no tiene preguntas configuradas', 'error');
        return;
    }
    
    let preguntasHTML = '';
    preguntas.forEach((pregunta, index) => {
        const esMultiple = pregunta.isMultipleChoice || (pregunta.correctAnswers && pregunta.correctAnswers.length > 1);
        const inputType = esMultiple ? 'checkbox' : 'radio';
        const indicadorTipo = esMultiple ? '<span class="badge badge-info ml-2">Múltiple respuesta</span>' : '';
        
        preguntasHTML += `
            <div class="quiz-question">
                <h5><span class="badge badge-primary">${index + 1}</span> ${pregunta.text} ${indicadorTipo}</h5>
                <small class="text-muted"><i class="fas fa-star"></i> ${pregunta.points} puntos</small>
                ${esMultiple ? '<small class="text-info d-block"><i class="fas fa-info-circle"></i> Selecciona todas las respuestas correctas</small>' : ''}
                <div class="mt-3">
        `;
        
        Object.keys(pregunta.options).forEach(opcion => {
            preguntasHTML += `
                <label class="quiz-option">
                    <input type="${inputType}" name="pregunta_${pregunta.id}" value="${opcion}">
                    <strong>${opcion})</strong> ${pregunta.options[opcion]}
                </label>
            `;
        });
        
        preguntasHTML += `
                </div>
            </div>
        `;
    });
    
    Swal.fire({
        title: '<i class="fas fa-graduation-cap"></i> ' + actividad.titulo,
        html: `
            <div class="text-center mb-3">
                <div class="quiz-timer" id="quiz-timer">
                    <i class="fas fa-clock"></i> <span id="tiempo-restante">${duracion}:00</span>
                </div>
                <small class="text-muted">Total de puntos: ${quizData.totalPoints}</small>
            </div>
            <div id="quiz-preguntas" style="max-height: 400px; overflow-y: auto; text-align: left;">
                ${preguntasHTML}
            </div>
        `,
        width: '800px',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-check-circle"></i> Enviar Respuestas',
        cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#dc3545',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            iniciarTemporizador(duracion, actividadId, actividad);
            
            // Manejar selección de opciones para radio buttons
            $('.quiz-option input[type="radio"]').on('change', function() {
                $(this).closest('.quiz-question').find('.quiz-option').removeClass('selected');
                $(this).closest('.quiz-option').addClass('selected');
            });
            
            // Manejar selección de opciones para checkboxes
            $('.quiz-option input[type="checkbox"]').on('change', function() {
                if ($(this).is(':checked')) {
                    $(this).closest('.quiz-option').addClass('selected');
                } else {
                    $(this).closest('.quiz-option').removeClass('selected');
                }
            });
        },
        willClose: () => {
            if (quizTimer) {
                clearInterval(quizTimer);
            }
        },
        preConfirm: () => {
            const respuestas = {};
            let todasRespondidas = true;
            
            preguntas.forEach(pregunta => {
                const esMultiple = pregunta.isMultipleChoice || (pregunta.correctAnswers && pregunta.correctAnswers.length > 1);
                
                if (esMultiple) {
                    // Para preguntas de múltiple respuesta, obtener todos los checkboxes marcados
                    const respuestasSeleccionadas = [];
                    $(`input[name="pregunta_${pregunta.id}"]:checked`).each(function() {
                        respuestasSeleccionadas.push($(this).val());
                    });
                    
                    if (respuestasSeleccionadas.length > 0) {
                        respuestas[pregunta.id] = respuestasSeleccionadas;
                    } else {
                        todasRespondidas = false;
                    }
                } else {
                    // Para preguntas de respuesta única
                    const respuesta = $(`input[name="pregunta_${pregunta.id}"]:checked`).val();
                    if (respuesta) {
                        respuestas[pregunta.id] = respuesta;
                    } else {
                        todasRespondidas = false;
                    }
                }
            });
            
            if (!todasRespondidas) {
                Swal.showValidationMessage('Por favor responde todas las preguntas');
                return false;
            }
            
            return respuestas;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            enviarRespuestasQuiz(actividadId, result.value);
        }
    });
}

// Iniciar temporizador del quiz
function iniciarTemporizador(duracionMinutos, actividadId, actividad) {
    tiempoInicio = Date.now();
    let tiempoRestante = duracionMinutos * 60; // segundos
    
    quizTimer = setInterval(() => {
        tiempoRestante--;
        
        const minutos = Math.floor(tiempoRestante / 60);
        const segundos = tiempoRestante % 60;
        
        $('#tiempo-restante').text(`${minutos}:${segundos.toString().padStart(2, '0')}`);
        
        if (tiempoRestante <= 60) {
            $('#tiempo-restante').parent().css('color', '#dc3545');
        }
        
        if (tiempoRestante <= 0) {
            clearInterval(quizTimer);
            Swal.close();
            Swal.fire({
                icon: 'warning',
                title: 'Tiempo Agotado',
                text: 'El tiempo del quiz ha terminado. Se enviarán las respuestas marcadas.',
                confirmButtonText: 'Entendido'
            }).then(() => {
                const respuestas = {};
                const preguntas = actividad.contenido_json.questions || [];
                preguntas.forEach(pregunta => {
                    const respuesta = $(`input[name="pregunta_${pregunta.id}"]:checked`).val();
                    if (respuesta) {
                        respuestas[pregunta.id] = respuesta;
                    }
                });
                enviarRespuestasQuiz(actividadId, respuestas);
            });
        }
    }, 1000);
}

// Enviar respuestas del quiz
function enviarRespuestasQuiz(actividadId, respuestas) {
    const tiempoTranscurrido = Math.floor((Date.now() - tiempoInicio) / 1000); // segundos
    
    Swal.fire({
        title: 'Enviando respuestas...',
        html: '<i class="fas fa-spinner fa-spin fa-3x"></i>',
        showConfirmButton: false,
        allowOutsideClick: false
    });
    
    $.ajax({
        url: `/capacitaciones/cursos/<?php echo e($curso->id); ?>/classroom/actividades/${actividadId}/resolver-quiz`,
        type: 'POST',
        data: {
            _token: '<?php echo e(csrf_token()); ?>',
            respuestas: respuestas,
            tiempo_transcurrido: tiempoTranscurrido
        },
        success: function(response) {
            if (response.success) {
                mostrarResultados(response);
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function(xhr) {
            const message = xhr.responseJSON?.message || 'Error al enviar las respuestas';
            Swal.fire('Error', message, 'error');
        }
    });
}

// Mostrar resultados del quiz
function mostrarResultados(response) {
    const resultados = response.resultados || [];
    const porcentaje = response.porcentaje || 0;
    const aprobado = response.aprobado || false;
    
    let resultadosHTML = '';
    resultados.forEach((resultado, index) => {
        const claseResultado = resultado.es_correcta ? 'quiz-result-correct' : 'quiz-result-incorrect';
        const iconoResultado = resultado.es_correcta ? '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-times-circle text-danger"></i>';
        
        resultadosHTML += `
            <div class="quiz-question ${claseResultado}">
                <div class="d-flex justify-content-between align-items-start">
                    <h6><span class="badge badge-secondary">${index + 1}</span> ${resultado.pregunta}</h6>
                    ${iconoResultado}
                </div>
                <p class="mb-1"><strong>Tu respuesta:</strong> ${resultado.respuesta_estudiante || 'Sin respuesta'}</p>
                ${!resultado.es_correcta ? `<p class="mb-1"><strong>Respuesta correcta:</strong> ${resultado.respuesta_correcta}</p>` : ''}
                <p class="mb-0"><strong>Puntos:</strong> ${resultado.puntos}</p>
            </div>
        `;
    });
    
    Swal.fire({
        icon: aprobado ? 'success' : 'warning',
        title: aprobado ? '¡Felicitaciones!' : 'Quiz Completado',
        html: `
            <div class="text-center mb-4">
                <h2 class="display-4">${porcentaje}%</h2>
                <p class="lead">${response.puntos_obtenidos} de ${response.puntos_maximos} puntos</p>
                <span class="badge badge-${aprobado ? 'success' : 'warning'} badge-pill px-3 py-2">
                    ${aprobado ? 'APROBADO' : 'NO APROBADO'}
                </span>
            </div>
            <div style="max-height: 400px; overflow-y: auto; text-align: left;">
                <h5 class="mb-3">Revisión de Respuestas:</h5>
                ${resultadosHTML}
            </div>
        `,
        width: '800px',
        confirmButtonText: '<i class="fas fa-check"></i> Entendido',
        confirmButtonColor: '#007bff'
    }).then(() => {
        // Recargar la pestaña de actividades
        loadTabContent('actividades', '#actividades');
    });
}

// Variables globales para edición de actividades
window.editQuestions = [];
window.editQuestionCounter = 0;
window.editOptionCounters = {};
window.optionLetters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];

// Materiales y actividades disponibles - se cargarán vía AJAX cuando se necesiten
let materialesDisponibles = [];
let actividadesDisponibles = [];

// Cargar datos cuando se necesiten
function cargarDatosDisponibles() {
    if (materialesDisponibles.length === 0 || actividadesDisponibles.length === 0) {
        $.ajax({
            url: '/capacitaciones/cursos/<?php echo e($curso->id); ?>/classroom/datos-disponibles',
            type: 'GET',
            async: false,
            success: function(response) {
                if (response.success) {
                    materialesDisponibles = response.materiales || [];
                    actividadesDisponibles = response.actividades || [];
                }
            }
        });
    }
}

// Función para editar actividad completa
function editarActividadCompleta(actividadId, actividad) {
    console.log('=== FUNCIÓN editarActividadCompleta ===');
    console.log('actividadId:', actividadId);
    console.log('actividad:', actividad);
    
    // Validar que actividad existe y tiene las propiedades necesarias
    if (!actividad || typeof actividad !== 'object') {
        console.error('Error: actividad es undefined o no es un objeto válido');
        Swal.fire('Error', 'No se pudieron cargar los datos de la actividad', 'error');
        return;
    }
    
    if (!actividad.tipo) {
        console.error('Error: actividad.tipo no está definido');
        Swal.fire('Error', 'Datos de actividad incompletos', 'error');
        return;
    }
    
    const tipo = actividad.tipo;
    const requierePreguntas = tipo === 'quiz' || tipo === 'evaluacion';
    
    console.log('Tipo:', tipo);
    console.log('Requiere preguntas:', requierePreguntas);
    
    const typeLabels = {
        tarea: 'Tarea',
        quiz: 'Quiz',
        evaluacion: 'Evaluación',
        proyecto: 'Proyecto'
    };
    const tipoLabel = typeLabels[tipo] || 'Actividad';
    
    // Obtener actividades prerrequisito actuales
    let prerequisiteActivityIds = [];
    if (actividad.prerequisite_activity_ids) {
        if (typeof actividad.prerequisite_activity_ids === 'string') {
            try {
                prerequisiteActivityIds = JSON.parse(actividad.prerequisite_activity_ids);
            } catch(e) {
                prerequisiteActivityIds = [];
            }
        } else if (Array.isArray(actividad.prerequisite_activity_ids)) {
            prerequisiteActivityIds = actividad.prerequisite_activity_ids;
        }
    }
    
    // Generar checkboxes de actividades prerrequisito (excluyendo la actividad actual)
    const otrasActividades = actividadesDisponibles.filter(a => a.id !== actividadId);
    let prereqHTML = '';
    if (otrasActividades.length > 0) {
        const typeIcons = { tarea: '📝', quiz: '❓', evaluacion: '📋', proyecto: '📊' };
        prereqHTML = `
            <hr class="my-3">
            <h6 class="text-info"><i class="fas fa-link"></i> Prerrequisitos de Actividades</h6>
            <div class="form-group">
                <small class="text-muted d-block mb-2">Selecciona las actividades que deben completarse antes de esta:</small>
                <div class="row">
        `;
        otrasActividades.forEach(act => {
            const isChecked = prerequisiteActivityIds.includes(act.id) ? 'checked' : '';
            const icon = typeIcons[act.tipo] || '📝';
            const actTitulo = (act.titulo || 'Sin título').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
            prereqHTML += `
                <div class="col-md-6">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input edit-prereq-checkbox" 
                               id="edit-prereq-${act.id}" value="${act.id}" ${isChecked}>
                        <label class="custom-control-label" for="edit-prereq-${act.id}">
                            ${icon} ${actTitulo}
                        </label>
                    </div>
                </div>
            `;
        });
        prereqHTML += '</div></div>';
    }
    
    // Cargar datos disponibles si no están cargados
    cargarDatosDisponibles();
    
    // Generar opciones de materiales para el select
    let materialesOptions = '<option value="">-- Seleccionar material --</option>';
    materialesDisponibles.forEach(mat => {
        const selected = actividad.material_id === mat.id ? 'selected' : '';
        materialesOptions += `<option value="${mat.id}" ${selected} data-porcentaje="${mat.porcentaje_curso || 0}">${mat.titulo} (${mat.porcentaje_curso || 0}% del curso)</option>`;
    });
    
    // Sección de configuración de calificación
    const gradingSection = `
        <hr class="my-3">
        <div class="card bg-light mb-3">
            <div class="card-header py-2">
                <strong><i class="fas fa-star text-warning"></i> Configuración de Calificación</strong>
            </div>
            <div class="card-body py-2">
                <div class="form-group mb-3">
                    <label for="edit-actividad-material"><i class="fas fa-book text-info"></i> Material al que pertenece *</label>
                    <select class="form-control" id="edit-actividad-material" onchange="updateEditPorcentajeDisponible()">
                        ${materialesOptions}
                    </select>
                    <small class="form-text text-muted">Selecciona el material al que pertenece esta actividad</small>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="edit-actividad-porcentaje">Porcentaje del Material (%) *</label>
                            <input type="number" class="form-control" id="edit-actividad-porcentaje" 
                                   min="0" max="100" step="0.1" value="${actividad.porcentaje_curso || 0}" placeholder="0">
                            <small class="form-text text-muted" id="edit-porcentaje-info">
                                El porcentaje es relativo al material (0-100%)
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="edit-actividad-nota-minima">Nota Mínima Aprobación *</label>
                            <input type="number" class="form-control" id="edit-actividad-nota-minima" 
                                   min="0" max="5" step="0.1" value="${actividad.nota_minima_aprobacion || 3.0}" placeholder="3.0">
                            <small class="form-text text-muted">Escala: 0.0 - 5.0</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Campos específicos para Quiz y Evaluación
    const quizFields = requierePreguntas ? `
        <hr class="my-4">
        <h5 class="text-primary"><i class="fas fa-list-ol"></i> Preguntas de la ${tipoLabel}</h5>
        <div class="alert alert-info py-2">
            <i class="fas fa-info-circle"></i> <strong>Nota máxima: 5.0</strong> - La suma de puntos de todas las preguntas no puede exceder 5.0
        </div>
        <div class="form-group">
            <label>Puntos totales asignados:</label>
            <div class="progress" style="height: 25px;">
                <div class="progress-bar bg-success" role="progressbar" id="edit-quiz-points-progress" style="width: 0%">0 / 5.0</div>
            </div>
        </div>
        <div class="form-group">
            <label for="edit-actividad-duration">Duración (minutos)</label>
            <input type="number" class="form-control" id="edit-actividad-duration" min="5" max="180" 
                   value="${actividad.contenido_json?.duration || 30}">
            <small class="form-text text-muted">Tiempo máximo para completar</small>
        </div>
        <div id="edit-actividad-questions-container">
            <!-- Las preguntas se cargarán aquí -->
        </div>
        <button type="button" class="btn btn-outline-primary btn-sm btn-block" onclick="addEditQuestion()" id="add-edit-question-btn">
            <i class="fas fa-plus"></i> Agregar Pregunta
        </button>
        <small class="form-text text-muted text-center d-block mt-2">
            <i class="fas fa-info-circle"></i> Cada pregunta puede tener de 2 a 10 opciones. Marca las respuestas correctas.
        </small>
    ` : '';
    
    // Formatear fechas para datetime-local
    let fechaApertura = '';
    let fechaCierre = '';
    if (actividad.fecha_apertura) {
        try {
            fechaApertura = actividad.fecha_apertura.substring(0, 16);
        } catch(e) {
            fechaApertura = '';
        }
    }
    if (actividad.fecha_cierre) {
        try {
            fechaCierre = actividad.fecha_cierre.substring(0, 16);
        } catch(e) {
            fechaCierre = '';
        }
    }
    
    // Escapar valores para evitar problemas con caracteres especiales
    const tituloEscapado = (actividad.titulo || '').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    const descripcionEscapada = (actividad.descripcion || '').replace(/"/g, '&quot;').replace(/'/g, '&#39;').replace(/\n/g, '&#10;');
    const instruccionesEscapadas = (actividad.instrucciones || '').replace(/"/g, '&quot;').replace(/'/g, '&#39;').replace(/\n/g, '&#10;');
    
    console.log('Fechas formateadas:', {fechaApertura, fechaCierre});
    console.log('Valores escapados:', {tituloEscapado, descripcionEscapada, instruccionesEscapadas});
    
    Swal.fire({
        title: `<i class="fas fa-edit"></i> Modificar Actividad: ${tipoLabel}`,
        html: `
            <div class="text-left" style="max-height: 600px; overflow-y: auto;">
                <input type="hidden" id="edit-actividad-id" value="${actividadId}">
                <input type="hidden" id="edit-actividad-tipo" value="${tipo}">
                <div class="form-group">
                    <label for="edit-actividad-titulo">Título *</label>
                    <input type="text" class="form-control" id="edit-actividad-titulo" value="${tituloEscapado}" placeholder="Título de la actividad">
                </div>
                <div class="form-group">
                    <label for="edit-actividad-descripcion">Descripción</label>
                    <textarea class="form-control" id="edit-actividad-descripcion" rows="3" placeholder="Descripción de la actividad">${descripcionEscapada}</textarea>
                </div>
                <div class="form-group">
                    <label for="edit-actividad-instrucciones">Instrucciones</label>
                    <textarea class="form-control" id="edit-actividad-instrucciones" rows="3" placeholder="Instrucciones para los estudiantes">${instruccionesEscapadas}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edit-actividad-fecha-apertura">Fecha de Apertura</label>
                            <input type="datetime-local" class="form-control" id="edit-actividad-fecha-apertura" value="${fechaApertura}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edit-actividad-fecha-cierre">Fecha de Cierre</label>
                            <input type="datetime-local" class="form-control" id="edit-actividad-fecha-cierre" value="${fechaCierre}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edit-actividad-puntos">Puntos Máximos</label>
                            <input type="number" class="form-control" id="edit-actividad-puntos" min="1" max="1000" value="${actividad.puntos_maximos || 100}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edit-actividad-intentos">Intentos Permitidos</label>
                            <input type="number" class="form-control" id="edit-actividad-intentos" min="1" max="10" value="${actividad.intentos_permitidos || 1}">
                        </div>
                    </div>
                </div>
                ${gradingSection}
                ${prereqHTML}
                ${quizFields}
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-save"></i> Guardar Cambios',
        cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
        confirmButtonColor: '#28a745',
        width: '900px',
        didOpen: () => {
            window.editQuestions = [];
            window.editQuestionCounter = 0;
            window.editOptionCounters = {};
            
            // Función para actualizar puntos disponibles del quiz
            window.calcularPuntosTotalesQuizEdit = function() {
                let total = 0;
                document.querySelectorAll('.edit-question-points-input').forEach(input => {
                    total += parseFloat(input.value) || 0;
                });
                return total;
            };
            
            window.actualizarPuntosDisponiblesQuizEdit = function() {
                const puntosUsados = calcularPuntosTotalesQuizEdit();
                const progressBar = document.getElementById('edit-quiz-points-progress');
                if (progressBar) {
                    const porcentaje = Math.min(100, (puntosUsados / 5) * 100);
                    progressBar.style.width = porcentaje + '%';
                    progressBar.textContent = puntosUsados.toFixed(1) + ' / 5.0';
                    progressBar.className = 'progress-bar ' + (puntosUsados > 5 ? 'bg-danger' : 'bg-success');
                }
                
                // Actualizar botón de agregar pregunta
                const addBtn = document.getElementById('add-edit-question-btn');
                if (addBtn) {
                    addBtn.disabled = puntosUsados >= 5;
                }
            };
            
            // Función para actualizar porcentaje disponible
            window.updateEditPorcentajeDisponible = function() {
                const materialSelect = document.getElementById('edit-actividad-material');
                const infoText = document.getElementById('edit-porcentaje-info');
                
                if (!materialSelect || !materialSelect.value) {
                    infoText.innerHTML = 'Selecciona un material para ver el porcentaje disponible';
                    return;
                }
                
                const selectedOption = materialSelect.options[materialSelect.selectedIndex];
                const porcentajeMaterial = parseFloat(selectedOption.dataset.porcentaje) || 0;
                infoText.innerHTML = 'El porcentaje es relativo al material (el material representa ' + porcentajeMaterial.toFixed(1) + '% del curso)';
            };
            
            // Inicializar
            updateEditPorcentajeDisponible();
            
            if (requierePreguntas && actividad.contenido_json && actividad.contenido_json.questions) {
                actividad.contenido_json.questions.forEach(question => {
                    loadEditQuestion(question);
                });
                setTimeout(() => actualizarPuntosDisponiblesQuizEdit(), 100);
            }
        },
        preConfirm: () => {
            const titulo = document.getElementById('edit-actividad-titulo').value;
            const descripcion = document.getElementById('edit-actividad-descripcion').value;
            const instrucciones = document.getElementById('edit-actividad-instrucciones').value;
            const fechaApertura = document.getElementById('edit-actividad-fecha-apertura').value;
            const fechaCierre = document.getElementById('edit-actividad-fecha-cierre').value;
            const puntos = document.getElementById('edit-actividad-puntos').value;
            const intentos = document.getElementById('edit-actividad-intentos').value;
            
            // Datos de calificación
            const materialId = document.getElementById('edit-actividad-material').value;
            const porcentajeMaterial = parseFloat(document.getElementById('edit-actividad-porcentaje').value) || 0;
            const notaMinimaAprobacion = parseFloat(document.getElementById('edit-actividad-nota-minima').value) || 3.0;
            
            // Prerrequisitos de actividades
            const prerequisiteActivities = [];
            document.querySelectorAll('.edit-prereq-checkbox:checked').forEach(cb => {
                prerequisiteActivities.push(parseInt(cb.value));
            });

            if (!titulo.trim()) {
                Swal.showValidationMessage('El título es requerido');
                return false;
            }
            
            // Validación de material
            if (!materialId) {
                Swal.showValidationMessage('Debes seleccionar un material al que pertenece la actividad');
                return false;
            }
            
            // Validación de porcentaje
            if (porcentajeMaterial < 0 || porcentajeMaterial > 100) {
                Swal.showValidationMessage('El porcentaje debe estar entre 0 y 100%');
                return false;
            }
            
            // Validación de nota mínima
            if (notaMinimaAprobacion < 0 || notaMinimaAprobacion > 5) {
                Swal.showValidationMessage('La nota mínima debe estar entre 0.0 y 5.0');
                return false;
            }

            let quizData = null;
            if (requierePreguntas) {
                const duration = document.getElementById('edit-actividad-duration').value;
                
                if (window.editQuestions.length < 1) {
                    Swal.showValidationMessage('Debes crear al menos 1 pregunta');
                    return false;
                }
                
                const questions = [];
                let totalQuestionPoints = 0;
                
                for (const questionId of window.editQuestions) {
                    const questionText = document.getElementById(`edit-question-text-${questionId}`).value;
                    const questionPoints = parseFloat(document.getElementById(`edit-question-points-${questionId}`).value) || 0;
                    
                    if (!questionText.trim()) {
                        Swal.showValidationMessage('Todas las preguntas deben tener texto');
                        return false;
                    }
                    
                    // Validar puntos por pregunta (0-5)
                    if (questionPoints < 0 || questionPoints > 5) {
                        Swal.showValidationMessage('Los puntos por pregunta deben estar entre 0 y 5');
                        return false;
                    }
                    
                    const optionsContainer = document.getElementById(`edit-options-container-${questionId}`);
                    const optionRows = optionsContainer.querySelectorAll('.option-row');
                    const options = {};
                    const correctAnswers = [];
                    
                    if (optionRows.length < 2) {
                        Swal.showValidationMessage('Cada pregunta debe tener al menos 2 opciones');
                        return false;
                    }
                    
                    let hasEmptyOption = false;
                    optionRows.forEach((row, index) => {
                        const letter = window.optionLetters[index];
                        const textInput = row.querySelector('input[type="text"]');
                        const checkbox = row.querySelector('input[type="checkbox"]');
                        
                        if (!textInput.value.trim()) hasEmptyOption = true;
                        options[letter] = textInput.value;
                        if (checkbox && checkbox.checked) correctAnswers.push(letter);
                    });
                    
                    if (hasEmptyOption) {
                        Swal.showValidationMessage('Todas las opciones deben tener texto');
                        return false;
                    }
                    
                    if (correctAnswers.length === 0) {
                        Swal.showValidationMessage('Cada pregunta debe tener al menos una respuesta correcta');
                        return false;
                    }
                    
                    totalQuestionPoints += questionPoints;
                    questions.push({
                        id: questionId,
                        text: questionText,
                        points: questionPoints,
                        options: options,
                        correctAnswers: correctAnswers,
                        isMultipleChoice: correctAnswers.length > 1
                    });
                }
                
                // Validar suma total de puntos
                if (totalQuestionPoints > 5.0) {
                    Swal.showValidationMessage('La suma de puntos de todas las preguntas no puede exceder 5.0 (actual: ' + totalQuestionPoints.toFixed(1) + ')');
                    return false;
                }
                
                quizData = { duration: parseInt(duration), questions: questions, totalPoints: totalQuestionPoints };
            }

            return {
                titulo, descripcion, instrucciones, fecha_apertura: fechaApertura, fecha_cierre: fechaCierre,
                puntos_maximos: parseInt(puntos), intentos_permitidos: parseInt(intentos),
                contenido_json: quizData, 
                prerequisite_activity_ids: prerequisiteActivities,
                material_id: materialId ? parseInt(materialId) : null,
                porcentaje_curso: porcentajeMaterial,
                nota_minima_aprobacion: notaMinimaAprobacion
            };
        }
    }).then((result) => {
        if (result.isConfirmed) actualizarActividadCompleta(actividadId, result.value);
    });
}
                        id: questionId,
                        text: questionText,
                        points: parseInt(questionPoints),
                        options: options,
                        correctAnswers: correctAnswers,
                        isMultipleChoice: correctAnswers.length > 1
                    });
                }
                
                quizData = { duration: parseInt(duration), questions: questions, totalPoints: totalQuestionPoints };
            }

            return {
                titulo, descripcion, instrucciones, fecha_apertura: fechaApertura, fecha_cierre: fechaCierre,
                puntos_maximos: parseInt(puntos), intentos_permitidos: parseInt(intentos),
                contenido_json: quizData, linked_material_ids: linkedMaterials
            };
        }
    }).then((result) => {
        if (result.isConfirmed) actualizarActividadCompleta(actividadId, result.value);
    });
}

function loadEditQuestion(question) {
    console.log('=== loadEditQuestion ===');
    console.log('question:', question);
    
    const questionId = ++window.editQuestionCounter;
    const container = document.getElementById('edit-actividad-questions-container');
    window.editOptionCounters[questionId] = 0;
    
    // Escapar el texto de la pregunta para evitar problemas con caracteres especiales
    const questionText = (question.text || '').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    const questionPoints = question.points || 1.0;
    
    console.log('questionId:', questionId);
    console.log('questionText:', questionText);
    console.log('questionPoints:', questionPoints);
    console.log('options:', question.options);
    
    const questionHtml = `
        <div class="card mb-3 quiz-question-card" id="edit-question-${questionId}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0"><i class="fas fa-question-circle text-primary"></i> Pregunta ${window.editQuestions.length + 1}</h6>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeEditQuestion(${questionId})"><i class="fas fa-trash"></i></button>
                </div>
                <div class="form-group">
                    <label>Texto de la Pregunta *</label>
                    <input type="text" class="form-control" id="edit-question-text-${questionId}" value="${questionText}" placeholder="Escribe la pregunta">
                </div>
                <div class="form-group">
                    <label>Ponderación (puntos) <small class="text-muted">Máx: 5.0</small></label>
                    <input type="number" class="form-control edit-question-points-input" id="edit-question-points-${questionId}" 
                           min="0" max="5" step="0.1" value="${questionPoints}" onchange="actualizarPuntosDisponiblesQuizEdit()">
                    <small class="form-text text-muted">Puntos de esta pregunta (0-5)</small>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="mb-0">Opciones de Respuesta * <small class="text-muted">(marca las correctas)</small></label>
                    <button type="button" class="btn btn-outline-success btn-sm" onclick="addEditQuestionOption(${questionId})"><i class="fas fa-plus"></i> Agregar</button>
                </div>
                <div id="edit-options-container-${questionId}"></div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', questionHtml);
    window.editQuestions.push(questionId);
    
    // Manejar opciones en diferentes formatos
    if (question.options) {
        if (Array.isArray(question.options)) {
            // Formato nuevo: array de objetos con {id, text, isCorrect}
            question.options.forEach((option, index) => {
                const letter = window.optionLetters[index] || String.fromCharCode(65 + index);
                const text = option.text || '';
                const isCorrect = option.isCorrect || false;
                addEditQuestionOptionWithData(questionId, letter, text, isCorrect);
            });
        } else {
            // Formato antiguo: objeto con letras como keys
            const correctAnswers = question.correctAnswers || [question.correctAnswer] || [];
            Object.keys(question.options).forEach((letter) => {
                const isCorrect = correctAnswers.includes(letter);
                addEditQuestionOptionWithData(questionId, letter, question.options[letter], isCorrect);
            });
        }
    }
    
    // Si no hay opciones, agregar 2 por defecto
    if (!question.options || (Array.isArray(question.options) && question.options.length === 0)) {
        addEditQuestionOption(questionId);
        addEditQuestionOption(questionId);
    }
}

function addEditQuestion() {
    const questionId = ++window.editQuestionCounter;
    const container = document.getElementById('edit-actividad-questions-container');
    window.editOptionCounters[questionId] = 0;
    
    const questionHtml = `
        <div class="card mb-3 quiz-question-card" id="edit-question-${questionId}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0"><i class="fas fa-question-circle text-primary"></i> Pregunta ${window.editQuestions.length + 1}</h6>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeEditQuestion(${questionId})"><i class="fas fa-trash"></i></button>
                </div>
                <div class="form-group">
                    <label>Texto de la Pregunta *</label>
                    <input type="text" class="form-control" id="edit-question-text-${questionId}" placeholder="Escribe la pregunta">
                </div>
                <div class="form-group">
                    <label>Ponderación (puntos) <small class="text-muted">Máx: 5.0</small></label>
                    <input type="number" class="form-control edit-question-points-input" id="edit-question-points-${questionId}" 
                           min="0" max="5" step="0.1" value="1.0" onchange="actualizarPuntosDisponiblesQuizEdit()">
                    <small class="form-text text-muted">Puntos de esta pregunta (0-5)</small>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="mb-0">Opciones de Respuesta * <small class="text-muted">(marca las correctas)</small></label>
                    <button type="button" class="btn btn-outline-success btn-sm" onclick="addEditQuestionOption(${questionId})"><i class="fas fa-plus"></i> Agregar</button>
                </div>
                <div id="edit-options-container-${questionId}"></div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', questionHtml);
    window.editQuestions.push(questionId);
    addEditQuestionOption(questionId);
    addEditQuestionOption(questionId);
    
    // Actualizar puntos disponibles
    setTimeout(() => actualizarPuntosDisponiblesQuizEdit(), 50);
}

function removeEditQuestion(questionId) {
    document.getElementById(`edit-question-${questionId}`).remove();
    window.editQuestions = window.editQuestions.filter(id => id !== questionId);
    window.editQuestions.forEach((id, index) => {
        const card = document.getElementById(`edit-question-${id}`);
        if (card) {
            const header = card.querySelector('h6');
            if (header) header.innerHTML = `<i class="fas fa-question-circle text-primary"></i> Pregunta ${index + 1}`;
        }
    });
    
    // Actualizar puntos disponibles
    actualizarPuntosDisponiblesQuizEdit();
}

function addEditQuestionOptionWithData(questionId, letter, text, isCorrect) {
    const optionsContainer = document.getElementById(`edit-options-container-${questionId}`);
    const currentOptions = optionsContainer.querySelectorAll('.option-row').length;
    
    // Escapar el texto de la opción para evitar problemas con caracteres especiales
    const escapedText = (text || '').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    
    const optionHtml = `
        <div class="input-group mb-2 option-row" id="edit-option-${questionId}-${letter}">
            <div class="input-group-prepend">
                <div class="input-group-text"><input type="checkbox" value="${letter}" ${isCorrect ? 'checked' : ''}></div>
                <span class="input-group-text"><strong>${letter}</strong></span>
            </div>
            <input type="text" class="form-control" value="${escapedText}" placeholder="Opción ${letter}">
            <div class="input-group-append">
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeEditQuestionOption(${questionId}, '${letter}')"><i class="fas fa-times"></i></button>
            </div>
        </div>
    `;
    optionsContainer.insertAdjacentHTML('beforeend', optionHtml);
    window.editOptionCounters[questionId] = currentOptions + 1;
    updateEditOptionRemoveButtons(questionId);
}

function addEditQuestionOption(questionId) {
    const optionsContainer = document.getElementById(`edit-options-container-${questionId}`);
    const currentOptions = optionsContainer.querySelectorAll('.option-row').length;
    if (currentOptions >= 10) return;
    
    const optionLetter = window.optionLetters[currentOptions];
    const optionHtml = `
        <div class="input-group mb-2 option-row" id="edit-option-${questionId}-${optionLetter}">
            <div class="input-group-prepend">
                <div class="input-group-text"><input type="checkbox" value="${optionLetter}"></div>
                <span class="input-group-text"><strong>${optionLetter}</strong></span>
            </div>
            <input type="text" class="form-control" placeholder="Opción ${optionLetter}">
            <div class="input-group-append">
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeEditQuestionOption(${questionId}, '${optionLetter}')"><i class="fas fa-times"></i></button>
            </div>
        </div>
    `;
    optionsContainer.insertAdjacentHTML('beforeend', optionHtml);
    window.editOptionCounters[questionId] = currentOptions + 1;
    updateEditOptionRemoveButtons(questionId);
}

function removeEditQuestionOption(questionId, optionLetter) {
    const optionsContainer = document.getElementById(`edit-options-container-${questionId}`);
    if (optionsContainer.querySelectorAll('.option-row').length <= 2) return;
    
    const optionElement = document.getElementById(`edit-option-${questionId}-${optionLetter}`);
    if (optionElement) {
        optionElement.remove();
        renumberEditOptions(questionId);
    }
}

function renumberEditOptions(questionId) {
    const optionsContainer = document.getElementById(`edit-options-container-${questionId}`);
    const optionRows = optionsContainer.querySelectorAll('.option-row');
    
    optionRows.forEach((row, index) => {
        const newLetter = window.optionLetters[index];
        row.id = `edit-option-${questionId}-${newLetter}`;
        const checkbox = row.querySelector('input[type="checkbox"]');
        if (checkbox) checkbox.value = newLetter;
        const letterSpan = row.querySelector('.input-group-text strong');
        if (letterSpan) letterSpan.textContent = newLetter;
        const textInput = row.querySelector('input[type="text"]');
        if (textInput) textInput.placeholder = `Opción ${newLetter}`;
        const removeBtn = row.querySelector('button');
        if (removeBtn) removeBtn.setAttribute('onclick', `removeEditQuestionOption(${questionId}, '${newLetter}')`);
    });
    updateEditOptionRemoveButtons(questionId);
}

function updateEditOptionRemoveButtons(questionId) {
    const optionsContainer = document.getElementById(`edit-options-container-${questionId}`);
    const optionRows = optionsContainer.querySelectorAll('.option-row');
    optionsContainer.querySelectorAll('.btn-outline-danger').forEach(btn => {
        btn.style.display = optionRows.length > 2 ? 'block' : 'none';
    });
}
</script>
<?php /**PATH C:\xampp\htdocs\SHC\resources\views/admin/capacitaciones/cursos/classroom/actividades.blade.php ENDPATH**/ ?>