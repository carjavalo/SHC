<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\CursoMaterial;
use App\Models\CursoActividad;
use App\Models\CursoEstudiante;
use App\Models\CursoAsignacion;
use App\Services\OperationLogger;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AcademicoController extends Controller
{
    /**
     * Mostrar cursos disponibles para estudiantes
     */
    public function cursosDisponibles(): View
    {
        return view('academico.cursos-disponibles.index');
    }

    /**
     * Obtener datos de cursos disponibles para DataTable
     * - Super Admin, Admin, Operador: ven TODOS los cursos activos
     * - Estudiantes y Docentes: solo ven cursos asignados
     */
    public function getCursosDisponiblesData(Request $request): JsonResponse
    {
        $user = Auth::user();
        $userRole = $user->role;
        
        // Roles que pueden ver todos los cursos
        $rolesVerTodos = ['Super Admin', 'Admin', 'Administrador', 'Operador'];
        
        // Query base de cursos activos
        $cursosQuery = Curso::with(['area.categoria', 'instructor', 'estudiantes'])
            ->where('estado', 'activo');
        
        // Si NO es un rol privilegiado, filtrar solo cursos asignados
        if (!in_array($userRole, $rolesVerTodos)) {
            // Obtener IDs de cursos asignados al usuario (asignaciones activas)
            $cursosAsignadosIds = CursoAsignacion::where('estudiante_id', $user->id)
                ->activas()
                ->pluck('curso_id')
                ->toArray();
            
            $cursosQuery->whereIn('id', $cursosAsignadosIds);
        }

        return DataTables::of($cursosQuery)
            ->addColumn('area_categoria', function ($curso) {
                return $curso->area->categoria->descripcion ?? 'Sin categoría';
            })
            ->addColumn('area_descripcion', function ($curso) {
                return $curso->area->descripcion ?? 'Sin área';
            })
            ->addColumn('instructor_nombre', function ($curso) {
                return $curso->instructor->full_name ?? 'Sin instructor';
            })
            ->addColumn('progreso', function ($curso) use ($user) {
                // Solo calcular progreso si está inscrito
                if ($curso->tieneEstudiante($user->id)) {
                    return $curso->getProgresoEstudiante($user->id);
                }
                return 0;
            })
            ->addColumn('estado_inscripcion', function ($curso) use ($user, $userRole, $rolesVerTodos) {
                // Roles privilegiados siempre tienen acceso directo
                if (in_array($userRole, $rolesVerTodos)) {
                    return 'acceso_directo';
                }
                
                // Verificar si está inscrito (tiene registro en curso_estudiantes)
                $estudiante = $curso->estudiantes()->where('users.id', $user->id)->first();
                if ($estudiante && $estudiante->pivot) {
                    return $estudiante->pivot->estado ?? 'inscrito';
                }
                
                // Si no está inscrito pero tiene asignación activa
                $tieneAsignacion = \App\Models\CursoAsignacion::where('curso_id', $curso->id)
                    ->where('estudiante_id', $user->id)
                    ->activas()
                    ->exists();
                
                if ($tieneAsignacion) {
                    return 'no_inscrito'; // Asignado pero no inscrito
                }
                
                return 'sin_acceso';
            })
            ->addColumn('fecha_inscripcion', function ($curso) use ($user, $userRole, $rolesVerTodos) {
                // Roles privilegiados no necesitan fecha de inscripción
                if (in_array($userRole, $rolesVerTodos)) {
                    return '-';
                }
                
                // Verificar si está inscrito
                $estudiante = $curso->estudiantes()->where('users.id', $user->id)->first();
                if ($estudiante && $estudiante->pivot && $estudiante->pivot->created_at) {
                    return $estudiante->pivot->created_at->format('d/m/Y');
                }
                
                // Si tiene asignación, mostrar fecha de asignación
                $asignacion = \App\Models\CursoAsignacion::where('curso_id', $curso->id)
                    ->where('estudiante_id', $user->id)
                    ->activas()
                    ->first();
                
                if ($asignacion) {
                    return $asignacion->fecha_asignacion->format('d/m/Y');
                }
                
                return '-';
            })
            ->addColumn('acciones', function ($curso) use ($user, $userRole, $rolesVerTodos) {
                // Verificar si está inscrito (no solo asignado)
                $isEnrolled = $curso->estudiantes()->where('users.id', $user->id)->exists();
                
                // Super Admin, Admin, Operador - Acceso directo sin inscripción
                if (in_array($userRole, $rolesVerTodos)) {
                    return '
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-info btn-sm" onclick="verCurso(' . $curso->id . ')" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-success btn-sm" onclick="aulaVirtual(' . $curso->id . ')" title="Aula Virtual">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="accederCurso(' . $curso->id . ')" title="Ejecutar curso">
                                <i class="fas fa-play"></i> Ejecutar
                            </button>
                        </div>
                    ';
                }
                
                // Docente - Botón "Iniciar" en lugar de "Inscribirse"
                if ($userRole === 'Docente') {
                    return '
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-info btn-sm" onclick="verCurso(' . $curso->id . ')" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-success btn-sm" onclick="aulaVirtual(' . $curso->id . ')" title="Aula Virtual">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="accederCurso(' . $curso->id . ')" title="Iniciar curso">
                                <i class="fas fa-play"></i> Iniciar
                            </button>
                        </div>
                    ';
                }
                
                // Estudiante inscrito - mostrar botones de acceso
                if ($isEnrolled) {
                    return '
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-info btn-sm" onclick="verCurso(' . $curso->id . ')" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-success btn-sm" onclick="aulaVirtual(' . $curso->id . ')" title="Aula Virtual">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="accederCurso(' . $curso->id . ')" title="Acceder al curso">
                                <i class="fas fa-play"></i>
                            </button>
                        </div>
                    ';
                }
                
                // Estudiante NO inscrito - mostrar botón de inscripción
                return '
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-info btn-sm" onclick="verCurso(' . $curso->id . ')" title="Ver detalles">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="inscribirseCurso(' . $curso->id . ')" title="Inscribirse">
                            <i class="fas fa-user-plus"></i> Inscribirse
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['acciones'])
            ->make(true);
    }

    /**
     * Ver detalles de un curso específico
     */
    public function verCurso(Curso $curso): View
    {
        $user = Auth::user();
        $userRole = $user->role;
        
        // Roles que pueden ver todos los cursos
        $rolesVerTodos = ['Super Admin', 'Admin', 'Administrador', 'Operador'];
        
        // Verificar acceso: roles privilegiados o estar inscrito
        if (!in_array($userRole, $rolesVerTodos) && !$curso->tieneEstudiante($user->id)) {
            abort(403, 'No tienes acceso a este curso');
        }

        $curso->load([
            'area.categoria',
            'instructor',
            'materiales' => function($query) {
                $query->where('es_publico', true)->orderBy('orden');
            },
            'actividades' => function($query) {
                $query->orderBy('fecha_apertura');
            }
        ]);

        $progreso = $curso->tieneEstudiante($user->id) ? $curso->getProgresoEstudiante($user->id) : 0;
        $materialesVistos = $this->getMaterialesVistos($curso->id, $user->id);
        $actividadesCompletadas = $this->getActividadesCompletadas($curso->id, $user->id);

        return view('academico.curso.index', compact(
            'curso', 'progreso', 'materialesVistos', 'actividadesCompletadas'
        ));
    }

    /**
     * Aula Virtual Interactiva - Vista principal para estudiantes
     */
    public function aulaVirtual(Curso $curso): View
    {
        $user = Auth::user();
        $userRole = $user->role;
        
        // Roles que pueden ver todos los cursos
        $rolesVerTodos = ['Super Admin', 'Admin', 'Administrador', 'Operador'];
        
        // Verificar acceso: roles privilegiados o estar inscrito
        if (!in_array($userRole, $rolesVerTodos) && !$curso->tieneEstudiante($user->id)) {
            abort(403, 'No tienes acceso a este curso');
        }

        $curso->load([
            'area.categoria',
            'instructor',
            'materiales' => function($query) {
                $query->where('es_publico', true)->orderBy('orden');
            },
            'actividades' => function($query) {
                $query->orderBy('fecha_apertura');
            }
        ]);

        $materiales = $curso->materiales()
            ->where('es_publico', true)
            ->orderBy('orden')
            ->get();

        $progreso = $curso->tieneEstudiante($user->id) ? $curso->getProgresoEstudiante($user->id) : 0;
        $materialesVistos = $this->getMaterialesVistos($curso->id, $user->id);
        $actividadesCompletadas = $this->getActividadesCompletadas($curso->id, $user->id);

        return view('academico.curso.aula-virtual', compact(
            'curso', 'materiales', 'progreso', 'materialesVistos', 'actividadesCompletadas'
        ));
    }

    /**
     * Ver materiales del curso
     */
    public function verMateriales(Curso $curso): View|RedirectResponse
    {
        $user = Auth::user();
        $userRole = $user->role;
        
        // Roles que pueden ver todos los cursos
        $rolesVerTodos = ['Super Admin', 'Admin', 'Administrador', 'Operador'];
        
        if (!in_array($userRole, $rolesVerTodos) && !$curso->tieneEstudiante($user->id)) {
            abort(403, 'No tienes acceso a este curso');
        }

        // Si no es una petición AJAX, redirigir a la vista principal con la pestaña activa
        if (!request()->ajax()) {
            return redirect()->route('academico.curso.ver', ['curso' => $curso->id, 'tab' => 'materiales']);
        }

        $materiales = $curso->materiales()
            ->where('es_publico', true)
            ->orderBy('orden')
            ->get();

        $materialesVistos = $this->getMaterialesVistos($curso->id, $user->id);

        return view('academico.curso.materiales', compact('curso', 'materiales', 'materialesVistos'));
    }

    /**
     * Ver actividades del curso
     */
    public function verActividades(Curso $curso): View|RedirectResponse
    {
        $user = Auth::user();
        $userRole = $user->role;
        
        // Roles que pueden ver todos los cursos
        $rolesVerTodos = ['Super Admin', 'Admin', 'Administrador', 'Operador'];
        
        if (!in_array($userRole, $rolesVerTodos) && !$curso->tieneEstudiante($user->id)) {
            abort(403, 'No tienes acceso a este curso');
        }

        // Si no es una petición AJAX, redirigir a la vista principal con la pestaña activa
        if (!request()->ajax()) {
            return redirect()->route('academico.curso.ver', ['curso' => $curso->id, 'tab' => 'actividades']);
        }

        $actividades = $curso->actividades()
            ->orderBy('fecha_apertura')
            ->get();

        $actividadesCompletadas = $this->getActividadesCompletadas($curso->id, $user->id);

        return view('academico.curso.actividades', compact('curso', 'actividades', 'actividadesCompletadas'));
    }

    /**
     * Ver evaluaciones del curso
     */
    public function verEvaluaciones(Curso $curso): View|RedirectResponse
    {
        $user = Auth::user();
        
        if (!$curso->tieneEstudiante($user->id)) {
            abort(403, 'No tienes acceso a este curso');
        }

        // Si no es una petición AJAX, redirigir a la vista principal con la pestaña activa
        if (!request()->ajax()) {
            return redirect()->route('academico.curso.ver', ['curso' => $curso->id, 'tab' => 'evaluaciones']);
        }

        // Por ahora, las evaluaciones son actividades de tipo 'evaluacion'
        $evaluaciones = $curso->actividades()
            ->where('tipo', 'evaluacion')
            ->orderBy('fecha_apertura')
            ->get();

        $evaluacionesCompletadas = $this->getActividadesCompletadas($curso->id, $user->id);

        return view('academico.curso.evaluaciones', compact('curso', 'evaluaciones', 'evaluacionesCompletadas'));
    }

    /**
     * Marcar material como visto
     */
    public function marcarMaterialVisto(Request $request, Curso $curso, CursoMaterial $material): JsonResponse
    {
        $user = Auth::user();
        
        if (!$curso->tieneEstudiante($user->id)) {
            return response()->json(['success' => false, 'message' => 'No tienes acceso a este curso'], 403);
        }

        // Verificar si el material tiene prerrequisito
        if ($material->prerequisite_id) {
            // Verificar si el prerrequisito ha sido completado
            $prerequisitoCompletado = DB::table('curso_material_visto')
                ->where('curso_id', $curso->id)
                ->where('material_id', $material->prerequisite_id)
                ->where('user_id', $user->id)
                ->exists();
            
            if (!$prerequisitoCompletado) {
                $prerequisito = CursoMaterial::find($material->prerequisite_id);
                $nombrePrerequisito = $prerequisito ? $prerequisito->titulo : 'el material previo';
                
                return response()->json([
                    'success' => false, 
                    'message' => "Debes completar primero: {$nombrePrerequisito}"
                ], 400);
            }
        }

        // Registrar que el material fue visto
        DB::table('curso_material_visto')->updateOrInsert([
            'curso_id' => $curso->id,
            'material_id' => $material->id,
            'user_id' => $user->id,
        ], [
            'visto_at' => now(),
            'updated_at' => now(),
        ]);

        // Registrar operación de visualización de material
        OperationLogger::logMaterialView($material->id, $material->titulo, $curso->id);

        return response()->json(['success' => true, 'message' => 'Material marcado como visto']);
    }

    /**
     * Entregar actividad
     */
    public function entregarActividad(Request $request, Curso $curso, CursoActividad $actividad): JsonResponse
    {
        $user = Auth::user();
        
        if (!$curso->tieneEstudiante($user->id)) {
            return response()->json(['success' => false, 'message' => 'No tienes acceso a este curso'], 403);
        }

        // Validar que la actividad esté abierta
        if ($actividad->fecha_cierre && now() > $actividad->fecha_cierre) {
            return response()->json(['success' => false, 'message' => 'La actividad ya está cerrada'], 400);
        }

        // Registrar entrega de actividad
        DB::table('curso_actividad_entrega')->updateOrInsert([
            'curso_id' => $curso->id,
            'actividad_id' => $actividad->id,
            'user_id' => $user->id,
        ], [
            'contenido' => $request->input('contenido', ''),
            'observaciones_estudiante' => $request->input('observaciones', ''),
            'archivo_path' => $request->hasFile('archivo') ? $request->file('archivo')->store('entregas', 'public') : null,
            'entregado_at' => now(),
            'updated_at' => now(),
        ]);

        // Registrar operación de entrega de actividad
        OperationLogger::logActivitySubmission($actividad->id, $actividad->titulo, $curso->id);

        return response()->json(['success' => true, 'message' => 'Actividad entregada correctamente']);
    }

    /**
     * Inscribir usuario a un curso
     */
    public function inscribirseCurso(Request $request, Curso $curso)
    {
        $user = Auth::user();

        // Verificar que el curso esté activo
        if ($curso->estado !== 'activo') {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'El curso no está disponible para inscripciones'
                ], 400);
            }
            return redirect()->back()->with('error', 'El curso no está disponible para inscripciones');
        }

        // Verificar si ya está inscrito (solo en curso_estudiantes, no en asignaciones)
        $yaInscrito = $curso->estudiantes()->wherePivot('estudiante_id', $user->id)->exists();
        
        if ($yaInscrito) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ya estás inscrito en este curso'
                ], 400);
            }
            return redirect()->back()->with('info', 'Ya estás inscrito en este curso');
        }

        // Verificar límite de estudiantes
        if ($curso->max_estudiantes && $curso->estudiantes_count >= $curso->max_estudiantes) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'El curso ha alcanzado el límite máximo de estudiantes'
                ], 400);
            }
            return redirect()->back()->with('error', 'El curso ha alcanzado el límite máximo de estudiantes');
        }

        try {
            $curso->estudiantes()->attach($user->id, [
                'estado' => 'activo',
                'progreso' => 0,
                'fecha_inscripcion' => now(),
                'ultima_actividad' => now(),
            ]);

            // Registrar operación de inscripción
            OperationLogger::logEnrollment($curso->id, $curso->titulo);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Te has inscrito exitosamente al curso'
                ]);
            }
            
            return redirect()->route('academico.cursos-disponibles')->with('success', '¡Te has inscrito exitosamente al curso!');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al inscribirse al curso: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Error al inscribirse al curso: ' . $e->getMessage());
        }
    }

    /**
     * Resolver quiz o evaluación (estudiante)
     */
    public function resolverQuiz(Request $request, Curso $curso, CursoActividad $actividad): JsonResponse
    {
        $user = Auth::user();

        // Verificar que el usuario esté inscrito
        if (!$curso->tieneEstudiante($user->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Debes estar inscrito en el curso para resolver esta actividad'
            ], 403);
        }

        // Verificar que sea un quiz o evaluación
        if (!in_array($actividad->tipo, ['quiz', 'evaluacion'])) {
            return response()->json([
                'success' => false,
                'message' => 'Esta actividad no es un quiz ni una evaluación'
            ], 400);
        }

        $tipoLabel = $actividad->tipo === 'quiz' ? 'quiz' : 'evaluación';

        // Verificar que el quiz/evaluación esté habilitado
        if (!$actividad->habilitado) {
            return response()->json([
                'success' => false,
                'message' => "Esta $tipoLabel no está habilitada"
            ], 400);
        }

        // Verificar que el quiz/evaluación esté abierto
        if ($actividad->estado !== 'abierta') {
            return response()->json([
                'success' => false,
                'message' => "Esta $tipoLabel no está disponible"
            ], 400);
        }

        $request->validate([
            'respuestas' => 'required|array',
            'tiempo_transcurrido' => 'nullable|integer'
        ]);

        try {
            $respuestas = $request->respuestas;
            $quizData = $actividad->contenido_json;
            $preguntas = $quizData['questions'] ?? [];
            
            // Calcular calificación
            $puntosObtenidos = 0;
            $puntosMaximos = $quizData['totalPoints'] ?? 0;
            $resultados = [];

            foreach ($preguntas as $pregunta) {
                $preguntaId = $pregunta['id'];
                $respuestaEstudiante = $respuestas[$preguntaId] ?? null;
                
                // Soportar tanto el formato antiguo (correctAnswer) como el nuevo (correctAnswers)
                $respuestasCorrectas = $pregunta['correctAnswers'] ?? [$pregunta['correctAnswer'] ?? ''];
                $esMultiple = ($pregunta['isMultipleChoice'] ?? false) || count($respuestasCorrectas) > 1;
                
                $esCorrecta = false;
                $respuestaEstudianteTexto = '';
                $respuestaCorrectaTexto = '';
                
                if ($esMultiple) {
                    // Para preguntas de múltiple respuesta
                    $respuestasEstudianteArray = is_array($respuestaEstudiante) ? $respuestaEstudiante : [];
                    sort($respuestasEstudianteArray);
                    sort($respuestasCorrectas);
                    
                    // Verificar si las respuestas coinciden exactamente
                    $esCorrecta = ($respuestasEstudianteArray === $respuestasCorrectas);
                    
                    // Formatear texto de respuestas
                    $respuestaEstudianteTexto = implode(', ', array_map(function($r) use ($pregunta) {
                        return $r . ') ' . ($pregunta['options'][$r] ?? '');
                    }, $respuestasEstudianteArray));
                    
                    $respuestaCorrectaTexto = implode(', ', array_map(function($r) use ($pregunta) {
                        return $r . ') ' . ($pregunta['options'][$r] ?? '');
                    }, $respuestasCorrectas));
                } else {
                    // Para preguntas de respuesta única
                    $respuestaCorrecta = $respuestasCorrectas[0] ?? '';
                    $esCorrecta = ($respuestaEstudiante === $respuestaCorrecta);
                    
                    $respuestaEstudianteTexto = $respuestaEstudiante ? $respuestaEstudiante . ') ' . ($pregunta['options'][$respuestaEstudiante] ?? '') : 'Sin respuesta';
                    $respuestaCorrectaTexto = $respuestaCorrecta . ') ' . ($pregunta['options'][$respuestaCorrecta] ?? '');
                }
                
                if ($esCorrecta) {
                    $puntosObtenidos += $pregunta['points'];
                }

                $resultados[] = [
                    'pregunta_id' => $preguntaId,
                    'pregunta' => $pregunta['text'],
                    'respuesta_estudiante' => $respuestaEstudianteTexto,
                    'respuesta_correcta' => $respuestaCorrectaTexto,
                    'es_correcta' => $esCorrecta,
                    'puntos' => $esCorrecta ? $pregunta['points'] : 0,
                    'es_multiple' => $esMultiple
                ];
            }

            $porcentaje = $puntosMaximos > 0 ? ($puntosObtenidos / $puntosMaximos) * 100 : 0;

            // Guardar resultado en la base de datos
            DB::table('curso_actividad_entrega')->updateOrInsert(
                [
                    'curso_id' => $curso->id,
                    'actividad_id' => $actividad->id,
                    'user_id' => $user->id
                ],
                [
                    'contenido' => json_encode([
                        'respuestas' => $respuestas,
                        'resultados' => $resultados,
                        'tiempo_transcurrido' => $request->tiempo_transcurrido
                    ]),
                    'puntos_obtenidos' => $puntosObtenidos,
                    'calificacion' => $porcentaje,
                    'entregado_at' => now(),
                    'updated_at' => now()
                ]
            );

            // Actualizar progreso del estudiante
            $curso->actualizarProgresoEstudiante($user->id);

            // Registrar operación de resolución de quiz
            OperationLogger::logQuizSubmission($actividad->id, $actividad->titulo, round($porcentaje, 2), $curso->id);

            return response()->json([
                'success' => true,
                'message' => 'Quiz completado exitosamente',
                'resultados' => $resultados,
                'puntos_obtenidos' => $puntosObtenidos,
                'puntos_maximos' => $puntosMaximos,
                'porcentaje' => round($porcentaje, 2),
                'aprobado' => $porcentaje >= 60
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el quiz: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener materiales vistos por el usuario
     */
    private function getMaterialesVistos(int $cursoId, int $userId): array
    {
        return DB::table('curso_material_visto')
            ->where('curso_id', $cursoId)
            ->where('user_id', $userId)
            ->pluck('material_id')
            ->toArray();
    }

    /**
     * Obtener actividades completadas por el usuario
     */
    private function getActividadesCompletadas(int $cursoId, int $userId): array
    {
        return DB::table('curso_actividad_entrega')
            ->where('curso_id', $cursoId)
            ->where('user_id', $userId)
            ->pluck('actividad_id')
            ->toArray();
    }
}
