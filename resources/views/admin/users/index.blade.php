@extends('admin.layouts.master')

@section('title', 'Gestión de Usuarios')

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Listado de usuarios del sistema</h3>
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Nuevo Usuario
                </a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

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
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->apellido1 }}</td>
                                <td>{{ $user->apellido2 }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->tipo_documento && $user->numero_documento)
                                        <small class="text-muted">{{ $user->tipo_documento }}:</small><br>
                                        <strong>{{ $user->numero_documento }}</strong>
                                    @else
                                        <span class="text-muted">No especificado</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->servicioArea)
                                        <span class="badge badge-primary">{{ $user->servicioArea->nombre }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->vinculacionContrato)
                                        <span class="badge badge-info">{{ $user->vinculacionContrato->nombre }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->sede)
                                        <span class="badge badge-success">{{ $user->sede->nombre }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->role)
                                        <span class="badge badge-{{ $user->role === 'Super Admin' ? 'danger' : ($user->role === 'Administrador' ? 'warning' : ($user->role === 'Docente' ? 'success' : ($user->role === 'Estudiante' ? 'info' : 'secondary'))) }}">
                                            {{ $user->role }}
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">Registrado</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete-btn" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('extra_css')
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
@stop

@section('js')
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
                            // Aquí puedes agregar la funcionalidad para importar archivos
                            alert('Función de importación de archivos');
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
        });
    </script>
@stop 