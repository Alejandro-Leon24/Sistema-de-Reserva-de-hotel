<?php
include '../../conexion/conexion.php';
$result = $conexion->query("SELECT COUNT(*) AS total_facturas FROM facturas");
$totalFacturas = 0;
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalFacturas = $row['total_facturas'];
}

$facturas = [];
if (isset($_GET['buscar']) && $_GET['buscar'] !== '') {
    $buscar = "%" . $_GET['buscar'] . "%";
    $stmt = $conexion->prepare("SELECT * FROM facturas WHERE nombre_huesped LIKE ? OR cedula_huesped LIKE ? ORDER BY fecha_emision DESC");
    $stmt->bind_param("ss", $buscar, $buscar);
    $stmt->execute();
    $result = $stmt->get_result();
    $facturas = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    $query = "SELECT * FROM facturas ORDER BY fecha_emision DESC";
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
    <title>Listar Facturas</title>
    <link rel="stylesheet" href="../../CSS/Styles.css" />
    <link rel="stylesheet" href="../../CSS/Style_Facturas.css" />
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
                    <li><a href="Registrar-Facturas.php">Registrar Factura</a></li>
                    <li><a href="Listar-Facturas.php">Mostrar Factura</a></li>
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
        <h2>Listado de Facturas</h2>

        <p><strong>Total de facturas:</strong> <?php echo $totalFacturas; ?></p>

        <form method="GET" action="Listar-Facturas.php" style="margin-bottom: 1em;">
            <input
                type="text"
                name="buscar"
                placeholder="Buscar por nombre o cédula"
                value="<?php echo isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : ''; ?>"
            />
            <button type="submit">Buscar</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>N° Factura</th>
                    <th>Huésped</th>
                    <th>Cédula</th>
                    <th>Habitación</th>
                    <th>Método Pago</th>
                    <th>Total</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($facturas) > 0): ?>
                    <?php foreach ($facturas as $fila): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($fila['numero_factura']); ?></td>
                            <td><?php echo htmlspecialchars($fila['nombre_huesped']); ?></td>
                            <td><?php echo htmlspecialchars($fila['cedula_huesped']); ?></td>
                            <td><?php echo htmlspecialchars($fila['numero_habitacion']); ?></td>
                            <td><?php echo htmlspecialchars($fila['metodo_pago']); ?></td>
                            <td>$<?php echo htmlspecialchars($fila['total']); ?></td>
                            <td><?php echo htmlspecialchars($fila['fecha_emision']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7">No hay facturas registradas</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
