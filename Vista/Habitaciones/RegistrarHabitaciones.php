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

    <title>Registrar habitaciones</title>
</head>

<body>
    <?php require_once __DIR__ . "/../layout/barra-navegacion.php" ?>
    <a href="index.php?accion=inicio" class="btn btn-secondary m-4 mb-0 btn-sm">← Volver al Menú</a>
    <main style="max-width: 650px;">
        <h2 style="text-align: center;"><b>Registrar Habitación</b></h2><br>
        <form action="index.php?accion=guardarHabitacion" method="post">
            <div class="grid">
                <div class="column1">
                    <label>Número de habitación:</label>
                    <input type="number" name="numero" placeholder="Número de habitación" required>
                </div>
                <div class="column2">
                    <label>Tipo de habitación:</label>
                    <select name="tipo" required>
                        <option value="" selected disabled>- Seleccione una opción -</option>
                        <option value="Individual">Individual</option>
                        <option value="Doble">Doble</option>
                        <option value="Triple">Triple</option>
                        <option value="Matrimonial">Matrimonial</option>
                        <option value="Suite">Suite</option>
                    </select>
                </div>
            </div>
            <div class="grid">
                <div class="column1">
                    <label>Capacidad: <input type="number" id="capacidad-numero" name="capacidad" min="1" readonly required style="width: 60px; height: 40px; padding: 10px; font-size: 16px; margin: 0;"></label>
                    <div style="display: flex; align-items: center;">
                        <input type="range" name="capacidad" min="1" max="10" value="1" oninput="document.getElementById('capacidad-numero').value = this.value">
                    </div>
                </div>
                <div class="column2">
                    <label>Precio por noche:</label>
                    <input type="number" step="0.01" min="0" name="precio" placeholder="Precio de la habitación" required>
                </div>
            </div>

            <label>Servicios incluidos:</label>
            <div>
                <input type="checkbox" name="servicios[]" value="WiFi" id="WiFi">
                <label for="WiFi">WiFi</label>

                <input type="checkbox" name="servicios[]" value="TV" id="TV">
                <label for="TV">TV</label>

                <input type="checkbox" name="servicios[]" value="Aire acondicionado" id="Aire_acondicionado">
                <label for="Aire_acondicionado">Aire acondicionado</label>

                <input type="checkbox" name="servicios[]" value="Minibar" id="Minibar">
                <label for="Minibar">Minibar</label>
            </div>
            <br>

            <label>Descripción:</label>
            <textarea name="descripcion"></textarea>
            <br>

            <div style="display: flex; justify-content: space-between; gap: 20px;">
                <button type="submit" style="width: 300px;">Registrar</button>
                <button type="reset" style="width: 300px;">Cancelar</button>
            </div>
        </form>
    </main>
</body>

</html>