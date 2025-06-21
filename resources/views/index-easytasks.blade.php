<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EasyTask - Gestor de Actividades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #fff; min-height: 100vh; }
        .navbar-custom {
            background: #fff;
            border-bottom: 1px solid #E8EDF5;
            box-shadow: 0 2px 8px rgba(79,70,229,0.04);
        }
        .navbar-logo {
            width: 38px;
            height: 38px;
            object-fit: contain;
        }
        .btn-primary-custom {
            background: #4F46E5;
            color: #fff;
            border: none;
            font-weight: 500;
            border-radius: 6px;
            transition: background 0.2s;
        }
        .btn-primary-custom:hover {
            background: #3730a3;
            color: #fff;
        }
        .btn-outline-custom {
            background: #E8EDF5;
            color: #4F46E5;
            border: none;
            font-weight: 500;
            border-radius: 6px;
            transition: background 0.2s;
        }
        .btn-outline-custom:hover {
            background: #4F46E5;
            color: #fff;
        }
        .hero-img {
            width: 100%;
            max-width: 800px;
            border-radius: 12px;
            object-fit: cover;
            margin: 0 auto 32px auto;
            display: block;
        }
        .hero-title {
            font-size: 2.3rem;
            font-weight: 700;
            color: #22223B;
        }
        .hero-desc {
            font-size: 1.3rem;
            color: #22223bcc;
            margin-bottom: 2.5rem;
        }
        .feature-card {
            border: 1px solid #E8EDF5;
            border-radius: 10px;
            background: #fff;
            padding: 1.5rem 1.2rem;
            min-height: 150px;
            box-shadow: 0 2px 8px rgba(79,70,229,0.04);
        }
        .feature-icon {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        .cta-section {
            margin: 60px 0 30px 0;
        }
        .cta-btn {
            background: #4F46E5;
            color: #fff;
            border-radius: 6px;
            font-weight: 600;
            padding: 0.7rem 2.5rem;
            font-size: 1.1rem;
            border: none;
        }
        .cta-btn:hover {
            background: #3730a3;
            color: #fff;
        }
        .footer-custom {
            color: #7c7c7c;
            font-size: 0.95rem;
            background: #fff;
            border-top: 1px solid #E8EDF5;
            padding: 18px 0 8px 0;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom px-3">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="navbar-logo">
                <span class="fw-bold" style="color:#22223B;">EasyTask</span>
            </a>
            <div class="d-flex gap-2">
                <a href="{{ route('register') }}" class="btn btn-primary-custom">Regístrate</a>
                <a href="{{ route('login') }}" class="btn btn-outline-custom">Iniciar Sesión</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">

            <div class="position-relative" style="max-width:800px;margin:0 auto;">
                    <img src="{{ asset('foto.png') }}" alt="Ilustración" class="hero-img mb-4" style="border-radius:12px;">
                    <div style="position:absolute;left:0;bottom:32px;padding-left:32px;padding-right:32px;width:100%;text-align:left;">
                        <h1 style="color:#fff;font-weight:800;font-size:2.5rem;line-height:1.1;text-shadow:0 2px 12px rgba(0,0,0,0.18);margin:0;">Optimiza tu flujo de trabajo con<br>EasyTask</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Características -->
        <div class="row justify-content-center mb-5">
            <div class="col-12 col-md-10">
                <h3 class="fw-bold mb-2" style="color:#22223B;">Características claves</h3>
                <p class="mb-4" style="color:#22223bcc;">Explora las potentes características que hacen de Easy Task la solución definitiva para la gestión de tareas.</p>
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="feature-card h-100">
                            <div class="feature-icon"><i class="bi bi-list-task"></i></div>
                            <div class="fw-bold mb-1">Task Organization</div>
                            <div class="text-muted" style="font-size:0.98rem;">Categoriza tareas, establece prioridades y haz seguimiento del progreso con facilidad. Mantente organizado y enfocado en lo que más importa.</div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="feature-card h-100">
                            <div class="feature-icon"><i class="bi bi-alarm"></i></div>
                            <div class="fw-bold mb-1">Time Management</div>
                            <div class="text-muted" style="font-size:0.98rem;">Administra tu tiempo eficientemente con plazos, recordatorios y tareas recurrentes. Nunca pierdas una fecha límite.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="row justify-content-center cta-section">
            <div class="col-12 col-md-8 text-center">
                <h2 class="fw-bold mb-3" style="color:#22223B;">¿Listo para Tomar el Control de Tus Tareas?</h2>
                <p class="mb-4" style="color:#22223bcc;">Regístrate en Easy Task hoy y experimenta la diferencia.</p>
                <a href="{{ route('register') }}" class="cta-btn">Comenzar</a>
            </div>
        </div>
    </section>

    <footer class="footer-custom text-center">&copy; {{ date('Y') }} EasyTask. Todos los derechos reservados</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
