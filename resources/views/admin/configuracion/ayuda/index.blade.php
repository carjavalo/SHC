@extends('adminlte::page')

@section('title', 'Ayuda - Administrar Contenido de Inicio')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0 text-dark"><i class="fas fa-tv mr-2"></i>Administrar Contenido de Pantalla de Inicio</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalCrear">
            <i class="fas fa-plus mr-1"></i> Nuevo Banner / Media
        </button>
    </div>
@stop

@section('content')

{{-- Mensajes de éxito/error --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

{{-- Vista previa de la pantalla de inicio --}}
<div class="card card-outline card-info mb-4">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-eye mr-2"></i>Vista Previa de la Pantalla de Inicio</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
        </div>
    </div>
    <div class="card-body p-0">
        <div id="preview-container" style="position: relative; background: url('{{ asset('images/huv.jpg') }}') no-repeat center center; background-size: cover; min-height: 400px; border-radius: 0 0 5px 5px;">
            <div style="background-color: rgba(0,0,0,0.6); min-height: 400px; padding: 20px;">
                
                {{-- Banner superior --}}
                @php $bannerActivo = $banners->where('activo', true)->first(); @endphp
                <div id="preview-banner" style="background-color: {{ $bannerActivo ? $bannerActivo->banner_color_fondo : '#2c4370' }}; border: 2px dashed rgba(255,255,255,0.3); border-radius: 8px; padding: 15px 25px; margin-bottom: 20px; text-align: center;">
                    <h3 style="color: {{ $bannerActivo ? $bannerActivo->banner_color_texto : '#fff' }}; margin: 0; font-weight: 600;">
                        {{ $bannerActivo ? $bannerActivo->banner_titulo : 'MENSAJE TIPO BANNER' }}
                    </h3>
                    @if($bannerActivo && $bannerActivo->banner_subtitulo)
                        <p style="color: {{ $bannerActivo ? $bannerActivo->banner_color_texto : '#fff' }}; margin: 5px 0 0; opacity: 0.9;">
                            {{ $bannerActivo->banner_subtitulo }}
                        </p>
                    @endif
                </div>

                <div class="row">
                    {{-- Área de video/imagen --}}
                    <div class="col-md-8">
                        <div id="preview-media" style="background-color: rgba(0,0,0,0.4); border: 2px dashed rgba(255,255,255,0.3); border-radius: 8px; min-height: 280px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                            @if($bannerActivo)
                                @if($bannerActivo->media_tipo === 'video')
                                    @if($bannerActivo->esYoutube())
                                        <iframe src="{{ $bannerActivo->getYoutubeEmbedUrl() }}" style="width: 100%; height: 280px; border: none; border-radius: 8px;" allowfullscreen></iframe>
                                    @elseif($bannerActivo->media_archivo)
                                        <video controls style="width: 100%; height: 280px; object-fit: contain; border-radius: 8px;">
                                            <source src="{{ asset('storage/' . $bannerActivo->media_archivo) }}" type="video/mp4">
                                        </video>
                                    @else
                                        <span style="color: rgba(255,255,255,0.5); font-size: 1.2rem;">VIDEO ILUSTRATIVO</span>
                                    @endif
                                @else
                                    @if($bannerActivo->media_archivo)
                                        <img src="{{ asset('storage/' . $bannerActivo->media_archivo) }}" style="width: 100%; height: 280px; object-fit: contain; border-radius: 8px;" alt="{{ $bannerActivo->media_titulo }}">
                                    @else
                                        <span style="color: rgba(255,255,255,0.5); font-size: 1.2rem;">IMAGEN ILUSTRATIVA</span>
                                    @endif
                                @endif
                            @else
                                <span style="color: rgba(255,255,255,0.5); font-size: 1.2rem;">VIDEO ILUSTRATIVO</span>
                            @endif
                        </div>
                    </div>

                    {{-- Formulario de ejemplo (solo visual) --}}
                    <div class="col-md-4">
                        <div style="background-color: rgba(255,255,255,0.9); border-radius: 8px; padding: 15px; min-height: 280px;">
                            <div style="background: linear-gradient(135deg, #2c4370, #1e2f4d); color: white; padding: 10px; border-radius: 5px; margin-bottom: 10px; text-align: center;">
                                <strong style="font-size: 0.85rem;">Hospital Universitario del Valle</strong>
                                <p style="margin: 3px 0 0; font-size: 0.75rem;">Gestión Educativa</p>
                            </div>
                            <div style="color: #999; text-align: center; padding: 20px; font-size: 0.8rem;">
                                <i class="fas fa-lock" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
                                Formulario de Login / Registro<br>
                                <small class="text-muted">(No se modifica desde aquí)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Listado de banners/media --}}
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-list mr-2"></i>Banners y Contenido Multimedia Configurados</h3>
    </div>
    <div class="card-body">
        @if($banners->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-photo-video text-muted" style="font-size: 4rem;"></i>
                <p class="text-muted mt-3">No hay contenido configurado aún.</p>
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalCrear">
                    <i class="fas fa-plus mr-1"></i> Crear Primer Banner
                </button>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Título del Banner</th>
                            <th>Tipo Media</th>
                            <th>Título del Media</th>
                            <th style="width: 100px;">Estado</th>
                            <th style="width: 80px;">Colores</th>
                            <th style="width: 200px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="sortable-banners">
                        @foreach($banners as $banner)
                        <tr data-id="{{ $banner->id }}">
                            <td><i class="fas fa-grip-vertical text-muted mr-1" style="cursor: grab;"></i> {{ $banner->orden + 1 }}</td>
                            <td>
                                <strong>{{ $banner->banner_titulo }}</strong>
                                @if($banner->banner_subtitulo)
                                    <br><small class="text-muted">{{ $banner->banner_subtitulo }}</small>
                                @endif
                            </td>
                            <td>
                                @if($banner->media_tipo === 'video')
                                    <span class="badge badge-info"><i class="fas fa-video mr-1"></i>Video</span>
                                    @if($banner->esYoutube())
                                        <span class="badge badge-danger"><i class="fab fa-youtube mr-1"></i>YouTube</span>
                                    @endif
                                @else
                                    <span class="badge badge-success"><i class="fas fa-image mr-1"></i>Imagen</span>
                                @endif
                            </td>
                            <td>{{ $banner->media_titulo ?? '-' }}</td>
                            <td>
                                <button class="btn btn-sm toggle-activo {{ $banner->activo ? 'btn-success' : 'btn-secondary' }}" data-id="{{ $banner->id }}">
                                    <i class="fas {{ $banner->activo ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                    {{ $banner->activo ? 'Activo' : 'Inactivo' }}
                                </button>
                            </td>
                            <td>
                                <span style="display: inline-block; width: 22px; height: 22px; border-radius: 4px; background-color: {{ $banner->banner_color_fondo }}; border: 1px solid #ddd;" title="Fondo: {{ $banner->banner_color_fondo }}"></span>
                                <span style="display: inline-block; width: 22px; height: 22px; border-radius: 4px; background-color: {{ $banner->banner_color_texto }}; border: 1px solid #ddd;" title="Texto: {{ $banner->banner_color_texto }}"></span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEditar{{ $banner->id }}" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-info btn-preview-media" data-id="{{ $banner->id }}" title="Vista previa">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <form action="{{ route('configuracion.ayuda.destroy', $banner->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este banner?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- MODAL: Crear nuevo banner --}}
<div class="modal fade" id="modalCrear" tabindex="-1" role="dialog" aria-labelledby="modalCrearLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('configuracion.ayuda.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalCrearLabel"><i class="fas fa-plus-circle mr-2"></i>Nuevo Banner / Contenido Multimedia</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {{-- Configuración del Banner Superior --}}
                        <div class="col-md-12">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-heading mr-1"></i> Configuración del Banner Superior
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="banner_titulo"><strong>Título del Banner</strong> <span class="text-danger">*</span></label>
                                <input type="text" name="banner_titulo" class="form-control" placeholder="Ej: Bienvenidos al Hospital Universitario" required>
                                <small class="form-text text-muted">Este texto se muestra en la franja superior de la pantalla de inicio.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="banner_subtitulo"><strong>Subtítulo</strong></label>
                                <input type="text" name="banner_subtitulo" class="form-control" placeholder="Ej: Plataforma de Gestión Educativa">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><strong>Color de Fondo</strong></label>
                                <input type="color" name="banner_color_fondo" class="form-control" value="#2c4370" style="height: 40px;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><strong>Color del Texto</strong></label>
                                <input type="color" name="banner_color_texto" class="form-control" value="#ffffff" style="height: 40px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Estado</strong></label>
                                <div class="custom-control custom-switch mt-2">
                                    <input type="checkbox" class="custom-control-input" id="activo_crear" name="activo" checked>
                                    <label class="custom-control-label" for="activo_crear">Activo (visible en la pantalla de inicio)</label>
                                </div>
                            </div>
                        </div>

                        {{-- Configuración del Media --}}
                        <div class="col-md-12 mt-3">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-photo-video mr-1"></i> Contenido Multimedia (Video o Imagen)
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Tipo de Media</strong> <span class="text-danger">*</span></label>
                                <select name="media_tipo" class="form-control select-media-tipo" required>
                                    <option value="video">Video</option>
                                    <option value="imagen">Imagen</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Título del Media</strong></label>
                                <input type="text" name="media_titulo" class="form-control" placeholder="Ej: Video institucional 2026">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Subir Archivo</strong></label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="media_archivo" id="media_archivo_crear" accept="video/mp4,video/webm,video/ogg,image/jpeg,image/png,image/gif,image/webp">
                                    <label class="custom-file-label" for="media_archivo_crear" data-browse="Explorar">Seleccionar archivo...</label>
                                </div>
                                <small class="form-text text-muted">Formatos: MP4, WebM, OGG, JPG, PNG, GIF, WebP. Máx: 100MB</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>O URL externa (YouTube, etc.)</strong></label>
                                <input type="url" name="media_url" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                                <small class="form-text text-muted">Si se especifica URL, tiene prioridad sobre el archivo subido.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Guardar Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODALES: Editar cada banner --}}
