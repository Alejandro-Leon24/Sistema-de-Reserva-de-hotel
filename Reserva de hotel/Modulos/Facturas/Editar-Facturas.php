<?php
include '../../conexion/conexion.php';

$facturas = [];
$mensaje = "";

// Si envían una cédula (buscar), se filtra; si no, muestra todas
if (isset($_GET['cedula']) && $_GET['cedula'] !== '') {
    $cedula = $_GET['cedula'];

    $stmt = $conexion->prepare("SELECT id, nombre_huesped, cedula_huesped, total FROM facturas WHERE cedula_huesped = ?");
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $result = $stmt->get_result();

    $facturas = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    if (count($facturas) == 0) {
        $mensaje = "No se encontraron facturas para la cédula: $cedula";
    }
} else {
    // Mostrar todas las facturas
    $query = "SELECT id, nombre_huesped, cedula_huesped, total FROM facturas";
    $result = $conexion->query($query);
    if ($result) {
        $facturas = $result->fetch_all(MYSQLI_ASSOC);
    }
}

// Manejo de la actualización (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_factura'])) {
    $id = $_POST['id_factura'];
    $nombre = $_POST['nombre'];
    $cedula = $_POST['cedula'];
    $total = $_POST['total'];

    $stmt = $conexion->prepare("UPDATE facturas SET nombre_huesped = ?, cedula_huesped = ?, total = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $nombre, $cedula, $total, $id);

    if ($stmt->execute()) {
        $mensaje = "Factura actualizada correctamente.";
    } else {
        $mensaje = "Error al actualizar la factura: " . $conexion->error;
    }
    $stmt->close();

    // Recargar datos después de actualizar para mostrar cambios
    if (isset($_GET['cedula']) && $_GET['cedula'] !== '') {
        $cedula = $_GET['cedula'];
        $stmt = $conexion->prepare("SELECT id, nombre_huesped, cedula_huesped, total FROM facturas WHERE cedula_huesped = ?");
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        $result = $stmt->get_result();
        $facturas = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    } else {
        $query = "SELECT id, nombre_huesped, cedula_huesped, total FROM facturas";
        $result = $conexion->query($query);
        if ($result) {
            $facturas = $result->fetch_all(MYSQLI_ASSOC);
        }
    }
}
?>

<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Facturas</title>
    <link rel="stylesheet" href="../../CSS/Styles.css" />
    <link rel="stylesheet" href="../../CSS/Style_Facturas.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
<header>
    <h1>Reserva de hotel</h1>
</header>

<nav class="menu">
        <ul>
            <li> <a href="../../index.html">Inicio</a></li>
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
                <a href="#">Factura</a>
                <ul class="submenu">
                    <li><a href="Registrar-Facturas.php">Registrar Factura</a></li>
                    <li><a href="Listar-Facturas.php">Mostrar Factura</a></li>
                    <li><a href="Editar-Facturas.php">Editar Factura</a></li>
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

<form class="formulario" method="GET" action="">
    <h2>Editar Factura</h2>
    <label for="cedula">Ingrese el número de cédula:</label>
    <input type="number" name="cedula" id="cedula" placeholder="EJ:0959087654" 
           value="<?php echo isset($_GET['cedula']) ? htmlspecialchars($_GET['cedula']) : ''; ?>">
    <button class="Enviar" type="submit">Buscar</button>
</form>

<?php if ($mensaje): ?>
    <p style="color: red; text-align:center;"><?php echo $mensaje; ?></p>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Nro</th>
            <th>Nombre</th>
            <th>Cédula</th>
            <th>Total Pagado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($facturas) > 0): ?>
            <?php foreach ($facturas as $index => $factura): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($factura['nombre_huesped']); ?></td>
                    <td><?php echo htmlspecialchars($factura['cedula_huesped']); ?></td>
                    <td>$<?php echo number_format($factura['total'], 2); ?></td>
                    <td class="acciones-editar">
                        <i class="fa-solid fa-pen fa-2x" onclick='mostrarModal(<?php echo json_encode($factura); ?>)'></i>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" style="text-align:center;">No hay facturas para mostrar.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div id="modal" class="modal">
    <div class="modal-contenido">
        <form method="POST" class="formulario" id="formEditarFactura">
            <h2>Información de Factura</h2>
            <input type="hidden" name="id_factura" id="id_factura" />
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" placeholder="Ingrese el nombre" required />
            <label for="cedulaModal">Cédula:</label>
            <input type="number" name="cedula" id="cedulaModal" placeholder="Ingrese el numero de cédula" required />
            <label for="total">Total Pagado:</label>
            <input type="number" name="total" id="total" placeholder="Ingrese total pagado" step="0.01" required />
            <div>
                <button type="submit" class="Enviar">Guardar</button>
                <button type="button" class="Cancelar" onclick="cerrarModal()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
function mostrarModal(factura) {
    document.getElementById("modal").style.display = "flex";
    document.getElementById("id_factura").value = factura.id;
    document.getElementById("nombre").value = factura.nombre_huesped;
    document.getElementById("cedulaModal").value = factura.cedula_huesped;
    document.getElementById("total").value = factura.total;
}

function cerrarModal() {
    document.getElementById("modal").style.display = "none";
}
</script>

</body>
</html>
