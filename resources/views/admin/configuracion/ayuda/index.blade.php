@extends('adminlte::page')

@section('title', 'Ayuda')

@section('content_header')
    <h1 class="m-0 text-dark">Ayuda y Soporte</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-question-circle mr-2"></i>Preguntas Frecuentes y Documentación</h3>
            </div>
            <div class="card-body">
                <p>Bienvenido a la sección de Ayuda. Aquí encontrarás información sobre el uso del sistema.</p>
                
                <h5>1. ¿Cómo gestionar usuarios?</h5>
                <p>En el menú "Gestión de Usuarios", puedes crear, editar y asignar roles a los usuarios del sistema.</p>

                <h5>2. ¿Cómo ver los reportes?</h5>
                <p>Existen diversas consultas disponibles en la sección "Consultas" -> "Reportes". Asegúrate de tener los permisos asignados si eres operador.</p>

                <!-- Puedes agregar más secciones dinámicas aquí -->
                <div class="callout callout-info mt-4">
                    <h5>¿Necesitas más soporte?</h5>
                    <p>Por favor contacta al administrador del sistema para asistencia técnica adicional.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@stop