

<?php $__env->startSection('content'); ?>
    <h2>Te han asignado un nuevo curso</h2>
    
    <p>Hola <strong><?php echo e($user->name); ?></strong>,</p>
    
    <p>Nos complace informarte que has sido asignado al siguiente curso de capacitación:</p>
    
    <div class="info-box">
        <p><strong>📚 Curso:</strong> <?php echo e($curso->nombre); ?></p>
        <?php if($curso->instructor): ?>
            <p><strong>👨‍🏫 Instructor:</strong> <?php echo e($curso->instructor->name); ?></p>
        <?php endif; ?>
        <?php if($curso->fecha_inicio): ?>
            <p><strong>📅 Fecha de inicio:</strong> <?php echo e(\Carbon\Carbon::parse($curso->fecha_inicio)->format('d/m/Y')); ?></p>
        <?php endif; ?>
        <?php if($curso->fecha_fin): ?>
            <p><strong>📅 Fecha de finalización:</strong> <?php echo e(\Carbon\Carbon::parse($curso->fecha_fin)->format('d/m/Y')); ?></p>
        <?php endif; ?>
        <?php if($curso->duracion_horas): ?>
            <p><strong>⏱️ Duración:</strong> <?php echo e($curso->duracion_horas); ?> horas</p>
        <?php endif; ?>
        <?php if($curso->modalidad): ?>
            <p><strong>📍 Modalidad:</strong> <?php echo e(ucfirst($curso->modalidad)); ?></p>
        <?php endif; ?>
    </div>
    
    <p>Para confirmar tu participación e inscribirte en el curso, haz clic en el siguiente botón:</p>
    
    <div style="text-align: center;">
        <a href="<?php echo e($inscripcionUrl); ?>" class="btn-primary">Inscribirme Ahora</a>
    </div>
    
    <?php if($curso->descripcion): ?>
    <div class="divider"></div>
    
    <p><strong>📖 Descripción del curso:</strong></p>
    <p style="color: #666666; font-size: 14px; line-height: 1.7; background-color: #f9f9f9; padding: 15px; border-radius: 5px;">
        <?php echo e($curso->descripcion); ?>

    </p>
    <?php endif; ?>
    
    <div class="divider"></div>
    
    <p><strong>🎯 Beneficios de este curso:</strong></p>
    <ul style="color: #555555; font-size: 15px; line-height: 1.8; margin-left: 20px;">
        <li>Desarrollo profesional continuo</li>
        <li>Certificado de finalización oficial</li>
        <li>Actualización de conocimientos en tu área</li>
        <li>Networking con otros profesionales</li>
        <li>Acceso a material didáctico de calidad</li>
    </ul>
    
    <div class="divider"></div>
    
    <p><strong>📝 Requisitos para completar el curso:</strong></p>
    <ul style="color: #555555; font-size: 15px; line-height: 1.8; margin-left: 20px;">
        <li>Asistencia mínima del 80% (si aplica)</li>
        <li>Completar todas las actividades asignadas</li>
        <li>Aprobar las evaluaciones con nota mínima</li>
        <li>Participar activamente en las sesiones</li>
    </ul>
    
    <div class="info-box" style="background-color: #fff3cd; border-left-color: #ffc107;">
        <p><strong>⏰ Fecha límite de inscripción:</strong></p>
        <p>Por favor, confirma tu inscripción antes del <strong><?php echo e($fechaLimite ?? 'inicio del curso'); ?></strong>.</p>
    </div>
    
    <p style="margin-top: 30px;">Si tienes alguna pregunta sobre el curso, no dudes en contactarnos.</p>
    
    <p>¡Esperamos contar con tu participación!</p>
    
    <p>Saludos cordiales,<br>
    <strong>Equipo de Coordinación Académica</strong><br>
    Hospital Universitario del Valle</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('emails.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\SHC\resources\views/emails/asignacion-curso.blade.php ENDPATH**/ ?>