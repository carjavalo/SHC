<script>
    // Variables globales para el quiz - usar var para permitir redeclaración en cargas dinámicas
    var quizTimer = null;
    var tiempoInicio = null;

    // Función para iniciar el quiz
    function iniciarQuiz(actividadId) {
        // Obtener datos del quiz desde el textarea oculto
        const quizDataElement = document.getElementById('quiz-data-' + actividadId);
        
        if (!quizDataElement) {
            Swal.fire('Error', 'No se encontraron los datos del quiz', 'error');
            return;
        }
        
        try {
            const actividad = JSON.parse(quizDataElement.value);
            
            // Fix for double-encoded JSON
            if (typeof actividad.contenido_json === 'string') {
                try {
                    actividad.contenido_json = JSON.parse(actividad.contenido_json);
                } catch (e) {
                    console.error('Error parsing nested JSON:', e);
                }
            }
            
            if (!actividad || !actividad.contenido_json) {
                Swal.fire('Error', 'No se encontraron las preguntas del quiz', 'error');
                return;
            }
            
            mostrarModalQuiz(actividadId, actividad);
        } catch (e) {
            console.error('Error parsing quiz data:', e);
            Swal.fire('Error', 'Error al procesar los datos del quiz', 'error');
        }
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
            preguntasHTML += `
                <div class="quiz-question">
                    <h5><span class="badge badge-primary">${index + 1}</span> ${pregunta.text}</h5>
                    <small class="text-muted"><i class="fas fa-star"></i> ${pregunta.points} puntos</small>
                    <div class="mt-3">
            `;
            
            Object.keys(pregunta.options).forEach(opcion => {
                preguntasHTML += `
                    <label class="quiz-option">
                        <input type="radio" name="pregunta_${pregunta.id}" value="${opcion}">
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
                
                // Manejar selección de opciones
                $('.quiz-option').on('click', function() {
                    $(this).find('input[type="radio"]').prop('checked', true);
                    $(this).siblings().removeClass('selected');
                    $(this).addClass('selected');
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
                    const respuesta = $(`input[name="pregunta_${pregunta.id}"]:checked`).val();
                    if (respuesta) {
                        respuestas[pregunta.id] = respuesta;
                    } else {
                        todasRespondidas = false;
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
            url: '{{ route("academico.curso.quiz.resolver", [$curso->id, ":actividadId"]) }}'.replace(':actividadId', actividadId),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
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
            // Recargar la página para actualizar el progreso
            location.reload();
        });
    }
</script>

<style>
    /* Quiz Styles */
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
        display: block;
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
        color: #28a745;
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
