// ==========================================
// VARIABLES GLOBALES DEL WIZARD
// ==========================================

// Datos del curso en construcción
let courseData = {
    materials: [],
    forumPosts: [],
    activities: []
};

// ==========================================
// PASO 2: MATERIALES DEL CURSO
// ==========================================

function initializeStep2() {
    // Botón agregar material
    $('#btn-add-material').click(function() {
        showMaterialModal();
    });

    // Hacer la lista de materiales sorteable
    if (typeof Sortable !== 'undefined') {
        new Sortable(document.getElementById('materials-list'), {
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: function(evt) {
                updateMaterialOrder();
            }
        });
    }

    // Inicializar estadísticas
    updateMaterialsStats();
}

function showMaterialModal() {
    // Generar opciones de materiales existentes para vincular
    const materialesExistentes = courseData.materials || [];
    let opcionesMateriales = '<option value="">-- Sin prerrequisito --</option>';
    materialesExistentes.forEach(mat => {
        opcionesMateriales += `<option value="${mat.id}">${mat.title}</option>`;
    });
    
    // Calcular porcentaje disponible
    const porcentajeUsado = materialesExistentes.reduce((sum, mat) => sum + (parseFloat(mat.porcentajeCurso) || 0), 0);
    const porcentajeDisponible = Math.max(0, 100 - porcentajeUsado);
    
    // Bloquear si ya se alcanzó el 100%
    if (porcentajeUsado >= 100) {
        Swal.fire({
            icon: 'warning',
            title: 'Porcentaje completo',
            html: `Ya se ha asignado el <strong>100%</strong> del porcentaje del curso entre los materiales existentes.<br><br>Para agregar un nuevo material, primero edita o elimina materiales existentes para liberar porcentaje.`,
            confirmButtonText: 'Entendido'
        });
        return;
    }
    
    // Mostrar u ocultar la sección de prerrequisitos
    const mostrarPrerrequisitos = materialesExistentes.length > 0;
    
    Swal.fire({
        title: 'Agregar Material',
        html: `
            <div class="text-left">
                <div class="form-group">
                    <label for="material-title">Título *</label>
                    <input type="text" class="form-control" id="material-title" placeholder="Nombre del material">
                </div>
                <div class="form-group">
                    <label for="material-description">Descripción</label>
                    <textarea class="form-control" id="material-description" rows="3" placeholder="Descripción breve del material"></textarea>
                </div>
                <div class="form-group">
                    <label for="material-type">Tipo de Material</label>
                    <select class="form-control" id="material-type" onchange="toggleMaterialTabs()">
                        <option value="documento">📄 Documento</option>
                        <option value="video">🎥 Video</option>
                        <option value="imagen">🖼️ Imagen</option>
                        <option value="clase_en_linea">🎓 Clase en Línea (Meet)</option>
                        <option value="archivo">📁 Archivo</option>
                    </select>
                </div>
                
                <!-- Sistema de Calificaciones -->
                <div class="card bg-light mb-3">
                    <div class="card-header py-2">
                        <strong><i class="fas fa-star text-warning"></i> Configuración de Calificación</strong>
                    </div>
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label for="material-porcentaje">Porcentaje del Curso (%) *</label>
                                    <input type="number" class="form-control" id="material-porcentaje" 
                                           min="0.1" max="${porcentajeDisponible}" step="0.1" value="" placeholder="0">
                                    <small class="form-text" id="porcentaje-feedback">
                                        Disponible: <strong>${porcentajeDisponible.toFixed(1)}%</strong> de 100%
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label for="material-nota-minima">Nota Mínima Aprobación *</label>
                                    <input type="number" class="form-control" id="material-nota-minima" 
                                           min="0" max="5" step="0.1" value="3.0" placeholder="3.0">
                                    <small class="form-text text-muted">Escala: 0.0 - 5.0</small>
                                </div>
                            </div>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-success" role="progressbar" id="barra-porcentaje-usado" style="width: ${porcentajeUsado}%">
                                ${porcentajeUsado.toFixed(1)}% usado
                            </div>
                            <div class="progress-bar bg-secondary" role="progressbar" id="barra-porcentaje-disponible" style="width: ${porcentajeDisponible}%">
                                ${porcentajeDisponible.toFixed(1)}% disponible
                            </div>
                        </div>
                        <small class="text-muted mt-1 d-block" id="resumen-porcentaje">Total asignado: ${porcentajeUsado.toFixed(1)}% | Máximo: 100%</small>
                    </div>
                </div>
                
                <div class="form-group" id="material-sources">
                    <label>Fuente del Material</label>
                    <div class="nav nav-tabs" id="material-source-tabs">
                        <a class="nav-link active" data-toggle="tab" href="#upload-tab">📤 Subir Archivo</a>
                        <a class="nav-link" data-toggle="tab" href="#url-tab">🔗 URL Externa</a>
                        <a class="nav-link" data-toggle="tab" href="#meet-tab" style="display:none;">🎓 Clase en Línea</a>
                    </div>
                    <div class="tab-content mt-3">
                        <div class="tab-pane active" id="upload-tab">
                            <div class="alert alert-info" id="video-upload-tip" style="display:none;">
                                <i class="fas fa-lightbulb"></i> <strong>Consejo:</strong> Para videos grandes, usa la pestaña "URL Externa" con YouTube o Vimeo para ahorrar espacio.
                            </div>
                            <input type="file" class="form-control-file" id="material-file">
                            <small class="form-text text-muted" id="upload-hint">Máximo 200MB por archivo. Formatos: PDF, DOC, PPT, XLS, JPG, PNG, MP4, etc. Para archivos muy grandes usa URLs.</small>
                        </div>
                        <div class="tab-pane" id="url-tab">
                            <div class="alert alert-success" id="video-url-tip" style="display:none;">
                                <i class="fas fa-video"></i> <strong>Videos recomendados:</strong> YouTube, Vimeo, Google Drive, Dailymotion, etc.
                            </div>
                            <input type="url" class="form-control" id="material-url" placeholder="https://ejemplo.com/archivo.pdf">
                            <small class="form-text text-muted" id="url-hint">YouTube, Vimeo, Google Drive, Dropbox, etc.</small>
                            <div class="mt-3" id="video-url-examples" style="display:none;">
                                <small class="text-muted">
                                    <strong>Ejemplos de URLs válidas:</strong><br>
                                    • YouTube: https://www.youtube.com/watch?v=abc123<br>
                                    • Vimeo: https://vimeo.com/123456789<br>
                                    • Google Drive: https://drive.google.com/file/d/...<br>
                                    • Dropbox: https://www.dropbox.com/s/...
                                </small>
                            </div>
                        </div>
                        <div class="tab-pane" id="meet-tab">
                            <div class="form-group">
                                <label for="meet-url">URL de Google Meet *</label>
                                <input type="url" class="form-control" id="meet-url" placeholder="https://meet.google.com/xxx-xxxx-xxx">
                                <small class="form-text text-muted">Pega aquí el enlace de la reunión de Google Meet</small>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meet-start">Fecha y Hora de Inicio *</label>
                                        <input type="datetime-local" class="form-control" id="meet-start">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meet-end">Fecha y Hora de Fin *</label>
                                        <input type="datetime-local" class="form-control" id="meet-end">
                                    </div>
                                </div>
                            </div>
                            <small class="text-info">
                                <i class="fas fa-info-circle"></i> Los estudiantes verán un botón para unirse a la clase cuando esté activa
                            </small>
                        </div>
                    </div>
                </div>
                
                <!-- Sección de Prerrequisitos -->
                <div class="form-group" id="prerequisite-section" style="display: ${mostrarPrerrequisitos ? 'block' : 'none'};">
                    <hr class="my-3">
                    <label><i class="fas fa-link text-info"></i> Vincular a Material Prerrequisito</label>
                    <div class="custom-control custom-switch mb-2">
                        <input type="checkbox" class="custom-control-input" id="material-has-prerequisite" onchange="togglePrerequisiteSelect()">
                        <label class="custom-control-label" for="material-has-prerequisite">
                            Requiere ver otro material primero
                        </label>
                    </div>
                    <div id="prerequisite-select-container" style="display: none;">
                        <select class="form-control" id="material-prerequisite">
                            ${opcionesMateriales}
                        </select>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> El estudiante deberá completar el material seleccionado antes de poder acceder a este.
                        </small>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="material-public" checked>
                        <label class="custom-control-label" for="material-public">Material público (visible para estudiantes)</label>
                    </div>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Agregar Material',
        cancelButtonText: 'Cancelar',
        width: '700px',
        didOpen: () => {
            // Validación en tiempo real del porcentaje
            const porcentajeInput = document.getElementById('material-porcentaje');
            if (porcentajeInput) {
                porcentajeInput.addEventListener('input', function() {
                    const valor = parseFloat(this.value) || 0;
                    const feedback = document.getElementById('porcentaje-feedback');
                    const barraUsado = document.getElementById('barra-porcentaje-usado');
                    const barraDisponible = document.getElementById('barra-porcentaje-disponible');
                    const resumen = document.getElementById('resumen-porcentaje');
                    const nuevoTotal = porcentajeUsado + valor;
                    const nuevoDisponible = Math.max(0, 100 - nuevoTotal);
                    
                    if (barraUsado) {
                        barraUsado.style.width = Math.min(nuevoTotal, 100) + '%';
                        barraUsado.textContent = nuevoTotal.toFixed(1) + '% usado';
                    }
                    if (barraDisponible) {
                        barraDisponible.style.width = nuevoDisponible + '%';
                        barraDisponible.textContent = nuevoDisponible.toFixed(1) + '% disponible';
                    }
                    if (resumen) {
                        resumen.textContent = 'Total asignado: ' + nuevoTotal.toFixed(1) + '% | Máximo: 100%';
                    }
                    
                    if (valor > porcentajeDisponible) {
                        this.classList.add('is-invalid');
                        this.classList.remove('is-valid');
                        feedback.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-triangle"></i> Excede el disponible: <strong>' + porcentajeDisponible.toFixed(1) + '%</strong></span>';
                        if (barraUsado) {
                            barraUsado.classList.remove('bg-success', 'bg-info');
                            barraUsado.classList.add('bg-danger');
                        }
                    } else if (valor > 0) {
                        this.classList.add('is-valid');
                        this.classList.remove('is-invalid');
                        feedback.innerHTML = '<span class="text-success"><i class="fas fa-check-circle"></i> OK - Quedará disponible: <strong>' + nuevoDisponible.toFixed(1) + '%</strong></span>';
                        if (barraUsado) {
                            barraUsado.classList.remove('bg-danger');
                            if (nuevoTotal === 100) {
                                barraUsado.classList.add('bg-success');
                            } else {
                                barraUsado.classList.add('bg-info');
                            }
                        }
                    } else {
                        this.classList.remove('is-valid', 'is-invalid');
                        feedback.innerHTML = 'Disponible: <strong>' + porcentajeDisponible.toFixed(1) + '%</strong> de 100%';
                        if (barraUsado) {
                            barraUsado.classList.remove('bg-danger');
                            barraUsado.classList.add('bg-success');
                        }
                    }
                });
            }
            
            // Función para mostrar/ocultar selector de prerrequisito
            window.togglePrerequisiteSelect = function() {
                const hasPrerequisite = document.getElementById('material-has-prerequisite').checked;
                const container = document.getElementById('prerequisite-select-container');
                container.style.display = hasPrerequisite ? 'block' : 'none';
            };
            
            // Función para mostrar/ocultar tabs según tipo
            window.toggleMaterialTabs = function() {
                const type = document.getElementById('material-type').value;
                const meetTab = document.querySelector('a[href="#meet-tab"]');
                const uploadTab = document.querySelector('a[href="#upload-tab"]');
                const urlTab = document.querySelector('a[href="#url-tab"]');
                const videoUploadTip = document.getElementById('video-upload-tip');
                const videoUrlTip = document.getElementById('video-url-tip');
                const videoUrlExamples = document.getElementById('video-url-examples');
                const materialUrl = document.getElementById('material-url');
                const uploadHint = document.getElementById('upload-hint');
                const urlHint = document.getElementById('url-hint');
                
                if (type === 'clase_en_linea') {
                    meetTab.style.display = 'block';
                    meetTab.click();
                    uploadTab.style.display = 'none';
                    urlTab.style.display = 'none';
                } else {
                    meetTab.style.display = 'none';
                    uploadTab.style.display = 'block';
                    urlTab.style.display = 'block';
                    uploadTab.click();
                    
                    // Mostrar tips específicos para videos
                    if (type === 'video') {
                        videoUploadTip.style.display = 'block';
                        videoUrlTip.style.display = 'block';
                        videoUrlExamples.style.display = 'block';
                        materialUrl.placeholder = 'https://www.youtube.com/watch?v=... o https://vimeo.com/...';
                        uploadHint.innerHTML = 'Máximo 200MB. Formatos: MP4, AVI, MOV, WMV. <strong>Recomendado: Usar URL para videos > 100MB</strong>';
                        urlHint.innerHTML = '<strong>Recomendado para videos:</strong> YouTube, Vimeo, Google Drive (sin límite de tamaño)';
                        // Cambiar a pestaña URL por defecto para videos
                        urlTab.click();
                    } else {
                        videoUploadTip.style.display = 'none';
                        videoUrlTip.style.display = 'none';
                        videoUrlExamples.style.display = 'none';
                        materialUrl.placeholder = 'https://ejemplo.com/archivo.pdf';
                        uploadHint.innerHTML = 'Máximo 200MB por archivo. Formatos: PDF, DOC, PPT, XLS, JPG, PNG, MP4, etc. Para archivos muy grandes usa URLs.';
                        urlHint.innerHTML = 'YouTube, Vimeo, Google Drive, Dropbox, etc.';
                        uploadTab.click();
                    }
                }
            };
        },
        preConfirm: () => {
            const title = document.getElementById('material-title').value;
            const description = document.getElementById('material-description').value;
            const type = document.getElementById('material-type').value;
            const file = document.getElementById('material-file').files[0];
            const url = document.getElementById('material-url').value;
            const isPublic = document.getElementById('material-public').checked;
            
            // Datos de calificación
            const porcentajeCurso = parseFloat(document.getElementById('material-porcentaje').value) || 0;
            const notaMinimaAprobacion = parseFloat(document.getElementById('material-nota-minima').value) || 3.0;
            
            // Datos de prerrequisito
            const hasPrerequisite = document.getElementById('material-has-prerequisite').checked;
            const prerequisiteId = hasPrerequisite ? document.getElementById('material-prerequisite').value : null;
            
            // Datos específicos de clase en línea
            const meetUrl = document.getElementById('meet-url').value;
            const meetStart = document.getElementById('meet-start').value;
            const meetEnd = document.getElementById('meet-end').value;
            
            if (!title.trim()) {
                Swal.showValidationMessage('El título es requerido');
                return false;
            }
            
            // Validación de porcentaje
            if (porcentajeCurso <= 0) {
                Swal.showValidationMessage('El porcentaje debe ser mayor a 0%. Cada material debe tener un porcentaje asignado.');
                return false;
            }
            
            if (porcentajeCurso > porcentajeDisponible) {
                Swal.showValidationMessage('El porcentaje (' + porcentajeCurso.toFixed(1) + '%) excede el disponible (' + porcentajeDisponible.toFixed(1) + '%). La suma de todos los materiales no puede pasar de 100%.');
                return false;
            }
            
            // Validación de nota mínima
            if (notaMinimaAprobacion < 0 || notaMinimaAprobacion > 5) {
                Swal.showValidationMessage('La nota mínima debe estar entre 0.0 y 5.0');
                return false;
            }
            
            // Validación de prerrequisito
            if (hasPrerequisite && !prerequisiteId) {
                Swal.showValidationMessage('Debes seleccionar un material prerrequisito');
                return false;
            }
            
            // Validación específica para clase en línea
            if (type === 'clase_en_linea') {
                if (!meetUrl.trim()) {
                    Swal.showValidationMessage('La URL de Google Meet es requerida');
                    return false;
                }
                if (!meetStart) {
                    Swal.showValidationMessage('La fecha y hora de inicio es requerida');
                    return false;
                }
                if (!meetEnd) {
                    Swal.showValidationMessage('La fecha y hora de fin es requerida');
                    return false;
                }
                if (new Date(meetEnd) <= new Date(meetStart)) {
                    Swal.showValidationMessage('La fecha de fin debe ser posterior a la de inicio');
                    return false;
                }
            } else {
                // Validación para otros tipos
                if (!file && !url.trim()) {
                    Swal.showValidationMessage('Debes subir un archivo o proporcionar una URL');
                    return false;
                }
                
                // Validar tamaño del archivo (máximo 200MB por archivo individual)
                if (file && file.size > 200 * 1024 * 1024) {
                    const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                    Swal.showValidationMessage(`El archivo es muy grande (${sizeMB} MB). Máximo 200 MB por archivo. Usa YouTube/Vimeo para videos muy grandes o Google Drive/Dropbox.`);
                    return false;
                }
            }
            
            return {
                title: title,
                description: description,
                type: type,
                file: file,
                url: url,
                isPublic: isPublic,
                meetUrl: meetUrl,
                meetStart: meetStart,
                meetEnd: meetEnd,
                prerequisiteId: prerequisiteId ? parseInt(prerequisiteId) : null,
                porcentajeCurso: porcentajeCurso,
                notaMinimaAprobacion: notaMinimaAprobacion
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            addMaterial(result.value);
        }
    });
}

function addMaterial(materialData) {
    const materialId = Date.now(); // ID temporal
    const material = {
        id: materialId,
        title: materialData.title,
        description: materialData.description,
        type: materialData.type,
        file: materialData.file,
        url: materialData.url,
        isPublic: materialData.isPublic,
        order: courseData.materials.length + 1,
        // Datos específicos de clase en línea
        meetUrl: materialData.meetUrl || null,
        meetStart: materialData.meetStart || null,
        meetEnd: materialData.meetEnd || null,
        // Prerrequisito
        prerequisiteId: materialData.prerequisiteId || null,
        // Datos de calificación
        porcentajeCurso: materialData.porcentajeCurso || 0,
        notaMinimaAprobacion: materialData.notaMinimaAprobacion || 3.0
    };
    
    courseData.materials.push(material);
    renderMaterialsList();
    updateMaterialsStats();
}

function renderMaterialsList() {
    const container = $('#materials-list');
    
    if (courseData.materials.length === 0) {
        container.html(`
            <div class="text-center text-muted py-4" id="no-materials">
                <i class="fas fa-folder-open fa-3x mb-3"></i>
                <p>No hay materiales agregados aún</p>
                <p>Haz clic en "Agregar Material" para comenzar</p>
            </div>
        `);
        return;
    }
    
    let html = '';
    courseData.materials.forEach((material, index) => {
        const typeIcons = {
            documento: 'fas fa-file-alt text-primary',
            video: 'fas fa-video text-danger',
            imagen: 'fas fa-image text-success',
            clase_en_linea: 'fas fa-video text-info',
            archivo: 'fas fa-file text-warning'
        };
        
        const typeLabels = {
            documento: 'Documento',
            video: 'Video',
            imagen: 'Imagen',
            clase_en_linea: 'Clase en Línea',
            archivo: 'Archivo'
        };
        
        // Información específica según el tipo
        let sourceInfo = '';
        if (material.type === 'clase_en_linea') {
            const startDate = new Date(material.meetStart);
            const endDate = new Date(material.meetEnd);
            sourceInfo = `${startDate.toLocaleDateString()} ${startDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})} - ${endDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}`;
        } else {
            sourceInfo = material.file ? material.file.name : material.url;
        }
        
        // Información de prerrequisito
        let prerequisiteInfo = '';
        if (material.prerequisiteId) {
            const prerequisiteMaterial = courseData.materials.find(m => m.id === material.prerequisiteId);
            if (prerequisiteMaterial) {
                prerequisiteInfo = `<span class="badge badge-info mr-2" title="Requiere completar: ${prerequisiteMaterial.title}"><i class="fas fa-link"></i> Requiere: ${prerequisiteMaterial.title.substring(0, 20)}${prerequisiteMaterial.title.length > 20 ? '...' : ''}</span>`;
            }
        }
        
        html += `
            <div class="material-item" data-id="${material.id}">
                <div class="d-flex align-items-center">
                    <div class="drag-handle mr-3">
                        <i class="fas fa-grip-vertical"></i>
                    </div>
                    <div class="mr-3">
                        <i class="${typeIcons[material.type] || typeIcons.archivo} fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">${material.title}</h6>
                        <p class="mb-1 text-muted small">${material.description || 'Sin descripción'}</p>
                        <div class="d-flex align-items-center flex-wrap">
                            <span class="badge badge-secondary mr-2">${typeLabels[material.type] || material.type}</span>
                            ${material.isPublic ? '<span class="badge badge-success mr-2">Público</span>' : '<span class="badge badge-warning mr-2">Privado</span>'}
                            <span class="badge badge-primary mr-2" title="Porcentaje del curso"><i class="fas fa-percent"></i> ${(material.porcentajeCurso || 0).toFixed(1)}%</span>
                            <span class="badge badge-warning mr-2" title="Nota mínima de aprobación"><i class="fas fa-star"></i> ${(material.notaMinimaAprobacion || 3.0).toFixed(1)}</span>
                            ${prerequisiteInfo}
                            <small class="text-muted">
                                ${sourceInfo}
                            </small>
                        </div>
                    </div>
                    <div class="ml-auto">
                        <button type="button" class="btn btn-sm btn-outline-primary mr-1" onclick="editMaterial(${material.id}); return false;">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeMaterial(${material.id}); return false;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
    
    container.html(html);
}

