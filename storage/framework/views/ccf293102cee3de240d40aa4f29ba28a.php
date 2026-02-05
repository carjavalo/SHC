<?php $__env->startSection('title', 'Gestión de Usuarios'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Usuarios</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Listado de usuarios del sistema</h3>
                <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Nuevo Usuario
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table id="users-table" class="table table-striped table-hover table-bordered responsive nowrap" width="100%">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Primer Apellido</th>
                            <th>Segundo Apellido</th>
                            <th>Email</th>
                            <th>Documento</th>
                            <th>Servicio/Área</th>
                            <th>Vinculación</th>
                            <th>Sede</th>
                            <th>Rol</th>
                            <th>Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($user->id); ?></td>
                                <td><?php echo e($user->name); ?></td>
                                <td><?php echo e($user->apellido1); ?></td>
                                <td><?php echo e($user->apellido2); ?></td>
                                <td><?php echo e($user->email); ?></td>
                                <td>
                                    <?php if($user->tipo_documento && $user->numero_documento): ?>
                                        <small class="text-muted"><?php echo e($user->tipo_documento); ?>:</small><br>
                                        <strong><?php echo e($user->numero_documento); ?></strong>
                                    <?php else: ?>
                                        <span class="text-muted">No especificado</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($user->servicioArea): ?>
                                        <span class="badge badge-primary"><?php echo e($user->servicioArea->nombre); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($user->vinculacionContrato): ?>
                                        <span class="badge badge-info"><?php echo e($user->vinculacionContrato->nombre); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($user->sede): ?>
                                        <span class="badge badge-success"><?php echo e($user->sede->nombre); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($user->role): ?>
                                        <span class="badge badge-<?php echo e($user->role === 'Super Admin' ? 'danger' : ($user->role === 'Administrador' ? 'warning' : ($user->role === 'Docente' ? 'success' : ($user->role === 'Estudiante' ? 'info' : 'secondary')))); ?>">
                                            <?php echo e($user->role); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Registrado</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($user->created_at->format('d/m/Y H:i')); ?></td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('users.show', $user->id)); ?>" class="btn btn-info btn-sm" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="btn btn-warning btn-sm" title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="<?php echo e(route('users.destroy', $user->id)); ?>" method="POST" class="d-inline delete-form">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm delete-btn" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de Importación de Usuarios -->
    <div class="modal fade" id="importarUsuariosModal" tabindex="-1" role="dialog" aria-labelledby="importarUsuariosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="importarUsuariosModalLabel">
                        <i class="fas fa-file-import"></i> Importar Usuarios desde Excel
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formImportarUsuarios" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Formato del archivo Excel:</h6>
                            <p class="mb-2">El archivo debe tener los datos organizados de la siguiente manera:</p>
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Columna</th>
                                        <th>Campo</th>
                                        <th>Requerido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td><strong>A</strong></td><td>Nombre</td><td><span class="badge badge-danger">Sí</span></td></tr>
                                    <tr><td><strong>B</strong></td><td>Primer Apellido</td><td><span class="badge badge-secondary">No</span></td></tr>
                                    <tr><td><strong>C</strong></td><td>Segundo Apellido</td><td><span class="badge badge-secondary">No</span></td></tr>
                                    <tr><td><strong>D</strong></td><td>Email</td><td><span class="badge badge-secondary">No</span></td></tr>
                                    <tr><td><strong>E</strong></td><td>Teléfono</td><td><span class="badge badge-secondary">No</span></td></tr>
                                    <tr><td><strong>F</strong></td><td>Tipo de Documento</td><td><span class="badge badge-secondary">No</span></td></tr>
                                    <tr><td><strong>G</strong></td><td>Número de Documento</td><td><span class="badge badge-danger">Sí</span></td></tr>
                                    <tr><td><strong>H</strong></td><td>Rol (ignorado)</td><td><span class="badge badge-secondary">No</span></td></tr>
                                </tbody>
                            </table>
                            <small class="text-muted">
                                <i class="fas fa-exclamation-triangle text-warning"></i> 
                                <strong>Nota:</strong> La fila 1 debe ser el encabezado. Los datos inician desde la fila 2.<br>
                                <i class="fas fa-user-graduate text-info"></i> 
                                Todos los usuarios se crearán con rol <strong>"Estudiante"</strong>.<br>
                                <i class="fas fa-key text-warning"></i> 
                                La contraseña será el número de documento.<br>
                                <i class="fas fa-graduation-cap text-success"></i> 
                                Se inscribirán automáticamente al curso <strong>"Inducción Institucional (General)"</strong>.
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="archivo_excel"><i class="fas fa-file-excel text-success"></i> Seleccionar archivo Excel:</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="archivo_excel" name="archivo_excel" accept=".xlsx,.xls" required>
                                <label class="custom-file-label" for="archivo_excel">Seleccionar archivo...</label>
                            </div>
                            <small class="form-text text-muted">Formatos permitidos: .xlsx, .xls (Máximo 10MB)</small>
                        </div>

                        <div id="importProgress" class="d-none">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%"></div>
                            </div>
                            <p class="text-center mt-2"><i class="fas fa-spinner fa-spin"></i> Procesando archivo, por favor espere...</p>
                        </div>

                        <div id="importResult" class="d-none"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Cerrar
                        </button>
                        <button type="submit" class="btn btn-success" id="btnImportar">
                            <i class="fas fa-upload"></i> Importar Usuarios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra_css'); ?>
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        /* Evitar que los botones de DataTables se envuelvan a la siguiente línea */
        .dt-buttons {
            white-space: nowrap;
        }
        .dt-buttons .btn {
            margin-right: 6px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function() {
            $('#users-table').DataTable({
                responsive: true,
                autoWidth: false,
                dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-3"p><"col-sm-12 col-md-3"f>>rt<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"i>>',
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> Copiar',
                        className: 'btn btn-secondary',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-success',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Imprimir',
                        className: 'btn btn-info',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fas fa-columns"></i> Columnas',
                        className: 'btn btn-primary'
                    },
                    {
                        text: '<i class="fas fa-file-import"></i> Importar archivo',
                        className: 'btn btn-success',
                        action: function (e, dt, node, config) {
                            // Limpiar modal antes de abrir
                            $('#archivo_excel').val('');
                            $('.custom-file-label[for="archivo_excel"]').text('Seleccionar archivo...');
                            $('#importProgress').addClass('d-none');
                            $('#importResult').addClass('d-none').html('');
                            $('#btnImportar').prop('disabled', false);
                            $('#importarUsuariosModal').modal('show');
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-export"></i> Exportar archivo',
                        className: 'btn btn-success',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                        }
                    }
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                stateSave: true,
                ordering: true,
                fixedHeader: true,
                scrollCollapse: true,
                columnDefs: [
                    { targets: 0, visible: false }, // Ocultar columna ID
                    { responsivePriority: 1, targets: 1 }, // Nombre es prioridad 1
                    { responsivePriority: 2, targets: 2 }, // Primer Apellido es prioridad 2
                    { responsivePriority: 3, targets: 4 }, // Email es prioridad 3
                    { responsivePriority: 4, targets: 5 }, // Documento es prioridad 4
                    { responsivePriority: 5, targets: 9 }, // Rol es prioridad 5
                    { responsivePriority: 6, targets: 11 }, // Acciones es prioridad 6
                    { width: '120px', targets: 11 } // Ancho para columna Acciones
                ]
            });

            // Confirmación para eliminar
            $('.delete-form').submit(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });

            // Ajustar tabla cuando cambia el tamaño de la ventana
            $(window).on('resize', function() {
                $('#users-table').DataTable().columns.adjust().responsive.recalc();
            });

            // Mostrar nombre del archivo seleccionado
            $('#archivo_excel').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName || 'Seleccionar archivo...');
            });

            // Envío del formulario de importación
            $('#formImportarUsuarios').on('submit', function(e) {
                e.preventDefault();
                
                var formData = new FormData(this);
                
                // Mostrar progreso
                $('#importProgress').removeClass('d-none');
                $('#importResult').addClass('d-none').html('');
                $('#btnImportar').prop('disabled', true);
                
                $.ajax({
                    url: '<?php echo e(route("users.import")); ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#importProgress').addClass('d-none');
                        
                        var resultHtml = '<div class="alert alert-' + (response.success ? 'success' : 'danger') + '">';
                        resultHtml += '<h6><i class="fas fa-' + (response.success ? 'check-circle' : 'times-circle') + '"></i> ' + response.message + '</h6>';
                        
                        if (response.detalles) {
                            resultHtml += '<hr>';
                            resultHtml += '<p class="mb-1"><strong>Usuarios creados:</strong> ' + response.detalles.usuarios_creados + '</p>';
                            resultHtml += '<p class="mb-1"><strong>Usuarios omitidos (ya existían):</strong> ' + response.detalles.usuarios_omitidos + '</p>';
                            resultHtml += '<p class="mb-1"><strong>Correos enviados:</strong> ' + response.detalles.correos_enviados + '</p>';
                            
                            if (response.detalles.errores && response.detalles.errores.length > 0) {
                                resultHtml += '<hr><h6 class="text-warning"><i class="fas fa-exclamation-triangle"></i> Advertencias:</h6>';
                                resultHtml += '<ul class="mb-0">';
                                response.detalles.errores.forEach(function(error) {
                                    resultHtml += '<li><small>' + error + '</small></li>';
                                });
                                resultHtml += '</ul>';
                            }
                        }
                        resultHtml += '</div>';
                        
                        $('#importResult').html(resultHtml).removeClass('d-none');
                        
                        if (response.success && response.detalles && response.detalles.usuarios_creados > 0) {
                            // Recargar la tabla después de 2 segundos
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                        }
                        
                        $('#btnImportar').prop('disabled', false);
                    },
                    error: function(xhr) {
                        $('#importProgress').addClass('d-none');
                        var errorMsg = 'Error al procesar el archivo.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            for (var key in errors) {
                                errorMsg += '<br>' + errors[key].join('<br>');
                            }
                        }
                        $('#importResult').html('<div class="alert alert-danger"><i class="fas fa-times-circle"></i> ' + errorMsg + '</div>').removeClass('d-none');
                        $('#btnImportar').prop('disabled', false);
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SHC\resources\views/admin/users/index.blade.php ENDPATH**/ ?>