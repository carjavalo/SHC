<?php $__env->startSection('title', 'Cursos Disponibles'); ?>

<?php $__env->startSection('content_header'); ?>
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-graduation-cap"></i> Cursos Disponibles</h1>
                <p class="text-muted mb-0">Cursos asignados para tu formación académica</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Cursos Disponibles</li>
                </ol>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-list"></i> Lista de Cursos Asignados
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="cursosTable" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Área</th>
                                        <th>Categoría</th>
                                        <th>Instructor</th>
                                        <th>Progreso</th>
                                        <th>Estado</th>
                                        <th>Fecha Inscripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para ver detalles del curso -->
    <div class="modal fade" id="viewCursoModal" tabindex="-1" role="dialog" aria-labelledby="viewCursoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="viewCursoModalLabel">
                        <i class="fas fa-eye"></i> Detalles del Curso
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Título:</strong>
                            <p id="view_titulo"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Área:</strong>
                            <p id="view_area"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Instructor:</strong>
                            <p id="view_instructor"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Estado:</strong>
                            <p id="view_estado"></p>
                        </div>
                        <div class="col-md-12">
                            <strong>Descripción:</strong>
                            <p id="view_descripcion"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Fecha Inicio:</strong>
                            <p id="view_fecha_inicio"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Fecha Fin:</strong>
                            <p id="view_fecha_fin"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Duración:</strong>
                            <p id="view_duracion"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Tu Progreso:</strong>
                            <div class="progress">
                                <div id="view_progreso_bar" class="progress-bar bg-success" role="progressbar" style="width: 0%">
                                    <span id="view_progreso_text">0%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cerrar
                    </button>
                    <button type="button" class="btn btn-primary" id="accederCursoBtn">
                        <i class="fas fa-play"></i> Acceder al Curso
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra_css'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
    <style>
        .progress {
            height: 25px;
        }
        .progress-bar {
            line-height: 25px;
        }
        .badge-estado {
            font-size: 0.9em;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra_js'); ?>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            $('#cursosTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '<?php echo e(route("academico.cursos.disponibles.data")); ?>',
                columns: [
                    { data: 'titulo', name: 'titulo' },
                    { data: 'area_descripcion', name: 'area.descripcion' },
                    { data: 'area_categoria', name: 'area.categoria.descripcion' },
                    { data: 'instructor_nombre', name: 'instructor.name' },
                    { 
                        data: 'progreso', 
                        name: 'progreso',
                        render: function(data, type, row) {
                            return '<div class="progress"><div class="progress-bar bg-success" role="progressbar" style="width: ' + data + '%">' + data + '%</div></div>';
                        }
                    },
                    { 
                        data: 'estado_inscripcion', 
                        name: 'estado_inscripcion',
                        render: function(data, type, row) {
                            if (data === 'inscrito') {
                                return '<span class="badge badge-success badge-estado">Inscrito</span>';
                            } else if (data === 'no_inscrito') {
                                return '<span class="badge badge-warning badge-estado">Pendiente</span>';
                            } else if (data === 'acceso_directo') {
                                return '<span class="badge badge-info badge-estado">Acceso Directo</span>';
                            } else {
                                return '<span class="badge badge-secondary badge-estado">Sin Acceso</span>';
                            }
                        }
                    },
                    { data: 'fecha_inscripcion', name: 'fecha_inscripcion' },
                    { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                order: [[0, 'asc']]
            });
        });

        // Función para ver detalles del curso
        function verCurso(id) {
            // Aquí harías una petición AJAX para obtener los detalles del curso
            // Por simplicidad, usaremos datos del DataTable
            $('#viewCursoModal').modal('show');
        }

        // Función para acceder al aula virtual (validar inscripción primero)
        function aulaVirtual(id) {
            window.location.href = '<?php echo e(route("academico.curso.aula-virtual", ":id")); ?>'.replace(':id', id);
        }

        // Función para acceder al curso
        function accederCurso(id) {
            window.location.href = '<?php echo e(route("academico.curso.ver", ":id")); ?>'.replace(':id', id);
        }

        // Función para inscribirse a un curso
        function inscribirseCurso(id) {
            Swal.fire({
                title: '¿Inscribirse al curso?',
                text: "Podrás acceder a todo el material del curso",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, inscribirme',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo e(route("academico.curso.inscribirse", ":id")); ?>'.replace(':id', id),
                        type: 'POST',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Inscrito!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(() => {
                                    // Recargar la tabla
                                    $('#cursosTable').DataTable().ajax.reload();
                                });
                            } else {
                                Swal.fire('Error', response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            const message = xhr.responseJSON?.message || 'Error al inscribirse al curso';
                            Swal.fire('Error', message, 'error');
                        }
                    });
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SHC\resources\views/academico/cursos-disponibles/index.blade.php ENDPATH**/ ?>