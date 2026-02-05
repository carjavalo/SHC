<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(config('app.name', 'Hospital Universitario del Valle')); ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background: url('<?php echo e(asset('images/huv.jpg')); ?>') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            margin: 0;
            color: #fff;
        }
        
        .overlay {
            background-color: rgba(0, 0, 0, 0.6);
            height: 100%;
            width: 100%;
            position: fixed;
        }
        
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5% 1.5%;
            gap: 25px;
            overflow-y: auto;
        }
        
        .auth-card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            width: 100%;
            max-width: 480px;
            flex-shrink: 0;
        }

        /* Contenedor independiente del carrusel */
        .carousel-wrapper {
            flex-shrink: 0;
            width: 650px;
            max-width: 650px;
        }
        
        .card-left {
            background: linear-gradient(135deg, #2c4370 0%, #1e2f4d 100%);
            color: white;
            padding: 18px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Estilos del Carrusel */
        .carousel-container {
            position: relative;
            width: 100%;
            height: 300px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            margin-bottom: 0;
        }

        .carousel-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.8s ease-in-out;
        }

        .carousel-slide.active {
            opacity: 1;
        }

        .carousel-slide img {
            width: 95%;
            height: 100%;
            object-fit: contain;
            border-radius: 15px;
            margin: 0 auto;
            display: block;
        }

        .carousel-controls {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .carousel-controls:hover {
            background-color: rgba(255, 255, 255, 0.95);
            transform: translateY(-50%) scale(1.1);
        }

        .carousel-prev {
            left: 10px;
        }

        .carousel-next {
            right: 10px;
        }

        .carousel-indicators {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            z-index: 10;
        }

        .carousel-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .carousel-indicator.active {
            background-color: rgba(255, 255, 255, 0.9);
            transform: scale(1.2);
        }
        
        .card-right {
            padding: 15px 18px;
            color: #333;
        }
        
        .logo {
            max-width: 120px;
            margin-bottom: 20px;
        }
        
        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
            display: flex;
            flex-wrap: nowrap;
        }
        
        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 8px 14px;
            font-size: 0.95rem;
            white-space: nowrap;
        }
        
        .nav-tabs .nav-link.active {
            color: #2c4370;
            background-color: transparent;
            border-bottom: 3px solid #2c4370;
        }
        
        .tab-content {
            padding-top: 10px;
        }
        
        .form-control {
            border-radius: 5px;
            padding: 6px 10px;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        
        .form-label {
            font-size: 0.9rem;
            margin-bottom: 3px;
        }
        
        .btn-primary {
            border-radius: 5px;
            padding: 8px 12px;
            font-weight: 500;
            font-size: 0.95rem;
            background-color: #2c4370 !important;
            border-color: #2c4370 !important;
        }
        
        .btn-primary:hover {
            background-color: #1e2f4d !important;
            border-color: #1e2f4d !important;
        }
        
        .form-control:focus {
            border-color: #2c4370;
            box-shadow: 0 0 0 0.2rem rgba(44, 67, 112, 0.25);
        }
        
        a {
            color: #2c4370;
        }
        
        a:hover {
            color: #1e2f4d;
        }
        
        .hospital-info h1 {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .hospital-info p {
            font-size: 0.9rem;
            margin-bottom: 12px;
        }
        
        .features {
            margin-top: 12px;
        }
        
        .feature-item {
            margin-bottom: 8px;
            font-size: 0.85rem;
        }
        
        .feature-item i {
            margin-right: 8px;
            color: #fff;
        }
        
        .card-right h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        
        .mb-3 {
            margin-bottom: 8px !important;
        }
        
        .form-check {
            margin-bottom: 8px !important;
        }
        
        .row {
            margin-bottom: 0 !important;
        }
        
        .row .col-md-6 .mb-3 {
            margin-bottom: 8px !important;
        }
        
        /* Hacer el formulario de registro más compacto */
        #register .form-control {
            padding: 5px 10px;
            margin-bottom: 6px;
        }
        
        #register .form-label {
            margin-bottom: 2px;
        }
        
        #register .mb-3 {
            margin-bottom: 6px !important;
        }
        
        #register h3 {
            margin-bottom: 8px !important;
        }
        
        #register .row {
            margin-bottom: 0 !important;
        }
        
        #register .d-grid {
            margin-top: 8px;
        }
        
        /* Alinear correctamente los campos en filas */
        #register .row.g-2 {
            margin-left: -4px;
            margin-right: -4px;
        }
        
        #register .row.g-2 .col-6 {
            padding-left: 4px;
            padding-right: 4px;
        }
        
        @media (max-width: 992px) {
            .auth-container {
                flex-direction: column;
                gap: 20px;
                padding: 20px;
            }

            .auth-card {
                max-width: 90%;
            }

            .carousel-wrapper {
                width: 100%;
                max-width: 650px;
            }

            .carousel-container {
                height: 280px;
            }
        }

        @media (max-width: 768px) {
            .auth-container {
                gap: 15px;
                padding: 15px;
            }

            .carousel-container {
                height: 240px;
                margin-bottom: 0;
            }

            .carousel-controls {
                width: 32px;
                height: 32px;
            }

            .carousel-prev {
                left: 5px;
            }

            .carousel-next {
                right: 5px;
            }

            .carousel-indicators {
                bottom: 10px;
            }

            .carousel-indicator {
                width: 10px;
                height: 10px;
            }

            .carousel-wrapper {
                max-width: 100%;
            }

            .auth-card {
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            .carousel-container {
                height: 200px;
            }

            .auth-container {
                gap: 12px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="overlay">
        <div class="auth-container">
            <!-- Carrusel Independiente a la Izquierda -->
            <div class="carousel-wrapper">
                <div class="carousel-container" id="imageCarousel">
                    <div class="carousel-slide active">
                        <img src="<?php echo e(asset('images/inicio/img1.jpg')); ?>" alt="Imagen 1 - Hospital Universitario del Valle">
                    </div>
                    <div class="carousel-slide">
                        <img src="<?php echo e(asset('images/inicio/img2.jpg')); ?>" alt="Imagen 2 - Hospital Universitario del Valle">
                    </div>
                    <div class="carousel-slide">
                        <img src="<?php echo e(asset('images/inicio/img3.jpg')); ?>" alt="Imagen 3 - Hospital Universitario del Valle">
                    </div>
                    <div class="carousel-slide">
                        <img src="<?php echo e(asset('images/inicio/img4.jpg')); ?>" alt="Imagen 4 - Hospital Universitario del Valle">
                    </div>

                    <!-- Controles de navegación -->
                    <button class="carousel-controls carousel-prev" onclick="changeSlide(-1)">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="carousel-controls carousel-next" onclick="changeSlide(1)">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <!-- Indicadores -->
                    <div class="carousel-indicators">
                        <div class="carousel-indicator active" onclick="currentSlide(1)"></div>
                        <div class="carousel-indicator" onclick="currentSlide(2)"></div>
                        <div class="carousel-indicator" onclick="currentSlide(3)"></div>
                        <div class="carousel-indicator" onclick="currentSlide(4)"></div>
                    </div>
                </div>
            </div>

            <!-- Card de Autenticación a la Derecha -->
            <div class="auth-card">
                <div class="row g-0">
                    <!-- Lado izquierdo - Información del Hospital -->
                    <div class="col-md-5 card-left">
                        <div class="hospital-info">
                            <h1>Hospital Universitario del Valle</h1>
                            <p>Sistema de Gestión Hospitalaria</p>

                            <div class="features">
                                <div class="feature-item">
                                    <i class="fas fa-user-md"></i> Gestión de Pacientes
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-procedures"></i> Control de Procedimientos
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-clipboard-list"></i> Historial Clínico
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-pills"></i> Administración de Medicamentos
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lado derecho - Formularios de Autenticación -->
                    <div class="col-md-7 card-right">
                        <ul class="nav nav-tabs" id="authTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="true">Iniciar Sesión</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">Registrarse</button>
                            </li>
                        </ul>
                        
                        <div class="tab-content" id="authTabsContent">
                            <!-- Formulario de Login -->
                            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                                <h3 class="mb-3">Iniciar Sesión</h3>
                                
                                <form method="POST" action="<?php echo e(route('login')); ?>">
                                    <?php echo csrf_field(); ?>
                                    
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Correo Electrónico</label>
                                        <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password" name="password" required autocomplete="current-password">
                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="remember" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="remember">Recordarme</label>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                                    </div>
                                    
                                    <?php if(Route::has('password.request')): ?>
                                        <div class="text-center mt-3">
                                            <a href="<?php echo e(route('password.request')); ?>" class="text-decoration-none">
                                                ¿Olvidaste tu contraseña?
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </form>
                            </div>
                            
                            <!-- Formulario de Registro -->
                            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                <h3 class="mb-3">Crear Cuenta</h3>
                                
                                <form method="POST" action="<?php echo e(route('register')); ?>">
                                    <?php echo csrf_field(); ?>
                                    
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nombre</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" name="name" value="<?php echo e(old('name')); ?>" required autocomplete="name" autofocus>
                                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="apellido1" class="form-label">Primer Apellido</label>
                                                <input type="text" class="form-control <?php $__errorArgs = ['apellido1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="apellido1" name="apellido1" value="<?php echo e(old('apellido1')); ?>" required autocomplete="apellido1">
                                                <?php $__errorArgs = ['apellido1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($message); ?></strong>
                                                    </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="apellido2" class="form-label">Segundo Apellido</label>
                                                <input type="text" class="form-control <?php $__errorArgs = ['apellido2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="apellido2" name="apellido2" value="<?php echo e(old('apellido2')); ?>" autocomplete="apellido2">
                                                <?php $__errorArgs = ['apellido2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($message); ?></strong>
                                                    </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                                                <select class="form-control <?php $__errorArgs = ['tipo_documento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="tipo_documento" name="tipo_documento" required>
                                                    <option value="">Seleccione tipo de documento</option>
                                                    <option value="DNI" <?php echo e(old('tipo_documento') == 'DNI' ? 'selected' : ''); ?>>DNI</option>
                                                    <option value="Pasaporte" <?php echo e(old('tipo_documento') == 'Pasaporte' ? 'selected' : ''); ?>>Pasaporte</option>
                                                    <option value="Carnet de Extranjería" <?php echo e(old('tipo_documento') == 'Carnet de Extranjería' ? 'selected' : ''); ?>>Carnet de Extranjería</option>
                                                    <option value="Cédula" <?php echo e(old('tipo_documento') == 'Cédula' ? 'selected' : ''); ?>>Cédula</option>
                                                </select>
                                                <?php $__errorArgs = ['tipo_documento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($message); ?></strong>
                                                    </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="numero_documento" class="form-label">Número de Documento</label>
                                                <input type="text" class="form-control <?php $__errorArgs = ['numero_documento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="numero_documento" name="numero_documento" value="<?php echo e(old('numero_documento')); ?>" required maxlength="20" autocomplete="numero_documento">
                                                <?php $__errorArgs = ['numero_documento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($message); ?></strong>
                                                    </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Correo Electrónico</label>
                                        <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="register_email" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email">
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Teléfono de Contacto</label>
                                        <input type="tel" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="phone" name="phone" value="<?php echo e(old('phone')); ?>" placeholder="Ej: 3001234567" maxlength="20" autocomplete="tel">
                                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="register_password" name="password" required autocomplete="new-password">
                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                                    </div>

                                    <div class="mb-3">
                                        <label for="servicio_area_id" class="form-label">Servicio / Área</label>
                                        <select class="form-control <?php $__errorArgs = ['servicio_area_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="servicio_area_id" name="servicio_area_id" required>
                                            <option value="">Seleccione Servicio/Área</option>
                                            <?php $__currentLoopData = \App\Models\ServicioArea::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $servicio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($servicio->id); ?>" <?php echo e(old('servicio_area_id') == $servicio->id ? 'selected' : ''); ?>><?php echo e($servicio->nombre); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['servicio_area_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="vinculacion_contrato_id" class="form-label">Tipo de Vinculación/Contrato</label>
                                        <select class="form-control <?php $__errorArgs = ['vinculacion_contrato_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="vinculacion_contrato_id" name="vinculacion_contrato_id" required>
                                            <option value="">Seleccione Tipo de Vinculación</option>
                                            <?php $__currentLoopData = \App\Models\VinculacionContrato::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vinculacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($vinculacion->id); ?>" <?php echo e(old('vinculacion_contrato_id') == $vinculacion->id ? 'selected' : ''); ?>><?php echo e($vinculacion->nombre); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['vinculacion_contrato_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="mb-3">
                                        <label for="sede_id" class="form-label">Sede</label>
                                        <select class="form-control <?php $__errorArgs = ['sede_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="sede_id" name="sede_id" required>
                                            <option value="">Seleccione Sede</option>
                                            <?php $__currentLoopData = \App\Models\Sede::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sede): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($sede->id); ?>" <?php echo e(old('sede_id') == $sede->id ? 'selected' : ''); ?>><?php echo e($sede->nombre); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['sede_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">Registrarse</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Carrusel JavaScript -->
    <script>
        let currentSlideIndex = 0;
        const slides = document.querySelectorAll('.carousel-slide');
        const indicators = document.querySelectorAll('.carousel-indicator');
        const totalSlides = slides.length;
        let autoSlideInterval;

        // Función para mostrar una diapositiva específica
        function showSlide(index) {
            // Ocultar todas las diapositivas
            slides.forEach(slide => slide.classList.remove('active'));
            indicators.forEach(indicator => indicator.classList.remove('active'));

            // Mostrar la diapositiva actual
            slides[index].classList.add('active');
            indicators[index].classList.add('active');
        }

        // Función para cambiar diapositiva (anterior/siguiente)
        function changeSlide(direction) {
            currentSlideIndex += direction;

            if (currentSlideIndex >= totalSlides) {
                currentSlideIndex = 0;
            } else if (currentSlideIndex < 0) {
                currentSlideIndex = totalSlides - 1;
            }

            showSlide(currentSlideIndex);
            resetAutoSlide();
        }

        // Función para ir a una diapositiva específica
        function currentSlide(index) {
            currentSlideIndex = index - 1;
            showSlide(currentSlideIndex);
            resetAutoSlide();
        }

        // Función para avanzar automáticamente
        function autoSlide() {
            currentSlideIndex++;
            if (currentSlideIndex >= totalSlides) {
                currentSlideIndex = 0;
            }
            showSlide(currentSlideIndex);
        }

        // Función para reiniciar el auto-slide
        function resetAutoSlide() {
            clearInterval(autoSlideInterval);
            autoSlideInterval = setInterval(autoSlide, 5000);
        }

        // Inicializar el carrusel
        document.addEventListener('DOMContentLoaded', function() {
            // Iniciar auto-slide cada 5 segundos
            autoSlideInterval = setInterval(autoSlide, 5000);

            // Pausar auto-slide cuando el mouse está sobre el carrusel
            const carousel = document.getElementById('imageCarousel');
            carousel.addEventListener('mouseenter', function() {
                clearInterval(autoSlideInterval);
            });

            // Reanudar auto-slide cuando el mouse sale del carrusel
            carousel.addEventListener('mouseleave', function() {
                autoSlideInterval = setInterval(autoSlide, 5000);
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\SHC\resources\views/welcome.blade.php ENDPATH**/ ?>