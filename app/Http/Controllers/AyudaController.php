<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WelcomeBanner;
use Illuminate\Support\Facades\Storage;

class AyudaController extends Controller
{
    /**
     * Muestra la vista principal de administración de banners.
     */
    public function index()
    {
        $banners = WelcomeBanner::orderBy('orden')->get();
        return view('admin.configuracion.ayuda.index', compact('banners'));
    }

    /**
     * Almacena un nuevo banner.
     */
    public function store(Request $request)
    {
        $request->validate([
            'banner_titulo'      => 'required|string|max:255',
            'banner_subtitulo'   => 'nullable|string|max:255',
            'banner_color_fondo' => 'nullable|string|max:20',
            'banner_color_texto' => 'nullable|string|max:20',
            'media_tipo'         => 'required|in:video,imagen',
            'media_archivo'      => 'nullable|file|mimes:mp4,webm,ogg,jpg,jpeg,png,gif,webp|max:102400',
            'media_url'          => 'nullable|url|max:500',
            'media_titulo'       => 'nullable|string|max:255',
        ]);

        $data = $request->except('media_archivo');
        $data['activo'] = $request->has('activo') ? 1 : 0;
        $data['orden'] = WelcomeBanner::max('orden') + 1;

        // Subir archivo si se proporciona
        if ($request->hasFile('media_archivo')) {
            $archivo = $request->file('media_archivo');
            $path = $archivo->store('welcome_banners', 'public');
            $data['media_archivo'] = $path;
        }

        WelcomeBanner::create($data);

        return redirect()->route('configuracion.ayuda')
            ->with('success', 'Banner creado exitosamente.');
    }

    /**
     * Actualiza un banner existente.
     */
    public function update(Request $request, $id)
    {
        $banner = WelcomeBanner::findOrFail($id);

        $request->validate([
            'banner_titulo'      => 'required|string|max:255',
            'banner_subtitulo'   => 'nullable|string|max:255',
            'banner_color_fondo' => 'nullable|string|max:20',
            'banner_color_texto' => 'nullable|string|max:20',
            'media_tipo'         => 'required|in:video,imagen',
            'media_archivo'      => 'nullable|file|mimes:mp4,webm,ogg,jpg,jpeg,png,gif,webp|max:102400',
            'media_url'          => 'nullable|url|max:500',
            'media_titulo'       => 'nullable|string|max:255',
        ]);

        $data = $request->except(['media_archivo', '_method', '_token']);
        $data['activo'] = $request->has('activo') ? 1 : 0;

        // Subir nuevo archivo si se proporciona
        if ($request->hasFile('media_archivo')) {
            // Eliminar archivo anterior
            if ($banner->media_archivo) {
                Storage::disk('public')->delete($banner->media_archivo);
            }
            $archivo = $request->file('media_archivo');
            $path = $archivo->store('welcome_banners', 'public');
            $data['media_archivo'] = $path;
        }

        $banner->update($data);

        return redirect()->route('configuracion.ayuda')
            ->with('success', 'Banner actualizado exitosamente.');
    }

    /**
     * Elimina un banner.
     */
    public function destroy($id)
    {
        $banner = WelcomeBanner::findOrFail($id);

        // Eliminar archivo asociado
        if ($banner->media_archivo) {
            Storage::disk('public')->delete($banner->media_archivo);
        }

        $banner->delete();

        return redirect()->route('configuracion.ayuda')
            ->with('success', 'Banner eliminado exitosamente.');
    }

    /**
     * Activa/desactiva un banner.
     */
    public function toggleActivo($id)
    {
        $banner = WelcomeBanner::findOrFail($id);
        $banner->activo = !$banner->activo;
        $banner->save();

        return response()->json(['success' => true, 'activo' => $banner->activo]);
    }

    /**
     * Actualiza el orden de los banners.
     */
    public function updateOrden(Request $request)
    {
        $orden = $request->input('orden', []);
        foreach ($orden as $index => $id) {
            WelcomeBanner::where('id', $id)->update(['orden' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
