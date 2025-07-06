<?php
include '../../conexion/conexion.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_factura_eliminar'])) {
    $idEliminar = $_POST['id_factura_eliminar'];
    $stmt = $conexion->prepare("DELETE FROM facturas WHERE id = ?");
    $stmt->bind_param("i", $idEliminar);
    if ($stmt->execute()) {
        $mensaje = "Factura eliminada correctamente.";
    } else {
        $mensaje = "Error al eliminar factura: " . $conexion->error;
    }
    $stmt->close();
}

$facturas = [];
if (isset($_GET['buscar']) && $_GET['buscar'] !== '') {
    $buscar = "%" . $_GET['buscar'] . "%";
    $stmt = $conexion->prepare("SELECT id, nombre_huesped, cedula_huesped, total FROM facturas WHERE nombre_huesped LIKE ? OR cedula_huesped LIKE ?");
    $stmt->bind_param("ss", $buscar, $buscar);
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
    <h2>Eliminar Factura</h2>
    <label for="buscar">Buscar factura por nombre o cédula:</label>
    <input type="text" name="buscar" id="buscar" placeholder="Ingrese nombre o cédula" 
        value="<?php echo isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : ''; ?>" />
    <button class="Enviar" type="submit">Buscar</button>
</form>

<?php if ($mensaje): ?>
    <p style="color: green; text-align:center;"><?php echo $mensaje; ?></p>
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
        <?php if(count($facturas) > 0): ?>
            <?php foreach ($facturas as $index => $factura): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($factura['nombre_huesped']); ?></td>
                    <td><?php echo htmlspecialchars($factura['cedula_huesped']); ?></td>
                    <td>$<?php echo number_format($factura['total'], 2); ?></td>
                    <td class="acciones-editar">
                        <form method="POST" style="display:inline;" onsubmit="return confirmarEliminar('<?php echo htmlspecialchars($factura['nombre_huesped']); ?>')">
                            <input type="hidden" name="id_factura_eliminar" value="<?php echo $factura['id']; ?>" />
                            <button type="submit" class="btn-eliminar" title="Eliminar factura">
                                <i class="fa-solid fa-trash fa-2x" style="color:#d9534f;"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" style="text-align:center;">No hay facturas para mostrar.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
function confirmarEliminar(nombre) {
    return confirm("¿Estás seguro que deseas eliminar la factura de: " + nombre + "?");
}
</script>

</body>
</html>
