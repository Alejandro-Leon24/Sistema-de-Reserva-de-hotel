<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$mensaje_exito = $_SESSION['mensaje_exito'] ?? '';
$error = $_SESSION['error_pago'] ?? '';
unset($_SESSION['mensaje_exito'], $_SESSION['error_pago']);

?>


<!DOCTYPE html>
<html lang="es" data-theme="light">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="../../assets/css/Style_Facturas.css">

    <title>Registrar Factura</title>
</head>

<body>
    <?php require_once __DIR__ . "/../layout/barra-navegacion.php"; ?>
    <main>

        <form method="GET" action="index.php" id="formBuscarHuesped">
            <input type="hidden" name="accion" value="registrar_pago">
            <div class="grupo-formulario">
                <label for="cedulaHuesped"><b>Ingrese Cédula del huésped:</b></label>
                <input type="text" id="cedulainput" name="cedula" placeholder="Ej: 1234567890" value="<?php echo $_GET["cedula"] ?? ''; ?>" required>
                <button type="submit" class="boton-verde">Buscar</button>
            </div>
        </form>

        <?php if ($mensaje_exito): ?>
            <div class="mensaje" style="max-width: 600px; margin: 0 auto 20px auto;"><?php echo htmlspecialchars($mensaje_exito); ?></div>
        <?php elseif ($error): ?>
            <div class="mensaje error" style="max-width: 600px; margin: 0 auto 20px auto;"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (isset($huesped) && isset($ResultadoReserva)): ?>
            <section id="contenedor-principal">
                <div class="resumen-huesped" id="resumenHuesped">
                    <h3>Resumen</h3>
                    <h4>Datos del Huésped</h4>
                    <p><strong>Nombre:</strong> <?php echo $huesped["Nombre"]; ?></p>
                    <p><strong>Apellido:</strong> <?php echo $huesped["Apellido"]; ?></p>
                    <p><strong>Cédula:</strong> <?php echo $huesped["N_Documento"]; ?></p>
                    <p><strong>Número de Habitación:</strong> <?php echo $ResultadoReserva["num_habitacion"]; ?></p>
                    <p><strong>Precio de la Habitación:</strong> $<?php echo number_format($ResultadoReserva["precio"], 2); ?></p>
                    <p class="total-pagar">Total a pagar: $<?php echo number_format($ResultadoReserva["precio"], 2); ?></p>
                </div>

                <form method="POST" action="index.php?accion=guardar_pago" id="formPago">
                    <div>
                        <input type="hidden" name="cedula_huesped" value="<?php echo $huesped['N_Documento']; ?>">
                        <input type="hidden" name="nombre_huesped" value="<?php echo $huesped['Nombre'] . " " . $huesped['Apellido']; ?>">
                        <input type="hidden" name="numero_habitacion" value="<?php echo $ResultadoReserva['num_habitacion']; ?>">
                        <input type="hidden" name="precio_habitacion" value="<?php echo number_format($ResultadoReserva["precio"], 2);?>">
                    </div>
                    <div id="metodoPagoContainer">
                        <div class="grupo-formulario">
                            <label for="payment-type">Método de pago:</label>
                            <select name="metodo_pago" id="payment-type" required onchange="mostrarCamposPago(this.value)">
                                <option value="">Seleccione un método</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta">Tarjeta</option>
                            </select>
                        </div>

                        <div id="campos-pago" style="display: none;">
                            <div id="pago-efectivo" class="hidden">
                                <h4>Pago en Efectivo</h4>
                                <div class="grupo-formulario">
                                    <label for="titular_nombre_efectivo">Nombre del titular:</label>
                                    <input type="text" name="nombre_titular" id="titular_nombre_efectivo" required />
                                </div>
                                <div class="grupo-formulario">
                                    <label for="titular_cedula_efectivo">Cédula del titular:</label>
                                    <input type="text" name="cedula_titular" id="titular_cedula_efectivo" required />
                                </div>
                            </div>

                            <div id="pago-tarjeta" class="hidden">
                                <h4>Pago con Tarjeta</h4>
                                <div class="grupo-formulario">
                                    <label for="numero_tarjeta">Número de tarjeta:</label>
                                    <input type="text" name="numero_tarjeta" id="numero_tarjeta" maxlength="16" required />
                                </div>
                                <div class="grupo-formulario">
                                    <label for="nombre_titular_tarjeta">Nombre del titular:</label>
                                    <input type="text" name="nombre_titular_tarjeta" id="nombre_titular_tarjeta" required />
                                </div>
                                <div class="grupo-formulario">
                                    <label for="cedula_titular_tarjeta">Cédula del titular:</label>
                                    <input type="text" name="cedula_titular_tarjeta" id="cedula_titular_tarjeta" required />
                                </div>
                                <div class="grupo-formulario">
                                    <label for="fecha_vencimiento">Fecha de vencimiento:</label>
                                    <input type="month" id="fecha_vencimiento" name="fecha_vencimiento" required style="padding: 10px 40px;">
                                </div>
                                <div class="grupo-formulario">
                                    <label for="codigo_seguridad">Código de seguridad:</label>
                                    <input type="password" name="codigo_seguridad" id="codigo_seguridad" maxlength="4" required />
                                </div>
                            </div>

                            <button type="submit" name="accion" value="pagar" class="boton-verde" id="btnPagar">Pagar</button>
                        </div>
                    </div>
                </form>
            </section>
        <?php endif; ?>

    </main>
    <script src="../../assets/js/Pagos.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mensaje = document.querySelector('.mensaje');
            if (mensaje) {
                setTimeout(() => {
                    mensaje.style.transition = 'opacity 0.8s ease';
                    mensaje.style.opacity = 0;
                    setTimeout(() => mensaje.remove(), 1000);
                }, 3000);
            }
        });
    </script>

</body>

</html>