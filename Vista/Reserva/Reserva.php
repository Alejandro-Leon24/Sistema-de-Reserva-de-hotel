<?php
require_once __DIR__ . '/../../Modelo/ReservaModelo.php';
$modelo = new ReservaModelo();
$habitaciones = $modelo->obtenerHabitacionesDisponibles();
?>

<!DOCTYPE html>
<html lang="es" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reserva habitación</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.classless.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.colors.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/css/Styles-Reserva.css">
</head>

<body>
  <?php include_once __DIR__ . '/../layout/barra-navegacion.php'; ?>

  <main style="padding: 0; margin: 40px auto;">
    <h2 class="text-center mb-1"><strong>Reserva de habitación</strong></h2>

    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'huesped_ocupado'): ?>
      <div id="alerta-huesped" class="alert alert-warning text-center" role="alert">
        El huésped ya tiene una habitación reservada
      </div>
    <?php endif; ?>

    <div id="info-huesped" class="alert d-none text-center fw-bold py-2 px-3"></div>

    <div class="d-flex justify-content-center">
      <form method="post" action="index.php?accion=guardar_reserva" id="form-reserva" class="w-100" style="max-width: 600px;">

        <fieldset class="mt-2 mb-3 p-2 rounded bg-light">
          <legend><strong>Datos de reserva</strong></legend>

          <label for="cedula">Cédula del huésped:</label>
          <div class="d-flex gap-2">
            <input type="search" id="cedula" name="cedula" class="form-control w-70" placeholder="Buscar cédula" maxlength="10" required>
            <button type="button" class="btn btn-sm btn-outline-primary px-3 py-2" onclick="buscarHuesped()">
              Buscar
            </button>
          </div>
          <div class="grid">
            <div class="column1">
              <label for="nombre">Nombre:</label>
              <input type="text" id="nombre" name="nombre" class="form-control w-70" readonly>
            </div>
            <div class="column2">
              <label for="apellido">Apellido:</label>
              <input type="text" id="apellido" name="apellido" class="form-control w-70" readonly>
            </div>
          </div>
          <label for="correo">Correo:</label>
          <input type="email" id="correo" name="correo" class="form-control w-70" readonly>

          <label for="habitacion">Tipo de habitación:</label>
          <select id="habitacion" name="habitacion" class="form-select w-70" required>
            <option value="">Seleccione una opción</option>
            <?php foreach ($habitaciones as $h): ?>
              <option value="<?= $h['ID'] ?>"><?= "#" . $h["num_habitacion"] . " - " . ucfirst($h['tipo_habitacion']) ?></option>
            <?php endforeach; ?>
          </select>

          <label for="fecha_ingreso">Fecha de ingreso:</label>
          <input type="datetime-local" id="fecha_ingreso" name="fecha_ingreso" class="form-control w-70" required>

          <label for="fecha_salida">Fecha de salida:</label>
          <input type="datetime-local" id="fecha_salida" name="fecha_salida" class="form-control w-70" required>
        </fieldset>

        <div class="text-end mt-2 mb-0">
          <button type="submit" class="btn btn-primary w-60 py-2">
            Guardar reserva
          </button>
        </div>
      </form>
    </div>
  </main>

  <script>
    function mostrarMensaje(texto, tipo = 'info') {
      const info = document.getElementById("info-huesped");
      info.className = "alert text-center fw-bold py-2 px-3";

      if (tipo === "success") {
        info.classList.add("alert-success");
      } else if (tipo === "warning") {
        info.classList.add("alert-warning");
      } else if (tipo === "danger") {
        info.classList.add("alert-danger");
      } else {
        info.classList.add("alert-info");
      }

      info.textContent = texto;
      info.classList.remove("d-none");

      setTimeout(() => {
        info.classList.add("d-none");
      }, 3000);
    }

    function buscarHuesped() {
      const cedula = document.getElementById("cedula").value.trim();
      if (!cedula) {
        mostrarMensaje("Ingrese una cédula para buscar", "warning");
        return;
      }

      fetch(`index.php?accion=buscar_huesped&cedula=${cedula}`)
        .then(response => response.json())
        .then(data => {
          if (data && data.Nombre) {
            document.getElementById("nombre").value = data.Nombre;
            document.getElementById("apellido").value = data.Apellido;
            document.getElementById("correo").value = data.Correo;
            mostrarMensaje("Huésped encontrado", "success");

          } else {
            document.getElementById("nombre").value = "";
            document.getElementById("apellido").value = "";
            document.getElementById("correo").value = "";
            mostrarMensaje("No se encontró el huésped", "danger");
          }
        })
        .catch(error => {
          console.error("Error al buscar huésped:", error);
          mostrarMensaje("Error al consultar el huésped", "danger");
        });
    }
    setTimeout(() => {
      const alerta = document.getElementById("alerta-huesped");
      if (alerta) alerta.remove();
    }, 3000);
  </script>
</body>

</html>