<?php
include '../../conexion/conexion.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "<script>alert('¡Pago exitoso!');</script>";
}
// Datos quemados del huésped (simulados)
$datos_huesped = [
    '1234567890' => [
        'nombre' => 'Aaron St',
        'apellido' => 'Perez',
        'habitacion' => '102',
        'precio_habitacion' => 150.20
    ],
    '0987654321' => [
        'nombre' => 'María García',
        'apellido' => 'López',
        'habitacion' => '205',
        'precio_habitacion' => 200.00
    ]
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cedula = $_POST['cedula'];
    $metodo_pago = $_POST['payment-type'];
    $total = $_POST['total'];

    $numero_factura = 'FACT-' . date('Ymd') . '-' . rand(1000, 9999);
    $nombre_completo = $datos_huesped[$cedula]['nombre'] . ' ' . $datos_huesped[$cedula]['apellido'];
    $habitacion = $datos_huesped[$cedula]['habitacion'];

    if ($metodo_pago == 'Efectivo') {
    $nombre_titular = $_POST['titular_nombre'] ?? '';
    $cedula_titular = $_POST['titular_cedula'] ?? '';

    $numero_tarjeta = '';
    $fecha_vencimiento = '';
    $codigo_seguridad = '';

    $stmt = $conexion->prepare("INSERT INTO facturas (
        numero_factura, cedula_huesped, nombre_huesped, numero_habitacion, metodo_pago, total, 
        numero_tarjeta, fecha_vencimiento, codigo_seguridad, nombre_titular, cedula_titular
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssdsssss", $numero_factura, $cedula, $nombre_completo, $habitacion, $metodo_pago, $total,
        $numero_tarjeta, $fecha_vencimiento, $codigo_seguridad, $nombre_titular, $cedula_titular);

} elseif ($metodo_pago == 'Tarjeta') {
    $numero_tarjeta = $_POST['numero_tarjeta'] ?? '';
    $fecha_vencimiento = $_POST['fecha_vencimiento'] ?? '';
    $codigo_seguridad = $_POST['codigo_seguridad'] ?? '';
    $nombre_titular = $_POST['nombre_titular_tarjeta'] ?? '';
    $cedula_titular = $_POST['cedula_titular_tarjeta'] ?? '';

    $stmt = $conexion->prepare("INSERT INTO facturas (
        numero_factura, cedula_huesped, nombre_huesped, numero_habitacion, metodo_pago, total,
        numero_tarjeta, fecha_vencimiento, codigo_seguridad, nombre_titular, cedula_titular
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssdsssss", $numero_factura, $cedula, $nombre_completo, $habitacion, $metodo_pago, $total,
        $numero_tarjeta, $fecha_vencimiento, $codigo_seguridad, $nombre_titular, $cedula_titular);
}

    if ($stmt->execute()) {
        echo "<script>alert('Factura registrada y pagada exitosamente! N°: $numero_factura'); window.location.href = 'Registrar-Facturas.php';</script>";
        exit;
    } else {
        echo "Error: " . $conexion->error;
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Facturas</title>
    <link rel="stylesheet" href="../../CSS/Styles.css">
    <link rel="stylesheet" href="../../CSS/Style_Facturas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
    <header>
        <h1>Reserva de hotel</h1>
    </header>
    
    <nav class="menu">
        <ul>
            <li><a href="../../index.html">Inicio</a></li>
            <li>
                <a href="../Huesped/Lobby-Huesped.html">Huesped</a>
                <ul class="submenu">
                    <li><a href="../Huesped/Registrar-Huesped.html">Registrar Huesped</a></li>
                    <li><a href="../Huesped/Listar-Huesped.html">Mostrar Huesped</a></li>
                    <li><a href="../Huesped/Editar-Huesped.html">Editar Huesped</a></li>
                    <li><a href="../Huesped/Eliminar-Huesped.html">Eliminar Huesped</a></li>
                </ul>
            </li>
            <li>
                <a href="../Habitaciones/Lobby-Habitaciones.html">Habitación</a>
                <ul class="submenu">
                    <li><a href="../Habitaciones/Registrar-Habitaciones.html">Registrar Habitación</a></li>
                    <li><a href="../Habitaciones/Asignar-Habitaciones.html">Asignar Habitación</a></li>
                    <li><a href="../Habitaciones/Listar-Habitaciones.html">Mostrar Habitación</a></li>
                    <li><a href="../Habitaciones/Editar-Habitaciones.html">Editar Habitación</a></li>
                    <li><a href="../Habitaciones/Eliminar-Habitaciones.html">Eliminar Habitación</a></li>
                </ul>
            </li>
            <li>
                <a href="../Servicios/Lobby-Servicios.html">Servicios</a>
                <ul class="submenu">
                    <li><a href="../Servicios/Registrar-Servicios.html">Registrar Servicios</a></li>
                    <li><a href="../Servicios/Listar-Servicios.html">Mostrar Servicios</a></li>
                    <li><a href="../Servicios/Editar-Servicios.html">Editar Servicios</a></li>
                    <li><a href="../Servicios/Eliminar-Servicios.html">Eliminar Servicios</a></li>
                </ul>
            </li>
            <li>
                <a href="Lobby-Facturas.html">Factura</a>
                <ul class="submenu">
                    <li><a href="Registrar-Facturas.html">Registrar Factura</a></li>
                    <li><a href="Listar-Facturas.html">Mostrar Factura</a></li>
                    <li><a href="Editar-Facturas.html">Editar Factura</a></li>
                    <li><a href="Eliminar-Facturas.html">Eliminar Factura</a></li>
                </ul>
            </li>
            <li>
                <a href="../Cancelaciones/Lobby-Cancelaciones.html">Cancelaciones</a>
                <ul class="submenu">
                    <li><a href="../Cancelaciones/Registrar-Cancelaciones.html">Registrar Cancelaciones</a></li>
                    <li><a href="../Cancelaciones/Lista-Cancelaciones.html">Mostrar Cancelaciones</a></li>
                    <li><a href="../Cancelaciones/Editar-Cancelaciones.html">Editar Cancelaciones</a></li>
                    <li><a href="../Cancelaciones/Eliminar-Cancelaciones.html">Eliminar Cancelaciones</a></li>
                </ul>
            </li>
        </ul>
    </nav>


    <main>
        <section id="contenedor-principal">
            <?php if (isset($mensaje)): ?>
                <div class="mensaje"><?php echo $mensaje; ?></div>
            <?php endif; ?>
            
            <div class="contenedor-formulario">
                <div class="seccion-busqueda">
                    <form method="POST" action="">
                        <div class="grupo-formulario">
                            <label for="cedulaHuesped" id="cedulahuesp">Ingrese Cédula del huésped:</label>
                            <input type="text" id="cedulainput" name="cedula" placeholder="Ej: 1234567890" required
                                   onchange="buscarHuesped(this.value)">        
<button type="submit" style="background-color: #27ae60; width: 100%; padding: 1rem;">
                                buscar
                            </button>
                        </div>
                        
                        <div class="resumen-huesped" id="resumenHuesped" style="display:none;">
                            <h3>Resumen:</h3>
                            <h4>Datos del Huésped:</h4>
                            <p><strong>Nombre:</strong> <span id="nombreHuesped"></span></p>
                            <p><strong>Apellido:</strong> <span id="apellidoHuesped"></span></p>
                            <p><strong>Cédula:</strong> <span id="cedulaHuesped"></span></p>
                            
                            <h4>Información de la habitación:</h4>
                            <p><strong>Número de Habitación:</strong> <span id="numeroHabitacion"></span></p>
                            <p><strong>Precio de la habitación:</strong> $<span id="precioHabitacion"></span></p>
                            
                            <input type="hidden" name="total" id="totalPagarInput">
                            <p class="total-pagar">Total a pagar: $<span id="totalPagar"></span></p>
                        </div>
                        
                        <div class="grupo-formulario" id="metodoPagoContainer" style="display:none;">
                            <label for="payment-type">Método de pago:</label>
                            <select name="payment-type" id="payment-type" required onchange="mostrarCamposPago(this.value)">
                                <option value="">Seleccione</option>
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta">Tarjeta de Crédito/Débito</option>
                            </select>
                        </div>

                        <!-- Campos específicos según método -->
                        <div id="pago-efectivo" style="display: none;">
                            <h4>Pago en Efectivo</h4>
                            <div class="grupo-formulario">
                                <label for="titular_nombre">Nombre del titular:</label>
                                <input type="text" name="titular_nombre" id="titular_nombre_efectivo" />
                            </div>
                            <div class="grupo-formulario">
                                <label for="titular_cedula">Cédula del titular:</label>
                                <input type="text" name="titular_cedula" id="titular_cedula_efectivo" />
                            </div>
                        </div>

                        <!-- Campos adicionales para Tarjeta -->
                        <div id="pago-tarjeta" style="display: none;">
                            <h4>Pago con Tarjeta</h4>
                            <div class="grupo-formulario">
                                <label for="numero_tarjeta">Número de tarjeta:</label>
                                <input type="text" name="numero_tarjeta" id="numero_tarjeta" maxlength="16" />
                            </div>
                            <div class="grupo-formulario">
                                <label for="nombre_titular_tarjeta">Nombre del titular:</label>
                                <input type="text" name="nombre_titular_tarjeta" />
                            </div>
                            <div class="grupo-formulario">
                                <label for="cedula_titular_tarjeta">Cédula del titular:</label>
                                <input type="text" name="cedula_titular_tarjeta" />
                            </div>
                            <div class="grupo-formulario">
                                <label for="fecha_vencimiento">Fecha de vencimiento:</label>
                                <input type="month" name="fecha_vencimiento" />
                            </div>
                            <div class="grupo-formulario">
                                <label for="codigo_seguridad">Código de seguridad:</label>
                                <input type="password" name="codigo_seguridad" maxlength="4" />
                            </div>
                        </div>


                            <button type="submit" style="background-color: #27ae60; width: 100%; padding: 1rem;">
                                Pagar
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </section>
    </main>

<script>
    function mostrarCamposPago(metodo) {
        const efectivoDiv = document.getElementById('pago-efectivo');
        const tarjetaDiv = document.getElementById('pago-tarjeta');

        // Oculta ambos inicialmente
        efectivoDiv.style.display = 'none';
        tarjetaDiv.style.display = 'none';

        if (metodo === 'Efectivo') {
            efectivoDiv.style.display = 'block';
        } else if (metodo === 'Tarjeta') {
            tarjetaDiv.style.display = 'block';
        }
    }

    function buscarHuesped(cedula) {
        const resumen = document.getElementById('resumenHuesped');
        const metodoPagoContainer = document.getElementById('metodoPagoContainer');

        const datosHuesped = {
            '1234567890': {
                nombre: 'Aaron',
                apellido: 'St',
                habitacion: '102',
                precioHabitacion: 150.20
            },
            '0987654321': {
                nombre: 'María',
                apellido: 'García',
                habitacion: '205',
                precioHabitacion: 200.00
            }
        };

        if (datosHuesped[cedula]) {
            const huesped = datosHuesped[cedula];

            document.getElementById('nombreHuesped').textContent = huesped.nombre;
            document.getElementById('apellidoHuesped').textContent = huesped.apellido;
            document.getElementById('cedulaHuesped').textContent = cedula;
            document.getElementById('numeroHabitacion').textContent = huesped.habitacion;
            document.getElementById('precioHabitacion').textContent = huesped.precioHabitacion.toFixed(2);
            document.getElementById('totalPagar').textContent = huesped.precioHabitacion.toFixed(2);
            document.getElementById('totalPagarInput').value = huesped.precioHabitacion;

            resumen.style.display = 'block';
            metodoPagoContainer.style.display = 'block';

        } else {
            alert('Huésped no encontrado');
            resumen.style.display = 'none';
            metodoPagoContainer.style.display = 'none';
        }
    }
</script>




</body>
</html>











