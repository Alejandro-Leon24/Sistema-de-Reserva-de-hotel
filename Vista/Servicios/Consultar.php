<!DOCTYPE html>
<html lang="en" data-theme="ligth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.classless.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.colors.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="assets/css/Styles.css">
    <link rel="stylesheet" href="assets/css/Styles-Servicios.css">
    <link rel="stylesheet" href="assets/css/Styles2.css">

    <title>Consultar Servicios</title>
    <style>
        fieldset{
            top: 0;
        }
        .filtros div{
            width: 320px;
        }
        .filtros select, .filtros input[type="date"], .filtros input[type="number"] {
            width: 150px;
        }
    </style>
</head>

<body>
    <?php require_once __DIR__ . "/../layout/barra-navegacion.php" ?>

    <main>
        <section style="display: flex;justify-content: space-between;">
            <a class="login-link" href="index.php?accion=inicio" style="display: inline-flex; align-items: start; gap: 5px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M20 11v2H8l5.5 5.5l-1.42 1.42L4.16 12l7.92-7.92L13.5 5.5L8 11z" stroke-width="0.5" stroke="currentColor" />
                </svg>
                Regresar
            </a>
        </section>

        <h3>Lista de Servicios Registrados</h3>

        <form method="GET" action="index.php" >
            <input type="hidden" name="accion" value="consultar-servicio">
            <section class="filtros" style="height: 100px; gap: 40px;">
                    <div style="width: 220px; margin-top: 38px">
                        <select id="filtro" name="estado" onchange="this.form.submit()" style="width: 220px;">
                            <option value="" selected disabled>- Filtrar por Estado -</option>
                            <option value="activo" <?= ($_GET['estado'] ?? '') == 'activo' ? 'selected' : '' ?>>Activo</option>
                            <option value="inactivo" <?= ($_GET['estado'] ?? '') == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                        </select>
                    </div>
                    <fieldset>
                        <legend for="filtrofechadesde"> <b>Rango de Fecha</b> </legend>
                        <div>
                            <input type="date" name="filtrofechadesde" value="<?= $_GET['filtrofechadesde'] ?? '' ?>">
                            <input type="date" name="filtrofechahasta" value="<?= $_GET['filtrofechahasta'] ?? '' ?>">
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend for="filtropreciodesde"> <b>Rango de Precio</b> </legend>
                        <div>
                            <input type="number" step="0.01" name="filtropreciodesde" placeholder="Desde" value="<?= $_GET['filtropreciodesde'] ?? '' ?>">
                            <input type="number" step="0.01" name="filtropreciohasta" placeholder="Hasta" value="<?= $_GET['filtropreciohasta'] ?? '' ?>">
                        </div>
                    </fieldset>

                    <div class="botones">
                        <button type="button" onclick="window.location.href='index.php?accion=consultar-servicio'">Refrescar</button>
                        <button type="submit">Buscar</button>
                    </div>
            </section>
        </form>


        <?php if (!empty($servicios)): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($servicios as $servicio): ?>
                        <tr>
                            <td> <?php echo htmlspecialchars($servicio['id']); ?> </td>
                            <td> <?php echo htmlspecialchars($servicio['nombre']); ?> </td>
                            <td> $<?php echo number_format($servicio['precio'], 2); ?> </td>
                            <td> <?php echo htmlspecialchars($servicio['fecha']); ?> </td>
                            <td> <?php echo htmlspecialchars($servicio['descripcion']); ?> </td>
                            <td> <?php echo htmlspecialchars($servicio['estado']); ?> </td>
                            <td style="display: flex; gap: 5px;">
                                <!-- Ver -->
                                <a onclick="mostrarModal('modal-ver-<?= $servicio['id'] ?>')" title="Ver">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-eye">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </a>

                                <!-- Editar -->
                                <a onclick="mostrarModal('modal-editar-<?= $servicio['id'] ?>')" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none"
                                        stroke="green" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-pencil">
                                        <path d="M12 20h9" />
                                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z" />
                                    </svg>
                                </a>

                                <!-- Eliminar -->
                                <a onclick="mostrarModal('modal-eliminar-<?= $servicio['id'] ?>')" title="Eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none"
                                        stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-trash">
                                        <path d="M3 6h18" />
                                        <path d="M8 6v14h8V6" />
                                        <path d="M10 10v6" />
                                        <path d="M14 10v6" />
                                        <path d="M5 6l1-2h12l1 2" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        <!-- Modal VER -->
                        <div class="modal" id="modal-ver-<?= $servicio['id'] ?>">
                            <div class="modal-content">
                                <span class="close-modal" onclick="cerrarModal('modal-ver-<?= $servicio['id'] ?>')">&times;</span>
                                <h2>Detalles del Servicio</h2>
                                <p><strong>Nombre:</strong> <?= $servicio['nombre'] ?></p>
                                <p><strong>Precio:</strong> $<?= number_format($servicio['precio'], 2) ?></p>
                                <p><strong>Fecha:</strong> <?= $servicio['fecha'] ?></p>
                                <p><strong>Descripción:</strong> <?= $servicio['descripcion'] ?></p>
                                <p><strong>Estado:</strong> <?= $servicio['estado'] ?></p>
                            </div>
                        </div>

                        <!-- Modal EDITAR -->
                        <div class="modal" id="modal-editar-<?= $servicio['id'] ?>">
                            <div class="modal-content">
                                <span class="close-modal" onclick="cerrarModal('modal-editar-<?= $servicio['id'] ?>')">&times;</span>
                                <h2>Editar Servicio</h2>
                                <form action="index.php?accion=editar-servicio" method="post">
                                    <input type="hidden" name="id" value="<?= $servicio['id'] ?>">
                                    <label>Nombre:</label>
                                    <input type="text" name="nombre" value="<?= htmlspecialchars($servicio['nombre']) ?>" required>
                                    <label>Precio:</label>
                                    <input type="number" name="precio" step="0.01" value="<?= $servicio['precio'] ?>" required>
                                    <label>Fecha:</label>
                                    <input type="date" name="fecha" value="<?= $servicio['fecha'] ?>" required>
                                    <label>Descripción:</label>
                                    <input type="text" name="descripcion" value="<?= htmlspecialchars($servicio['descripcion']) ?>" required>
                                    <div class="botones-menu">
                                        <button type="submit">Guardar cambios</button>
                                        <button type="reset" onclick="cerrarModal('modal-editar-<?= $servicio['id'] ?>')">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Modal ELIMINAR -->
                        <div class="modal" id="modal-eliminar-<?= $servicio['id'] ?>">
                            <div class="modal-content">
                                <span class="close-modal" onclick="cerrarModal('modal-eliminar-<?= $servicio['id'] ?>')">&times;</span>
                                <h2>¿Eliminar Servicio?</h2>
                                <p>¿Estás seguro de eliminar <strong><?= htmlspecialchars($servicio['nombre']) ?></strong>?</p>
                                <form action="index.php?accion=eliminar-servicio" method="post">
                                    <input type="hidden" name="id" value="<?= $servicio['id'] ?>">
                                    <div class="botones-menu">
                                        <button type="submit">Sí, eliminar</button>
                                        <button type="reset" onclick="cerrarModal('modal-eliminar-<?= $servicio['id'] ?>')">Cancelar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay servicios registrados.</p>
        <?php endif; ?>
    </main>

    <script>
        function mostrarModal(id) {
            document.getElementById(id).style.display = "flex";
        }

        function cerrarModal(id) {
            document.getElementById(id).style.display = "none";
        }
    </script>
</body>

</html>