@extends('emails.layout')

@section('content')
    <h2>¡Bienvenido a nuestra plataforma!</h2>
    
    <p>Hola <strong>{{ $user->name }}</strong>,</p>
    
    <p>Gracias por registrarte en la plataforma de capacitación del Hospital Universitario del Valle. Estamos emocionados de tenerte con nosotros.</p>
    
    <div class="info-box">
        <p><strong>⏰ Importante:</strong></p>
        <p>Este enlace de verificación expirará en <strong>24 horas</strong>.</p>
        <p>Si no solicitaste esta cuenta, puedes ignorar este correo de forma segura.</p>
    </div>
    
    <div class="divider"></div>
    
    <p><strong>¿Qué puedes hacer en la plataforma?</strong></p>
    <ul style="color: #555555; font-size: 15px; line-height: 1.8; margin-left: 20px;">
        <li>Acceder a cursos de capacitación profesional</li>
        <li>Obtener certificados de finalización</li>
        <li>Interactuar con instructores y compañeros</li>
        <li>Realizar evaluaciones y seguimiento de tu progreso</li>
    </ul>
    
    <div class="divider"></div>

    <div style="font-size: 13px; color: #555; margin-bottom: 25px; text-align: justify; background-color: #f6f7f8; padding: 15px; border-radius: 8px; border: 1px solid #e0e0e0;">
        <p style="margin-bottom: 10px; color: #2c4370;"><strong>Política de Tratamiento de Datos Personales</strong></p>
        <p style="margin-bottom: 0; font-size: 13px; line-height: 1.6;">En cumplimiento de la Ley 1581 de 2012 y normatividad vigente, le informamos que sus datos personales serán tratados de acuerdo con la Política de Tratamiento de Datos Personales del <strong>Hospital Universitario del Valle</strong>. La información será utilizada exclusivamente con fines académicos, de registro, institucionales y comunicacionales relativos a la plataforma de capacitación. Al pulsar en el botón de verificación a continuación, usted autoriza de manera voluntaria y expresa el tratamiento de sus datos personales para dichos fines.</p>
    </div>

    <p style="text-align: center; margin-bottom: 15px;">Para confirmar tu registro, activar tu cuenta y aceptar las políticas mencionadas, por favor haz clic en el siguiente botón:</p>
    
    <div style="text-align: center;">
        <a href="{{ $verificationUrl }}" class="btn-primary">Verificar mi cuenta</a>
    </div>
    
    <div class="divider"></div>
    
    <p>Si el botón de verificación no funciona, copia y pega el siguiente enlace en tu navegador:</p>
    
    <div class="alternative-link">
        {{ $verificationUrl }}
    </div>
    
    <p style="margin-top: 30px;">¡Esperamos verte pronto en la plataforma!</p>
    
    <p>Saludos cordiales,<br>
    <strong>Equipo de Coordinación Académica</strong><br>
    Hospital Universitario del Valle</p>
@endsection