// Función para calcular el porcentaje total usado por materiales
function calcularPorcentajeUsado() {
    return courseData.materials.reduce((sum, mat) => sum + (parseFloat(mat.porcentajeCurso) || 0), 0);
}

function updateMaterialsStats() {
    const stats = {
        documento: 0,
        video: 0,
        imagen: 0,
        archivo: 0
    };

    courseData.materials.forEach(material => {
        if (material.type === 'documento') {
            stats.documento++;
        } else if (material.type === 'video') {
            stats.video++;
        } else if (material.type === 'imagen') {
            stats.imagen++;
        } else {
            // clase_en_linea y archivo van a "otros"
            stats.archivo++;
        }
    });

    $('#count-documentos').text(stats.documento);
    $('#count-videos').text(stats.video);
    $('#count-imagenes').text(stats.imagen);
    $('#count-otros').text(stats.archivo);
    
    // Actualizar barra de porcentaje en el paso 1 si existe
    const porcentajeUsado = calcularPorcentajeUsado();
    const porcentajeDisponible = Math.max(0, 100 - porcentajeUsado);
    
    // Actualizar barra de progreso
    const $bar = $('#porcentaje-asignado-bar');
    const $text = $('#porcentaje-asignado-text');
    const $badge = $('#porcentaje-total-badge');
    
    $bar.css('width', porcentajeUsado + '%').attr('aria-valuenow', porcentajeUsado);
    $text.text(porcentajeUsado.toFixed(1));
    
    // Cambiar color según el porcentaje
    $bar.removeClass('bg-danger bg-warning bg-info bg-success');
    $badge.removeClass('badge-danger badge-warning badge-info badge-success');
    
    if (porcentajeUsado === 0) {
        $bar.addClass('bg-secondary');
        $badge.addClass('badge-secondary');
    } else if (porcentajeUsado < 50) {
        $bar.addClass('bg-danger');
        $badge.addClass('badge-danger');
    } else if (porcentajeUsado < 80) {
        $bar.addClass('bg-warning');
        $badge.addClass('badge-warning');
    } else if (porcentajeUsado < 100) {
        $bar.addClass('bg-info');
        $badge.addClass('badge-info');
    } else if (porcentajeUsado === 100) {
        $bar.addClass('bg-success');
        $badge.addClass('badge-success');
    } else {
        // Más de 100%
        $bar.addClass('bg-danger');
        $badge.addClass('badge-danger');
    }
}

function updateMaterialOrder() {
    // Actualizar el orden de los materiales basado en su posición en la lista
    const materialItems = $('#materials-list .material-item');
    materialItems.each(function(index) {
        const materialId = parseInt($(this).data('id'));
        const material = courseData.materials.find(m => m.id === materialId);
        if (material) {
            material.order = index + 1;
        }
    });
}

