<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ServicioArea;
use App\Models\VinculacionContrato;
use App\Models\Sede;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentUser = auth()->user();
        
        // Si el usuario autenticado es Operador, excluir Super Admins
        if ($currentUser->role === 'Operador') {
            $users = User::with(['servicioArea', 'vinculacionContrato', 'sede'])
                ->where('role', '!=', 'Super Admin')->get();
        } else {
            // Para otros roles, mostrar todos los usuarios
            $users = User::with(['servicioArea', 'vinculacionContrato', 'sede'])->get();
        }
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $availableRoles = User::getAvailableRoles();
        
        // Si el usuario autenticado es Operador, excluir Super Admin y Administrador de los roles disponibles
        if (auth()->user()->role === 'Operador') {
            $availableRoles = array_values(array_filter($availableRoles, function($role) {
                return !in_array($role, ['Super Admin', 'Administrador']);
            }));
        }
        
        $availableDocumentTypes = User::getAvailableDocumentTypes();
        $serviciosAreas = ServicioArea::all();
        $vinculacionesContrato = VinculacionContrato::all();
        $sedes = Sede::all();
        
        return view('admin.users.create', compact(
            'availableRoles', 
            'availableDocumentTypes',
            'serviciosAreas',
            'vinculacionesContrato',
            'sedes'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'apellido1' => ['required', 'string', 'max:100'],
            'apellido2' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:' . implode(',', User::getAvailableRoles())],
            'tipo_documento' => ['required', 'in:' . implode(',', User::getAvailableDocumentTypes())],
            'numero_documento' => ['required', 'string', 'max:20', 'unique:users'],
            'servicio_area_id' => ['nullable', 'exists:servicios_areas,id'],
            'vinculacion_contrato_id' => ['nullable', 'exists:vinculacion_contrato,id'],
            'sede_id' => ['nullable', 'exists:sedes,id'],
        ]);
        
        // Validación adicional: Operadores no pueden asignar roles Super Admin ni Administrador
        if (auth()->user()->role === 'Operador' && in_array($request->role, ['Super Admin', 'Administrador'])) {
            return redirect()->back()
                ->withErrors(['role' => 'No tienes permisos para asignar los roles Super Admin o Administrador.'])
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'apellido1' => $request->apellido1,
            'apellido2' => $request->apellido2,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'tipo_documento' => $request->tipo_documento,
            'numero_documento' => $request->numero_documento,
            'servicio_area_id' => $request->servicio_area_id,
            'vinculacion_contrato_id' => $request->vinculacion_contrato_id,
            'sede_id' => $request->sede_id,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with(['servicioArea', 'vinculacionContrato', 'sede'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $availableRoles = User::getAvailableRoles();
        
        // Si el usuario autenticado es Operador, excluir Super Admin y Administrador de los roles disponibles
        if (auth()->user()->role === 'Operador') {
            $availableRoles = array_values(array_filter($availableRoles, function($role) {
                return !in_array($role, ['Super Admin', 'Administrador']);
            }));
        }
        
        $availableDocumentTypes = User::getAvailableDocumentTypes();
        $serviciosAreas = ServicioArea::all();
        $vinculacionesContrato = VinculacionContrato::all();
        $sedes = Sede::all();
        
        return view('admin.users.edit', compact(
            'user', 
            'availableRoles', 
            'availableDocumentTypes',
            'serviciosAreas',
            'vinculacionesContrato',
            'sedes'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'apellido1' => ['required', 'string', 'max:100'],
            'apellido2' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'in:' . implode(',', User::getAvailableRoles())],
            'tipo_documento' => ['required', 'in:' . implode(',', User::getAvailableDocumentTypes())],
            'numero_documento' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'servicio_area_id' => ['nullable', 'exists:servicios_areas,id'],
            'vinculacion_contrato_id' => ['nullable', 'exists:vinculacion_contrato,id'],
            'sede_id' => ['nullable', 'exists:sedes,id'],
        ]);
        
        // Validación adicional: Operadores no pueden asignar roles Super Admin ni Administrador
        if (auth()->user()->role === 'Operador' && in_array($request->role, ['Super Admin', 'Administrador'])) {
            return redirect()->back()
                ->withErrors(['role' => 'No tienes permisos para asignar los roles Super Admin o Administrador.'])
                ->withInput();
        }

        $data = [
            'name' => $request->name,
            'apellido1' => $request->apellido1,
            'apellido2' => $request->apellido2,
            'email' => $request->email,
            'role' => $request->role,
            'tipo_documento' => $request->tipo_documento,
            'numero_documento' => $request->numero_documento,
            'servicio_area_id' => $request->servicio_area_id,
            'vinculacion_contrato_id' => $request->vinculacion_contrato_id,
            'sede_id' => $request->sede_id,
        ];

        // Actualizar contraseña solo si se proporciona
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['string', 'min:8', 'confirmed'],
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}
