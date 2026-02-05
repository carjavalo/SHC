@extends('emails.layout')

@section('content')
    <h2>Recuperación de Contraseña</h2>
    
    <p>Hola <strong>{{ $user->name }}</strong>,</p>
    
    <p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta en la plataforma del Hospital Universitario del Valle.</p>
    
    <p>Para crear una nueva contraseña, haz clic en el siguiente botón:</p>
    
    <div style="text-align: center;">
        <a href="{{ $resetUrl }}" class="btn-primary">Restablecer Contraseña</a>
    </div>
    
    <div class="info-box">
        <p><strong>🔒 Información de Seguridad:</strong></p>
        <p>Este enlace expirará en <strong>60 minutos</strong> por razones de seguridad.</p>
        <p>Si no solicitaste este cambio, tu cuenta está segura y puedes ignorar este correo.</p>
    </div>
    
    <div class="divider"></div>
    
    <p><strong>Consejos para una contraseña segura:</strong></p>
    <ul style="color: #555555; font-size: 15px; line-height: 1.8; margin-left: 20px;">
        <li>Usa al menos 8 caracteres</li>
        <li>Combina letras mayúsculas y minúsculas</li>
        <li>Incluye números y símbolos especiales</li>
        <li>No uses información personal obvia</li>
        <li>No reutilices contraseñas de otras cuentas</li>
    </ul>
    
    <div class="divider"></div>
    
    <p>Si el botón no funciona, copia y pega el siguiente enlace en tu navegador:</p>
    
    <div class="alternative-link">
        {{ $resetUrl }}
    </div>
    
    <p style="margin-top: 30px; color: #d9534f;">
        <strong>⚠️ Atención:</strong> Si no solicitaste este cambio de contraseña, te recomendamos que cambies tu contraseña inmediatamente y contactes con nuestro equipo de soporte.
    </p>
    
    <p>Saludos cordiales,<br>
    <strong>Equipo de Coordinación Académica</strong><br>
    Hospital Universitario del Valle</p>
@endsection
