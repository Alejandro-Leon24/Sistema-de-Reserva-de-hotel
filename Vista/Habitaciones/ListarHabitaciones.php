<!DOCTYPE html>
<html lang="es" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.classless.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.colors.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/Styles.css">
    <title>Listar habitaciones</title>
    <style>
        table th, table td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <?php require_once __DIR__."/../layout/barra-navegacion.php"?>
    <a href="index.php?accion=inicio" class="btn btn-secondary m-4 mb-0 btn-sm">← Volver al Menú</a>
    <div class="container mt-2">
        <h2 class="text-center mb-4"><b>Lista de Habitaciones</b></h2>
        <main>
            <?php
                if (isset($_SESSION['mensaje'])) {
                    Exito($_SESSION['mensaje']);
                    unset($_SESSION['mensaje']);
                }
            ?>
            <form method="GET" action="index.php" class="row g-2 mb-4 align-items-center">
                <input type="hidden" name="accion" value="listarHabitaciones">

                <div class="col-auto d-flex me-auto">
                    <input type="search" style="height: 48px;" class="form-control me-2 mb-0" name="num_habitacion" placeholder="N° Habitación" value="<?= $_GET['num_habitacion'] ?? '' ?>">
                    <button type="submit" style="height: 48px;" class="btn btn-primary mb-0">Buscar</button>
                </div>
                
                <div class="col-auto ms-auto">
                    <select class="form-select" name="tipo_habitacion">
                        <option value="">Tipo</option>
                        <option value="Individual" <?= ($_GET['tipo_habitacion'] ?? '') == 'Individual' ? 'selected' : '' ?>>Individual</option>
                        <option value="Doble" <?= ($_GET['tipo_habitacion'] ?? '') == 'Doble' ? 'selected' : '' ?>>Doble</option>
                        <option value="Triple" <?= ($_GET['tipo_habitacion'] ?? '') == 'Triple' ? 'selected' : '' ?>>Triple</option>
                        <option value="Matrimonial" <?= ($_GET['tipo_habitacion'] ?? '') == 'Matrimonial' ? 'selected' : '' ?>>Matrimonial</option>
                        <option value="Suite" <?= ($_GET['tipo_habitacion'] ?? '') == 'Suite' ? 'selected' : '' ?>>Suite</option>
                    </select>
                </div>
                
                <div class="col-auto ms-auto">
                    <select class="form-select" style="width: 175px;" name="estado">
                        <option value="">Todos</option>
                        <option value="Activo" <?= ($_GET['estado'] ?? '') == 'Activo' ? 'selected' : '' ?>>Activo</option>
                        <option value="Inactivo" <?= ($_GET['estado'] ?? '') == 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
                    </select>
                </div>

                <div class="col-auto ms-auto">
                    <a href="index.php?accion=listarHabitaciones" class="btn btn-secondary">Refrescar</a>
                </div>
            </form>
            
            <table class="table ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Número de Habitación</th>
                        <th>Tipo de Habitación</th>
                        <th>Capacidad</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($habitaciones as $hab): ?>
                        <tr>
                            <td><?= htmlspecialchars($hab['ID']) ?></td>
                            <td><?= htmlspecialchars($hab['num_habitacion']) ?></td>
                            <td><?= htmlspecialchars($hab['tipo_habitacion']) ?></td>
                            <td><?= htmlspecialchars($hab['capacidad']) ?> personas</td>
                            <td>$<?= htmlspecialchars($hab['precio']) ?></td>
                            <td><?= htmlspecialchars($hab['estado']) ?></td>
                            <td>
                                <a href="#" title="Ver" data-bs-toggle="modal" data-bs-target="#modal-ver<?= $hab['ID'] ?>" class="text-primary me-3">
                                    <i class="bi bi-eye-fill fs-5"></i>
                                </a>
                                <a href="#" title="Editar" data-bs-toggle="modal" data-bs-target="#modal-editar<?= $hab['ID'] ?>" class="text-warning me-3">
                                    <i class="bi bi-pencil-fill fs-5"></i>
                                </a>
                                <a href="#" title="Eliminar" data-bs-toggle="modal" data-bs-target="#modal-eliminar<?= $hab['ID'] ?>" class="text-danger">
                                    <i class="bi bi-trash-fill fs-5"></i>
                                </a>
                            </td>
                        </tr>
                        <!--Modal Ver-->
                        <div class="modal fade" id="modal-ver<?= $hab['ID'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="titulo-modal-<?= $hab['ID'] ?>">Detalles de la Habitación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Número de Habitación:</strong> <?= $hab['num_habitacion'] ?></p>
                                        <p><strong>Tipo de Habitación:</strong> <?= $hab['tipo_habitacion'] ?></p>
                                        <p><strong>Capacidad:</strong> <?= $hab['capacidad'] ?> personas</p>
                                        <p><strong>Precio:</strong> $<?= number_format($hab['precio'], 2) ?></p>
                                        <p><strong>Servicios incluidos:</strong> <?= nl2br(htmlspecialchars($hab['servicios'])) ?></p>
                                        <p><strong>Descripción:</strong> <?= nl2br(htmlspecialchars($hab['descripcion'])) ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    </div>                            
                                </div>
                            </div>
                        </div>
                        <!--Modal Editar-->
                        <div class="modal fade" id="modal-editar<?= $hab['ID'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="titulo-modal-<?= $hab['ID'] ?>">Editar Habitación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="index.php?accion=actualizarHabitacion">
                                            <input type="hidden" name="id" value="<?= $hab['ID'] ?>">

                                            <label>Número de habitación:</label>
                                            <input type="number" name="numero" value="<?= $hab['num_habitacion'] ?>" required>

                                            <label>Tipo de habitación:</label>
                                            <select name="tipo" required>
                                                <option value="" selected disabled>- Seleccione una opción -</option>
                                                <option value="Individual" <?= $hab['tipo_habitacion'] == 'Individual' ? 'selected' : '' ?>>Individual</option>
                                                <option value="Doble" <?= $hab['tipo_habitacion'] == 'Doble' ? 'selected' : '' ?>>Doble</option>
                                                <option value="Triple" <?= $hab['tipo_habitacion'] == 'Triple' ? 'selected' : '' ?>>Triple</option>
                                                <option value="Matrimonial" <?= $hab['tipo_habitacion'] == 'Matrimonial' ? 'selected' : '' ?>>Matrimonial</option>
                                                <option value="Suite" <?= $hab['tipo_habitacion'] == 'Suite' ? 'selected' : '' ?>>Suite</option>
                                            </select>

                                            <br><br><label>Capacidad:</label>
                                            <input type="number" name="capacidad" value="<?= $hab['capacidad'] ?>" required>

                                            <label>Precio por noche:</label>
                                            <input type="number" step="0.01" name="precio" value="<?= $hab['precio'] ?>" required>

                                            <label>Servicios incluidos:</label>
                                            <div>
                                                <?php
                                                    $serviciosGuardados = explode(', ', $hab['servicios']);
                                                    $serviciosDisponibles = ['WiFi', 'TV', 'Aire acondicionado', 'Minibar'];
                                                    foreach ($serviciosDisponibles as $servicio):
                                                ?>
                                                    <input type="checkbox" name="servicios[]" value="<?= $servicio ?>" <?= in_array($servicio, $serviciosGuardados) ? 'checked' : '' ?>>
                                                    <label><?= $servicio ?></label>
                                                <?php endforeach; ?>
                                            </div>
                                            <br>
                                            
                                            <label>Descripción:</label>
                                            <textarea name="descripcion"><?= htmlspecialchars($hab['descripcion']) ?></textarea>
                                            
                                            <div class="d-flex justify-content-end gap-2 mt-3">
                                                <button type="submit" class="btn btn-primary w-50">Actualizar</button>
                                                <button type="button" class="btn btn-secondary w-50" data-bs-dismiss="modal">Cancelar</button>
                                            </div>
                                        </form>
                                    </div>                         
                                </div>
                            </div>
                        </div>
                        <!-- Modal Eliminar -->
                        <div class="modal fade" id="modal-eliminar<?= $hab['ID'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirmar Eliminación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Estás seguro de eliminar la habitación número <strong><?= $hab['num_habitacion'] ?></strong>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="index.php?accion=eliminarHabitacion&id=<?= $hab['ID'] ?>" class="btn btn-danger">
                                            Sí, eliminar
                                        </a>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selects = document.querySelectorAll('select[name="tipo_habitacion"], select[name="estado"]');
            selects.forEach(select => {
                select.addEventListener('change', function () {
                    this.form.submit();
                });
            });
        });
    </script>
</body>
</html>