<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Encuesta de Reclutamiento')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('assets/img/favicon.png')}}" rel="icon">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: "Segoe UI", Roboto, Arial, sans-serif;
        }
        .public-header {
            background: linear-gradient(135deg, #37517E,#0056b3, #007bff);
            padding: 0.8rem 1rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            color: white;
            height: 70px;
        }
        .public-header img {
            max-height: 50px;
        }


        /* Título centrado globalmente */
        .header-title {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-weight: 600;
            color: white;
            text-align: center;
            line-height: 1.2;
        }
            .logo img {
                display: block;
                max-height: 40px;
            }

        .pregunta-faltante {
            border: 2px solid #dc3545;
            border-radius: 8px;
            padding: 10px;
            background-color: #ffe5e5;
            transition: all 0.3s;
        }

    </style>
</head>
<body>
 <!-- 🔹 Header corporativo -->
<header id="header" class="header fixed-top public-header">
    <div class="container-fluid position-relative d-flex align-items-center">
        
        <!-- Logo a la izquierda -->
        <div class="logo">
            <img src="{{ asset('assets/img/Ft2.png')}}" 
                 alt="Logo Empresa" 
                 class="img-fluid" 
                 style="max-height: 40px;">
        </div>

        <!-- Título centrado en toda la página -->
        <h3 class="header-title m-0">
            Dirección de Gente y Organización
        </h3>
    </div>
</header>


    <main class="my-4">
        @yield('content')
    </main>

    <footer class="text-center text-muted py-3 small">
        &copy; {{ date('Y') }} FOCUSTalent – Todos los derechos reservados.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
