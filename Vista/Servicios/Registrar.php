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
    <link rel="stylesheet" href="assets/css/Styles2.css">
    <title>Registrar Servicios</title>
</head>

<body>
    <?php require_once __DIR__ . "/../layout/barra-navegacion.php" ?>
    <main>
        <header>
            <a class="login-link" href="index.php?accion=inicio" style="display: inline-flex; align-items: start; gap: 5px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M20 11v2H8l5.5 5.5l-1.42 1.42L4.16 12l7.92-7.92L13.5 5.5L8 11z" stroke-width="0.5" stroke="currentColor" />
                </svg>
                Regresar
            </a>
        </header>

        <form action="index.php?accion=registro" method="POST" class="form-registrar animate__animated animate__fadeIn" style="width: 700px; margin: 0 auto;">
            <h2 style="width: 100%; text-align: center; margin: 0 0 30px;">Registre un Servicio</h2>
            <div class="grid">
                <div class="column1">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" placeholder="Ingrese el nombre del servicio" required>
                </div>
                <div class="column2">
                    <label for="precio">Precio:</label>
                    <input type="number" name="precio" id="precio" step="0.01" placeholder="Ingrese el precio del servicio" required>
                </div>
            </div>

            <label for="fecha">Fecha de creacion:</label>
            <input type="date" name="fecha" id="fecha" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" placeholder="Ingrese la descripción del servicio" required></textarea>

            <div class="botones" style="justify-content: center;">
                <button type="submit">Guardar</button>
                <button type="reset">Cancelar</button>
            </div>
        </form>
    </main>

</body>

</html>