function editMaterial(materialId) {
    // Buscar el material a editar
    const material = courseData.materials.find(m => m.id === materialId);
    if (!material) return;

    const isClaseEnLinea = material.type === 'clase_en_linea';
    const activeTab = isClaseEnLinea ? 'meet' : (material.file ? 'upload' : 'url');
    
    // Generar opciones de materiales existentes para vincular (excluyendo el actual)
    const materialesExistentes = courseData.materials.filter(m => m.id !== materialId) || [];
    let opcionesMateriales = '<option value="">-- Sin prerrequisito --</option>';
    materialesExistentes.forEach(mat => {
        const selected = material.prerequisiteId === mat.id ? 'selected' : '';
        opcionesMateriales += `<option value="${mat.id}" ${selected}>${mat.title}</option>`;
    });
    
    // Calcular porcentaje disponible (excluyendo el material actual)
    const porcentajeUsadoOtros = materialesExistentes.reduce((sum, mat) => sum + (parseFloat(mat.porcentajeCurso) || 0), 0);
    const porcentajeActual = parseFloat(material.porcentajeCurso) || 0;
    const porcentajeDisponible = Math.max(0, 100 - porcentajeUsadoOtros);
    
    // Mostrar u ocultar la sección de prerrequisitos
    const mostrarPrerrequisitos = materialesExistentes.length > 0;
    
    Swal.fire({
        title: 'Editar Material',
        html: `
            <div class="text-left">
                <div class="form-group">
                    <label for="material-title">Título *</label>
                    <input type="text" class="form-control" id="material-title" placeholder="Nombre del material" value="${material.title}">
                </div>
                <div class="form-group">
                    <label for="material-description">Descripción</label>
                    <textarea class="form-control" id="material-description" rows="3" placeholder="Descripción breve del material">${material.description || ''}</textarea>
                </div>
                <div class="form-group">
                    <label for="material-type">Tipo de Material</label>
                    <select class="form-control" id="material-type" onchange="toggleMaterialTabsEdit()">
                        <option value="documento" ${material.type === 'documento' ? 'selected' : ''}>📄 Documento</option>
                        <option value="video" ${material.type === 'video' ? 'selected' : ''}>🎥 Video</option>
                        <option value="imagen" ${material.type === 'imagen' ? 'selected' : ''}>🖼️ Imagen</option>
                        <option value="clase_en_linea" ${material.type === 'clase_en_linea' ? 'selected' : ''}>🎓 Clase en Línea (Meet)</option>
                        <option value="archivo" ${material.type === 'archivo' ? 'selected' : ''}>📁 Archivo</option>
                    </select>
                </div>
                
                <!-- Sistema de Calificaciones -->
                <div class="card bg-light mb-3">
                    <div class="card-header py-2">
                        <strong><i class="fas fa-star text-warning"></i> Configuración de Calificación</strong>
                    </div>
                    <div class="card-body py-2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label for="material-porcentaje">Porcentaje del Curso (%) *</label>
                                    <input type="number" class="form-control" id="material-porcentaje" 
                                           min="0.1" max="${porcentajeDisponible}" step="0.1" value="${porcentajeActual}" placeholder="0">
                                    <small class="form-text" id="porcentaje-feedback">
                                        Disponible: <strong>${porcentajeDisponible.toFixed(1)}%</strong> de 100% (este material tiene ${porcentajeActual.toFixed(1)}%)
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label for="material-nota-minima">Nota Mínima Aprobación *</label>
                                    <input type="number" class="form-control" id="material-nota-minima" 
                                           min="0" max="5" step="0.1" value="${material.notaMinimaAprobacion || 3.0}" placeholder="3.0">
                                    <small class="form-text text-muted">Escala: 0.0 - 5.0</small>
                                </div>
                            </div>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-info" role="progressbar" id="barra-porcentaje-otros" style="width: ${porcentajeUsadoOtros}%">
                                ${porcentajeUsadoOtros.toFixed(1)}% otros
                            </div>
                            <div class="progress-bar bg-success" role="progressbar" id="barra-porcentaje-actual" style="width: ${porcentajeActual}%">
                                ${porcentajeActual.toFixed(1)}% este
                            </div>
                            <div class="progress-bar bg-secondary" role="progressbar" id="barra-porcentaje-libre" style="width: ${Math.max(0, 100 - porcentajeUsadoOtros - porcentajeActual)}%">
                                ${Math.max(0, 100 - porcentajeUsadoOtros - porcentajeActual).toFixed(1)}% libre
                            </div>
                        </div>
                        <small class="text-muted mt-1 d-block" id="resumen-porcentaje">Otros materiales: ${porcentajeUsadoOtros.toFixed(1)}% | Este material: ${porcentajeActual.toFixed(1)}% | Total: ${(porcentajeUsadoOtros + porcentajeActual).toFixed(1)}%</small>
                    </div>
                </div>
                
                <div class="form-group" id="material-sources">
                    <label>Fuente del Material</label>
                    <div class="nav nav-tabs" id="material-source-tabs">
                        <a class="nav-link ${activeTab === 'upload' ? 'active' : ''}" data-toggle="tab" href="#upload-tab" style="${isClaseEnLinea ? 'display:none;' : ''}">📤 Subir Archivo</a>
                        <a class="nav-link ${activeTab === 'url' ? 'active' : ''}" data-toggle="tab" href="#url-tab" style="${isClaseEnLinea ? 'display:none;' : ''}">🔗 URL Externa</a>
                        <a class="nav-link ${activeTab === 'meet' ? 'active' : ''}" data-toggle="tab" href="#meet-tab" style="${isClaseEnLinea ? '' : 'display:none;'}">🎓 Clase en Línea</a>
                    </div>
                    <div class="tab-content mt-3">
                        <div class="tab-pane ${activeTab === 'upload' ? 'active' : ''}" id="upload-tab">
                            <div class="alert alert-info" id="video-upload-tip" style="display:${material.type === 'video' ? 'block' : 'none'};">
                                <i class="fas fa-lightbulb"></i> <strong>Consejo:</strong> Para videos grandes, usa la pestaña "URL Externa" con YouTube o Vimeo para ahorrar espacio.
                            </div>
                            <input type="file" class="form-control-file" id="material-file">
                            <small class="form-text text-muted" id="upload-hint">
                                ${material.file ? 'Archivo actual: ' + material.file.name + ' (Selecciona otro para reemplazar)' : 'Máximo 200MB por archivo'}
                            </small>
                        </div>
                        <div class="tab-pane ${activeTab === 'url' ? 'active' : ''}" id="url-tab">
                            <div class="alert alert-success" id="video-url-tip" style="display:${material.type === 'video' ? 'block' : 'none'};">
                                <i class="fas fa-video"></i> <strong>Videos recomendados:</strong> YouTube, Vimeo, Google Drive, Dailymotion, etc.
                            </div>
                            <input type="url" class="form-control" id="material-url" placeholder="https://ejemplo.com/archivo.pdf" value="${material.url || ''}">
                            <small class="form-text text-muted" id="url-hint">YouTube, Vimeo, Google Drive, Dropbox, etc.</small>
                            <div class="mt-3" id="video-url-examples" style="display:${material.type === 'video' ? 'block' : 'none'};">
                                <small class="text-muted">
                                    <strong>Ejemplos de URLs válidas:</strong><br>
                                    • YouTube: https://www.youtube.com/watch?v=abc123<br>
                                    • Vimeo: https://vimeo.com/123456789<br>
                                    • Google Drive: https://drive.google.com/file/d/...<br>
                                    • Dropbox: https://www.dropbox.com/s/...
                                </small>
                            </div>
                        </div>
                        <div class="tab-pane ${activeTab === 'meet' ? 'active' : ''}" id="meet-tab">
                            <div class="form-group">
                                <label for="meet-url">URL de Google Meet *</label>
                                <input type="url" class="form-control" id="meet-url" placeholder="https://meet.google.com/xxx-xxxx-xxx" value="${material.meetUrl || ''}">
                                <small class="form-text text-muted">Pega aquí el enlace de la reunión de Google Meet</small>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meet-start">Fecha y Hora de Inicio *</label>
                                        <input type="datetime-local" class="form-control" id="meet-start" value="${material.meetStart || ''}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meet-end">Fecha y Hora de Fin *</label>
                                        <input type="datetime-local" class="form-control" id="meet-end" value="${material.meetEnd || ''}">
                                    </div>
                                </div>
                            </div>
                            <small class="text-info">
                                <i class="fas fa-info-circle"></i> Los estudiantes verán un botón para unirse a la clase cuando esté activa
                            </small>
                        </div>
                    </div>
                </div>
                
                <!-- Sección de Prerrequisitos -->
                <div class="form-group" id="prerequisite-section" style="display: ${mostrarPrerrequisitos ? 'block' : 'none'};">
                    <hr class="my-3">
                    <label><i class="fas fa-link text-info"></i> Vincular a Material Prerrequisito</label>
                    <div class="custom-control custom-switch mb-2">
                        <input type="checkbox" class="custom-control-input" id="material-has-prerequisite" ${material.prerequisiteId ? 'checked' : ''} onchange="togglePrerequisiteSelectEdit()">
                        <label class="custom-control-label" for="material-has-prerequisite">
                            Requiere ver otro material primero
                        </label>
                    </div>
                    <div id="prerequisite-select-container" style="display: ${material.prerequisiteId ? 'block' : 'none'};">
                        <select class="form-control" id="material-prerequisite">
                            ${opcionesMateriales}
                        </select>
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> El estudiante deberá completar el material seleccionado antes de poder acceder a este.
                        </small>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="material-public" ${material.isPublic ? 'checked' : ''}>
                        <label class="custom-control-label" for="material-public">Material público (visible para estudiantes)</label>
                    </div>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Actualizar Material',
        cancelButtonText: 'Cancelar',
        width: '700px',
        didOpen: () => {
            // Validación en tiempo real del porcentaje en edición
            const porcentajeInputEdit = document.getElementById('material-porcentaje');
            if (porcentajeInputEdit) {
                porcentajeInputEdit.addEventListener('input', function() {
                    const valor = parseFloat(this.value) || 0;
                    const feedback = document.getElementById('porcentaje-feedback');
                    const barraActual = document.getElementById('barra-porcentaje-actual');
                    const barraLibre = document.getElementById('barra-porcentaje-libre');
                    const resumen = document.getElementById('resumen-porcentaje');
                    const nuevoTotal = porcentajeUsadoOtros + valor;
                    const nuevoLibre = Math.max(0, 100 - nuevoTotal);
                    
                    if (barraActual) {
                        barraActual.style.width = Math.min(valor, porcentajeDisponible) + '%';
                        barraActual.textContent = valor.toFixed(1) + '% este';
                    }
                    if (barraLibre) {
                        barraLibre.style.width = nuevoLibre + '%';
                        barraLibre.textContent = nuevoLibre.toFixed(1) + '% libre';
                    }
                    if (resumen) {
                        resumen.textContent = 'Otros materiales: ' + porcentajeUsadoOtros.toFixed(1) + '% | Este material: ' + valor.toFixed(1) + '% | Total: ' + nuevoTotal.toFixed(1) + '%';
                    }
                    
                    if (valor > porcentajeDisponible) {
                        this.classList.add('is-invalid');
                        this.classList.remove('is-valid');
                        feedback.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-triangle"></i> Excede el disponible: <strong>' + porcentajeDisponible.toFixed(1) + '%</strong></span>';
                        if (barraActual) {
                            barraActual.classList.remove('bg-success', 'bg-info');
                            barraActual.classList.add('bg-danger');
                        }
                    } else if (valor > 0) {
                        this.classList.add('is-valid');
                        this.classList.remove('is-invalid');
                        feedback.innerHTML = '<span class="text-success"><i class="fas fa-check-circle"></i> OK - Quedará libre: <strong>' + nuevoLibre.toFixed(1) + '%</strong></span>';
                        if (barraActual) {
                            barraActual.classList.remove('bg-danger');
                            barraActual.classList.add('bg-success');
                        }
                    } else {
                        this.classList.remove('is-valid', 'is-invalid');
                        feedback.innerHTML = 'Disponible: <strong>' + porcentajeDisponible.toFixed(1) + '%</strong> de 100%';
                    }
                });
            }
            
            // Función para mostrar/ocultar selector de prerrequisito en edición
            window.togglePrerequisiteSelectEdit = function() {
                const hasPrerequisite = document.getElementById('material-has-prerequisite').checked;
                const container = document.getElementById('prerequisite-select-container');
                container.style.display = hasPrerequisite ? 'block' : 'none';
            };
            
            // Función para mostrar/ocultar tabs según tipo en edición
            window.toggleMaterialTabsEdit = function() {
                const type = document.getElementById('material-type').value;
                const meetTab = document.querySelector('a[href="#meet-tab"]');
                const uploadTab = document.querySelector('a[href="#upload-tab"]');
                const urlTab = document.querySelector('a[href="#url-tab"]');
                const videoUploadTip = document.getElementById('video-upload-tip');
                const videoUrlTip = document.getElementById('video-url-tip');
                const videoUrlExamples = document.getElementById('video-url-examples');
                const materialUrl = document.getElementById('material-url');
                const uploadHint = document.getElementById('upload-hint');
                const urlHint = document.getElementById('url-hint');
                
                if (type === 'clase_en_linea') {
                    meetTab.style.display = 'block';
                    meetTab.click();
                    uploadTab.style.display = 'none';
                    urlTab.style.display = 'none';
                } else {
                    meetTab.style.display = 'none';
                    uploadTab.style.display = 'block';
                    urlTab.style.display = 'block';
                    
                    // Mostrar tips específicos para videos
                    if (type === 'video') {
                        videoUploadTip.style.display = 'block';
                        videoUrlTip.style.display = 'block';
                        videoUrlExamples.style.display = 'block';
                        materialUrl.placeholder = 'https://www.youtube.com/watch?v=... o https://vimeo.com/...';
                        if (uploadHint) {
                            uploadHint.innerHTML = 'Máximo 200MB. Formatos: MP4, AVI, MOV, WMV. <strong>Recomendado: Usar URL para videos > 100MB</strong>';
                        }
                        if (urlHint) {
                            urlHint.innerHTML = '<strong>Recomendado para videos:</strong> YouTube, Vimeo, Google Drive (sin límite de tamaño)';
                        }
                    } else {
                        videoUploadTip.style.display = 'none';
                        videoUrlTip.style.display = 'none';
                        videoUrlExamples.style.display = 'none';
                        materialUrl.placeholder = 'https://ejemplo.com/archivo.pdf';
                        if (uploadHint && !uploadHint.textContent.includes('Archivo actual')) {
                            uploadHint.innerHTML = 'Máximo 200MB por archivo. Formatos: PDF, DOC, PPT, XLS, JPG, PNG, MP4, etc.';
                        }
                        if (urlHint) {
                            urlHint.innerHTML = 'YouTube, Vimeo, Google Drive, Dropbox, etc.';
                        }
                    }
                    
                    // Activar tab correcto
                    if (!urlTab.classList.contains('active') && !uploadTab.classList.contains('active') && !meetTab.classList.contains('active')) {
                        uploadTab.click();
                    }
                }
            };
        },
        preConfirm: () => {
            const title = document.getElementById('material-title').value;
            const description = document.getElementById('material-description').value;
            const type = document.getElementById('material-type').value;
            const file = document.getElementById('material-file').files[0];
            const url = document.getElementById('material-url').value;
            const isPublic = document.getElementById('material-public').checked;
            
            // Datos de calificación
            const porcentajeCurso = parseFloat(document.getElementById('material-porcentaje').value) || 0;
            const notaMinimaAprobacion = parseFloat(document.getElementById('material-nota-minima').value) || 3.0;
            
            // Datos de prerrequisito
            const hasPrerequisite = document.getElementById('material-has-prerequisite')?.checked || false;
            const prerequisiteId = hasPrerequisite ? document.getElementById('material-prerequisite')?.value : null;
            
            // Datos específicos de clase en línea
            const meetUrl = document.getElementById('meet-url').value;
            const meetStart = document.getElementById('meet-start').value;
            const meetEnd = document.getElementById('meet-end').value;
            
            if (!title.trim()) {
                Swal.showValidationMessage('El título es requerido');
                return false;
            }
            
            // Validación de porcentaje
            if (porcentajeCurso <= 0) {
                Swal.showValidationMessage('El porcentaje debe ser mayor a 0%. Cada material debe tener un porcentaje asignado.');
                return false;
            }
            
            if (porcentajeCurso > porcentajeDisponible) {
                Swal.showValidationMessage('El porcentaje (' + porcentajeCurso.toFixed(1) + '%) excede el disponible (' + porcentajeDisponible.toFixed(1) + '%). La suma de todos los materiales no puede pasar de 100%.');
                return false;
            }
            
            // Validación de nota mínima
            if (notaMinimaAprobacion < 0 || notaMinimaAprobacion > 5) {
                Swal.showValidationMessage('La nota mínima debe estar entre 0.0 y 5.0');
                return false;
            }
            
            // Validación de prerrequisito
            if (hasPrerequisite && !prerequisiteId) {
                Swal.showValidationMessage('Debes seleccionar un material prerrequisito');
                return false;
            }
            
            // Validación específica para clase en línea
            if (type === 'clase_en_linea') {
                if (!meetUrl.trim()) {
                    Swal.showValidationMessage('La URL de Google Meet es requerida');
                    return false;
                }
                if (!meetStart) {
                    Swal.showValidationMessage('La fecha y hora de inicio es requerida');
                    return false;
                }
                if (!meetEnd) {
                    Swal.showValidationMessage('La fecha y hora de fin es requerida');
                    return false;
                }
                if (new Date(meetEnd) <= new Date(meetStart)) {
                    Swal.showValidationMessage('La fecha de fin debe ser posterior a la de inicio');
                    return false;
                }
            } else {
                // Validación para otros tipos
                if (!file && !url.trim() && !material.file && !material.url) {
                    Swal.showValidationMessage('Debes subir un archivo o proporcionar una URL');
                    return false;
                }
                
                // Validar tamaño del archivo nuevo (máximo 200MB por archivo individual)
                if (file && file.size > 200 * 1024 * 1024) {
                    const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
                    Swal.showValidationMessage(`El archivo es muy grande (${sizeMB} MB). Máximo 200 MB por archivo. Usa YouTube/Vimeo para videos muy grandes o Google Drive/Dropbox.`);
                    return false;
                }
            }
            
            return {
                title: title,
                description: description,
                type: type,
                file: file || material.file,
                url: url || material.url,
                isPublic: isPublic,
                meetUrl: meetUrl,
                meetStart: meetStart,
                meetEnd: meetEnd,
                prerequisiteId: prerequisiteId ? parseInt(prerequisiteId) : null,
                porcentajeCurso: porcentajeCurso,
                notaMinimaAprobacion: notaMinimaAprobacion
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Actualizar el material existente
            material.title = result.value.title;
            material.description = result.value.description;
            material.type = result.value.type;
            material.file = result.value.file;
            material.url = result.value.url;
            material.isPublic = result.value.isPublic;
            material.meetUrl = result.value.meetUrl;
            material.meetStart = result.value.meetStart;
            material.meetEnd = result.value.meetEnd;
            material.prerequisiteId = result.value.prerequisiteId;
            material.porcentajeCurso = result.value.porcentajeCurso;
            material.notaMinimaAprobacion = result.value.notaMinimaAprobacion;
            
            renderMaterialsList();
            updateMaterialsStats();
            
            Swal.fire({
                icon: 'success',
                title: 'Material actualizado',
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}

function removeMaterial(materialId) {
    // Verificar si otros materiales dependen de este
    const dependientes = courseData.materials.filter(m => m.prerequisiteId === materialId);
    let warningText = 'Esta acción no se puede deshacer';
    
    if (dependientes.length > 0) {
        const nombres = dependientes.map(m => m.title).join(', ');
        warningText = `Este material es prerrequisito de: ${nombres}. Al eliminarlo, estos materiales quedarán sin prerrequisito.`;
    }
    
    Swal.fire({
        title: '¿Eliminar material?',
        text: warningText,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Limpiar prerrequisitos de materiales que dependían de este
            courseData.materials.forEach(m => {
                if (m.prerequisiteId === materialId) {
                    m.prerequisiteId = null;
                }
            });
            
            // Eliminar el material
            courseData.materials = courseData.materials.filter(m => m.id !== materialId);
            renderMaterialsList();
            updateMaterialsStats();
            
            Swal.fire({
                icon: 'success',
                title: 'Material eliminado',
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}

// ==========================================
// PASO 3: FOROS Y DISCUSIONES
// ==========================================

function initializeStep3() {
    // Botones para agregar posts
    $('#btn-add-post').click(function() {
        showForumPostModal(false);
    });
    
    $('#btn-add-announcement').click(function() {
        showForumPostModal(true);
    });
    
    // Plantillas de posts
    $('[data-template]').click(function() {
        const template = $(this).data('template');
        applyPostTemplate(template);
    });
}

function showForumPostModal(isAnnouncement = false) {
    const title = isAnnouncement ? 'Crear Anuncio' : 'Crear Post';
    
    Swal.fire({
        title: title,
        html: `
            <div class="text-left">
                <div class="form-group">
                    <label for="post-title">Título *</label>
                    <input type="text" class="form-control" id="post-title" placeholder="Título del ${isAnnouncement ? 'anuncio' : 'post'}">
                </div>
                <div class="form-group">
                    <label for="post-content">Contenido *</label>
                    <textarea class="form-control" id="post-content" rows="6" placeholder="Escribe el contenido aquí..."></textarea>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="post-pinned" ${isAnnouncement ? 'checked' : ''}>
                        <label class="custom-control-label" for="post-pinned">Fijar ${isAnnouncement ? 'anuncio' : 'post'}</label>
                    </div>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: `Crear ${isAnnouncement ? 'Anuncio' : 'Post'}`,
        cancelButtonText: 'Cancelar',
        width: '600px',
        preConfirm: () => {
            const title = document.getElementById('post-title').value;
            const content = document.getElementById('post-content').value;
            const isPinned = document.getElementById('post-pinned').checked;
            
            if (!title.trim()) {
                Swal.showValidationMessage('El título es requerido');
                return false;
            }
            
            if (!content.trim()) {
                Swal.showValidationMessage('El contenido es requerido');
                return false;
            }
            
            return {
                title: title,
                content: content,
                isAnnouncement: isAnnouncement,
                isPinned: isPinned
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            addForumPost(result.value);
        }
    });
}

function addForumPost(postData) {
    const postId = Date.now();
    const post = {
        id: postId,
        title: postData.title,
        content: postData.content,
        isAnnouncement: postData.isAnnouncement,
        isPinned: postData.isPinned,
        createdAt: new Date()
    };
    
    courseData.forumPosts.push(post);
    renderForumPostsList();
}

function renderForumPostsList() {
    const container = $('#forum-posts-list');
    
    if (courseData.forumPosts.length === 0) {
        container.html(`
            <div class="text-center text-muted py-4" id="no-posts">
                <i class="fas fa-comments fa-3x mb-3"></i>
                <p>No hay posts creados aún</p>
                <p>Crea un post de bienvenida o anuncio inicial</p>
            </div>
        `);
        return;
    }
    
    let html = '';
    courseData.forumPosts.forEach(post => {
        const postClass = post.isAnnouncement ? 'announcement' : (post.isPinned ? 'pinned' : '');
        
        html += `
            <div class="forum-post-item ${postClass}" data-id="${post.id}">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="d-flex align-items-center">
                        ${post.isAnnouncement ? '<span class="badge badge-warning mr-2"><i class="fas fa-bullhorn"></i> Anuncio</span>' : ''}
                        ${post.isPinned && !post.isAnnouncement ? '<span class="badge badge-info mr-2"><i class="fas fa-thumbtack"></i> Fijado</span>' : ''}
                        <h6 class="mb-0">${post.title}</h6>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" onclick="editForumPost(${post.id}); return false;">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a class="dropdown-item text-danger" href="#" onclick="removeForumPost(${post.id}); return false;">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Por: Instructor • ${post.createdAt.toLocaleDateString()}</small>
                </div>
                <div class="post-content">
                    ${post.content.substring(0, 200)}${post.content.length > 200 ? '...' : ''}
                </div>
            </div>
        `;
    });
    
    container.html(html);
}

function applyPostTemplate(template) {
    const templates = {
        welcome: {
            title: '¡Bienvenidos al curso!',
            content: `¡Hola a todos y bienvenidos a nuestro curso!

Estoy muy emocionado de comenzar este viaje de aprendizaje con ustedes. En este curso exploraremos conceptos fundamentales y desarrollaremos habilidades prácticas que les serán muy útiles.

Algunas cosas importantes:
• Revisen regularmente los materiales del curso
• Participen activamente en las discusiones
• No duden en hacer preguntas
• Cumplan con las fechas de entrega

¡Espero que disfruten el curso y aprendan mucho!

Saludos,
[Nombre del Instructor]`
        },
        rules: {
            title: 'Reglas y Normas del Curso',
            content: `Para mantener un ambiente de aprendizaje positivo, por favor sigan estas reglas:

📋 PARTICIPACIÓN:
• Sean respetuosos en todas las interacciones
• Mantengan las discusiones relacionadas al tema
• Usen un lenguaje apropiado y profesional

📅 ENTREGAS:
• Cumplan con las fechas límite establecidas
• Notifiquen con anticipación si tienen algún inconveniente
• Sigan las instrucciones específicas de cada actividad

💬 COMUNICACIÓN:
• Usen el foro para preguntas generales
• Envíen mensajes privados para asuntos personales
• Respondan de manera constructiva a sus compañeros

¡Gracias por su cooperación!`
        },
        schedule: {
            title: 'Cronograma del Curso',
            content: `📅 CRONOGRAMA GENERAL

SEMANA 1: Introducción y Fundamentos
• Revisión de materiales básicos
• Actividad de presentación

SEMANA 2-3: Desarrollo de Conceptos
• Estudio de casos prácticos
• Primera evaluación

SEMANA 4-5: Aplicación Práctica
• Proyecto grupal
• Discusiones temáticas

SEMANA 6: Evaluación Final
• Presentaciones finales
• Evaluación integral

📝 FECHAS IMPORTANTES:
• [Fecha]: Primera evaluación
• [Fecha]: Entrega de proyecto
• [Fecha]: Evaluación final

*Las fechas específicas se actualizarán en el calendario del curso.`
        },
        faq: {
            title: 'Preguntas Frecuentes',
            content: `❓ PREGUNTAS FRECUENTES

🔹 ¿Cómo accedo a los materiales?
Los materiales están disponibles en la pestaña "Materiales" del curso.

🔹 ¿Puedo entregar tareas tarde?
Las entregas tardías pueden tener penalización. Consulta las políticas específicas de cada actividad.

🔹 ¿Cómo contacto al instructor?
Puedes usar el sistema de mensajes del curso o el email institucional.

🔹 ¿Hay horarios específicos para participar?
El curso es principalmente asíncrono, pero puede haber sesiones sincrónicas programadas.

🔹 ¿Qué pasa si tengo problemas técnicos?
Contacta al soporte técnico o al instructor inmediatamente.

¿Tienes otras preguntas? ¡No dudes en preguntar en el foro!`
        }
    };
    
    if (templates[template]) {
        showForumPostModal(template === 'welcome');
        // Llenar los campos con la plantilla
        setTimeout(() => {
            document.getElementById('post-title').value = templates[template].title;
            document.getElementById('post-content').value = templates[template].content;
        }, 100);
    }
}

function editForumPost(postId) {
    // Buscar el post a editar
    const post = courseData.forumPosts.find(p => p.id === postId);
    if (!post) return;

    const title = post.isAnnouncement ? 'Editar Anuncio' : 'Editar Post';
    
    Swal.fire({
        title: title,
        html: `
            <div class="text-left">
                <div class="form-group">
                    <label for="post-title">Título *</label>
                    <input type="text" class="form-control" id="post-title" placeholder="Título del ${post.isAnnouncement ? 'anuncio' : 'post'}" value="${post.title}">
                </div>
                <div class="form-group">
                    <label for="post-content">Contenido *</label>
                    <textarea class="form-control" id="post-content" rows="6" placeholder="Escribe el contenido aquí...">${post.content}</textarea>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="post-pinned" ${post.isPinned ? 'checked' : ''}>
                        <label class="custom-control-label" for="post-pinned">Fijar ${post.isAnnouncement ? 'anuncio' : 'post'}</label>
                    </div>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Actualizar',
        cancelButtonText: 'Cancelar',
        width: '600px',
        preConfirm: () => {
            const title = document.getElementById('post-title').value;
            const content = document.getElementById('post-content').value;
            const isPinned = document.getElementById('post-pinned').checked;
            
            if (!title.trim()) {
                Swal.showValidationMessage('El título es requerido');
                return false;
            }
            
            if (!content.trim()) {
                Swal.showValidationMessage('El contenido es requerido');
                return false;
            }
            
            return {
                title: title,
                content: content,
                isPinned: isPinned
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Actualizar el post existente
            post.title = result.value.title;
            post.content = result.value.content;
            post.isPinned = result.value.isPinned;
            
            renderForumPostsList();
            
            Swal.fire({
                icon: 'success',
                title: 'Post actualizado',
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}

function removeForumPost(postId) {
    Swal.fire({
        title: '¿Eliminar post?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            courseData.forumPosts = courseData.forumPosts.filter(p => p.id !== postId);
            renderForumPostsList();
            
            Swal.fire({
                icon: 'success',
                title: 'Post eliminado',
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}

// ==========================================
// PASO 4: ACTIVIDADES Y EVALUACIONES
// ==========================================

function initializeStep4() {
    // Botones para crear actividades
    $('[data-activity-type]').click(function() {
        const activityType = $(this).data('activity-type');
        showActivityModal(activityType);
    });
}

function showActivityModal(activityType) {
    const typeLabels = {
        tarea: 'Tarea',
        quiz: 'Quiz',
        evaluacion: 'Evaluación',
        proyecto: 'Proyecto'
    };

    const typeIcons = {
        tarea: 'fas fa-file-alt',
        quiz: 'fas fa-question-circle',
        evaluacion: 'fas fa-clipboard-check',
        proyecto: 'fas fa-project-diagram'
    };

    // Determinar si es un tipo que requiere preguntas (quiz o evaluación)
    const requierePreguntas = activityType === 'quiz' || activityType === 'evaluacion';
    const tipoLabel = activityType === 'quiz' ? 'Quiz' : 'Evaluación';

    // Generar lista de actividades existentes para prerrequisitos
    const actividadesExistentes = courseData.activities || [];
    let actividadesCheckboxes = '';
    if (actividadesExistentes.length > 0) {
        const typeIcons = {
            tarea: '📝',
            quiz: '❓',
            evaluacion: '📋',
            proyecto: '�'
        };
        actividadesExistentes.forEach(act => {
            const tipoIcon = typeIcons[act.type] || '📝';
            actividadesCheckboxes += `
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input activity-prereq-checkbox" id="activity-prereq-${act.id}" value="${act.id}">
                    <label class="custom-control-label" for="activity-prereq-${act.id}">
                        ${tipoIcon} ${act.title}
                    </label>
                </div>
            `;
        });
    }

    // Sección de prerrequisitos de actividades (solo si hay actividades existentes)
    const prerequisitosSection = actividadesExistentes.length > 0 ? `
        <hr class="my-3">
        <div class="form-group">
            <label><i class="fas fa-link text-info"></i> Prerrequisitos de Actividades</label>
            <div class="custom-control custom-switch mb-2">
                <input type="checkbox" class="custom-control-input" id="activity-has-prereqs" onchange="togglePrereqsSelection()">
                <label class="custom-control-label" for="activity-has-prereqs">
                    Requiere completar otras actividades antes
                </label>
            </div>
            <div id="prereqs-selection-container" style="display: none;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted">Selecciona las actividades que el estudiante debe completar:</small>
                    <div>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="selectAllPrereqs()">
                            <i class="fas fa-check-double"></i> Todas
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="deselectAllPrereqs()">
                            <i class="fas fa-times"></i> Ninguna
                        </button>
                    </div>
                </div>
                <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                    ${actividadesCheckboxes}
                </div>
                <small class="form-text text-muted">
                    <i class="fas fa-info-circle"></i> El estudiante deberá completar las actividades seleccionadas antes de poder acceder a esta actividad.
                </small>
            </div>
        </div>
    ` : '';

    // Generar lista de materiales disponibles para vincular actividad
    const materialesDisponibles = courseData.materials || [];
    // El porcentaje de cada actividad es relativo al material (0-100%), no al curso
    let materialesOptions = '<option value="">-- Actividad independiente (sin material) --</option>';
    materialesDisponibles.forEach(mat => {
        // Calcular porcentaje usado por otras actividades de este material (sobre 100% del material)
        const porcentajeUsadoEnMaterial = courseData.activities
            .filter(a => a.materialId === mat.id)
            .reduce((sum, a) => sum + (parseFloat(a.porcentajeMaterial) || 0), 0);
        // El disponible es 100% menos lo usado (relativo al material, no al curso)
        const porcentajeDisponibleMaterial = Math.max(0, 100 - porcentajeUsadoEnMaterial);
        materialesOptions += `<option value="${mat.id}" data-porcentaje-disponible="${porcentajeDisponibleMaterial.toFixed(1)}" data-porcentaje-material="${mat.porcentajeCurso || 0}">${mat.title} (${porcentajeDisponibleMaterial.toFixed(1)}% disponible)</option>`;
    });

    // Sección de configuración de calificación para actividades
    const gradingSection = `
        <hr class="my-3">
        <div class="card bg-light mb-3">
            <div class="card-header py-2">
                <strong><i class="fas fa-star text-warning"></i> Configuración de Calificación</strong>
            </div>
            <div class="card-body py-2">
                <div class="form-group mb-3">
                    <label for="activity-material"><i class="fas fa-book text-info"></i> Material al que pertenece *</label>
                    <select class="form-control" id="activity-material" onchange="updatePorcentajeDisponibleActividad()">
                        ${materialesOptions}
                    </select>
                    <small class="form-text text-muted">Selecciona el material al que pertenece esta actividad</small>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="activity-porcentaje">Porcentaje de la Actividad (%) *</label>
                            <input type="number" class="form-control" id="activity-porcentaje" 
                                   min="0" max="100" step="0.1" value="0" placeholder="0">
                            <small class="form-text text-muted" id="porcentaje-disponible-info">
                                Selecciona un material para ver el porcentaje disponible
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="activity-nota-minima">Nota Mínima Aprobación *</label>
                            <input type="number" class="form-control" id="activity-nota-minima" 
                                   min="0" max="5" step="0.1" value="3.0" placeholder="3.0">
                            <small class="form-text text-muted">Escala: 0.0 - 5.0</small>
                        </div>
                    </div>
                </div>
                <div id="material-progress-container" style="display: none;">
                    <label class="small">Distribución del porcentaje del material:</label>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar bg-success" role="progressbar" id="porcentaje-usado-bar" style="width: 0%"></div>
                        <div class="progress-bar bg-secondary" role="progressbar" id="porcentaje-disponible-bar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Campos específicos para Quiz y Evaluación (misma funcionalidad)
    const quizFields = requierePreguntas ? `
        <hr class="my-4">
        <h5 class="text-primary"><i class="fas fa-list-ol"></i> Preguntas de la ${tipoLabel}</h5>
        <div class="alert alert-info py-2">
            <i class="fas fa-info-circle"></i> <strong>Nota máxima: 5.0</strong> - La suma de puntos de todas las preguntas no puede exceder 5.0
        </div>
        <div class="form-group">
            <label>Puntos totales asignados:</label>
            <div class="progress" style="height: 25px;">
                <div class="progress-bar bg-success" role="progressbar" id="quiz-points-progress" style="width: 0%">0 / 5.0</div>
            </div>
        </div>
        <div class="form-group">
            <label for="quiz-duration">Duración de la ${tipoLabel} (minutos)</label>
            <input type="number" class="form-control" id="quiz-duration" min="5" max="180" value="30" placeholder="Ej: 30">
            <small class="form-text text-muted">Tiempo máximo para completar la ${tipoLabel.toLowerCase()}</small>
        </div>
        <div id="quiz-questions-container">
            <!-- Las preguntas se agregarán aquí -->
        </div>
        <button type="button" class="btn btn-outline-primary btn-sm btn-block" onclick="addQuizQuestion()" id="add-question-btn">
            <i class="fas fa-plus"></i> Agregar Pregunta
        </button>
        <small class="form-text text-muted text-center d-block mt-2">
            <i class="fas fa-info-circle"></i> Cada pregunta puede tener de 2 a 10 opciones de respuesta. Puedes marcar una o varias respuestas correctas.
        </small>
    ` : '';

    Swal.fire({
        title: `Crear ${typeLabels[activityType]}`,
        html: `
            <div class="text-left" style="max-height: 600px; overflow-y: auto;">
                <div class="form-group">
                    <label for="activity-title">Título *</label>
                    <input type="text" class="form-control" id="activity-title" placeholder="Título de la ${typeLabels[activityType].toLowerCase()}">
                </div>
                <div class="form-group">
                    <label for="activity-description">Descripción</label>
                    <textarea class="form-control" id="activity-description" rows="3" placeholder="Descripción de la actividad"></textarea>
                </div>
                <div class="form-group">
                    <label for="activity-instructions">Instrucciones</label>
                    <textarea class="form-control" id="activity-instructions" rows="4" placeholder="Instrucciones detalladas para los estudiantes"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="activity-open-date">Fecha de Apertura</label>
                            <input type="datetime-local" class="form-control" id="activity-open-date">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="activity-close-date">Fecha de Cierre</label>
                            <input type="datetime-local" class="form-control" id="activity-close-date">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="activity-points">Puntos Máximos</label>
                            <input type="number" class="form-control" id="activity-points" min="1" max="1000" value="100">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="activity-attempts">Intentos Permitidos</label>
                            <input type="number" class="form-control" id="activity-attempts" min="1" max="10" value="1">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="activity-required" checked>
                        <label class="custom-control-label" for="activity-required">Actividad obligatoria</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="activity-late-submissions">
                        <label class="custom-control-label" for="activity-late-submissions">Permitir entregas tardías</label>
                    </div>
                </div>
                ${gradingSection}
                ${prerequisitosSection}
                ${quizFields}
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: `Crear ${typeLabels[activityType]}`,
        cancelButtonText: 'Cancelar',
        width: '900px',
        didOpen: () => {
            // Función para mostrar/ocultar selección de prerrequisitos de actividades
            window.togglePrereqsSelection = function() {
                const hasPrereqs = document.getElementById('activity-has-prereqs')?.checked || false;
                const container = document.getElementById('prereqs-selection-container');
                if (container) {
                    container.style.display = hasPrereqs ? 'block' : 'none';
                }
            };
            
            // Función para seleccionar todas las actividades prerrequisito
            window.selectAllPrereqs = function() {
                document.querySelectorAll('.activity-prereq-checkbox').forEach(cb => cb.checked = true);
            };
            
            // Función para deseleccionar todas las actividades prerrequisito
            window.deselectAllPrereqs = function() {
                document.querySelectorAll('.activity-prereq-checkbox').forEach(cb => cb.checked = false);
            };
            
            // Función para actualizar el porcentaje disponible según el material seleccionado
            // El porcentaje de la actividad es relativo al material (0-100%), no al curso
            window.updatePorcentajeDisponibleActividad = function() {
                const materialSelect = document.getElementById('activity-material');
                const porcentajeInput = document.getElementById('activity-porcentaje');
                const infoText = document.getElementById('porcentaje-disponible-info');
                const progressContainer = document.getElementById('material-progress-container');
                const usadoBar = document.getElementById('porcentaje-usado-bar');
                const disponibleBar = document.getElementById('porcentaje-disponible-bar');
                
                if (!materialSelect || !materialSelect.value) {
                    infoText.innerHTML = 'Selecciona un material para ver el porcentaje disponible';
                    progressContainer.style.display = 'none';
                    porcentajeInput.max = 100;
                    return;
                }
                
                const selectedOption = materialSelect.options[materialSelect.selectedIndex];
                // porcentajeDisponible es sobre 100% del material (no sobre el porcentaje del curso)
                const porcentajeDisponible = parseFloat(selectedOption.dataset.porcentajeDisponible) || 0;
                const porcentajeMaterialEnCurso = parseFloat(selectedOption.dataset.porcentajeMaterial) || 0;
                // El porcentaje usado es 100 - disponible (sobre el material)
                const porcentajeUsadoEnMaterial = 100 - porcentajeDisponible;
                
                porcentajeInput.max = porcentajeDisponible;
                infoText.innerHTML = 'Disponible: <strong>' + porcentajeDisponible.toFixed(1) + '%</strong> del material (el material representa ' + porcentajeMaterialEnCurso.toFixed(1) + '% del curso)';
                
                progressContainer.style.display = 'block';
                // La barra de progreso muestra el uso sobre 100% del material
                usadoBar.style.width = porcentajeUsadoEnMaterial + '%';
                usadoBar.textContent = porcentajeUsadoEnMaterial > 10 ? porcentajeUsadoEnMaterial.toFixed(1) + '% usado' : '';
                disponibleBar.style.width = porcentajeDisponible + '%';
                disponibleBar.textContent = porcentajeDisponible > 10 ? porcentajeDisponible.toFixed(1) + '% disp' : '';
            };
            
            // Inicializar array temporal para preguntas del quiz
            window.quizQuestions = [];
            window.questionCounter = 0;
            window.optionCounters = {}; // Contador de opciones por pregunta
            
            // Letras para las opciones
            window.optionLetters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
            
            // Función para agregar una opción de respuesta a una pregunta
            window.addQuestionOption = function(questionId) {
                const optionsContainer = document.getElementById(`options-container-${questionId}`);
                const currentOptions = optionsContainer.querySelectorAll('.option-row').length;
                
                if (currentOptions >= 10) {
                    Swal.showValidationMessage('Máximo 10 opciones por pregunta');
                    return;
                }
                
                const optionLetter = window.optionLetters[currentOptions];
                const optionHtml = `
                    <div class="input-group mb-2 option-row" id="option-${questionId}-${optionLetter}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <input type="checkbox" name="correct-answer-${questionId}" value="${optionLetter}" title="Marcar como respuesta correcta">
                            </div>
                            <span class="input-group-text"><strong>${optionLetter}</strong></span>
                        </div>
                        <input type="text" class="form-control" id="question-option-${optionLetter.toLowerCase()}-${questionId}" placeholder="Opción ${optionLetter}">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeQuestionOption(${questionId}, '${optionLetter}')" title="Eliminar opción">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `;
                
                optionsContainer.insertAdjacentHTML('beforeend', optionHtml);
                window.optionCounters[questionId] = currentOptions + 1;
                
                // Actualizar visibilidad del botón de eliminar opciones
                updateOptionRemoveButtons(questionId);
            };
            
            // Función para eliminar una opción de respuesta
            window.removeQuestionOption = function(questionId, optionLetter) {
                const optionsContainer = document.getElementById(`options-container-${questionId}`);
                const currentOptions = optionsContainer.querySelectorAll('.option-row').length;
                
                if (currentOptions <= 2) {
                    Swal.showValidationMessage('Mínimo 2 opciones por pregunta');
                    return;
                }
                
                const optionElement = document.getElementById(`option-${questionId}-${optionLetter}`);
                if (optionElement) {
                    optionElement.remove();
                    window.optionCounters[questionId]--;
                    
                    // Renumerar las opciones restantes
                    renumberOptions(questionId);
                }
            };
            
            // Función para renumerar opciones después de eliminar una
            window.renumberOptions = function(questionId) {
                const optionsContainer = document.getElementById(`options-container-${questionId}`);
                const optionRows = optionsContainer.querySelectorAll('.option-row');
                
                optionRows.forEach((row, index) => {
                    const newLetter = window.optionLetters[index];
                    const oldId = row.id;
                    const oldLetter = oldId.split('-').pop();
                    
                    // Actualizar ID del contenedor
                    row.id = `option-${questionId}-${newLetter}`;
                    
                    // Actualizar checkbox
                    const checkbox = row.querySelector('input[type="checkbox"]');
                    if (checkbox) {
                        checkbox.value = newLetter;
                    }
                    
                    // Actualizar etiqueta de letra
                    const letterSpan = row.querySelector('.input-group-text strong');
                    if (letterSpan) {
                        letterSpan.textContent = newLetter;
                    }
                    
                    // Actualizar input de texto
                    const textInput = row.querySelector('input[type="text"]');
                    if (textInput) {
                        textInput.id = `question-option-${newLetter.toLowerCase()}-${questionId}`;
                        textInput.placeholder = `Opción ${newLetter}`;
                    }
                    
                    // Actualizar botón de eliminar
                    const removeBtn = row.querySelector('button');
                    if (removeBtn) {
                        removeBtn.setAttribute('onclick', `removeQuestionOption(${questionId}, '${newLetter}')`);
                    }
                });
                
                updateOptionRemoveButtons(questionId);
            };
            
            // Función para actualizar visibilidad de botones de eliminar
            window.updateOptionRemoveButtons = function(questionId) {
                const optionsContainer = document.getElementById(`options-container-${questionId}`);
                const optionRows = optionsContainer.querySelectorAll('.option-row');
                const removeButtons = optionsContainer.querySelectorAll('.btn-outline-danger');
                
                removeButtons.forEach(btn => {
                    btn.style.display = optionRows.length > 2 ? 'block' : 'none';
                });
            };
            
            // Función para agregar pregunta
            window.addQuizQuestion = function() {
                const questionId = ++window.questionCounter;
                const container = document.getElementById('quiz-questions-container');
                window.optionCounters[questionId] = 0;
                
                // Calcular puntos disponibles
                const puntosUsados = calcularPuntosTotalesQuiz();
                const puntosDisponibles = Math.max(0, 5 - puntosUsados).toFixed(1);
                
                const questionHtml = `
                    <div class="card mb-3" id="question-${questionId}" style="border-left: 3px solid #007bff;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0"><i class="fas fa-question-circle text-primary"></i> Pregunta ${window.quizQuestions.length + 1}</h6>
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeQuizQuestion(${questionId})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="form-group">
                                <label>Texto de la Pregunta *</label>
                                <input type="text" class="form-control" id="question-text-${questionId}" placeholder="Escribe la pregunta aquí">
                            </div>
                            <div class="form-group">
                                <label>Ponderación (puntos) <small class="text-muted">Máx: 5.0</small></label>
                                <input type="number" class="form-control question-points-input" id="question-points-${questionId}" 
                                       min="0" max="5" step="0.1" value="1.0" placeholder="Puntos de esta pregunta"
                                       onchange="actualizarPuntosDisponiblesQuiz()">
                                <small class="form-text text-muted">Disponible: <span class="puntos-disponibles">${puntosDisponibles}</span> de 5.0 puntos</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="mb-0">Opciones de Respuesta * <small class="text-muted">(marca las correctas)</small></label>
                                <button type="button" class="btn btn-outline-success btn-sm" onclick="addQuestionOption(${questionId})">
                                    <i class="fas fa-plus"></i> Agregar Opción
                                </button>
                            </div>
                            <div id="options-container-${questionId}">
                                <!-- Las opciones se agregarán aquí -->
                            </div>
                            <small class="text-muted"><i class="fas fa-info-circle"></i> Marca con el checkbox las respuestas correctas (puede ser una o varias)</small>
                        </div>
                    </div>
                `;
                
                container.insertAdjacentHTML('beforeend', questionHtml);
                window.quizQuestions.push(questionId);
                
                // Agregar 2 opciones por defecto (mínimo requerido)
                addQuestionOption(questionId);
                addQuestionOption(questionId);
                
                // Actualizar puntos disponibles en todas las preguntas
                actualizarPuntosDisponiblesQuiz();
            };
            
            // Función para calcular puntos totales del quiz
            window.calcularPuntosTotalesQuiz = function() {
                let total = 0;
                document.querySelectorAll('.question-points-input').forEach(input => {
                    total += parseFloat(input.value) || 0;
                });
                return total;
            };
            
            // Función para actualizar puntos disponibles en todas las preguntas
            window.actualizarPuntosDisponiblesQuiz = function() {
                const puntosUsados = calcularPuntosTotalesQuiz();
                const puntosDisponibles = Math.max(0, 5 - puntosUsados).toFixed(1);
                document.querySelectorAll('.puntos-disponibles').forEach(span => {
                    span.textContent = puntosDisponibles;
                    span.style.color = puntosUsados > 5 ? 'red' : 'inherit';
                });
                
                // Actualizar barra de progreso si existe
                const progressBar = document.getElementById('quiz-points-progress');
                if (progressBar) {
                    const porcentaje = Math.min(100, (puntosUsados / 5) * 100);
                    progressBar.style.width = porcentaje + '%';
                    progressBar.textContent = puntosUsados.toFixed(1) + ' / 5.0';
                    progressBar.className = 'progress-bar ' + (puntosUsados > 5 ? 'bg-danger' : 'bg-success');
                }
            };
            
            // Función para eliminar pregunta
            window.removeQuizQuestion = function(questionId) {
                document.getElementById(`question-${questionId}`).remove();
                window.quizQuestions = window.quizQuestions.filter(id => id !== questionId);
                delete window.optionCounters[questionId];
                
                // Renumerar preguntas
                window.quizQuestions.forEach((id, index) => {
                    const questionCard = document.getElementById(`question-${id}`);
                    if (questionCard) {
                        const header = questionCard.querySelector('h6');
                        if (header) {
                            header.innerHTML = `<i class="fas fa-question-circle text-primary"></i> Pregunta ${index + 1}`;
                        }
                    }
                });
                
                // Actualizar puntos disponibles
                actualizarPuntosDisponiblesQuiz();
            };
            
            // Si es quiz o evaluación, agregar 1 pregunta por defecto para empezar
            if (activityType === 'quiz' || activityType === 'evaluacion') {
                setTimeout(() => window.addQuizQuestion(), 100);
            }
        },
        preConfirm: () => {
            const title = document.getElementById('activity-title').value;
            const description = document.getElementById('activity-description').value;
            const instructions = document.getElementById('activity-instructions').value;
            const openDate = document.getElementById('activity-open-date').value;
            const closeDate = document.getElementById('activity-close-date').value;
            const points = document.getElementById('activity-points').value;
            const attempts = document.getElementById('activity-attempts').value;
            const isRequired = document.getElementById('activity-required').checked;
            const allowLateSubmissions = document.getElementById('activity-late-submissions').checked;
            
            // Datos de calificación
            const materialId = document.getElementById('activity-material').value;
            const porcentajeMaterial = parseFloat(document.getElementById('activity-porcentaje').value) || 0;
            const notaMinimaAprobacion = parseFloat(document.getElementById('activity-nota-minima').value) || 3.0;

            if (!title.trim()) {
                Swal.showValidationMessage('El título es requerido');
                return false;
            }

            if (openDate && closeDate && new Date(closeDate) <= new Date(openDate)) {
                Swal.showValidationMessage('La fecha de cierre debe ser posterior a la fecha de apertura');
                return false;
            }
            
            // Validación de material
            if (!materialId) {
                Swal.showValidationMessage('Debes seleccionar un material al que pertenece la actividad');
                return false;
            }
            
            // Validación de porcentaje (relativo al material, 0-100%)
            const materialSelect = document.getElementById('activity-material');
            const selectedOption = materialSelect.options[materialSelect.selectedIndex];
            const maxPorcentajeMat = parseFloat(selectedOption.dataset.porcentajeDisponible) || 0;
            
            if (porcentajeMaterial < 0) {
                Swal.showValidationMessage('El porcentaje no puede ser negativo');
                return false;
            }
            
            if (porcentajeMaterial > 100) {
                Swal.showValidationMessage('El porcentaje no puede exceder 100% del material');
                return false;
            }
            
            if (porcentajeMaterial > maxPorcentajeMat) {
                Swal.showValidationMessage('El porcentaje excede el disponible del material (' + maxPorcentajeMat.toFixed(1) + '% de 100%)');
                return false;
            }
            
            // Validación de nota mínima
            if (notaMinimaAprobacion < 0 || notaMinimaAprobacion > 5) {
                Swal.showValidationMessage('La nota mínima debe estar entre 0.0 y 5.0');
                return false;
            }

            // Validación específica para Quiz y Evaluación
            let quizData = null;
            if (activityType === 'quiz' || activityType === 'evaluacion') {
                const duration = document.getElementById('quiz-duration').value;
                
                if (window.quizQuestions.length < 1) {
                    Swal.showValidationMessage('Debes crear al menos 1 pregunta');
                    return false;
                }
                
                const questions = [];
                let totalQuestionPoints = 0;
                
                for (const questionId of window.quizQuestions) {
                    const questionText = document.getElementById(`question-text-${questionId}`).value;
                    const questionPoints = document.getElementById(`question-points-${questionId}`).value;
                    
                    if (!questionText.trim()) {
                        Swal.showValidationMessage('Todas las preguntas deben tener texto');
                        return false;
                    }
                    
                    // Obtener todas las opciones dinámicamente
                    const optionsContainer = document.getElementById(`options-container-${questionId}`);
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
                        
                        if (!textInput.value.trim()) {
                            hasEmptyOption = true;
                        }
                        
                        options[letter] = textInput.value;
                        
                        if (checkbox && checkbox.checked) {
                            correctAnswers.push(letter);
                        }
                    });
                    
                    if (hasEmptyOption) {
                        Swal.showValidationMessage('Todas las opciones de respuesta deben tener texto');
                        return false;
                    }
                    
                    if (correctAnswers.length === 0) {
                        Swal.showValidationMessage('Cada pregunta debe tener al menos una respuesta correcta marcada');
                        return false;
                    }
                    
                    const puntosPregunta = parseFloat(questionPoints) || 0;
                    
                    // Validar que los puntos de la pregunta estén entre 0 y 5
                    if (puntosPregunta < 0 || puntosPregunta > 5) {
                        Swal.showValidationMessage('Los puntos de cada pregunta deben estar entre 0 y 5');
                        return false;
                    }
                    
                    totalQuestionPoints += puntosPregunta;
                    
                    questions.push({
                        id: questionId,
                        text: questionText,
                        points: puntosPregunta,
                        options: options,
                        correctAnswers: correctAnswers, // Array de respuestas correctas
                        isMultipleChoice: correctAnswers.length > 1 // Indica si tiene múltiples respuestas correctas
                    });
                }
                
                // Validar que la suma total no exceda 5.0
                if (totalQuestionPoints > 5) {
                    Swal.showValidationMessage('La suma de puntos de todas las preguntas no puede exceder 5.0 (actual: ' + totalQuestionPoints.toFixed(1) + ')');
                    return false;
                }
                
                quizData = {
                    duration: parseInt(duration),
                    questions: questions,
                    totalPoints: totalQuestionPoints
                };
            }

            // Obtener actividades prerrequisito
            const hasPrereqs = document.getElementById('activity-has-prereqs')?.checked || false;
            let prerequisiteActivityIds = [];
            if (hasPrereqs) {
                document.querySelectorAll('.activity-prereq-checkbox:checked').forEach(cb => {
                    prerequisiteActivityIds.push(parseInt(cb.value));
                });
            }

            return {
                title: title,
                description: description,
                instructions: instructions,
                type: activityType,
                openDate: openDate,
                closeDate: closeDate,
                points: parseInt(points),
                attempts: parseInt(attempts),
                isRequired: isRequired,
                allowLateSubmissions: allowLateSubmissions,
                quizData: quizData,
                prerequisiteActivityIds: prerequisiteActivityIds,
                materialId: materialId ? parseInt(materialId) : null,
                porcentajeMaterial: porcentajeMaterial,
                notaMinimaAprobacion: notaMinimaAprobacion
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            addActivity(result.value);
        }
    });
}

