<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\User;
use App\Models\PlantillaCertificado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CertificadoPlantillaController extends Controller
{
    protected $rolesPermitidos = ['Super Admin', 'Administrador', 'Operador'];

    private function verificarAcceso(): void
    {
        $user = Auth::user();

        if (!$user || !in_array($user->role, $this->rolesPermitidos)) {
            abort(403, 'No tiene permisos para acceder a esta sección.');
        }
    }

    public function index(): View
    {
        $this->verificarAcceso();
        $docentes = User::where('role', 'Docente')->orderBy('name')->get();
        $usuarios = $docentes; // Mantener la variable para no romper la vista si se usa en otro lado
        $cursos = Curso::orderBy('titulo')->get();
        $plantillas = PlantillaCertificado::latest()->get();

        return view('admin.configuracion.editor-certificados.index', compact('usuarios', 'cursos', 'plantillas'));
    }

    public function store(Request $request)
    {
        $this->verificarAcceso();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'elementos_json' => 'nullable|string',
            'html_content' => 'nullable|string',
            'fondo_base64' => 'nullable|string'
        ]);

        $plantilla = new PlantillaCertificado();
        $plantilla->nombre = $request->nombre;
        
        $elementosStr = $request->elementos_json ?? '[]';
        $plantilla->elementos_json = json_decode($elementosStr, true);
        $plantilla->html_content = $request->html_content;

        if ($request->filled('fondo_base64')) {
            // we will just store base64 in the elements_json or fondo_path for now
            // simpler than uploading file just for the template background
            $data = $plantilla->elementos_json ?? [];
            $data['fondo_base64'] = $request->fondo_base64;
            $plantilla->elementos_json = $data;
        }

        $plantilla->save();

        return redirect()->route('configuracion.editor-certificados.index')->with('success', 'Plantilla guardada correctamente.');
    }

    public function destroy(PlantillaCertificado $plantilla)
    {
        $this->verificarAcceso();

        $cursosUsando = $plantilla->cursos()->count();
        if ($cursosUsando > 0) {
            return redirect()->back()->with('error', 'No se puede eliminar la plantilla porque está asignada a ' . $cursosUsando . ' cursos.');
        }

        $plantilla->delete();
        return redirect()->route('configuracion.editor-certificados.index')->with('success', 'Plantilla eliminada correctamente.');
    }

    public function showJson(PlantillaCertificado $plantilla)
    {
        $this->verificarAcceso();
        return response()->json($plantilla);
    }

    public function getCursosPorDocente(User $docente)
    {
        $this->verificarAcceso();
        
        // Obtener cursos donde es instructor o está asignado como docente
        $cursosIds = \App\Models\CursoAsignacion::where('docente_id', $docente->id)->pluck('curso_id')->toArray();
        
        $cursos = Curso::where('instructor_id', $docente->id)
            ->orWhereIn('id', $cursosIds)
            ->select('id', 'titulo', 'duracion_horas', 'fecha_inicio', 'fecha_fin')
            ->orderBy('titulo')
            ->get();

        return response()->json($cursos);
    }
}









