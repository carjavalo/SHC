@extends('emails.layout')

@section('content')
    <h2>Nuevo estudiante asignado a tu curso</h2>
    
    <p>Hola <strong>{{ $instructor->name }}</strong>,</p>
    
    <p>Te informamos que se ha asignado un nuevo estudiante al curso que impartes:</p>
    
    <div class="info-box">
        <p><strong>📚 Curso:</strong> {{ $curso->titulo }}</p>
        @if($curso->nombre)
            <p><strong>Nombre:</strong> {{ $curso->nombre }}</p>
        @endif
        @if($curso->modalidad)
            <p><strong>📍 Modalidad:</strong> {{ ucfirst($curso->modalidad) }}</p>
        @endif
    </div>
    
    <div class="divider"></div>
    
    <p><strong>👨‍🎓 Estudiante asignado:</strong></p>
    
    <div class="info-box" style="background-color: #e8f5e9; border-left-color: #4caf50;">
        <p><strong>Nombre:</strong> {{ $estudiante->name }} {{ $estudiante->apellido1 }} {{ $estudiante->apellido2 ?? '' }}</p>
        <p><strong>Email:</strong> {{ $estudiante->email }}</p>
        @if($estudiante->numero_documento)
            <p><strong>Documento:</strong> {{ $estudiante->tipo_documento }}: {{ $estudiante->numero_documento }}</p>
        @endif
        @if($estudiante->servicio_area)
            <p><strong>Área:</strong> {{ $estudiante->servicio_area->descripcion }}</p>
        @endif
    </div>
    
    <div class="divider"></div>
    
    <p><strong>📝 Próximos pasos:</strong></p>
    <ul style="color: #555555; font-size: 15px; line-height: 1.8; margin-left: 20px;">
        <li>El estudiante recibirá una notificación para inscribirse al curso</li>
        <li>Una vez inscrito, podrás ver su progreso en el aula virtual</li>
        <li>Puedes gestionar el contenido y actividades del curso desde el panel de administración</li>
        <li>Recibirás notificaciones cuando el estudiante complete actividades</li>
    </ul>
    
    <div class="info-box" style="background-color: #fff3cd; border-left-color: #ffc107;">
        <p><strong>💡 Recordatorio:</strong></p>
        <p style="font-size: 14px;">Asegúrate de que el contenido del curso esté actualizado y las actividades estén configuradas correctamente antes de que el estudiante comience.</p>
    </div>
    
    <div class="divider"></div>
    
    <p><strong>🎯 Información del curso:</strong></p>
    
    @if($curso->descripcion)
    <div style="background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin: 15px 0;">
        <p style="color: #666666; font-size: 14px; line-height: 1.7; margin: 0;">
            {{ $curso->descripcion }}
        </p>
    </div>
    @endif
    
    <div class="info-box">
        @if($curso->duracion_horas)
            <p><strong>⏱️ Duración:</strong> {{ $curso->duracion_horas }} horas</p>
        @endif
        @if($curso->fecha_inicio)
            <p><strong>📅 Fecha de inicio:</strong> {{ \Carbon\Carbon::parse($curso->fecha_inicio)->format('d/m/Y') }}</p>
        @endif
        @if($curso->fecha_fin)
            <p><strong>📅 Fecha de finalización:</strong> {{ \Carbon\Carbon::parse($curso->fecha_fin)->format('d/m/Y') }}</p>
        @endif
        @if($curso->max_estudiantes)
            <p><strong>👥 Capacidad máxima:</strong> {{ $curso->max_estudiantes }} estudiantes</p>
        @endif
    </div>
    
    <div class="divider"></div>
    
    <p style="margin-top: 30px;">Si tienes alguna pregunta sobre el curso o necesitas soporte, no dudes en contactarnos.</p>
    
    <p>Saludos cordiales,<br>
    <strong>Equipo de Coordinación Académica</strong><br>
    Hospital Universitario del Valle</p>
@endsection
