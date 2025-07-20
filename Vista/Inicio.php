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

    <title>Inicio</title>
</head>

<body>
    <?php require_once __DIR__ . "/layout/barra-navegacion.php" ?>
    <main>
        <div class="banner">
            <p>Bienvenido, <b><?php echo $_SESSION["usuario"]["Nombre"] . " " . $_SESSION["usuario"]["Apellido"] ?></b></p>
        </div>
        <div class="menu animate__animated animate__fadeIn">
            <div class="modulos">
                <div class="header-modulos">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M17 3h-3v2h3v16H7V5h3V3H7a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2m-5 4a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2m4 8H8v-1c0-1.33 2.67-2 4-2s4 .67 4 2zm0 3H8v-1h8zm-4 2H8v-1h4zm1-15h-2V1h2z" />
                    </svg>
                    <div>
                        <h3>Huesped</h3>
                        <span>Gestión de huespedes</span>
                    </div>
                </div>
                <div class="botones-menu">
                    <a href="index.php?accion=registrar-huesped">
                        <button>Registrar
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M4 12h12.25L11 6.75l.66-.75l6.5 6.5l-6.5 6.5l-.66-.75L16.25 13H4z" stroke-width="2" stroke="currentColor" />
                            </svg>
                        </button>
                    </a>
                    <a href="index.php?accion=listar-huesped">
                        <button class="outline contrast">Consultar
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M4 12h12.25L11 6.75l.66-.75l6.5 6.5l-6.5 6.5l-.66-.75L16.25 13H4z" stroke-width="2" stroke="currentColor" />
                            </svg>
                        </button>
                    </a>
                </div>
            </div>
            <div class="modulos">
                <div class="header-modulos">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M19 9h-6v6h8v-4c0-1.1-.9-2-2-2" opacity="0.15" stroke-width="0.5" stroke="currentColor" />
                        <circle cx="7" cy="11" r="1" fill="currentColor" opacity="0.15" stroke-width="0.5" stroke="currentColor" />
                        <path fill="currentColor" d="M4 11c0 1.66 1.34 3 3 3s3-1.34 3-3s-1.34-3-3-3s-3 1.34-3 3m4 0c0 .55-.45 1-1 1s-1-.45-1-1s.45-1 1-1s1 .45 1 1m11-4h-8v8H3V5H1v15h2v-3h18v3h2v-9c0-2.21-1.79-4-4-4m2 8h-8V9h6c1.1 0 2 .9 2 2z" stroke-width="0.5" stroke="currentColor" />
                    </svg>
                    <div>
                        <h3>Habitación</h3>
                        <span>Gestión de habitaciones</span>
                    </div>
                </div>
                <div class="botones-menu">
                    <a href="index.php?accion=registrarHabitacion">
                        <button>Registrar
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M4 12h12.25L11 6.75l.66-.75l6.5 6.5l-6.5 6.5l-.66-.75L16.25 13H4z" stroke-width="2" stroke="currentColor" />
                            </svg>
                        </button>
                    </a>
                    <a href="index.php?accion=listarHabitaciones">
                        <button class="outline contrast">Consultar
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M4 12h12.25L11 6.75l.66-.75l6.5 6.5l-6.5 6.5l-.66-.75L16.25 13H4z" stroke-width="2" stroke="currentColor" />
                            </svg>
                        </button>
                    </a>
                </div>
            </div>
            <div class="modulos">
                <div class="header-modulos">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 21H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4.5M16 3v4M8 3v4m-4 4h16m-3 6a2 2 0 1 0 4 0a2 2 0 1 0-4 0m5 5a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2" />
                    </svg>
                    <div>
                        <h3>Reserva</h3>
                        <span>Gestión de reservas</span>
                    </div>
                </div>
                <div class="botones-menu">
                    <a href="index.php?accion=Registrar">
                        <button>Registrar
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M4 12h12.25L11 6.75l.66-.75l6.5 6.5l-6.5 6.5l-.66-.75L16.25 13H4z" stroke-width="2" stroke="currentColor" />
                            </svg>
                        </button>
                    </a>
                    <a href="index.php?accion=consultar">
                        <button class="outline contrast">Consultar
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M4 12h12.25L11 6.75l.66-.75l6.5 6.5l-6.5 6.5l-.66-.75L16.25 13H4z" stroke-width="2" stroke="currentColor" />
                            </svg>
                        </button>
                    </a>
                </div>
            </div>
            <div class="modulos">
                <div class="header-modulos">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M12 9.58c-2.95 0-5.47 1.83-6.5 4.41h13A7 7 0 0 0 12 9.58" opacity="0.15" stroke-width="0.5" stroke="currentColor" />
                        <path fill="currentColor" d="M2 17h20v2H2zm11.84-9.21A2.006 2.006 0 0 0 12 5a2.006 2.006 0 0 0-1.84 2.79C6.25 8.6 3.27 11.93 3 16h18c-.27-4.07-3.25-7.4-7.16-8.21M12 9.58c2.95 0 5.47 1.83 6.5 4.41h-13A7 7 0 0 1 12 9.58" stroke-width="0.5" stroke="currentColor" />
                    </svg>
                    <div>
                        <h3>Servicios</h3>
                        <span>Gestión de servicios del hotel</span>
                    </div>
                </div>
                <div class="botones-menu">
                    <a href="index.php?accion=registrar-servicio">
                        <button>Registrar
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M4 12h12.25L11 6.75l.66-.75l6.5 6.5l-6.5 6.5l-.66-.75L16.25 13H4z" stroke-width="2" stroke="currentColor" />
                            </svg>
                        </button>
                    </a>
                    <a href="index.php?accion=consultar-servicio">
                        <button class="outline contrast">Consultar
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M4 12h12.25L11 6.75l.66-.75l6.5 6.5l-6.5 6.5l-.66-.75L16.25 13H4z" stroke-width="2" stroke="currentColor" />
                            </svg>
                        </button>
                    </a>
                </div>
            </div>
            <div class="modulos">
                <div class="header-modulos">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M13.5 12.423q-.846 0-1.423-.577t-.577-1.423T12.077 9t1.423-.577T14.923 9t.577 1.423t-.577 1.423t-1.423.577m-6.192 3.193q-.667 0-1.141-.475q-.475-.475-.475-1.141V6.846q0-.666.475-1.14t1.14-.475h12.385q.667 0 1.141.474t.475 1.141V14q0 .666-.475 1.14q-.474.476-1.14.476zm1-1h10.384q0-.672.475-1.144q.474-.472 1.14-.472V7.846q-.67 0-1.142-.474q-.473-.475-.473-1.141H8.308q0 .671-.475 1.143q-.474.472-1.14.472V13q.67 0 1.143.475q.472.474.472 1.14m9.538 4H4.308q-.667 0-1.141-.474q-.475-.475-.475-1.141V8.692q0-.212.144-.356t.357-.144t.356.144t.143.356V17q0 .23.192.423q.193.193.424.193h13.538q.213 0 .356.143q.144.144.144.357t-.144.356t-.356.144m-10.538-4h-.616V6.23h.616q-.25 0-.433.183t-.183.432V14q0 .25.183.433t.433.183" stroke-width="0.5" stroke="currentColor" />
                    </svg>
                    <div>
                        <h3>Pagos</h3>
                        <span>Gestión de pagos</span>
                    </div>
                </div>
                <div class="botones-menu">
                    <a href="index.php?accion=registrar_pago">
                        <button>Registrar
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M4 12h12.25L11 6.75l.66-.75l6.5 6.5l-6.5 6.5l-.66-.75L16.25 13H4z" stroke-width="2" stroke="currentColor" />
                            </svg>
                        </button>
                    </a>
                    <a href="index.php?accion=listar_pagos">
                        <button class="outline contrast">Consultar
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M4 12h12.25L11 6.75l.66-.75l6.5 6.5l-6.5 6.5l-.66-.75L16.25 13H4z" stroke-width="2" stroke="currentColor" />
                            </svg>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </main>
    <dialog>
        <article class="animate__animated animate__zoomIn">
            <h2>hola</h2>
        </article>
    </dialog>
</body>

</html>