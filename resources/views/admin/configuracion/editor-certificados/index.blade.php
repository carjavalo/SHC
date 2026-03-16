@extends('adminlte::page')

@section('title', 'Editor de Certificados')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-certificate"></i> Editor de Certificados</h1>
                <p class="text-muted">Diseñe y genere certificados personalizados para los participantes de los cursos.</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Configuración</a></li>
                    <li class="breadcrumb-item active">Editor de Certificados</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
<div id="editor-certificados-app">
    {{-- Barra de herramientas superior --}}
    <div class="d-flex align-items-center justify-content-between mb-3 p-3 bg-white rounded shadow-sm">
        <div class="d-flex align-items-center">
            <div style="width:40px;height:40px;background:#1e3a8a;border-radius:8px;" class="d-flex align-items-center justify-content-center text-white mr-3">
                <i class="fas fa-file-alt"></i>
            </div>
            <div>
                <h5 class="mb-0 font-weight-bold" style="color:#1e3a8a;">Editor de Certificados</h5>
                <small class="text-muted text-uppercase" style="font-size:10px;letter-spacing:1px;">Hospital Universitario del Valle</small>
            </div>
        </div>
        <div class="d-flex align-items-center">
            @if(isset($plantillas) && count($plantillas) > 0)
            <select id="selectPlantilla" class="form-control form-control-sm mr-2" style="width: 150px;">
                <option value="">-- Cargar --</option>
                @foreach($plantillas as $plantilla)
                    <option value="{{ $plantilla->id }}">{{ $plantilla->nombre }}</option>
                @endforeach
            </select>
            @endif
            <button class="btn btn-outline-success btn-sm mr-2" id="btnGuardarPlantilla" data-toggle="modal" data-target="#modalGuardarPlantilla">
                <i class="fas fa-save mr-1"></i> Guardar Plantilla
            </button>
            <button class="btn btn-outline-secondary btn-sm mr-2" id="btnVistaPrevia">
                <i class="fas fa-eye mr-1"></i> Vista Previa
            </button>
            <button class="btn btn-sm text-white font-weight-bold" style="background:#1e3a8a;" id="btnGenerarCertificado">
                <i class="fas fa-download mr-1"></i> Generar Certificado
            </button>
        </div>
    </div>

    <div class="row" style="min-height: calc(100vh - 250px);">
        {{-- Panel lateral izquierdo de configuración --}}
        <div class="col-md-4 col-lg-3">
            <div class="card card-outline card-primary" style="max-height: calc(100vh - 250px); overflow-y: auto;">
                <div class="card-body p-3" style="font-family: 'Inter', sans-serif;">
                    <div class="space-y-4">

                        {{-- Selección de usuario --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted font-weight-bold" style="font-size:10px;letter-spacing:2px;">
                                <i class="fas fa-chalkboard-teacher mr-1"></i> Seleccionar Docente
                            </h6>
                            <select class="form-control form-control-sm mt-2" id="selectDocente">
                                <option value="">-- Seleccione un docente --</option>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}"
                                            data-name="{{ $usuario->name }}"
                                            data-apellido1="{{ $usuario->apellido1 }}"
                                            data-apellido2="{{ $usuario->apellido2 }}"
                                            data-documento="{{ $usuario->numero_documento }}">
                                        {{ $usuario->name }} {{ $usuario->apellido1 }} {{ $usuario->apellido2 }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Selección de curso --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted font-weight-bold" style="font-size:10px;letter-spacing:2px;">
                                <i class="fas fa-book-open mr-1"></i> Seleccionar Curso
                            </h6>
                            <select class="form-control form-control-sm mt-2" id="selectCurso">
                                <option value="">-- Seleccione un curso --</option>
                                
                            </select>
                        </div>

                        {{-- Selección de estudiante --}}
                        <div class="mb-4" id="containerSelectEstudiante" style="display:none;">
                            <h6 class="text-uppercase text-muted font-weight-bold" style="font-size:10px;letter-spacing:2px;">
                                <i class="fas fa-user-graduate mr-1"></i> Seleccionar Estudiante
                            </h6>
                            <select class="form-control form-control-sm mt-2" id="selectEstudiante">
                                <option value="">-- Seleccione un estudiante --</option>
                            </select>
                            <small class="text-muted" style="font-size:10px;" id="infoEstudiantes"></small>
                        </div>

                        <hr>

                        {{-- Imagen de fondo --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted font-weight-bold" style="font-size:10px;letter-spacing:2px;">
                                <i class="fas fa-image mr-1"></i> Imagen de Fondo
                            </h6>
                            <div class="border border-dashed rounded p-3 text-center mt-2" style="background:#f8fafc;">
                                <i class="fas fa-cloud-upload-alt text-muted mb-2" style="font-size:24px;"></i>
                                <p class="text-muted mb-2" style="font-size:11px;">Sube el fondo institucional (JPG/PNG)</p>
                                <input type="file" id="inputFondo" accept="image/jpeg,image/png" class="d-none">
                                <button class="btn btn-sm btn-outline-secondary btn-block" onclick="document.getElementById('inputFondo').click()">
                                    Cargar Fondo
                                </button>
                            </div>
                        </div>

                        {{-- Logotipos --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted font-weight-bold" style="font-size:10px;letter-spacing:2px;">
                                <i class="fas fa-stamp mr-1"></i> Logotipos
                            </h6>
                            <div class="row mt-2">
                                <div class="col-6">
                                    <label class="text-muted text-uppercase" style="font-size:9px;font-weight:700;">Logo 1</label>
                                    <input type="file" id="inputLogo1" accept="image/*" class="d-none">
                                    <button class="btn btn-xs btn-outline-secondary btn-block mb-1" onclick="document.getElementById('inputLogo1').click()">
                                        <i class="fas fa-plus"></i> Cargar
                                    </button>
                                    <label class="text-muted text-uppercase" style="font-size:9px;font-weight:700;">Ancho</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" class="form-control" id="logo1Ancho" value="120">
                                        <div class="input-group-append"><span class="input-group-text" style="font-size:10px;">px</span></div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted text-uppercase" style="font-size:9px;font-weight:700;">Logo 2</label>
                                    <input type="file" id="inputLogo2" accept="image/*" class="d-none">
                                    <button class="btn btn-xs btn-outline-secondary btn-block mb-1" onclick="document.getElementById('inputLogo2').click()">
                                        <i class="fas fa-plus"></i> Cargar
                                    </button>
                                    <label class="text-muted text-uppercase" style="font-size:9px;font-weight:700;">Ancho</label>
                                    <div class="input-group input-group-sm">
                                        <input type="number" class="form-control" id="logo2Ancho" value="120">
                                        <div class="input-group-append"><span class="input-group-text" style="font-size:10px;">px</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Identificación --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted font-weight-bold" style="font-size:10px;letter-spacing:2px;">
                                <i class="fas fa-id-card mr-1"></i> Identificación
                            </h6>
                            <div class="row mt-2">
                                <div class="col-6 mb-2">
                                    <label class="text-muted text-uppercase" style="font-size:9px;font-weight:700;">Nombres</label>
                                    <input type="text" class="form-control form-control-sm" id="inputNombres" placeholder="Juan" readonly>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="text-muted text-uppercase" style="font-size:9px;font-weight:700;">1er Apellido</label>
                                    <input type="text" class="form-control form-control-sm" id="inputApellido1" placeholder="Pérez" readonly>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="text-muted text-uppercase" style="font-size:9px;font-weight:700;">2do Apellido</label>
                                    <input type="text" class="form-control form-control-sm" id="inputApellido2" placeholder="García" readonly>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="text-muted text-uppercase" style="font-size:9px;font-weight:700;">Documento</label>
                                    <input type="text" class="form-control form-control-sm" id="inputDocumento" placeholder="CC. 12345678" readonly>
                                </div>
                            </div>
                        </div>

                        {{-- Contenido --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted font-weight-bold" style="font-size:10px;letter-spacing:2px;">
                                <i class="fas fa-pen-nib mr-1"></i> Contenido
                            </h6>
                            <div class="mt-2">
                                <label class="text-muted text-uppercase" style="font-size:9px;font-weight:700;">Nombre del Curso</label>
                                <input type="text" class="form-control form-control-sm mb-2" id="inputCursoNombre" placeholder="Seminario de Urgencias Médicas" readonly>

                                <label class="text-muted text-uppercase" style="font-size:9px;font-weight:700;">Detalle Adicional</label>
                                <textarea class="form-control form-control-sm mb-2" id="inputDetalle" rows="2" placeholder="En calidad de asistente con mención..."></textarea>

                                <label class="text-muted text-uppercase" style="font-size:9px;font-weight:700;">Intensidad Horaria</label>
                                <input type="number" class="form-control form-control-sm mb-2" id="inputHoras" placeholder="40" readonly>

                                <div class="row">
                                    <div class="col-6">
                                        <label class="text-muted text-uppercase" style="font-size:9px;font-weight:700;">Fecha Inicio</label>
                                        <input type="date" class="form-control form-control-sm" id="inputFechaInicio" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-muted text-uppercase" style="font-size:9px;font-weight:700;">Fecha Fin</label>
                                        <input type="date" class="form-control form-control-sm" id="inputFechaFin" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Validadores (editables desde la vista) --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted font-weight-bold" style="font-size:10px;letter-spacing:2px;">
                                <i class="fas fa-signature mr-1"></i> Validadores
                            </h6>
                            <div class="mt-2">
                                <label class="text-muted text-uppercase" style="font-size:9px;font-weight:700;">Nombre Firma</label>
                                <input type="text" class="form-control form-control-sm mb-2" id="inputFirmaNombre" placeholder="Dr. Armando Casas">

                                <label class="text-muted text-uppercase" style="font-size:9px;font-weight:700;">Cargo Responsable</label>
                                <input type="text" class="form-control form-control-sm" id="inputFirmaCargo" placeholder="Director de Docencia HUV">
                            </div>
                        </div>

                        {{-- Estilo visual --}}
                        <div class="mb-3 pt-3 border-top">
                            <h6 class="text-uppercase text-muted font-weight-bold" style="font-size:10px;letter-spacing:2px;">Estilo Visual</h6>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <span class="text-muted" style="font-size:12px;">Tamaño Tipografía</span>
                                <span class="font-weight-bold" style="font-size:12px;color:#1e3a8a;" id="fontSizeLabel">24px</span>
                            </div>
                            <input type="range" class="custom-range mt-1" min="12" max="64" value="24" id="fontSizeRange">
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Panel principal: Canvas del certificado --}}
        <div class="col-md-8 col-lg-9">
            {{-- Barra de herramientas del canvas --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="btn-group btn-group-sm bg-white rounded shadow-sm">
                    <button class="btn btn-light" title="Seleccionar" style="color:#1e3a8a;">
                        <i class="fas fa-mouse-pointer"></i>
                    </button>
                    <button class="btn btn-light" title="Mover Lienzo">
                        <i class="fas fa-hand-paper"></i>
                    </button>
                    <div class="btn-group-separator" style="width:1px;background:#dee2e6;"></div>
                    <button class="btn btn-light" title="Zoom In" id="btnZoomIn">
                        <i class="fas fa-search-plus"></i>
                    </button>
                    <span class="btn btn-light disabled font-weight-bold" style="font-size:11px;" id="zoomLabel">100%</span>
                    <button class="btn btn-light" title="Zoom Out" id="btnZoomOut">
                        <i class="fas fa-search-minus"></i>
                    </button>
                </div>
                <span class="badge badge-light text-uppercase font-weight-bold shadow-sm" style="letter-spacing:2px;font-size:10px;">
                    Modo Edición Capas
                </span>
            </div>

            {{-- Canvas del certificado --}}
            <div id="certificateWrapper" style="overflow:auto; max-height: calc(100vh - 310px);">
                <div id="certificate" class="certificate-canvas bg-white position-relative mx-auto" style="width:100%;max-width:960px;box-shadow: 0 20px 50px -12px rgba(0,0,0,0.25);">
                    {{-- Logo HUV --}}
                    <div class="draggable-element position-absolute d-flex flex-column align-items-center justify-content-center text-center rounded"
                         id="logoHUV"
                        style="z-index:20;top:6%;left:8%;width:160px;height:96px;border:2px dashed #94a3b8;background:rgba(255,255,255,0.4);backdrop-filter:blur(2px);cursor:move;user-select:none;">
                        <i class="fas fa-plus-circle text-muted mb-1" style="font-size:20px;"></i>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size:9px;">Logotipo HUV</span>
                    </div>

                    {{-- Logo Institución --}}
                    <div class="draggable-element position-absolute d-flex flex-column align-items-center justify-content-center text-center rounded"
                         id="logoInstitucion"
                        style="z-index:20;top:6%;right:8%;width:160px;height:96px;border:2px dashed #94a3b8;background:rgba(255,255,255,0.4);backdrop-filter:blur(2px);cursor:move;user-select:none;">
                        <i class="fas fa-plus-circle text-muted mb-1" style="font-size:20px;"></i>
                        <span class="text-muted text-uppercase font-weight-bold" style="font-size:9px;">Logotipo Institución</span>
                    </div>

                    {{-- Contenido central del certificado --}}
                    <div class="position-absolute d-flex flex-column align-items-center justify-content-center text-center" style="inset:0;padding:80px 96px;">

                        <div class="draggable-element mb-2 px-3 py-2">
                            <h2 class="text-uppercase font-weight-bold" style="color:#1e3a8a;font-size:16px;letter-spacing:4px;">El Hospital Universitario del Valle</h2>
                            <p class="text-muted font-italic" style="font-size:13px;">"Evaristo García" E.S.E.</p>
                        </div>

                        <div class="draggable-element my-3">
                            <p class="text-muted" style="font-size:13px;">Otorga el presente certificado a:</p>
                        </div>

                        <div class="draggable-element mb-4">
                            <h1 class="text-uppercase font-weight-bold" id="certNombreCompleto" style="font-size:2.8rem;color:#1e293b;letter-spacing:1px;">NOMBRE APELLIDO1 APELLIDO2</h1>
                            <div style="height:4px;width:96px;background:rgba(30,58,138,0.2);border-radius:4px;" class="mx-auto mt-1"></div>
                            <p class="text-muted font-weight-bold mt-1" id="certDocumento" style="font-size:13px;">C.C. 00.000.000 de Cali</p>
                        </div>

                        <div class="draggable-element mb-5" style="max-width:640px;">
                            <p class="text-secondary" style="line-height:1.7;font-size:14px;padding:0 40px;">
                                Por haber participado y aprobado satisfactoriamente las actividades académicas del curso
                                <span class="font-weight-bold font-italic" style="color:#1e3a8a;" id="certCursoNombre">NOMBRE DEL CURSO</span>, con una intensidad horaria de
                                <span class="font-weight-bold" id="certHoras">40</span> horas cronológicas, desarrollado bajo la modalidad presencial en las instalaciones del hospital.
                            </p>
                        </div>

                        <div class="draggable-element mb-4">
                            <p class="text-muted" style="font-size:13px;">
                                Realizado del <span class="font-weight-bold text-dark" id="certFechaInicio">01 de Enero</span> al <span class="font-weight-bold text-dark" id="certFechaFin">15 de Febrero de 2024</span>
                            </p>
                        </div>

                        <div class="mt-4 d-flex justify-content-center w-100">
                            <div class="draggable-element d-flex flex-column align-items-center" style="width:320px;">
                                <div class="w-100 border-bottom mb-2" style="opacity:0.5;"></div>
                                <p class="text-uppercase font-weight-bold mb-0" style="font-size:13px;letter-spacing:3px;" id="certFirmaNombre">FIRMACOR</p>
                                <p class="text-uppercase text-muted font-weight-bold" style="font-size:9px;letter-spacing:2px;" id="certFirmaCargo">CARGOCOR</p>
                            </div>
                        </div>
                    </div>

                    {{-- Pie de página --}}
                        {{-- Pie de página (eliminado por solicitud) --}}

                    {{-- Marca lateral --}}
                    <div class="position-absolute" style="right:24px;top:50%;transform:rotate(-90deg);transform-origin:right center;">
                        <span class="text-uppercase font-weight-bold" style="font-size:8px;color:#cbd5e1;letter-spacing:4px;">Certificación Académica V3.0 - 2024</span>
                    </div>
                </div>
            </div>

            {{-- Nota inferior --}}
            <div class="d-flex align-items-center bg-white rounded-pill shadow-sm px-4 py-2 mt-3 mx-auto" style="max-width:600px;">
                <i class="fas fa-info-circle mr-2" style="color:#1e3a8a;"></i>
                <p class="text-muted mb-0" style="font-size:11px;">
                    Todos los elementos (logos y textos) se pueden arrastrar para ajustar su posición sobre el fondo.
                </p>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --primary-huv: #1e3a8a;
        --silver-huv: #e2e8f0;
        --accent-huv: #0f172a;
    }
    #editor-certificados-app {
        font-family: 'Inter', sans-serif;
    }
    .certificate-canvas {
        aspect-ratio: unset;
        width: var(--cert-width, 960px);
        min-height: var(--cert-height, 680px);
        max-width: 100%;
        background-size: 100% 100%;
        background-repeat: no-repeat;
        background-position: center;
        position: relative;
    }
    .draggable-element {
        cursor: move;
        user-select: none;
        transition: outline 0.1s ease;
    }
    .draggable-element:hover {
        outline: 2px dashed var(--primary-huv);
        outline-offset: 4px;
    }
    .border-dashed {
        border-style: dashed !important;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .card::-webkit-scrollbar {
        width: 5px;
    }
    .card::-webkit-scrollbar-track {
        background: transparent;
    }
    .card::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .custom-range::-webkit-slider-thumb {
        background: #1e3a8a;
    }
    /* Menú contextual personalizado */
    .custom-context-menu {
        position: absolute;
        z-index: 9999;
        background: #fff;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(30,58,138,0.08);
        padding: 8px 0;
        min-width: 140px;
        font-size: 14px;
        display: none;
    }
    .custom-context-menu .menu-item {
        padding: 8px 16px;
        cursor: pointer;
        color: #1e3a8a;
        transition: background 0.2s;
    }
    .custom-context-menu .menu-item:hover {
        background: #e2e8f0;
    }
</style>

<!-- Modal para Guardar Plantilla -->
<div class="modal fade" id="modalGuardarPlantilla" tabindex="-1" role="dialog" aria-labelledby="modalGuardarLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('configuracion.editor-certificados.store') }}" method="POST" id="formGuardarPlantilla">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalGuardarLabel">Guardar Plantilla de Certificado</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="nombre_plantilla">Nombre de la plantilla</label>
            <input type="text" class="form-control" id="nombre_plantilla" name="nombre" required placeholder="Ej: Certificado de Aprobación 2026">
          </div>
          <input type="hidden" name="html_content" id="html_content_input">
          <input type="hidden" name="fondo_base64" id="fondo_base64_input">
          <input type="hidden" name="elementos_json" id="elementos_json_input">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" id="btnSubmitPlantilla">Guardar Plantilla</button>
        </div>
      </form>
    </div>
  </div>
</div>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // ===== Meses en español para formateo =====
    const meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

    function formatearFecha(dateStr) {
        if (!dateStr) return '';
        const parts = dateStr.split('-');
        const d = parseInt(parts[2], 10);
        const m = parseInt(parts[1], 10) - 1;
        const y = parts[0];
        return d + ' de ' + meses[m] + ' de ' + y;
    }

    // ===== Bandera para saber si hay una plantilla cargada =====
    let plantillaCargada = false;

    // ===== Selección de docente → carga cursos del docente =====
    const selectDocente = document.getElementById('selectDocente');
    selectDocente.addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        const containerEst = document.getElementById('containerSelectEstudiante');
        const selectEstudianteEl = document.getElementById('selectEstudiante');

        if (!this.value) {
            document.getElementById('inputNombres').value = '';
            document.getElementById('inputApellido1').value = '';
            document.getElementById('inputApellido2').value = '';
            document.getElementById('inputDocumento').value = '';
            // Resetear curso y estudiante
            document.getElementById('selectCurso').innerHTML = '<option value="">-- Seleccione un curso --</option>';
            containerEst.style.display = 'none';
            selectEstudianteEl.innerHTML = '<option value="">-- Seleccione un estudiante --</option>';
            document.getElementById('infoEstudiantes').textContent = '';
            document.getElementById('inputCursoNombre').value = '';
            document.getElementById('inputHoras').value = '';
            document.getElementById('inputFechaInicio').value = '';
            document.getElementById('inputFechaFin').value = '';
            actualizarCertificado();
            return;
        }

        // Guardar datos del docente para la firma SOLO si no hay plantilla cargada
        if (!plantillaCargada) {
            document.getElementById('inputFirmaNombre').value = (opt.dataset.name || '') + ' ' + (opt.dataset.apellido1 || '') + ' ' + (opt.dataset.apellido2 || '');
        }
        actualizarCertificado();
          
          // Cargar cursos al cambiar el docente
          const cursoSelect = document.getElementById('selectCurso');
          cursoSelect.innerHTML = '<option value="">Cargando...</option>';
          // Resetear estudiante
          containerEst.style.display = 'none';
          selectEstudianteEl.innerHTML = '<option value="">-- Seleccione un estudiante --</option>';
          document.getElementById('infoEstudiantes').textContent = '';
          document.getElementById('inputNombres').value = '';
          document.getElementById('inputApellido1').value = '';
          document.getElementById('inputApellido2').value = '';
          document.getElementById('inputDocumento').value = '';

          fetch('/configuracion/editor-certificados/docente/' + opt.value + '/cursos')
              .then(res => res.json())
              .then(cursos => {
                  cursoSelect.innerHTML = '<option value="">-- Seleccione un curso --</option>';
                  cursos.forEach(c => {
                      let dura = c.duracion_horas ? c.duracion_horas : ''; let fini = c.fecha_inicio ? c.fecha_inicio.substring(0,10) : ''; let ffin = c.fecha_fin ? c.fecha_fin.substring(0,10) : '';
                      cursoSelect.innerHTML += '<option value="'+c.id+'" data-titulo="'+c.titulo+'" data-duracion="'+dura+'" data-fecha-inicio="'+fini+'" data-fecha-fin="'+ffin+'">'+c.titulo+'</option>';
                  });
              })
              .catch(err => {
                  console.error("Error al cargar los cursos", err);
                  cursoSelect.innerHTML = '<option value="">-- Error --</option>';
              });
      });

    // ===== Selección de curso → llena campos de contenido y carga estudiantes =====
    const selectCurso = document.getElementById('selectCurso');
    selectCurso.addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        const containerEst = document.getElementById('containerSelectEstudiante');
        const selectEstudiante = document.getElementById('selectEstudiante');

        if (!this.value) {
            document.getElementById('inputCursoNombre').value = '';
            document.getElementById('inputHoras').value = '';
            document.getElementById('inputFechaInicio').value = '';
            document.getElementById('inputFechaFin').value = '';
            // Ocultar y resetear select de estudiantes
            containerEst.style.display = 'none';
            selectEstudiante.innerHTML = '<option value="">-- Seleccione un estudiante --</option>';
            document.getElementById('infoEstudiantes').textContent = '';
            // Limpiar datos del estudiante
            document.getElementById('inputNombres').value = '';
            document.getElementById('inputApellido1').value = '';
            document.getElementById('inputApellido2').value = '';
            document.getElementById('inputDocumento').value = '';
            actualizarCertificado();
            return;
        }
        document.getElementById('inputCursoNombre').value = opt.dataset.titulo || '';
        document.getElementById('inputHoras').value = opt.dataset.duracion || '';
        document.getElementById('inputFechaInicio').value = opt.dataset.fechaInicio || '';
        document.getElementById('inputFechaFin').value = opt.dataset.fechaFin || '';
        actualizarCertificado();

        // Cargar estudiantes del curso seleccionado
        containerEst.style.display = 'block';
        selectEstudiante.innerHTML = '<option value="">Cargando estudiantes...</option>';
        document.getElementById('infoEstudiantes').textContent = '';

        fetch('/configuracion/editor-certificados/curso/' + this.value + '/estudiantes')
            .then(res => res.json())
            .then(estudiantes => {
                selectEstudiante.innerHTML = '<option value="">-- Seleccione un estudiante --</option>';
                let aprobados = 0;
                let reprobados = 0;

                // Separar aprobados y reprobados
                const listaAprobados = [];
                const listaReprobados = [];
                estudiantes.forEach(est => {
                    if (est.aprobado) {
                        aprobados++;
                        listaAprobados.push(est);
                    } else {
                        reprobados++;
                        listaReprobados.push(est);
                    }
                });

                // Agregar aprobados (seleccionables)
                if (listaAprobados.length > 0) {
                    const grpAprobados = document.createElement('optgroup');
                    grpAprobados.label = '✅ Aprobados (' + aprobados + ')';
                    listaAprobados.forEach(est => {
                        const opcion = document.createElement('option');
                        opcion.value = est.id;
                        opcion.dataset.name = est.name;
                        opcion.dataset.apellido1 = est.apellido1;
                        opcion.dataset.apellido2 = est.apellido2;
                        opcion.dataset.documento = est.numero_documento;
                        opcion.dataset.aprobado = '1';
                        opcion.dataset.notaFinal = est.nota_final;
                        opcion.textContent = est.name + ' ' + est.apellido1 + ' ' + est.apellido2 + ' (Nota: ' + est.nota_final + ')';
                        grpAprobados.appendChild(opcion);
                    });
                    selectEstudiante.appendChild(grpAprobados);
                }

                // Agregar reprobados (deshabilitados, no seleccionables)
                if (listaReprobados.length > 0) {
                    const grpReprobados = document.createElement('optgroup');
                    grpReprobados.label = '❌ Reprobados (' + reprobados + ') — No se puede certificar';
                    listaReprobados.forEach(est => {
                        const opcion = document.createElement('option');
                        opcion.value = '';
                        opcion.disabled = true;
                        opcion.style.color = '#aaa';
                        opcion.textContent = est.name + ' ' + est.apellido1 + ' ' + est.apellido2 + ' (Nota: ' + est.nota_final + ') — REPROBADO';
                        grpReprobados.appendChild(opcion);
                    });
                    selectEstudiante.appendChild(grpReprobados);
                }

                document.getElementById('infoEstudiantes').innerHTML = estudiantes.length + ' estudiante(s) inscrito(s) — <strong style="color:green;">' + aprobados + ' aprobado(s)</strong>, <span style="color:#c00;">' + reprobados + ' reprobado(s)</span>';
            })
            .catch(err => {
                console.error('Error al cargar estudiantes', err);
                selectEstudiante.innerHTML = '<option value="">-- Error al cargar --</option>';
            });
    });

    // ===== Selección de estudiante → llena campos de identidad =====
    const selectEstudiante = document.getElementById('selectEstudiante');
    let estudianteAprobado = false;

    selectEstudiante.addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        const btnGenerar = document.getElementById('btnGenerarCertificado');

        // Si no seleccionó nada o el value está vacío (reprobado/disabled)
        if (!this.value) {
            document.getElementById('inputNombres').value = '';
            document.getElementById('inputApellido1').value = '';
            document.getElementById('inputApellido2').value = '';
            document.getElementById('inputDocumento').value = '';
            estudianteAprobado = false;
            btnGenerar.disabled = true;
            btnGenerar.style.opacity = '0.5';
            btnGenerar.style.pointerEvents = 'none';
            btnGenerar.title = 'Seleccione un estudiante aprobado para generar el certificado';
            actualizarCertificado();
            return;
        }

        // Solo los aprobados tienen value != '' (los reprobados tienen value="")
        estudianteAprobado = true;

        // Estudiante aprobado: habilitar botón y rellenar datos
        btnGenerar.disabled = false;
        btnGenerar.style.opacity = '1';
        btnGenerar.style.pointerEvents = 'auto';
        btnGenerar.title = '';
        document.getElementById('inputNombres').value = opt.dataset.name || '';
        document.getElementById('inputApellido1').value = opt.dataset.apellido1 || '';
        document.getElementById('inputApellido2').value = opt.dataset.apellido2 || '';
        document.getElementById('inputDocumento').value = opt.dataset.documento || '';
        actualizarCertificado();
    });

    // ===== Actualizar vista previa del certificado en tiempo real =====
    function actualizarCertificado() {
        const nombres = document.getElementById('inputNombres').value || 'NOMBRE';
        const ap1 = document.getElementById('inputApellido1').value || 'APELLIDO1';
        const ap2 = document.getElementById('inputApellido2').value || 'APELLIDO2';
        const doc = document.getElementById('inputDocumento').value || '00.000.000';
        const curso = document.getElementById('inputCursoNombre').value || 'NOMBRE DEL CURSO';
        const horas = document.getElementById('inputHoras').value || '40';
        const fInicio = document.getElementById('inputFechaInicio').value;
        const fFin = document.getElementById('inputFechaFin').value;
        const firmaNombre = document.getElementById('inputFirmaNombre').value || 'FIRMACOR';
        const firmaCargo = document.getElementById('inputFirmaCargo').value || 'CARGOCOR';

        document.getElementById('certNombreCompleto').textContent = (nombres + ' ' + ap1 + ' ' + ap2).toUpperCase();
        document.getElementById('certDocumento').textContent = 'C.C. ' + doc + ' de Cali';
        document.getElementById('certCursoNombre').textContent = curso;
        document.getElementById('certHoras').textContent = horas;
        document.getElementById('certFechaInicio').textContent = fInicio ? formatearFecha(fInicio) : '01 de Enero';
        document.getElementById('certFechaFin').textContent = fFin ? formatearFecha(fFin) : '15 de Febrero de 2024';
        document.getElementById('certFirmaNombre').textContent = firmaNombre.toUpperCase();
        document.getElementById('certFirmaCargo').textContent = firmaCargo.toUpperCase();
    }

    // Escuchar cambios en los campos editables (firma, detalle)
    ['inputFirmaNombre', 'inputFirmaCargo', 'inputDetalle'].forEach(function(id) {
        const el = document.getElementById(id);
        if (el) el.addEventListener('input', actualizarCertificado);
    });

    // ===== Tamaño de tipografía =====
    const fontRange = document.getElementById('fontSizeRange');
    const fontLabel = document.getElementById('fontSizeLabel');
    fontRange.addEventListener('input', function() {
        fontLabel.textContent = this.value + 'px';
        document.getElementById('certNombreCompleto').style.fontSize = this.value + 'px';
    });

    // ===== Carga de imagen de fondo =====
    document.getElementById('inputFondo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('certificate').style.backgroundImage = 'url(' + ev.target.result + ')';
        };
        reader.readAsDataURL(file);
    });

    // ===== Carga de logotipos =====
    document.getElementById('inputLogo1').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(ev) {
            let el = document.getElementById('logoHUV');
            if(!el) {
                el = document.createElement('div');
                el.id = 'logoHUV';
                el.className = 'draggable-element position-absolute d-flex flex-column align-items-center justify-content-center text-center rounded';
                el.style.cssText = 'z-index:20;top:6%;left:8%;width:' + (document.getElementById('logo1Ancho')?.value || 160) + 'px;height:96px;cursor:move;user-select:none;';
                document.getElementById('certificate').appendChild(el);
            }
            el.style.border = 'none';
            el.style.background = 'transparent';
            el.innerHTML = '<img src="' + ev.target.result + '" style="max-width:100%;max-height:100%;object-fit:contain;pointer-events:none;">';
            el.classList.add('draggable-element');
            makeDraggable(el);
        };
        reader.readAsDataURL(file);
    });

    document.getElementById('inputLogo2').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(ev) {
            let el = document.getElementById('logoInstitucion');
            if(!el) {
                el = document.createElement('div');
                el.id = 'logoInstitucion';
                el.className = 'draggable-element position-absolute d-flex flex-column align-items-center justify-content-center text-center rounded';
                el.style.cssText = 'z-index:20;top:6%;right:8%;width:' + (document.getElementById('logo2Ancho')?.value || 160) + 'px;height:96px;cursor:move;user-select:none;';
                document.getElementById('certificate').appendChild(el);
            }
            el.style.border = 'none';
            el.style.background = 'transparent';
            el.innerHTML = '<img src="' + ev.target.result + '" style="max-width:100%;max-height:100%;object-fit:contain;pointer-events:none;">';
            el.classList.add('draggable-element');
            makeDraggable(el);
        };
        reader.readAsDataURL(file);
    });

    // ===== Ancho de logotipos =====
    document.getElementById('logo1Ancho').addEventListener('input', function() {
        const logo = document.getElementById('logoHUV');
        if(logo) logo.style.width = this.value + 'px';
    });
    document.getElementById('logo2Ancho').addEventListener('input', function() {
        const logo = document.getElementById('logoInstitucion');
        if(logo) logo.style.width = this.value + 'px';
    });

    // ===== Men� contextual para eliminar elementos (Configuraci�n global) =====
    const contextMenu = document.createElement('div');
    contextMenu.className = 'custom-context-menu';
    contextMenu.innerHTML = '<div class="menu-item" id="menuEliminar">Eliminar elemento</div>';
    document.body.appendChild(contextMenu);

    let elementoSeleccionado = null;

    // ===== Drag & drop para elementos del certificado =====
    function makeDraggable(el) {
        el.oncontextmenu = function(e) {
            e.preventDefault();
            elementoSeleccionado = el;
            contextMenu.style.display = 'block';
            contextMenu.style.left = e.pageX + 'px';
            contextMenu.style.top = e.pageY + 'px';
        };

        el.onmousedown = function(e) {
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT') return;
            
            // Guardar el z-index original para no perder capas al soltar
            let originalZIndex = el.style.zIndex || window.getComputedStyle(el).zIndex;
            if (originalZIndex === 'auto' || originalZIndex === '') originalZIndex = 20;

            let shiftX = e.clientX - el.getBoundingClientRect().left;
            let shiftY = e.clientY - el.getBoundingClientRect().top;
            el.style.position = 'absolute';
            el.style.zIndex = 1000;
            function moveAt(pageX, pageY) {
                const canvas = document.getElementById('certificate');
                const canvasRect = canvas.getBoundingClientRect();
                let x = pageX - canvasRect.left - shiftX;
                let y = pageY - canvasRect.top - shiftY;
                x = Math.max(0, Math.min(x, canvasRect.width - el.offsetWidth));
                y = Math.max(0, Math.min(y, canvasRect.height - el.offsetHeight));
                el.style.left = x + 'px';
                el.style.top = y + 'px';
            }
            function onMouseMove(e) {
                moveAt(e.clientX, e.clientY);
            }
            document.addEventListener('mousemove', onMouseMove);
            document.onmouseup = function() {
                document.removeEventListener('mousemove', onMouseMove);
                document.onmouseup = null;
                // Restaurar el z-index en vez de dejarlo vacío para evitar el bloqueo del div principal
                el.style.zIndex = originalZIndex;
            };
            e.preventDefault();
        };
        el.ondragstart = function() { return false; };
    }
    function applyDraggableToAll() {
        document.querySelectorAll('.draggable-element').forEach(function(el) {
            makeDraggable(el);
        });
    }
    applyDraggableToAll();
    // Permitir que los nuevos elementos también sean movibles
    const observer = new MutationObserver(applyDraggableToAll);
    observer.observe(document.getElementById('certificate'), { childList: true, subtree: true });

    // ===== Zoom =====
    let zoomLevel = 100;
    document.getElementById('btnZoomIn').addEventListener('click', function() {
        zoomLevel = Math.min(200, zoomLevel + 10);
        applyZoom();
    });
    document.getElementById('btnZoomOut').addEventListener('click', function() {
        zoomLevel = Math.max(50, zoomLevel - 10);
        applyZoom();
    });
    function applyZoom() {
        document.getElementById('zoomLabel').textContent = zoomLevel + '%';
        document.getElementById('certificate').style.transform = 'scale(' + (zoomLevel / 100) + ')';
        document.getElementById('certificate').style.transformOrigin = 'top center';
    }
      // ===== Guardar Plantilla (Modal) =====
      document.getElementById('btnGuardarPlantilla').addEventListener('click', function() {
          const certEl = document.getElementById('certificate');
          const htmlContent = certEl.innerHTML;
          let base64Bg = certEl.style.backgroundImage.slice(4, -1).replace(/"/g, "");
          
          let elementos = [];
          document.querySelectorAll('.draggable-element').forEach(el => {
              elementos.push({
                  id: el.id,
                  type: el.classList.contains('text-element') ? 'text' : 'image',
                  top: el.style.top,
                  left: el.style.left,
                  width: el.style.width || 'auto',
                  height: el.style.height || 'auto',
                  content: el.classList.contains('text-element') ? el.innerHTML : el.querySelector('img')?.src
              });
          });

          // Guardar firma y cargo en los elementos para que se persistan con la plantilla
          const elementosObj = {
              items: elementos,
              firma_nombre: document.getElementById('inputFirmaNombre').value || '',
              firma_cargo: document.getElementById('inputFirmaCargo').value || ''
          };

          document.getElementById('html_content_input').value = htmlContent;
          document.getElementById('fondo_base64_input').value = base64Bg;
          document.getElementById('elementos_json_input').value = JSON.stringify(elementosObj);
      });

      // ===== Cargar Plantilla Seleccionada =====
      const selectPlantilla = document.getElementById('selectPlantilla');
      if (selectPlantilla) {
          selectPlantilla.addEventListener('change', function() {
              if (this.value) {
                  fetch(`/configuracion/editor-certificados/${this.value}/json`)
                      .then(r => r.json())
                      .then(data => {
                          const certEl = document.getElementById('certificate');
                          certEl.innerHTML = data.html_content;
                          
                          document.querySelectorAll('.draggable-element').forEach(el => {
                              makeDraggable(el);
                          });

                          if (data.elementos_json && data.elementos_json.fondo_base64) {
                              certEl.style.backgroundImage = 'url(' + data.elementos_json.fondo_base64 + ')';
                          }

                          // Restaurar firma y cargo guardados en la plantilla
                          if (data.elementos_json) {
                              const firmaNombre = data.elementos_json.firma_nombre || '';
                              const firmaCargo = data.elementos_json.firma_cargo || '';
                              if (firmaNombre) {
                                  document.getElementById('inputFirmaNombre').value = firmaNombre;
                              }
                              if (firmaCargo) {
                                  document.getElementById('inputFirmaCargo').value = firmaCargo;
                              }
                          }

                          // Marcar que hay plantilla cargada para proteger firma/cargo
                          plantillaCargada = true;
                          actualizarCertificado();
                      });
              } else {
                  document.getElementById('certificate').innerHTML = '';
                  document.getElementById('certificate').style.backgroundImage = 'none';
                  plantillaCargada = false;
              }
          });
      }
    // ===== Función para abrir certificado en nueva ventana (DOM nativo, sin document.write para el fondo) =====
    function abrirCertificadoEnVentana(autoImprimir) {
        const certEl = document.getElementById('certificate');
        const win = window.open('', '_blank');
        if (!win) { alert('El navegador bloqueó la ventana emergente. Permita pop-ups para este sitio.'); return; }
        const doc = win.document;
        doc.open();
        doc.write('<!DOCTYPE html><html><head><title>Certificado</title>');
        doc.write('<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">');
        doc.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">');
        doc.write('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">');
        doc.write('</head><body><div id="certOutput"></div></body></html>');
        doc.close();

        // Esperar a que el documento esté listo para manipular el DOM
        win.addEventListener('load', function() {
            const d = win.document;

            // Inyectar estilos — mantener 960x680 SIEMPRE para no descuadrar posiciones absolutas
            const style = d.createElement('style');
            style.textContent = `
                @page { size: landscape; margin: 0; }
                * { box-sizing: border-box; }
                html, body {
                    margin: 0; padding: 0;
                    font-family: 'Inter', sans-serif;
                    width: 100%; height: 100%;
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                    color-adjust: exact !important;
                }
                body {
                    background: #525659;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                }
                @media print {
                    body { background: white; }
                    #certOutput {
                        width: 100vw;
                        height: 100vh;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        overflow: hidden;
                    }
                    .cert {
                        /* Mantener tamaño original y escalar para llenar la página */
                        width: 960px !important;
                        height: 680px !important;
                        transform: scale(calc(100vw / 960)) !important;
                        transform-origin: center center !important;
                        box-shadow: none !important;
                    }
                }
                .cert {
                    width: 960px;
                    height: 680px;
                    background-size: 100% 100%;
                    background-repeat: no-repeat;
                    background-position: center;
                    position: relative;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
                    background-color: white;
                    overflow: hidden;
                }
                .draggable-element { outline: none !important; cursor: default !important; }
                .draggable-element:hover { outline: none !important; }
            `;
            d.head.appendChild(style);

            // Clonar el certificado del editor al div de salida
            const container = d.getElementById('certOutput');
            const clone = certEl.cloneNode(true);
            clone.removeAttribute('id');
            clone.className = 'cert';
            clone.style.cssText = certEl.style.cssText; // Copia TODOS los estilos inline incluyendo background-image
            clone.style.width = '960px';
            clone.style.height = '680px';
            clone.style.maxWidth = 'none';
            clone.style.transform = 'none';
            clone.style.boxShadow = '0 10px 30px rgba(0,0,0,0.5)';

            // Desactivar interactividad de los elementos arrastrables
            clone.querySelectorAll('.draggable-element').forEach(function(el) {
                el.style.cursor = 'default';
                el.onmousedown = null;
                el.oncontextmenu = null;
                el.ondragstart = null;
            });

            container.appendChild(clone);

            // Auto-imprimir si se solicita
            if (autoImprimir) {
                setTimeout(function() { win.print(); }, 1000);
            }
        });
    }

    // ===== Vista previa (abrir en nueva pestaña) =====
    document.getElementById('btnVistaPrevia').addEventListener('click', function() {
        abrirCertificadoEnVentana(false);
    });

    // ===== Generar certificado (print) =====
    // Inicialmente deshabilitado hasta que se seleccione un estudiante aprobado
    document.getElementById('btnGenerarCertificado').disabled = true;
    document.getElementById('btnGenerarCertificado').style.opacity = '0.5';
    document.getElementById('btnGenerarCertificado').style.pointerEvents = 'none';
    document.getElementById('btnGenerarCertificado').title = 'Seleccione un estudiante aprobado para generar el certificado';

    document.getElementById('btnGenerarCertificado').addEventListener('click', function(e) {
        const selEst = document.getElementById('selectEstudiante');
        if (!estudianteAprobado || !selEst.value) {
            e.preventDefault();
            e.stopPropagation();
            alert('⚠️ No se puede generar el certificado. Debe seleccionar un estudiante que haya aprobado el curso.');
            return false;
        }
        abrirCertificadoEnVentana(true);
    });

    // Inicializar
    actualizarCertificado();


    // Ocultar men� contextual al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!contextMenu.contains(e.target)) {
            contextMenu.style.display = 'none';
        }
    });

    // Eliminar elemento seleccionado
    document.getElementById('menuEliminar').addEventListener('click', function() {
        if (elementoSeleccionado) {
            elementoSeleccionado.remove();
            contextMenu.style.display = 'none';
            elementoSeleccionado = null;
        }
    });
});
</script>
@stop













