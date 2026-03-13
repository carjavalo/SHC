<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado - {{ $curso->titulo }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @page { size: landscape; margin: 0; }
        body { 
            margin: 0; 
            font-family: 'Inter', sans-serif; 
            background: #525659;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .cert-container {
            width: 960px; /* same as editor */
            height: 680px; 
            background-color: #fff;
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center;
            position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            overflow: hidden;
        }

        /* Print Specific */
        @media print {
            body { 
                background: white; 
                display: block; 
                min-height: auto; 
            }
            .cert-container { 
                width: 100vw; 
                height: 100vh; 
                box-shadow: none;
                margin: 0;
            }
            .no-print { display: none !important; }
        }

        /* Toolbar floating on top */
        .toolbar {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            padding: 10px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            z-index: 1000;
        }
        .btn-print {
            background: #1e3a8a;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
        }
        .btn-print:hover { background: #152c6e; }
    </style>
</head>
<body>

    <div class="toolbar no-print">
        <button class="btn-print" onclick="window.print()">🖨️ Imprimir Certificado</button>
    </div>

    <!-- Container that uses the background and HTML structure from the DB -->
    <div class="cert-container" id="certCanvas" 
         style="background-image: url('{{ $plantilla->elementos_json['fondo_base64'] ?? '' }}')">
        {!! $plantilla->html_content !!}
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Load user and course data into the template fields
            const userData = {
                nombreCompleto: "{{ mb_strtoupper($user->name . ' ' . $user->apellido1 . ' ' . $user->apellido2) }}",
                documento: "{{ $user->numero_documento ? 'C.C. ' . $user->numero_documento : 'C.C. ____________' }}",
                cursoNombre: "{{ mb_strtoupper($curso->titulo) }}",
                horas: "{{ $curso->duracion_horas ?? '40' }}",
                fechaInicio: "{{ $curso->fecha_inicio ? \Carbon\Carbon::parse($curso->fecha_inicio)->translatedFormat('d \d\e F') : 'Inicio' }}",
                fechaFin: "{{ $curso->fecha_fin ? \Carbon\Carbon::parse($curso->fecha_fin)->translatedFormat('d \d\e F \d\e Y') : 'Fin' }}",
                firmaNombre: "{{ mb_strtoupper($curso->instructor->name ?? 'Firma') }}",
                firmaCargo: "INSTRUCTOR DE CURSO"
            };

            const mapIds = {
                'certNombreCompleto': userData.nombreCompleto,
                'certDocumento': userData.documento,
                'certCursoNombre': userData.cursoNombre,
                'certHoras': userData.horas,
                'certFechaInicio': userData.fechaInicio,
                'certFechaFin': userData.fechaFin,
                'certFirmaNombre': userData.firmaNombre,
                'certFirmaCargo': userData.firmaCargo
            };

            for (const [id, value] of Object.entries(mapIds)) {
                const el = document.getElementById(id);
                if (el) {
                    el.textContent = value;
                }
            }

            // Remove editor interaction classes or fix them
            document.querySelectorAll('.draggable-element').forEach(el => {
                el.classList.remove('draggable-element');
                el.style.cursor = 'default';
                el.oncontextmenu = null;
                el.onmousedown = null;
            });
        });
    </script>
</body>
</html>