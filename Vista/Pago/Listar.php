<?php
require_once __DIR__ . '/../../Config/Conexion.php';
require_once __DIR__ . "/../layout/barra-navegacion.php";

$conexion = new Conexion();
$pdo = $conexion->conectar();

$buscar = $_GET['buscar'] ?? '';

if (isset($_SESSION['mensaje'])) {
    echo '<div class="mensaje '.($_SESSION['tipo_mensaje'] ?? '').'">'.$_SESSION['mensaje'].'</div>';
    unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']);
}
if ($buscar) {
    $sql = "SELECT * FROM facturas 
            WHERE estado != 'Eliminado' AND (nombre_huesped LIKE :buscar 
            OR cedula_huesped LIKE :buscar)
            ORDER BY fecha_emision DESC";
    $stmt = $pdo->prepare($sql);
    $buscarParam = "%$buscar%";
    $stmt->bindParam(':buscar', $buscarParam, PDO::PARAM_STR);
} else {
    $sql = "SELECT * FROM facturas WHERE estado != 'Eliminado' ORDER BY fecha_emision DESC";
    $stmt = $pdo->prepare($sql);
}

$stmt->execute();
$facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalFacturas = count($facturas);
?>

<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="../../assets/css/Style_Facturas.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Listado de Facturas</title>
</head>
<body>
<main>
    <h2 class="titulo">Listado de Facturas</h2>
        <form method="GET" action="" class="form-buscador" style="margin-bottom: 1rem;">
            <input type="hidden" name="accion" value="listar_pagos">
            <input type="text" name="buscar" placeholder="Buscar por nombre o cédula" 
                value="<?php echo htmlspecialchars($buscar ?? ''); ?>">
            <button type="submit" class="buscar">Buscar</button>
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
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($totalFacturas > 0): ?>
            <?php foreach ($facturas as $fila): ?>
                <tr>
                    <td><?php echo htmlspecialchars($fila['numero_factura']); ?></td>
                    <td><?php echo htmlspecialchars($fila['nombre_huesped']); ?></td>
                    <td><?php echo htmlspecialchars($fila['cedula_huesped']); ?></td>
                    <td><?php echo htmlspecialchars($fila['numero_habitacion']); ?></td>
                    <td><?php echo htmlspecialchars($fila['metodo_pago']); ?></td>
                    <td>$<?php echo number_format($fila['total'], 2); ?></td>
                    <td><?php echo htmlspecialchars($fila['fecha_emision']); ?></td>
                    <td>
                        <div class="acciones-botones">
                            <button class="btn-ver" title="Ver"
                                data-id="<?php echo htmlspecialchars($fila['numero_factura']); ?>"
                                data-nombre="<?php echo htmlspecialchars($fila['nombre_huesped']); ?>"
                                data-cedula="<?php echo htmlspecialchars($fila['cedula_huesped']); ?>"
                                data-total="<?php echo htmlspecialchars($fila['total']); ?>"
                            >
                                <i class="fas fa-eye"></i>
                            </button>

                            <button class="btn-editar" title="Editar"
                                data-id="<?php echo htmlspecialchars($fila['numero_factura']); ?>"
                                data-nombre="<?php echo htmlspecialchars($fila['nombre_huesped']); ?>"
                                data-cedula="<?php echo htmlspecialchars($fila['cedula_huesped']); ?>"
                                data-total="<?php echo htmlspecialchars($fila['total']); ?>"
                            >
                                <i class="fas fa-pen"></i>
                            </button>

                            <form method="POST" action="index.php?accion=eliminar_factura" 
                                onsubmit="return confirm('¿Seguro que deseas eliminar esta factura?');">
                                <input type="hidden" name="id_factura" value="<?= htmlspecialchars($fila['numero_factura']) ?>">
                                <button type="submit" class="btn-eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="8">No hay facturas registradas</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="total-facturas">
        Total de facturas: <?php echo $totalFacturas; ?>
    </div>
</main>

<div id="modalVer" class="modal">
    <div class="modal-contenido">
        <h2>Información de Factura</h2>
        <p><strong>N° Factura:</strong> <span id="ver_id"></span></p>
        <p><strong>Nombre:</strong> <span id="ver_nombre"></span></p>
        <p><strong>Cédula:</strong> <span id="ver_cedula"></span></p>
        <p><strong>Total Pagado:</strong> $<span id="ver_total"></span></p>
        <button onclick="cerrarModal('modalVer')">Cerrar</button>
    </div>
</div>


<div id="modalEditar" class="modal">
    <div class="modal-contenido">
        <form method="POST" action="index.php?accion=editar_factura">
            <h2>Editar Factura</h2>
            <input type="hidden" name="id_factura" id="editar_id_factura" />
            <label for="editar_nombre">Nombre:</label>
            <input type="text" name="nombre" id="editar_nombre" required />
            <label for="editar_cedula">Cédula:</label>
            <input type="number" name="cedula" id="editar_cedula" required />
            <label for="editar_total">Total Pagado:</label>
            <input type="number" name="total" id="editar_total" step="0.01" required />
            <div style="margin-top:1rem;">
                <button type="submit" class="guardar">Guardar</button>
                <button type="button" onclick="cerrarModal('modalEditar')">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script src="../../assets/js/ListarPagos.js"></script>


</body>
</html>