function addActivity(activityData) {
    const activityId = Date.now();
    const activity = {
        id: activityId,
        title: activityData.title,
        description: activityData.description,
        instructions: activityData.instructions,
        type: activityData.type,
        openDate: activityData.openDate,
        closeDate: activityData.closeDate,
        points: activityData.points,
        attempts: activityData.attempts,
        isRequired: activityData.isRequired,
        allowLateSubmissions: activityData.allowLateSubmissions,
        quizData: activityData.quizData || null,
        prerequisiteActivityIds: activityData.prerequisiteActivityIds || [],
        materialId: activityData.materialId || null,
        porcentajeMaterial: activityData.porcentajeMaterial || 0,
        notaMinimaAprobacion: activityData.notaMinimaAprobacion || 3.0,
        createdAt: new Date()
    };

    courseData.activities.push(activity);
    renderActivitiesList();
    updateActivitiesStats();
    
    // Mensaje de confirmación específico para Quiz y Evaluación
    if ((activityData.type === 'quiz' || activityData.type === 'evaluacion') && activityData.quizData) {
        const tipoLabel = activityData.type === 'quiz' ? 'Quiz' : 'Evaluación';
        let prereqInfo = '';
        if (activityData.prerequisiteActivityIds && activityData.prerequisiteActivityIds.length > 0) {
            prereqInfo = `<br>Requiere <strong>${activityData.prerequisiteActivityIds.length} actividad(es)</strong> previas`;
        }
        Swal.fire({
            icon: 'success',
            title: `${tipoLabel} creado exitosamente`,
            html: `<strong>${activityData.quizData.questions.length} preguntas</strong> agregadas<br>
                   Duración: <strong>${activityData.quizData.duration} minutos</strong><br>
                   Puntos totales: <strong>${activityData.quizData.totalPoints}</strong>${prereqInfo}`,
            showConfirmButton: false,
            timer: 2500
        });
    } else if (activityData.prerequisiteActivityIds && activityData.prerequisiteActivityIds.length > 0) {
        Swal.fire({
            icon: 'success',
            title: 'Actividad creada',
            html: `Requiere <strong>${activityData.prerequisiteActivityIds.length} actividad(es)</strong> previas`,
            showConfirmButton: false,
            timer: 1500
        });
    }
}

