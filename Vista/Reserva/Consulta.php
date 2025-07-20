<?php
require_once __DIR__ . '/../../Modelo/ReservaModelo.php';
$modelo = new ReservaModelo();
$reservas = $modelo->listarReservas();
?>

<!DOCTYPE html>
<html lang="es" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservas registradas</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.classless.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.colors.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/Styles-Reserva.css">
</head>

<body>
  <?php include_once __DIR__ . '/../layout/barra-navegacion.php'; ?>
  <main class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="m-0">Reservas registradas</h3>

      <div class="d-flex align-items-center gap-2">                  <select id="estadoFiltro" class="form-select form-select-sm" style="height: 36px; width: 170px;"
          onchange="filtrarReservas()">
          <option value="">Todas</option>
          <option value="Reservada">Reservadas</option>
          <option value="Cancelada">Canceladas</option>
          <option value="Pagado">Pagadas</option>
        </select>

        <input type="date" id="fechaInicio" class="form-control form-control-sm"
          style="height: 34px; width: 180px;" oninput="filtrarPorFechas()">

        <span class="fw-semibold">a</span>

        <input type="date" id="fechaFin" class="form-control form-control-sm"
          style="height: 34px; width: 180px;" oninput="filtrarPorFechas()">
      </div>
    </div>


    <table class="table table-hover text-center align-middle"
      style="margin: 0 auto; max-width: 90%; width: fit-content;">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Cédula</th>
          <th>Correo</th>
          <th>Habitación</th>
          <th>Ingreso</th>
          <th>Salida</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($reservas) && is_array($reservas)): ?>
          <?php foreach ($reservas as $r): ?>
            <tr>
              <td><?= $r['ID'] ?></td>
              <td><?= $r['Nombre'] ?> <?= $r['Apellido'] ?></td>
              <td><?= $r['N_Documento'] ?></td>
              <td><?= $r['Correo'] ?></td>
              <td><?= "#" . $r["habitacion"] . " - " . ucfirst($r['tipo_habitacion']) ?></td>
              <td><?= $r['Fecha_Ingreso'] && $r['Fecha_Ingreso'] != '0000-00-00 00:00:00' ? date('d/m/Y H:i', strtotime($r['Fecha_Ingreso'])) : 'Sin fecha' ?></td>
              <td><?= $r['Fecha_Salida'] && $r['Fecha_Salida'] != '0000-00-00 00:00:00' ? date('d/m/Y H:i', strtotime($r['Fecha_Salida'])) : 'Sin fecha' ?></td>
              <td>
                <?php if ($r['Estado'] === 'Reservada'): ?>
                  <span class="badge bg-success">Reservada</span>
                <?php elseif ($r['Estado'] === 'Cancelada'): ?>
                  <span class="badge bg-danger">Cancelada</span>
                <?php elseif ($r['Estado'] === 'Pagado'): ?>
                  <span class="badge bg-info">Pagado</span>
                <?php elseif (empty($r['Estado'])): ?>
                  <span class="badge bg-secondary">Sin estado</span>
                <?php else: ?>
                  <span class="badge bg-warning text-dark"><?= htmlspecialchars($r['Estado']) ?></span>
                <?php endif; ?>
              </td>
              <td>
                <div class="d-flex justify-content-center gap-2">
                  <button type="button"
                    class="btn btn-outline-info btn-sm"
                    onclick="document.getElementById('modalReserva<?= $r['ID'] ?>').showModal()">
                    <i class="bi bi-eye-fill"></i>
                  </button>

                  <?php if ($r['Estado'] !== 'Pagado'): ?>
                    <button type="button"
                      class="btn btn-outline-warning btn-sm"
                      onclick="document.getElementById('modalEditar<?= $r['ID'] ?>').showModal()">
                      <i class="bi bi-pencil-square"></i>
                    </button>

                    <button type="button"
                      class="btn btn-outline-danger btn-sm"
                      onclick="document.getElementById('modalEliminar<?= $r['ID'] ?>').showModal()">
                      <i class="bi bi-trash3-fill"></i>
                    </button>
                  <?php else: ?>
                    <button type="button" class="btn btn-outline-secondary btn-sm" disabled title="No se puede editar una reserva pagada">
                      <i class="bi bi-pencil-square"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-sm" disabled title="No se puede eliminar una reserva pagada">
                      <i class="bi bi-trash3-fill"></i>
                    </button>
                  <?php endif; ?>
                </div>
              </td>
            </tr>

            <!-- Modales para cada reserva -->
            <!-- Modal Ver -->
            <dialog id="modalReserva<?= $r['ID'] ?>">
              <article style="display: flex; flex-direction: column; min-width: 320px;">
                <header style="display: flex; justify-content: space-between; align-items: center;">
                  <h4 class="m-0">Detalles de la reserva</h4>
                  <button type="button"
                    onclick="document.getElementById('modalReserva<?= $r['ID'] ?>').close()"
                    style="background: none; border: none; font-size: 1.1rem; color: #333;">
                    <i class="bi bi-x-lg"></i>
                  </button>
                </header>
                <p><strong>Nombre:</strong> <?= $r['Nombre'] ?> <?= $r['Apellido'] ?></p>
                <p><strong>Cédula:</strong> <?= $r['N_Documento'] ?></p>
                <p><strong>Correo:</strong> <?= $r['Correo'] ?></p>
                <p><strong>Habitación:</strong> <?= "#" . $r['habitacion'] ?> - <?= ucfirst($r['tipo_habitacion']) ?></p>
                <p><strong>Fecha ingreso:</strong> <?= !empty($r['Fecha_Ingreso']) && strtotime($r['Fecha_Ingreso']) !== false ? date('d/m/Y H:i', strtotime($r['Fecha_Ingreso'])) : 'Sin fecha' ?></p>
                <p><strong>Fecha salida:</strong> <?= !empty($r['Fecha_Salida']) && strtotime($r['Fecha_Salida']) !== false ? date('d/m/Y H:i', strtotime($r['Fecha_Salida'])) : 'Sin fecha' ?></p>

                <p><strong>Estado:</strong>
                  <?php if ($r['Estado'] === 'Reservada'): ?>
                    <span style="background-color: #198754; color: white; padding: 0.25em 0.6em; border-radius: 0.5em; font-weight: 500;">
                      Reservada
                    </span>
                  <?php elseif ($r['Estado'] === 'Cancelada'): ?>
                    <span style="background-color: #dc3545; color: white; padding: 0.25em 0.6em; border-radius: 0.5em; font-weight: 500;">
                      Cancelada
                    </span>
                  <?php elseif ($r['Estado'] === 'Pagado'): ?>
                    <span style="background-color: #0dcaf0; color: white; padding: 0.25em 0.6em; border-radius: 0.5em; font-weight: 500;">
                      Pagado
                    </span>
                  <?php else: ?>
                    <span style="background-color: #6c757d; color: white; padding: 0.25em 0.6em; border-radius: 0.5em;">
                      Sin estado
                    </span>
                  <?php endif; ?>
                </p>

                <?php if (!empty($r['Motivo'])): ?>
                  <p><strong>Motivo:</strong> <?= htmlspecialchars($r['Motivo']) ?></p>
                <?php endif; ?>
              </article>
            </dialog>

            <!-- Modal Editar -->
            <dialog id="modalEditar<?= $r['ID'] ?>">
              <article style="min-width: 320px; display: flex; flex-direction: column;">
                <header style="display: flex; justify-content: space-between; align-items: center;">
                  <h4 class="m-0">Actualizar reserva</h4>
                </header>

                <form method="post" action="index.php?accion=actualizar_reserva&id=<?= $r['ID'] ?>" oninput="mostrarMotivo<?= $r['ID'] ?>()">
                  <!-- Campo oculto para enviar el ID -->
                  <input type="hidden" name="ID" value="<?= $r['ID'] ?>">
                  <div class="grid">
                    <div class="column1">
                      <label for="nombre<?= $r['ID'] ?>">Nombre:</label>
                      <input type="text" id="Nombre<?= $r['ID'] ?>" name="Nombre" value="<?= htmlspecialchars($r['Nombre']) ?>" readonly required>
                    </div>
                    <div class="column2">
                      <label for="apellido<?= $r['ID'] ?>">Apellido:</label>
                      <input type="text" id="Apellido<?= $r['ID'] ?>" name="Apellido" value="<?= htmlspecialchars($r['Apellido']) ?>" readonly required>
                    </div>
                  </div>
                  <div class="grid">
                    <div class="column1">
                      <label for="cedula<?= $r['ID'] ?>">Cédula:</label>
                      <input type="text" id="Cedula<?= $r['ID'] ?>" name="Cedula" value="<?= $r['N_Documento'] ?>" readonly readonly>
                    </div>
                    <div class="column2">
                      <label for="correo<?= $r['ID'] ?>">Correo:</label>
                      <input type="email" id="Correo<?= $r['ID'] ?>" name="Correo" value="<?= $r['Correo'] ?>" readonly required>
                    </div>
                  </div>

                  <label for="habitacion<?= $r['ID'] . $r["habitacion_id"] ?> ">Tipo de habitación:</label>
                  <select id="habitacion<?= $r['ID'] ?>" name="habitacion" required>
                    <?php $habitaciones = $modelo->obtenerHabitacionesDisponibles($r["ID"]);
                    if (!empty($habitaciones)){$select = "selected";} ?>
                    <option value="" disabled <?php echo $select ?>>Seleccione una opción</option>
                    <?php foreach ($habitaciones as $h): ?>
                      <option value="<?= $h['ID'] ?>" <?= $h['ID'] == $r['habitacion_id'] ? 'selected' : '' ?>>
                        <?= "#" . $h["num_habitacion"] . " - " . ucfirst($h['tipo_habitacion']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>

                  <label for="fecha_ingreso<?= $r['ID'] ?>">Fecha ingreso:</label>
                  <input type="datetime-local" id="Fecha_Ingreso<?= $r['ID'] ?>" name="fecha_ingreso"
                    value="<?= !empty($r['Fecha_Ingreso']) && strtotime($r['Fecha_Ingreso']) !== false ? date('Y-m-d\TH:i', strtotime($r['Fecha_Ingreso'])) : '' ?>" required>

                  <label for="fecha_salida<?= $r['ID'] ?>">Fecha salida:</label>
                  <input type="datetime-local" id="Fecha_Salida<?= $r['ID'] ?>" name="fecha_salida"
                    value="<?= !empty($r['Fecha_Salida']) && strtotime($r['Fecha_Salida']) !== false ? date('Y-m-d\TH:i', strtotime($r['Fecha_Salida'])) : '' ?>" required>

                  <label for="estado<?= $r['ID'] ?>">Estado:</label>
                  <select id="estado<?= $r['ID'] ?>" name="estado" required onchange="mostrarMotivo<?= $r['ID'] ?>()">
                    <option value="Reservada" <?= $r['Estado'] === 'Reservada' ? 'selected' : '' ?>>Reservada</option>
                    <option value="Cancelada" <?= $r['Estado'] === 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>
                  </select>

                  <div id="motivoCancelacion<?= $r['ID'] ?>" style="display: <?= $r['Estado'] === 'Cancelada' ? 'block' : 'none' ?>;">
                    <label for="motivo<?= $r['ID'] ?>">Motivo de cancelación:</label>
                    <textarea id="motivo<?= $r['ID'] ?>" name="motivo"><?= htmlspecialchars($r['Motivo'] ?? '') ?></textarea>
                  </div>

                  <div style="display: flex; justify-content: flex-end; gap: 0.5rem; margin-top: 0.5rem;">
                    <button type="submit"
                      class="btn btn-primary btn-sm"
                      style="width: 300px;">
                      Guardar cambios
                    </button>
                    <button type="button"
                      class="btn btn-secondary btn-sm"
                      style="width: 300px;"
                      onclick="document.getElementById('modalEditar<?= $r['ID'] ?>').close()">
                      Cancelar
                    </button>
                  </div>
                </form>
              </article>

              <script>
                function mostrarMotivo<?= $r['ID'] ?>() {
                  const estado = document.getElementById("estado<?= $r['ID'] ?>").value;
                  const motivoDiv = document.getElementById("motivoCancelacion<?= $r['ID'] ?>");
                  motivoDiv.style.display = estado === "Cancelada" ? "block" : "none";
                }
              </script>
            </dialog>

            <!-- Modal Eliminar -->
            <dialog id="modalEliminar<?= $r['ID'] ?>">
              <article style="min-width: 320px; display: flex; flex-direction: column; gap: 0.6rem;">
                <header style="display: flex; justify-content: space-between; align-items: center;">
                  <h4 class="m-0">Eliminar reserva</h4>
                </header>

                <p><strong>¿Estás segura de que deseas eliminar esta reserva?</strong></p>

                <form method="post" action="index.php?accion=cancelar_reserva&id=<?= $r['ID'] ?>">
                  <div style="display: flex; justify-content: flex-end; gap: 0.5rem; margin-top: 0.5rem;">
                    <button type="submit" class="btn btn-primary btn-sm" style="width: 140px;">Eliminar</button>
                    <button type="button"
                      class="btn btn-secondary btn-sm"
                      style="width: 140px;"
                      onclick="document.getElementById('modalEliminar<?= $r['ID'] ?>').close()">
                      Cancelar
                    </button>
                  </div>
                </form>
              </article>
            </dialog>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="9" class="text-center">No hay reservas registradas.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </main>

  <script>
    function abrirModal(id) {
      const modal = document.getElementById(id);
      if (modal) modal.showModal();
    }
  </script>

  <script>
    document.querySelectorAll('.estado-select').forEach(select => {
      select.addEventListener('change', function() {
        const id = this.dataset.id;
        const motivoDiv = document.getElementById('motivoCancelacion' + id);
        motivoDiv.style.display = this.value === 'Cancelada' ? 'block' : 'none';
      });
    });
  </script>

  <script>
    function filtrarReservas() {
      const filtro = document.getElementById("estadoFiltro").value.trim();
      const filas = document.querySelectorAll("tbody tr");

      filas.forEach(fila => {
        const estado = fila.querySelector("td:nth-child(8)").textContent.trim();
        fila.style.display = (filtro === "" || estado === filtro) ? "" : "none";
      });
    }
  </script>

  <script>
    function filtrarPorFechas() {
      const inicio = document.getElementById("fechaInicio").value;
      const fin = document.getElementById("fechaFin").value;
      const filas = document.querySelectorAll("tbody tr");

      filas.forEach(fila => {
        const fechaTexto = fila.querySelector("td:nth-child(6)").textContent.trim();

        // Skip if no date or invalid date
        if (fechaTexto === "Sin fecha" || !fechaTexto) {
          fila.style.display = "none";
          return;
        }

        try {
          const [dia, mes, anioHora] = fechaTexto.split('/');
          const [anio, hora] = anioHora.split(' ');
          const fecha = new Date(`${anio}-${mes}-${dia}T${hora || '00:00'}`);

          // Check if date is valid
          if (isNaN(fecha.getTime())) {
            fila.style.display = "none";
            return;
          }

          const dentroRango =
            (!inicio || fecha >= new Date(inicio)) &&
            (!fin || fecha <= new Date(fin));

          fila.style.display = dentroRango ? "" : "none";
        } catch (error) {
          // Hide row if date parsing fails
          fila.style.display = "none";
        }
      });
    }
  </script>

</body>

</html>