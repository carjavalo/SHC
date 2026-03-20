<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WelcomeBanner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AyudaController extends Controller
{
    /**
     * Asegura que la tabla welcome_banners exista, creándola si no.
     */
    private function ensureTableExists()
    {
        if (!Schema::hasTable('welcome_banners')) {
            Schema::create('welcome_banners', function (Blueprint $table) {
                $table->id();
                $table->string('banner_titulo')->nullable();
                $table->string('banner_subtitulo')->nullable();
                $table->string('banner_color_fondo', 20)->default('#2c4370');
                $table->string('banner_color_texto', 20)->default('#ffffff');
                $table->enum('media_tipo', ['video', 'imagen'])->default('video');
                $table->string('media_archivo')->nullable();
                $table->string('media_url')->nullable();
                $table->string('media_titulo')->nullable();
                $table->boolean('activo')->default(true);
                $table->integer('orden')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Muestra la vista principal de administración de banners.
     */
    public function index()
    {
        $this->ensureTableExists();
        $banners = WelcomeBanner::orderBy('orden')->get();
        return view('admin.configuracion.ayuda.index', compact('banners'));
    }

    /**
     * Almacena un nuevo banner.
     */
    public function store(Request $request)
    {
        $this->ensureTableExists();

        $request->validate([
            'banner_titulo'      => 'required|string|max:255',
            'banner_subtitulo'   => 'nullable|string|max:255',
            'banner_color_fondo' => 'nullable|string|max:20',
            'banner_color_texto' => 'nullable|string|max:20',
            'media_tipo'         => 'required|in:video,imagen',
            'media_archivo'      => 'nullable|file|mimes:mp4,webm,ogg,jpg,jpeg,png,gif,webp|max:51200',
            'media_url'          => 'nullable|url|max:500',
            'media_titulo'       => 'nullable|string|max:255',
        ]);

        try {
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

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Banner creado exitosamente.']);
            }

            return redirect()->route('configuracion.ayuda')
                ->with('success', 'Banner creado exitosamente.');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Error al crear el banner: ' . $e->getMessage()], 500);
            }
            return redirect()->route('configuracion.ayuda')
                ->with('error', 'Error al crear el banner: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza un banner existente.
     */
    public function update(Request $request, $id)
    {
        $this->ensureTableExists();
        $banner = WelcomeBanner::findOrFail($id);

        $request->validate([
            'banner_titulo'      => 'required|string|max:255',
            'banner_subtitulo'   => 'nullable|string|max:255',
            'banner_color_fondo' => 'nullable|string|max:20',
            'banner_color_texto' => 'nullable|string|max:20',
            'media_tipo'         => 'required|in:video,imagen',
            'media_archivo'      => 'nullable|file|mimes:mp4,webm,ogg,jpg,jpeg,png,gif,webp|max:51200',
            'media_url'          => 'nullable|url|max:500',
            'media_titulo'       => 'nullable|string|max:255',
        ]);

        try {
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

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Banner actualizado exitosamente.']);
            }

            return redirect()->route('configuracion.ayuda')
                ->with('success', 'Banner actualizado exitosamente.');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Error al actualizar el banner: ' . $e->getMessage()], 500);
            }
            return redirect()->route('configuracion.ayuda')
                ->with('error', 'Error al actualizar el banner: ' . $e->getMessage());
        }
    }

    /**
     * Elimina un banner.
     */
    public function destroy($id)
    {
        $this->ensureTableExists();
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
        $this->ensureTableExists();
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
        $this->ensureTableExists();
        $orden = $request->input('orden', []);
        foreach ($orden as $index => $id) {
            WelcomeBanner::where('id', $id)->update(['orden' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
