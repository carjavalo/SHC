<?php $__env->startSection('title', 'Detalle de Usuario'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Detalle de Usuario</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">Información de <?php echo e($user->name); ?> <?php echo e($user->apellido1); ?> <?php echo e($user->apellido2); ?></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="width: 25%" class="bg-light">ID</th>
                                            <td><?php echo e($user->id); ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Nombre</th>
                                            <td><?php echo e($user->name); ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Primer Apellido</th>
                                            <td><?php echo e($user->apellido1); ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Segundo Apellido</th>
                                            <td><?php echo e($user->apellido2); ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Correo Electrónico</th>
                                            <td><?php echo e($user->email); ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Verificado</th>
                                            <td>
                                                <?php if($user->email_verified_at): ?>
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-check-circle"></i> Verificado el 
                                                        <?php echo e(\Carbon\Carbon::parse($user->email_verified_at)->format('d/m/Y H:i')); ?>

                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-warning">
                                                        <i class="fas fa-clock"></i> Pendiente de verificación
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Fecha de Registro</th>
                                            <td><?php echo e($user->created_at->format('d/m/Y H:i:s')); ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Última Actualización</th>
                                            <td><?php echo e($user->updated_at->format('d/m/Y H:i:s')); ?></td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Servicio / Área</th>
                                            <td>
                                                <?php if($user->servicioArea): ?>
                                                    <span class="badge badge-primary"><?php echo e($user->servicioArea->nombre); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">No especificado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Tipo de Vinculación/Contrato</th>
                                            <td>
                                                <?php if($user->vinculacionContrato): ?>
                                                    <span class="badge badge-info"><?php echo e($user->vinculacionContrato->nombre); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">No especificado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Sede</th>
                                            <td>
                                                <?php if($user->sede): ?>
                                                    <span class="badge badge-success"><?php echo e($user->sede->nombre); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">No especificado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="user-profile">
                                <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name . ' ' . $user->apellido1)); ?>&size=200&background=random&color=fff" 
                                     alt="<?php echo e($user->name); ?>" class="img-circle img-fluid border p-2 mb-3">
                                <h3><?php echo e($user->name); ?> <?php echo e($user->apellido1); ?> <?php echo e($user->apellido2); ?></h3>
                                <p class="text-muted"><?php echo e($user->email); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="btn-group" role="group">
                                <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <form action="<?php echo e(route('users.destroy', $user->id)); ?>" method="POST" class="d-inline delete-form">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger delete-btn">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('extra_css'); ?>
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .user-profile img {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }
        .user-profile img:hover {
            transform: scale(1.05);
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        $(document).ready(function() {
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
        });
    </script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SHC\resources\views/admin/users/show.blade.php ENDPATH**/ ?>