function renderActivitiesList() {
    const container = $('#activities-list');

    if (courseData.activities.length === 0) {
        container.html(`
            <div class="text-center text-muted py-4" id="no-activities">
                <i class="fas fa-tasks fa-3x mb-3"></i>
                <p>No hay actividades creadas aún</p>
                <p>Crea tareas, quizzes o evaluaciones para tus estudiantes</p>
            </div>
        `);
        return;
    }

    let html = '';
    courseData.activities.forEach(activity => {
        const typeIcons = {
            tarea: 'fas fa-file-alt text-primary',
            quiz: 'fas fa-question-circle text-info',
            evaluacion: 'fas fa-clipboard-check text-warning',
            proyecto: 'fas fa-project-diagram text-success'
        };

        const typeLabels = {
            tarea: 'Tarea',
            quiz: 'Quiz',
            evaluacion: 'Evaluación',
            proyecto: 'Proyecto'
        };

        // Información adicional para Quiz
        let quizInfo = '';
        if ((activity.type === 'quiz' || activity.type === 'evaluacion') && activity.quizData) {
            quizInfo = `
                <div class="mt-2">
                    <span class="badge badge-light mr-2">
                        <i class="fas fa-list-ol"></i> ${activity.quizData.questions.length} preguntas
                    </span>
                    <span class="badge badge-light mr-2">
                        <i class="fas fa-clock"></i> ${activity.quizData.duration} min
                    </span>
                    <span class="badge badge-light">
                        <i class="fas fa-star"></i> ${activity.quizData.totalPoints} pts totales
                    </span>
                </div>
            `;
        }
        
        // Información del material al que pertenece
        let materialInfo = '';
        if (activity.materialId) {
            const material = courseData.materials.find(m => m.id === activity.materialId);
            if (material) {
                materialInfo = `<span class="badge badge-dark mr-2" title="Pertenece al material: ${material.title}"><i class="fas fa-book"></i> ${material.title.substring(0, 15)}${material.title.length > 15 ? '...' : ''}</span>`;
            }
        }
        
        // Información de actividades prerrequisito
        let prereqActivitiesInfo = '';
        if (activity.prerequisiteActivityIds && activity.prerequisiteActivityIds.length > 0) {
            const prereqActivityNames = activity.prerequisiteActivityIds.map(id => {
                const act = courseData.activities.find(a => a.id === id);
                return act ? act.title : 'Actividad eliminada';
            }).filter(name => name !== 'Actividad eliminada');
            
            if (prereqActivityNames.length > 0) {
                const displayNames = prereqActivityNames.length > 2 
                    ? prereqActivityNames.slice(0, 2).join(', ') + ` y ${prereqActivityNames.length - 2} más`
                    : prereqActivityNames.join(', ');
                prereqActivitiesInfo = `<span class="badge badge-info mr-2" title="Requiere completar: ${prereqActivityNames.join(', ')}"><i class="fas fa-link"></i> ${prereqActivityNames.length} prerreq.</span>`;
            }
        }
        
        html += `
            <div class="activity-item" data-id="${activity.id}">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <i class="${typeIcons[activity.type]} fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">${activity.title}</h6>
                        <p class="mb-1 text-muted small">${activity.description || 'Sin descripción'}</p>
                        <div class="d-flex align-items-center flex-wrap">
                            <span class="badge badge-secondary mr-2">${typeLabels[activity.type]}</span>
                            ${activity.isRequired ? '<span class="badge badge-danger mr-2">Obligatoria</span>' : '<span class="badge badge-info mr-2">Opcional</span>'}
                            ${materialInfo}
                            <span class="badge badge-primary mr-2" title="Porcentaje relativo al material (0-100%)"><i class="fas fa-percent"></i> ${(activity.porcentajeMaterial || 0).toFixed(1)}% del material</span>
                            <span class="badge badge-warning mr-2" title="Nota mínima de aprobación (0-5.0)"><i class="fas fa-star"></i> Mín: ${(activity.notaMinimaAprobacion || 3.0).toFixed(1)}</span>
                            ${prereqActivitiesInfo}
                            <small class="text-muted mr-3">${activity.points} puntos</small>
                            ${activity.openDate ? `<small class="text-muted">Abre: ${new Date(activity.openDate).toLocaleDateString()}</small>` : ''}
                        </div>
                        ${quizInfo}
                    </div>
                    <div class="ml-auto">
                        <button type="button" class="btn btn-sm btn-outline-primary mr-1" onclick="editActivity(${activity.id}); return false;">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeActivity(${activity.id}); return false;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    });

    container.html(html);
}

function updateActivitiesStats() {
    const stats = {
        tarea: 0,
        quiz: 0,
        evaluacion: 0,
        proyecto: 0
    };

    courseData.activities.forEach(activity => {
        if (stats.hasOwnProperty(activity.type)) {
            stats[activity.type]++;
        }
    });

    $('#count-tareas').text(stats.tarea);
    $('#count-quizzes').text(stats.quiz);
    $('#count-evaluaciones').text(stats.evaluacion);
    $('#count-proyectos').text(stats.proyecto);
}

function editActivity(activityId) {
    // Buscar la actividad a editar
    const activity = courseData.activities.find(a => a.id === activityId);
    if (!activity) return;

    const typeLabels = {
        tarea: 'Tarea',
        quiz: 'Quiz',
        evaluacion: 'Evaluación',
        proyecto: 'Proyecto'
    };

    // Generar opciones de materiales para vincular actividad
    // El porcentaje de cada actividad es relativo al material (0-100%), no al curso
    const materialesDisponibles = courseData.materials || [];
    let materialesOptionsEdit = '<option value="">-- Actividad independiente (sin material) --</option>';
    materialesDisponibles.forEach(mat => {
        // Calcular porcentaje usado por otras actividades de este material (excluyendo la actual)
        const porcentajeUsadoEnMaterial = courseData.activities
            .filter(a => a.materialId === mat.id && a.id !== activityId)
            .reduce((sum, a) => sum + (parseFloat(a.porcentajeMaterial) || 0), 0);
        // El disponible es 100% menos lo usado (relativo al material, no al curso)
        const porcentajeDisponibleMaterial = Math.max(0, 100 - porcentajeUsadoEnMaterial);
        const selected = activity.materialId === mat.id ? 'selected' : '';
        materialesOptionsEdit += `<option value="${mat.id}" ${selected} data-porcentaje-disponible="${porcentajeDisponibleMaterial.toFixed(1)}" data-porcentaje-material="${mat.porcentajeCurso || 0}">${mat.title} (${porcentajeDisponibleMaterial.toFixed(1)}% disponible)</option>`;
    });

    // Calcular porcentaje disponible del material actual (sobre 100% del material)
    let porcentajeDisponibleMaterialEdit = 100;
    if (activity.materialId) {
        const porcentajeUsadoEnMaterial = courseData.activities
            .filter(a => a.materialId === activity.materialId && a.id !== activityId)
            .reduce((sum, a) => sum + (parseFloat(a.porcentajeMaterial) || 0), 0);
        porcentajeDisponibleMaterialEdit = Math.max(0, 100 - porcentajeUsadoEnMaterial);
    }

    // Sección de configuración de calificación para edición
    const gradingSectionEdit = `
        <hr class="my-3">
        <div class="card bg-light mb-3">
            <div class="card-header py-2">
                <strong><i class="fas fa-star text-warning"></i> Configuración de Calificación</strong>
            </div>
            <div class="card-body py-2">
                <div class="form-group mb-3">
                    <label for="activity-material"><i class="fas fa-book text-info"></i> Material al que pertenece *</label>
                    <select class="form-control" id="activity-material" onchange="updatePorcentajeDisponibleActividadEdit()">
                        ${materialesOptionsEdit}
                    </select>
                    <small class="form-text text-muted">Selecciona el material al que pertenece esta actividad</small>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="activity-porcentaje">Porcentaje de la Actividad (%) *</label>
                            <input type="number" class="form-control" id="activity-porcentaje" 
                                   min="0" max="${porcentajeDisponibleMaterialEdit}" step="0.1" value="${activity.porcentajeMaterial || 0}" placeholder="0">
                            <small class="form-text text-muted" id="porcentaje-disponible-info-edit">
                                Disponible: <strong>${porcentajeDisponibleMaterialEdit.toFixed(1)}%</strong>
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label for="activity-nota-minima">Nota Mínima Aprobación *</label>
                            <input type="number" class="form-control" id="activity-nota-minima" 
                                   min="0" max="5" step="0.1" value="${activity.notaMinimaAprobacion || 3.0}" placeholder="3.0">
                            <small class="form-text text-muted">Escala: 0.0 - 5.0</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Campos editables para Quiz y Evaluación
    let quizFields = '';
    if ((activity.type === 'quiz' || activity.type === 'evaluacion') && activity.quizData) {
        const tipoLabel = activity.type === 'quiz' ? 'Quiz' : 'Evaluación';
        quizFields = `
            <hr class="my-4">
            <h5 class="text-primary"><i class="fas fa-list-ol"></i> Preguntas del ${tipoLabel}</h5>
            <div class="alert alert-info py-2">
                <i class="fas fa-info-circle"></i> <strong>Nota máxima: 5.0</strong> - La suma de puntos de todas las preguntas no puede exceder 5.0
            </div>
            <div class="form-group">
                <label>Puntos totales asignados:</label>
                <div class="progress" style="height: 25px;">
                    <div class="progress-bar bg-success" role="progressbar" id="quiz-points-progress-edit" style="width: 0%">0 / 5.0</div>
                </div>
            </div>
            <div class="form-group">
                <label for="quiz-duration">Duración del ${tipoLabel} (minutos)</label>
                <input type="number" class="form-control" id="quiz-duration" min="5" max="180" value="${activity.quizData.duration}" placeholder="Ej: 30">
                <small class="form-text text-muted">Tiempo máximo para completar el ${tipoLabel.toLowerCase()}</small>
            </div>
            <div id="quiz-questions-container">
                <!-- Las preguntas se cargarán aquí -->
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm btn-block" onclick="addQuizQuestionEdit()" id="add-question-btn-edit">
                <i class="fas fa-plus"></i> Agregar Pregunta
            </button>
        `;
    }

    Swal.fire({
        title: `Editar ${typeLabels[activity.type]}`,
        html: `
            <div class="text-left" style="max-height: 600px; overflow-y: auto;">
                <div class="form-group">
                    <label for="activity-title">Título *</label>
                    <input type="text" class="form-control" id="activity-title" placeholder="Título de la actividad" value="${activity.title}">
                </div>
                <div class="form-group">
                    <label for="activity-description">Descripción</label>
                    <textarea class="form-control" id="activity-description" rows="3" placeholder="Descripción de la actividad">${activity.description || ''}</textarea>
                </div>
                <div class="form-group">
                    <label for="activity-instructions">Instrucciones</label>
                    <textarea class="form-control" id="activity-instructions" rows="4" placeholder="Instrucciones detalladas para los estudiantes">${activity.instructions || ''}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="activity-open-date">Fecha de Apertura</label>
                            <input type="datetime-local" class="form-control" id="activity-open-date" value="${activity.openDate || ''}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="activity-close-date">Fecha de Cierre</label>
                            <input type="datetime-local" class="form-control" id="activity-close-date" value="${activity.closeDate || ''}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="activity-points">Puntos Máximos</label>
                            <input type="number" class="form-control" id="activity-points" min="1" max="1000" value="${activity.points}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="activity-attempts">Intentos Permitidos</label>
                            <input type="number" class="form-control" id="activity-attempts" min="1" max="10" value="${activity.attempts}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="activity-required" ${activity.isRequired ? 'checked' : ''}>
                        <label class="custom-control-label" for="activity-required">Actividad obligatoria</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="activity-late-submissions" ${activity.allowLateSubmissions ? 'checked' : ''}>
                        <label class="custom-control-label" for="activity-late-submissions">Permitir entregas tardías</label>
                    </div>
                </div>
                ${gradingSectionEdit}
                ${quizFields}
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Actualizar',
        cancelButtonText: 'Cancelar',
        width: '900px',
        didOpen: () => {
            // Función para actualizar el porcentaje disponible según el material seleccionado en edición
            // El porcentaje de la actividad es relativo al material (0-100%), no al curso
            window.updatePorcentajeDisponibleActividadEdit = function() {
                const materialSelect = document.getElementById('activity-material');
                const porcentajeInput = document.getElementById('activity-porcentaje');
                const infoText = document.getElementById('porcentaje-disponible-info-edit');
                
                if (!materialSelect || !materialSelect.value) {
                    infoText.innerHTML = 'Selecciona un material para ver el porcentaje disponible';
                    porcentajeInput.max = 100;
                    return;
                }
                
                const selectedOption = materialSelect.options[materialSelect.selectedIndex];
                // porcentajeDisponible es sobre 100% del material (no sobre el porcentaje del curso)
                const porcentajeDisponible = parseFloat(selectedOption.dataset.porcentajeDisponible) || 0;
                const porcentajeMaterialEnCurso = parseFloat(selectedOption.dataset.porcentajeMaterial) || 0;
                
                porcentajeInput.max = porcentajeDisponible;
                infoText.innerHTML = 'Disponible: <strong>' + porcentajeDisponible.toFixed(1) + '%</strong> del material (el material representa ' + porcentajeMaterialEnCurso.toFixed(1) + '% del curso)';
            };
            
            // Si es quiz o evaluación, cargar las preguntas existentes para edición
            if ((activity.type === 'quiz' || activity.type === 'evaluacion') && activity.quizData) {
                window.quizQuestionsEdit = [];
                window.questionCounterEdit = 0;
                
                // Función para calcular puntos totales del quiz en edición
                window.calcularPuntosTotalesQuizEdit = function() {
                    let total = 0;
                    document.querySelectorAll('.question-points-input-edit').forEach(input => {
                        total += parseFloat(input.value) || 0;
                    });
                    return total;
                };
                
                // Función para actualizar puntos disponibles en edición
                window.actualizarPuntosDisponiblesQuizEdit = function() {
                    const puntosUsados = calcularPuntosTotalesQuizEdit();
                    const puntosDisponibles = Math.max(0, 5 - puntosUsados).toFixed(1);
                    document.querySelectorAll('.puntos-disponibles-edit').forEach(span => {
                        span.textContent = puntosDisponibles;
                        span.style.color = puntosUsados > 5 ? 'red' : 'inherit';
                    });
                    
                    const progressBar = document.getElementById('quiz-points-progress-edit');
                    if (progressBar) {
                        const porcentaje = Math.min(100, (puntosUsados / 5) * 100);
                        progressBar.style.width = porcentaje + '%';
                        progressBar.textContent = puntosUsados.toFixed(1) + ' / 5.0';
                        progressBar.className = 'progress-bar ' + (puntosUsados > 5 ? 'bg-danger' : 'bg-success');
                    }
                };
                
                // Función para agregar pregunta en edición
                window.addQuizQuestionEdit = function(existingQuestion = null) {
                    const questionId = existingQuestion ? existingQuestion.id : ++window.questionCounterEdit;
                    const container = document.getElementById('quiz-questions-container');
                    
                    const puntosDefault = existingQuestion ? existingQuestion.points : 1.0;
                    
                    const questionHtml = `
                        <div class="card mb-3" id="question-edit-${questionId}" style="border-left: 3px solid #007bff;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0"><i class="fas fa-question-circle text-primary"></i> Pregunta ${window.quizQuestionsEdit.length + 1}</h6>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeQuizQuestionEdit(${questionId})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <div class="form-group">
                                    <label>Texto de la Pregunta *</label>
                                    <input type="text" class="form-control" id="question-text-edit-${questionId}" placeholder="Escribe la pregunta aquí" value="${existingQuestion ? existingQuestion.text : ''}">
                                </div>
                                <div class="form-group">
                                    <label>Ponderación (puntos) <small class="text-muted">Máx: 5.0</small></label>
                                    <input type="number" class="form-control question-points-input-edit" id="question-points-edit-${questionId}" 
                                           min="0" max="5" step="0.1" value="${puntosDefault}" placeholder="Puntos de esta pregunta"
                                           onchange="actualizarPuntosDisponiblesQuizEdit()">
                                    <small class="form-text text-muted">Disponible: <span class="puntos-disponibles-edit">5.0</span> de 5.0 puntos</small>
                                </div>
                                <label>Opciones de Respuesta *</label>
                                <div class="form-group">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="radio" name="correct-answer-edit-${questionId}" value="A" ${!existingQuestion || existingQuestion.correctAnswer === 'A' ? 'checked' : ''}>
                                            </div>
                                            <span class="input-group-text"><strong>A</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="question-option-a-edit-${questionId}" placeholder="Opción A" value="${existingQuestion ? existingQuestion.options.A : ''}">
                                    </div>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="radio" name="correct-answer-edit-${questionId}" value="B" ${existingQuestion && existingQuestion.correctAnswer === 'B' ? 'checked' : ''}>
                                            </div>
                                            <span class="input-group-text"><strong>B</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="question-option-b-edit-${questionId}" placeholder="Opción B" value="${existingQuestion ? existingQuestion.options.B : ''}">
                                    </div>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="radio" name="correct-answer-edit-${questionId}" value="C" ${existingQuestion && existingQuestion.correctAnswer === 'C' ? 'checked' : ''}>
                                            </div>
                                            <span class="input-group-text"><strong>C</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="question-option-c-edit-${questionId}" placeholder="Opción C" value="${existingQuestion ? existingQuestion.options.C : ''}">
                                    </div>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="radio" name="correct-answer-edit-${questionId}" value="D" ${existingQuestion && existingQuestion.correctAnswer === 'D' ? 'checked' : ''}>
                                            </div>
                                            <span class="input-group-text"><strong>D</strong></span>
                                        </div>
                                        <input type="text" class="form-control" id="question-option-d-edit-${questionId}" placeholder="Opción D" value="${existingQuestion ? existingQuestion.options.D : ''}">
                                    </div>
                                </div>
                                <small class="text-muted"><i class="fas fa-info-circle"></i> Selecciona el radio button de la respuesta correcta</small>
                            </div>
                        </div>
                    `;
                    
                    container.insertAdjacentHTML('beforeend', questionHtml);
                    window.quizQuestionsEdit.push(questionId);
                    
                    // Actualizar puntos disponibles
                    setTimeout(() => actualizarPuntosDisponiblesQuizEdit(), 50);
                };
                
                // Función para eliminar pregunta en edición
                window.removeQuizQuestionEdit = function(questionId) {
                    document.getElementById(`question-edit-${questionId}`).remove();
                    window.quizQuestionsEdit = window.quizQuestionsEdit.filter(id => id !== questionId);
                    
                    // Renumerar preguntas
                    window.quizQuestionsEdit.forEach((id, index) => {
                        const questionCard = document.getElementById(`question-edit-${id}`);
                        if (questionCard) {
                            const header = questionCard.querySelector('h6');
                            if (header) {
                                header.innerHTML = `<i class="fas fa-question-circle text-primary"></i> Pregunta ${index + 1}`;
                            }
                        }
                    });
                    
                    // Actualizar puntos disponibles
                    actualizarPuntosDisponiblesQuizEdit();
                };
                
                // Cargar preguntas existentes
                activity.quizData.questions.forEach((question) => {
                    setTimeout(() => window.addQuizQuestionEdit(question), 100);
                });
            }
        },
        preConfirm: () => {
            const title = document.getElementById('activity-title').value;
            const description = document.getElementById('activity-description').value;
            const instructions = document.getElementById('activity-instructions').value;
            const openDate = document.getElementById('activity-open-date').value;
            const closeDate = document.getElementById('activity-close-date').value;
            const points = document.getElementById('activity-points').value;
            const attempts = document.getElementById('activity-attempts').value;
            const isRequired = document.getElementById('activity-required').checked;
            const allowLateSubmissions = document.getElementById('activity-late-submissions').checked;
            
            // Datos de calificación
            const materialId = document.getElementById('activity-material').value;
            const porcentajeMaterial = parseFloat(document.getElementById('activity-porcentaje').value) || 0;
            const notaMinimaAprobacion = parseFloat(document.getElementById('activity-nota-minima').value) || 3.0;

            if (!title.trim()) {
                Swal.showValidationMessage('El título es requerido');
                return false;
            }

            if (openDate && closeDate && new Date(closeDate) <= new Date(openDate)) {
                Swal.showValidationMessage('La fecha de cierre debe ser posterior a la fecha de apertura');
                return false;
            }
            
            // Validación de material
            if (!materialId) {
                Swal.showValidationMessage('Debes seleccionar un material al que pertenece la actividad');
                return false;
            }
            
            // Validación de porcentaje (relativo al material, 0-100%)
            const materialSelect = document.getElementById('activity-material');
            const selectedOption = materialSelect.options[materialSelect.selectedIndex];
            const maxPorcentajeMat = parseFloat(selectedOption.dataset.porcentajeDisponible) || 0;
            
            if (porcentajeMaterial < 0) {
                Swal.showValidationMessage('El porcentaje no puede ser negativo');
                return false;
            }
            
            if (porcentajeMaterial > 100) {
                Swal.showValidationMessage('El porcentaje no puede exceder 100% del material');
                return false;
            }
            
            if (porcentajeMaterial > maxPorcentajeMat) {
                Swal.showValidationMessage('El porcentaje excede el disponible del material (' + maxPorcentajeMat.toFixed(1) + '% de 100%)');
                return false;
            }
            
            // Validación de nota mínima
            if (notaMinimaAprobacion < 0 || notaMinimaAprobacion > 5) {
                Swal.showValidationMessage('La nota mínima debe estar entre 0.0 y 5.0');
                return false;
            }

            // Validación y captura de datos del quiz si es edición de quiz o evaluación
            let quizData = null;
            if ((activity.type === 'quiz' || activity.type === 'evaluacion') && window.quizQuestionsEdit) {
                const duration = document.getElementById('quiz-duration').value;
                
                if (window.quizQuestionsEdit.length < 4) {
                    Swal.showValidationMessage('Debes tener al menos 4 preguntas');
                    return false;
                }
                
                const questions = [];
                let totalQuestionPoints = 0;
                
                for (const questionId of window.quizQuestionsEdit) {
                    const questionText = document.getElementById(`question-text-edit-${questionId}`).value;
                    const questionPoints = parseFloat(document.getElementById(`question-points-edit-${questionId}`).value) || 0;
                    const optionA = document.getElementById(`question-option-a-edit-${questionId}`).value;
                    const optionB = document.getElementById(`question-option-b-edit-${questionId}`).value;
                    const optionC = document.getElementById(`question-option-c-edit-${questionId}`).value;
                    const optionD = document.getElementById(`question-option-d-edit-${questionId}`).value;
                    const correctAnswer = document.querySelector(`input[name="correct-answer-edit-${questionId}"]:checked`)?.value;
                    
                    if (!questionText.trim()) {
                        Swal.showValidationMessage('Todas las preguntas deben tener texto');
                        return false;
                    }
                    
                    if (!optionA.trim() || !optionB.trim() || !optionC.trim() || !optionD.trim()) {
                        Swal.showValidationMessage('Todas las opciones de respuesta son requeridas');
                        return false;
                    }
                    
                    // Validar que los puntos estén entre 0 y 5
                    if (questionPoints < 0 || questionPoints > 5) {
                        Swal.showValidationMessage('Los puntos por pregunta deben estar entre 0 y 5');
                        return false;
                    }
                    
                    totalQuestionPoints += questionPoints;
                    
                    questions.push({
                        id: questionId,
                        text: questionText,
                        points: questionPoints,
                        options: {
                            A: optionA,
                            B: optionB,
                            C: optionC,
                            D: optionD
                        },
                        correctAnswer: correctAnswer
                    });
                }
                
                // Validar que la suma total no exceda 5.0
                if (totalQuestionPoints > 5.0) {
                    Swal.showValidationMessage('La suma de puntos de todas las preguntas no puede exceder 5.0 (actual: ' + totalQuestionPoints.toFixed(1) + ')');
                    return false;
                }
                
                quizData = {
                    duration: parseInt(duration),
                    questions: questions,
                    totalPoints: totalQuestionPoints
                };
            }

            return {
                title: title,
                description: description,
                instructions: instructions,
                openDate: openDate,
                closeDate: closeDate,
                points: parseInt(points),
                attempts: parseInt(attempts),
                isRequired: isRequired,
                allowLateSubmissions: allowLateSubmissions,
                quizData: quizData,
                materialId: materialId ? parseInt(materialId) : null,
                porcentajeMaterial: porcentajeMaterial,
                notaMinimaAprobacion: notaMinimaAprobacion
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Actualizar la actividad existente
            activity.title = result.value.title;
            activity.description = result.value.description;
            activity.instructions = result.value.instructions;
            activity.openDate = result.value.openDate;
            activity.closeDate = result.value.closeDate;
            activity.points = result.value.points;
            activity.attempts = result.value.attempts;
            activity.isRequired = result.value.isRequired;
            activity.allowLateSubmissions = result.value.allowLateSubmissions;
            activity.materialId = result.value.materialId;
            activity.porcentajeMaterial = result.value.porcentajeMaterial;
            activity.notaMinimaAprobacion = result.value.notaMinimaAprobacion;
            
            // Actualizar datos del quiz si fueron modificados
            if (result.value.quizData) {
                activity.quizData = result.value.quizData;
            }
            
            renderActivitiesList();
            updateActivitiesStats();
            
            Swal.fire({
                icon: 'success',
                title: 'Actividad actualizada',
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}

function removeActivity(activityId) {
    Swal.fire({
        title: '¿Eliminar actividad?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            courseData.activities = courseData.activities.filter(a => a.id !== activityId);
            renderActivitiesList();
            updateActivitiesStats();
            
            Swal.fire({
                icon: 'success',
                title: 'Actividad eliminada',
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
}

// ==========================================
// PASO 5: REVISAR Y PUBLICAR
// ==========================================

function initializeStep5() {
    // Este paso se inicializa cuando se muestra
}

function updateCourseSummary() {
    const titulo = $('#titulo').val() || 'Sin título';
    const descripcion = $('#descripcion').val() || 'Sin descripción';
    const area = $('#id_area option:selected').text() || 'Sin área';
    const instructor = $('#instructor_id option:selected').text() || 'Sin instructor';

    const html = `
        <div class="row">
            <div class="col-md-6">
                <h5>${titulo}</h5>
                <p class="text-muted">${descripcion}</p>
                <p><strong>Área:</strong> ${area}</p>
                <p><strong>Instructor:</strong> ${instructor}</p>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h6>Contenido del Curso</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-folder text-primary"></i> ${courseData.materials.length} materiales</li>
                            <li><i class="fas fa-comments text-info"></i> ${courseData.forumPosts.length} posts del foro</li>
                            <li><i class="fas fa-tasks text-success"></i> ${courseData.activities.length} actividades</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    `;

    $('#course-summary').html(html);
}

function updateCompletionChecklist() {
    let completedItems = 1; // Información básica siempre está completa si llegamos aquí
    const totalItems = 4;

    // Verificar materiales
    if (courseData.materials.length > 0) {
        $('#check-materials').removeClass('fa-circle text-muted').addClass('fa-check-circle text-success');
        completedItems++;
    } else {
        $('#check-materials').removeClass('fa-check-circle text-success').addClass('fa-circle text-muted');
    }

    // Verificar foros
    if (courseData.forumPosts.length > 0) {
        $('#check-forum').removeClass('fa-circle text-muted').addClass('fa-check-circle text-success');
        completedItems++;
    } else {
        $('#check-forum').removeClass('fa-check-circle text-success').addClass('fa-circle text-muted');
    }

    // Verificar actividades
    if (courseData.activities.length > 0) {
        $('#check-activities').removeClass('fa-circle text-muted').addClass('fa-check-circle text-success');
        completedItems++;
    } else {
        $('#check-activities').removeClass('fa-check-circle text-success').addClass('fa-circle text-muted');
    }

    const percentage = Math.round((completedItems / totalItems) * 100);
    $('#completion-progress').css('width', percentage + '%');
    $('#completion-percentage').text(percentage);
}

// ==========================================
// FUNCIÓN PARA CREAR EL CURSO
// ==========================================

function createCourse() {
    // Mostrar confirmación
    Swal.fire({
        title: '¿Crear curso?',
        text: 'Se creará el curso con todo el contenido configurado',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, crear curso',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            submitCourseData();
        }
    });
}

function submitCourseData() {
    // Calcular tamaño total de archivos
    let totalSize = 0;
    const maxSize = 600 * 1024 * 1024; // 600 MB límite para cursos con buena información
    
    // Sumar tamaño de imagen de portada
    const imagenPortada = $('#imagen_portada')[0].files[0];
    if (imagenPortada) {
        totalSize += imagenPortada.size;
    }
    
    // Sumar tamaño de archivos de materiales
    courseData.materials.forEach((material) => {
        if (material.file) {
            totalSize += material.file.size;
        }
    });
    
    // Validar tamaño total
    if (totalSize > maxSize) {
        const sizeMB = (totalSize / (1024 * 1024)).toFixed(2);
        Swal.fire({
            icon: 'error',
            title: 'Archivos demasiado grandes',
            html: `El tamaño total de los archivos es de <strong>${sizeMB} MB</strong>.<br>
                   El límite máximo es de <strong>600 MB</strong>.<br><br>
                   <strong>Recomendaciones:</strong><br>
                   • Reduce el tamaño de los videos<br>
                   • Comprime las imágenes<br>
                   • Usa URLs de YouTube/Vimeo para videos grandes (ilimitado)<br>
                   • Sube archivos grandes a Google Drive, Dropbox o OneDrive y usa el enlace<br>
                   • Para videos largos, usa plataformas de streaming (YouTube, Vimeo)`,
            confirmButtonText: 'Entendido'
        });
        return;
    }
    
    // Mostrar loading con progreso
    Swal.fire({
        title: 'Creando curso...',
        html: `<div id="upload-progress">
                   <p>Por favor espera mientras se crea tu curso</p>
                   <small class="text-muted">Subiendo ${(totalSize / (1024 * 1024)).toFixed(2)} MB de archivos...</small>
                   <div class="progress mt-3" style="height: 20px;">
                       <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                   </div>
                   <small id="progress-text" class="text-muted mt-2">Preparando datos...</small>
               </div>`,
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Preparar datos del formulario
    const formData = new FormData();

    // Datos básicos del curso
    formData.append('titulo', $('#titulo').val());
    formData.append('descripcion', $('#descripcion').val());
    formData.append('id_area', $('#id_area').val());
    formData.append('instructor_id', $('#instructor_id').val());
    formData.append('fecha_inicio', $('#fecha_inicio').val());
    formData.append('fecha_fin', $('#fecha_fin').val());
    formData.append('max_estudiantes', $('#max_estudiantes').val());
    formData.append('duracion_horas', $('#duracion_horas').val());
    formData.append('objetivos', $('#objetivos').val());
    formData.append('requisitos', $('#requisitos').val());
    formData.append('estado', $('#estado').val());

    // Imagen de portada
    if (imagenPortada) {
        formData.append('imagen_portada', imagenPortada);
    }

    // Validar que el porcentaje total de materiales no exceda 100%
    const porcentajeTotalMateriales = courseData.materials.reduce((sum, mat) => sum + (parseFloat(mat.porcentajeCurso) || 0), 0);
    if (porcentajeTotalMateriales > 100) {
        Swal.fire({
            icon: 'error',
            title: 'Porcentaje de materiales excedido',
            html: `La suma de los porcentajes de los materiales es <strong>${porcentajeTotalMateriales.toFixed(1)}%</strong>.<br>El máximo permitido es <strong>100%</strong>.<br><br>Por favor, ajusta los porcentajes de los materiales antes de crear el curso.`,
            confirmButtonText: 'Entendido'
        });
        return;
    }

    // Limpiar datos de materiales antes de enviar (remover objetos File del JSON)
    const cleanMaterials = courseData.materials.map((mat, index) => ({
        id: mat.id,
        title: mat.title,
        description: mat.description,
        type: mat.type,
        url: mat.url,
        isPublic: mat.isPublic,
        order: mat.order,
        meetUrl: mat.meetUrl,
        meetStart: mat.meetStart,
        meetEnd: mat.meetEnd,
        prerequisiteId: mat.prerequisiteId,
        porcentajeCurso: mat.porcentajeCurso || 0,
        notaMinimaAprobacion: mat.notaMinimaAprobacion || 3.0,
        file: mat.file ? true : false, // Solo indicar si hay archivo
        fileIndex: mat.file ? index : null
    }));

    // Datos adicionales del wizard
    formData.append('materials_data', JSON.stringify(cleanMaterials));
    formData.append('forum_posts_data', JSON.stringify(courseData.forumPosts));
    formData.append('activities_data', JSON.stringify(courseData.activities));

    // Agregar archivos de materiales
    courseData.materials.forEach((material, index) => {
        if (material.file) {
            formData.append(`material_files[${index}]`, material.file);
        }
    });

    // Agregar CSRF token
    formData.append('_token', $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val());

    // Enviar datos con XMLHttpRequest para mostrar progreso
    const xhr = new XMLHttpRequest();
    
    xhr.upload.addEventListener('progress', function(e) {
        if (e.lengthComputable) {
            const percentComplete = Math.round((e.loaded / e.total) * 100);
            $('.progress-bar').css('width', percentComplete + '%');
            $('#progress-text').text(`Subiendo archivos: ${percentComplete}%`);
        }
    });
    
    xhr.addEventListener('load', function() {
        if (xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Curso creado exitosamente!',
                        text: 'Tu curso ha sido creado y está listo para usar',
                        showCancelButton: true,
                        confirmButtonText: 'Ir al Aula Virtual',
                        cancelButtonText: 'Ver Lista de Cursos'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `/capacitaciones/cursos/${response.curso_id}/classroom`;
                        } else {
                            window.location.href = '/capacitaciones/cursos';
                        }
                    });
                } else {
                    Swal.fire('Error', response.message || 'Error desconocido', 'error');
                }
            } catch (e) {
                Swal.fire('Error', 'Error al procesar la respuesta del servidor', 'error');
            }
        } else if (xhr.status === 413) {
            Swal.fire({
                icon: 'error',
                title: 'Contenido demasiado grande',
                html: `El servidor rechazó la petición porque los archivos son muy grandes.<br><br>
                       <strong>Soluciones Recomendadas:</strong><br>
                       • <strong>Videos:</strong> Usa YouTube, Vimeo o Google Drive (solo pega el enlace)<br>
                       • <strong>Documentos grandes:</strong> Usa Google Drive, Dropbox o OneDrive<br>
                       • <strong>Imágenes:</strong> Comprime antes de subir (usa TinyPNG.com)<br>
                       • <strong>Múltiples archivos:</strong> Crea una carpeta compartida en Drive<br><br>
                       <strong>Límite actual:</strong> 600 MB de archivos directos por curso<br>
                       <strong>Límite por archivo:</strong> 200 MB<br>
                       <strong>Con URLs:</strong> ¡Ilimitado! (YouTube, Drive, etc.)`,
                confirmButtonText: 'Entendido',
                width: '600px'
            });
        } else if (xhr.status === 422) {
            try {
                const response = JSON.parse(xhr.responseText);
                const errors = response.errors;
                let errorMessage = 'Errores de validación:\n';
                Object.keys(errors).forEach(field => {
                    errorMessage += `• ${errors[field][0]}\n`;
                });
                Swal.fire('Error de Validación', errorMessage, 'error');
            } catch (e) {
                Swal.fire('Error de Validación', 'Error en los datos enviados', 'error');
            }
        } else if (xhr.status === 419) {
            Swal.fire({
                icon: 'error',
                title: 'Sesión Expirada',
                text: 'Tu sesión ha expirado. Por favor, recarga la página e intenta nuevamente.',
                confirmButtonText: 'Recargar',
                allowOutsideClick: false
            }).then(() => {
                window.location.reload();
            });
        } else if (xhr.status === 500) {
            let errorMsg = 'Ocurrió un error en el servidor.';
            try {
                const response = JSON.parse(xhr.responseText);
                if (response.message) {
                    errorMsg = response.message;
                }
            } catch (e) {}
            
            Swal.fire({
                icon: 'error',
                title: 'Error del Servidor',
                html: `${errorMsg}<br><br>
                       <strong>Posibles soluciones:</strong><br>
                       • Reduce la cantidad de contenido del curso<br>
                       • Usa URLs en lugar de subir archivos grandes<br>
                       • Intenta crear el curso con menos materiales y agregar más después<br>
                       • Contacta al administrador si el problema persiste`,
                confirmButtonText: 'Entendido',
                width: '500px'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al crear el curso. Código: ' + xhr.status,
                confirmButtonText: 'Entendido'
            });
        }
    });
    
    xhr.addEventListener('error', function() {
        Swal.fire({
            icon: 'error',
            title: 'Error de Conexión',
            text: 'No se pudo conectar con el servidor. Verifica tu conexión a internet.',
            confirmButtonText: 'Entendido'
        });
    });
    
    xhr.addEventListener('timeout', function() {
        Swal.fire({
            icon: 'error',
            title: 'Tiempo Agotado',
            html: `La operación tardó demasiado tiempo.<br><br>
                   <strong>Recomendaciones:</strong><br>
                   • Reduce el tamaño de los archivos<br>
                   • Usa URLs de YouTube/Drive para videos<br>
                   • Intenta con menos contenido`,
            confirmButtonText: 'Entendido'
        });
    });
    
    xhr.open('POST', '/capacitaciones/cursos', true);
    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val());
    xhr.timeout = 600000; // 10 minutos de timeout
    xhr.send(formData);
}
