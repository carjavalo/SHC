<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\UserOperationController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\CursoClassroomController;
use App\Http\Controllers\AcademicoController;
use App\Http\Controllers\ControlPedagogicoController;
use App\Http\Controllers\AsignacionCursoController;
use App\Http\Controllers\ServicioAreaController;
use App\Http\Controllers\VinculacionContratoController;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\PublicidadProductoController;
use App\Http\Controllers\CertificadoEditorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('chat')->name('chat.')->group(function () {
    Route::get('/buscar-usuarios', [\App\Http\Controllers\ChatController::class, 'buscarUsuarios'])->name('buscar-usuarios');
    Route::post('/enviar', [\App\Http\Controllers\ChatController::class, 'enviarMensaje'])->name('enviar');
    Route::get('/mensajes', [\App\Http\Controllers\ChatController::class, 'obtenerMensajes'])->name('mensajes');
    Route::get('/bandeja', [\App\Http\Controllers\ChatController::class, 'bandeja'])->name('bandeja');
    Route::post('/marcar-leido/{mensaje}', [\App\Http\Controllers\ChatController::class, 'marcarLeido'])->name('marcar-leido');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas de usuarios
    Route::post('users/import', [UserController::class, 'import'])->name('users.import');
    Route::resource('users', UserController::class);

    // Rutas de seguimiento de accesos
    Route::prefix('tracking')->name('tracking.')->group(function () {
        Route::get('logins', [UserLoginController::class, 'index'])->name('logins.index');
        Route::get('logins/data', [UserLoginController::class, 'getData'])->name('logins.data');
        Route::get('logins/{userLogin}', [UserLoginController::class, 'show'])->name('logins.show');
        Route::post('logins/resend-verification/{user}', [UserLoginController::class, 'resendVerification'])->name('logins.resend-verification');
        Route::get('stats', [UserLoginController::class, 'getStats'])->name('stats');
        
        // Rutas de operaciones
        Route::get('operations', [UserOperationController::class, 'index'])->name('operations.index');
        Route::get('operations/data', [UserOperationController::class, 'getData'])->name('operations.data');
        Route::get('operations/{operation}', [UserOperationController::class, 'show'])->name('operations.show');
        Route::get('operations-stats', [UserOperationController::class, 'getStats'])->name('operations.stats');
    });

    // Rutas de capacitaciones
    Route::prefix('capacitaciones')->name('capacitaciones.')->group(function () {
        // Rutas de categorías
        Route::get('categorias/data', [CategoriaController::class, 'getData'])->name('categorias.data');
        Route::resource('categorias', CategoriaController::class);

        // Rutas de áreas
        Route::get('areas/data', [AreaController::class, 'getData'])->name('areas.data');
        Route::resource('areas', AreaController::class);

        // Rutas de cursos
        Route::get('cursos/data', [CursoController::class, 'getData'])->name('cursos.data');
        Route::get('cursos/{curso}/stats', [CursoController::class, 'getStats'])->name('cursos.stats');
        Route::resource('cursos', CursoController::class);

        // Rutas del classroom
        Route::prefix('cursos/{curso}/classroom')->name('cursos.classroom.')->group(function () {
            Route::get('/', [CursoClassroomController::class, 'index'])->name('index');
            Route::get('/materiales', [CursoClassroomController::class, 'materiales'])->name('materiales');
            Route::post('/materiales', [CursoClassroomController::class, 'subirMaterial'])->name('materiales.store');
            Route::get('/materiales/test', function() { return response()->json(['test' => 'ok']); })->name('materiales.test');
            Route::get('/materiales/{material}/obtener', [CursoClassroomController::class, 'obtenerMaterial'])->name('materiales.obtener');
            Route::put('/materiales/{material}', [CursoClassroomController::class, 'actualizarMaterial'])->name('materiales.update');
            Route::delete('/materiales/{material}', [CursoClassroomController::class, 'eliminarMaterial'])->name('materiales.destroy');
            Route::get('/foros', [CursoClassroomController::class, 'foros'])->name('foros');
            Route::post('/foros', [CursoClassroomController::class, 'crearPost'])->name('foros.store');
            Route::post('/foros/{post}/responder', [CursoClassroomController::class, 'responderPost'])->name('foros.responder');
            Route::get('/actividades', [CursoClassroomController::class, 'actividades'])->name('actividades');
            Route::post('/actividades', [CursoClassroomController::class, 'crearActividad'])->name('actividades.store');
            Route::get('/actividades/{actividad}/obtener', [CursoClassroomController::class, 'obtenerActividad'])->name('actividades.obtener');
            Route::get('/actividades/{actividad}/datos-quiz', [CursoClassroomController::class, 'obtenerDatosQuiz'])->name('actividades.datos-quiz');
            Route::get('/datos-disponibles', [CursoClassroomController::class, 'obtenerDatosDisponibles'])->name('datos-disponibles');
            Route::get('/actividades/{actividad}/entregas', [CursoClassroomController::class, 'entregas'])->name('actividades.entregas');
            Route::post('/actividades/{actividad}/entregar', [CursoClassroomController::class, 'entregarActividad'])->name('actividades.entregar');
            Route::post('/actividades/{actividad}/toggle', [CursoClassroomController::class, 'toggleActividad'])->name('actividades.toggle');
            Route::post('/actividades/{actividad}/resolver-quiz', [CursoClassroomController::class, 'resolverQuiz'])->name('actividades.resolver-quiz');
            Route::put('/actividades/{actividad}/actualizar', [CursoClassroomController::class, 'actualizarActividad'])->name('actividades.actualizar');
            Route::delete('/actividades/{actividad}', [CursoClassroomController::class, 'eliminarActividad'])->name('actividades.destroy');
            Route::post('/actividades/{actividad}/calificar', [CursoClassroomController::class, 'calificarTarea'])->name('actividades.calificar');
            Route::get('/participantes', [CursoClassroomController::class, 'participantes'])->name('participantes');
            Route::post('/inscribir', [CursoClassroomController::class, 'inscribirEstudiante'])->name('inscribir');
            
            // Rutas de calificaciones
            Route::get('/calificaciones', [CursoClassroomController::class, 'getCalificacionesEstudiante'])->name('calificaciones');
            Route::get('/calificaciones/{estudiante}', [CursoClassroomController::class, 'getCalificacionesEstudiante'])->name('calificaciones.estudiante');
            Route::get('/porcentajes', [CursoClassroomController::class, 'getResumenPorcentajes'])->name('porcentajes');
        });

        // Ruta directa al classroom
        Route::get('cursos/{curso}/classroom', [CursoClassroomController::class, 'index'])->name('cursos.classroom');
    });

    // Rutas de la sección Académico (para usuarios finales)
    Route::prefix('academico')->name('academico.')->group(function () {
        // Control Pedagógico (Gradebook)
        Route::get('control-pedagogico', [ControlPedagogicoController::class, 'index'])->name('control-pedagogico.index');
        Route::post('control-pedagogico/guardar-calificacion', [ControlPedagogicoController::class, 'guardarCalificacionPublic'])->name('control-pedagogico.guardar-calificacion');
        
        // Cursos disponibles para estudiantes
        Route::get('cursos-disponibles', [AcademicoController::class, 'cursosDisponibles'])->name('cursos.disponibles');
        Route::get('cursos-disponibles/data', [AcademicoController::class, 'getCursosDisponiblesData'])->name('cursos.disponibles.data');

        // Acceso a curso específico para estudiante
        Route::get('curso/{curso}', [AcademicoController::class, 'verCurso'])->name('curso.ver');
        Route::get('curso/{curso}/aula-virtual', [AcademicoController::class, 'aulaVirtual'])->name('curso.aula-virtual');
        Route::get('curso/{curso}/materiales', [AcademicoController::class, 'verMateriales'])->name('curso.materiales');
        Route::get('curso/{curso}/actividades', [AcademicoController::class, 'verActividades'])->name('curso.actividades');
        Route::get('curso/{curso}/evaluaciones', [AcademicoController::class, 'verEvaluaciones'])->name('curso.evaluaciones');

        // Interacciones del estudiante
        Route::match(['get', 'post'], 'curso/{curso}/inscribirse', [AcademicoController::class, 'inscribirseCurso'])->name('curso.inscribirse');
        Route::post('curso/{curso}/marcar-material/{material}', [AcademicoController::class, 'marcarMaterialVisto'])->name('curso.material.marcar');
        Route::post('curso/{curso}/entregar-actividad/{actividad}', [AcademicoController::class, 'entregarActividad'])->name('curso.actividad.entregar');
        Route::post('curso/{curso}/resolver-quiz/{actividad}', [AcademicoController::class, 'resolverQuiz'])->name('curso.quiz.resolver');
    });

    // Rutas de Configuración - Asignación de Cursos
    Route::prefix('configuracion')->name('configuracion.')->group(function () {
        Route::prefix('asignacion-cursos')->name('asignacion-cursos.')->group(function () {
            Route::get('/', [AsignacionCursoController::class, 'index'])->name('index');
            Route::get('/buscar-estudiantes', [AsignacionCursoController::class, 'buscarEstudiantes'])->name('buscar-estudiantes');
            Route::get('/estudiante/{estudiante}', [AsignacionCursoController::class, 'getEstudiante'])->name('get-estudiante');
            Route::get('/cursos', [AsignacionCursoController::class, 'getCursosDisponibles'])->name('get-cursos');
            Route::get('/categorias', [AsignacionCursoController::class, 'getCategorias'])->name('get-categorias');
            Route::post('/asignar', [AsignacionCursoController::class, 'asignar'])->name('asignar');
            Route::post('/asignar-todos', [AsignacionCursoController::class, 'asignarATodos'])->name('asignar-todos');
            Route::post('/remover', [AsignacionCursoController::class, 'removerAsignacion'])->name('remover');
            Route::get('/historial', [AsignacionCursoController::class, 'getHistorial'])->name('historial');
        });

        // Rutas de Gestión de Componentes
        Route::prefix('componentes')->name('componentes.')->group(function () {
            // Servicios/Áreas
            Route::get('servicios-areas/data', [ServicioAreaController::class, 'getData'])->name('servicios-areas.data');
            Route::resource('servicios-areas', ServicioAreaController::class);

            // Vinculación/Contrato
            Route::get('vinculacion-contrato/data', [VinculacionContratoController::class, 'getData'])->name('vinculacion-contrato.data');
            Route::resource('vinculacion-contrato', VinculacionContratoController::class);

            // Sedes
            Route::get('sedes/data', [SedeController::class, 'getData'])->name('sedes.data');
            Route::resource('sedes', SedeController::class);
        });

        // Rutas de Editor de Certificados
        Route::prefix('editor-certificados')->name('editor-certificados.')->group(function () {
            Route::get('/', [CertificadoEditorController::class, 'index'])->name('index');
        });

        // Rutas de Publicidad y Productos
        Route::prefix('publicidad-productos')->name('publicidad-productos.')->group(function () {
            Route::get('/', [PublicidadProductoController::class, 'index'])->name('index');
            Route::get('/data', [PublicidadProductoController::class, 'getData'])->name('data');
            Route::post('/', [PublicidadProductoController::class, 'store'])->name('store');
            Route::put('/{id}', [PublicidadProductoController::class, 'update'])->name('update');
            Route::delete('/{id}', [PublicidadProductoController::class, 'destroy'])->name('destroy');
            Route::post('/guardar-config', [PublicidadProductoController::class, 'guardarConfiguracion'])->name('guardar-config');
            Route::post('/guardar-categorias', [PublicidadProductoController::class, 'guardarCategorias'])->name('guardar-categorias');
        });
    });
});

require __DIR__.'/auth.php';