@foreach($banners as $banner)
<div class="modal fade" id="modalEditar{{ $banner->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('configuracion.ayuda.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning">
                    <h5 class="modal-title"><i class="fas fa-edit mr-2"></i>Editar Banner #{{ $banner->id }}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-heading mr-1"></i> Configuración del Banner Superior
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Título del Banner</strong> <span class="text-danger">*</span></label>
                                <input type="text" name="banner_titulo" class="form-control" value="{{ $banner->banner_titulo }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Subtítulo</strong></label>
                                <input type="text" name="banner_subtitulo" class="form-control" value="{{ $banner->banner_subtitulo }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><strong>Color de Fondo</strong></label>
                                <input type="color" name="banner_color_fondo" class="form-control" value="{{ $banner->banner_color_fondo }}" style="height: 40px;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><strong>Color del Texto</strong></label>
                                <input type="color" name="banner_color_texto" class="form-control" value="{{ $banner->banner_color_texto }}" style="height: 40px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Estado</strong></label>
                                <div class="custom-control custom-switch mt-2">
                                    <input type="checkbox" class="custom-control-input" id="activo_editar_{{ $banner->id }}" name="activo" {{ $banner->activo ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="activo_editar_{{ $banner->id }}">Activo</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class="fas fa-photo-video mr-1"></i> Contenido Multimedia
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Tipo de Media</strong></label>
                                <select name="media_tipo" class="form-control select-media-tipo">
                                    <option value="video" {{ $banner->media_tipo === 'video' ? 'selected' : '' }}>Video</option>
                                    <option value="imagen" {{ $banner->media_tipo === 'imagen' ? 'selected' : '' }}>Imagen</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Título del Media</strong></label>
                                <input type="text" name="media_titulo" class="form-control" value="{{ $banner->media_titulo }}">
                            </div>
                        </div>

                        {{-- Mostrar archivo/URL actual --}}
                        @if($banner->media_archivo || $banner->media_url)
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle mr-1"></i>
                                <strong>Media actual:</strong>
                                @if($banner->media_url)
                                    URL: <a href="{{ $banner->media_url }}" target="_blank">{{ Str::limit($banner->media_url, 60) }}</a>
                                @elseif($banner->media_archivo)
                                    Archivo: {{ basename($banner->media_archivo) }}
                                @endif
                            </div>
                        </div>
                        @endif

                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Subir Nuevo Archivo</strong></label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="media_archivo" id="media_archivo_editar_{{ $banner->id }}" accept="video/mp4,video/webm,video/ogg,image/jpeg,image/png,image/gif,image/webp">
                                    <label class="custom-file-label" for="media_archivo_editar_{{ $banner->id }}" data-browse="Explorar">Seleccionar archivo...</label>
                                </div>
                                <small class="form-text text-muted">Deja vacío para mantener el archivo actual.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>O URL externa</strong></label>
                                <input type="url" name="media_url" class="form-control" value="{{ $banner->media_url }}" placeholder="https://www.youtube.com/watch?v=...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- MODAL: Vista previa de media --}}
<div class="modal fade" id="modalPreviewMedia" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-eye mr-2"></i>Vista Previa</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body text-center p-4" id="preview-media-body" style="min-height: 300px; background: #111;">
                <p class="text-muted">Cargando...</p>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
<style>
    .toggle-activo {
        min-width: 100px;
        transition: all 0.3s;
    }
    .custom-file-label::after {
        content: "Explorar";
    }
    #sortable-banners tr {
        transition: background-color 0.3s;
    }
    #sortable-banners tr:hover {
        background-color: rgba(0,123,255,0.05);
    }
