<!DOCTYPE html>
<html lang="es" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.classless.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.colors.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="assets/css/Styles.css">
    <title>Principal</title>
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
            background: linear-gradient(120deg, #2196f3 0%, #0f73d4 60%, #0356b3 100%);
            position: relative;
            overflow-x: hidden;
        }
    </style>
</head>

<body>
    <main>
        <div class="landing-bg">
            <svg class="decorative-svg" viewBox="0 0 160 160">
                <circle cx="80" cy="80" r="65" fill="#ffffff" fill-opacity="0.25" />
                <path d="M30,110 Q80,40 130,110" stroke="#21cbf3" stroke-width="4" fill="none" opacity="0.7" />
                <path d="M40,120 Q80,70 120,120" stroke="#2196f3" stroke-width="2" fill="none" opacity="0.5" />
            </svg>
            <div class="landing-content">
                <h1 class=" animate__animated animate__bounceInDown">Sistema de reserva de hotel</h1>
                <p class="subtitle animate__animated animate__bounceInDown">Bienvenido al sistema de reserva de hotel<br>Gestiona a los huéspedes, habitaciones, reservas, servicios y pagos</p>
                <div class="collage-container animate__animated animate__fadeIn">
                    <div class="collage-img img1 animate__animated animate__bounceInLeft"></div>
                    <div class="collage-img img2 animate__animated animate__bounceInLeft"></div>
                    <div class="collage-img img3 animate__animated animate__bounceInRight"></div>
                    <div class="collage-img img4 animate__animated animate__bounceInRight"></div>
                    <div class="collage-img img5 animate__animated animate__jackInTheBox"></div>
                    <a href="index.php?accion=iniciar_sesion" style="bottom: 200px; position: fixed;">
                        <button class="contrast">
                            Iniciar sesión
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M4 12h12.25L11 6.75l.66-.75l6.5 6.5l-6.5 6.5l-.66-.75L16.25 13H4z" stroke-width="2" stroke="currentColor" />
                            </svg>
                        </button>
                    </a>
                </div>
            </div>
            <footer class="footer">
                Copyright © Sistema de reserva de hotel - Todos los derechos reservados
            </footer>
        </div>
    </main>
</body>

</html>