</style>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Actualizar label del file input al seleccionar archivo
    $(document).on('change', '.custom-file-input', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass('selected').html(fileName || 'Seleccionar archivo...');
    });

    // Toggle activo/inactivo
    $(document).on('click', '.toggle-activo', function() {
        var btn = $(this);
        var id = btn.data('id');

        $.ajax({
            url: '{{ url("configuracion/ayuda") }}/' + id + '/toggle',
            type: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                if (response.success) {
                    if (response.activo) {
                        btn.removeClass('btn-secondary').addClass('btn-success');
                        btn.html('<i class="fas fa-eye"></i> Activo');
                    } else {
                        btn.removeClass('btn-success').addClass('btn-secondary');
                        btn.html('<i class="fas fa-eye-slash"></i> Inactivo');
                    }
                    location.reload();
                }
            },
            error: function() {
                alert('Error al cambiar el estado.');
            }
        });
    });

    // Vista previa individual de media
    var bannersData = @json($banners);
    $(document).on('click', '.btn-preview-media', function() {
        var id = $(this).data('id');
        var banner = bannersData.find(function(b) { return b.id == id; });
        var html = '';

        if (banner) {
            if (banner.media_url && (banner.media_url.includes('youtube.com') || banner.media_url.includes('youtu.be'))) {
                var videoId = '';
                var match = banner.media_url.match(/[?&]v=([^&]+)/);
                if (match) videoId = match[1];
                else {
                    match = banner.media_url.match(/youtu\.be\/([^?&]+)/);
                    if (match) videoId = match[1];
                }
                if (videoId) {
                    html = '<iframe src="https://www.youtube.com/embed/' + videoId + '" style="width:100%;height:450px;border:none;" allowfullscreen></iframe>';
                }
            } else if (banner.media_tipo === 'video' && banner.media_archivo) {
                html = '<video controls autoplay style="max-width:100%;max-height:450px;"><source src="{{ asset("storage") }}/' + banner.media_archivo + '" type="video/mp4"></video>';
            } else if (banner.media_tipo === 'imagen' && banner.media_archivo) {
                html = '<img src="{{ asset("storage") }}/' + banner.media_archivo + '" style="max-width:100%;max-height:450px;" alt="Vista previa">';
            } else {
                html = '<p class="text-white mt-5">No hay media configurado para este banner.</p>';
            }

            html = '<div style="background-color:' + banner.banner_color_fondo + ';padding:10px 20px;border-radius:5px;margin-bottom:15px;"><h4 style="color:' + banner.banner_color_texto + ';margin:0;">' + banner.banner_titulo + '</h4></div>' + html;
        }

        $('#preview-media-body').html(html);
        $('#modalPreviewMedia').modal('show');
    });

    // Limpiar iframe/video al cerrar modal preview
    $('#modalPreviewMedia').on('hidden.bs.modal', function () {
        $('#preview-media-body').html('<p class="text-muted">Cargando...</p>');
    });
});
</script>
@stop