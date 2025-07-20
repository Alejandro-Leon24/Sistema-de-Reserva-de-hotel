<!DOCTYPE html>
<html lang="es" data-theme="ligth">
<?php
$HuespedControlador = new HuespedControlador();
$T_Documentos = $HuespedControlador->ListaTipoDocumento();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.classless.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.colors.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="assets/css/Styles.css">
    <title>Registrar Huesped</title>
</head>

<body>
    <?php require_once __DIR__ . "/../layout/barra-navegacion.php" ?>
    <main>
        <header>
            <h3>Registrar Huesped</h3>
        </header>
        <form action="index.php?accion=form-huesped" method="post" class="form-registrar animate__animated animate__fadeIn">
            <div class="form-content">
                <div class="row1">
                    <label for="nombre"><b>Nombres:</b></label>
                    <label for="genero"><b>Genero:</b></label>
                    <label for="documento"><b>Documento:</b></label>
                    <label for="fecha-nacimiento"><b>Fecha de nacimiento:</b></label>
                    <label for="correo"><b>Correo:</b></label>
                </div>
                <div class="row2">
                    <div class="grupo grupo-input">
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre" required>
                        <input type="text" name="apellido" id="apellido" placeholder="Apellido" required>
                    </div>
                    <div class="grupo" style="margin-bottom: 25px;">
                        <input type="radio" name="genero" id="masculino" value="Masculino" required>
                        <label for="masculino">Masculino</label>
                        <input type="radio" name="genero" id="femenino" value="Femenino">
                        <label for="femenino">Femenino</label>
                        <input type="radio" name="genero" id="Otro" value="Otro">
                        <label for="Otro">Otro</label>
                    </div>
                    <div class="grupo grupo-input">
                        <select name="T_documento" id="documento" required>
                            <option value="" selected disabled>- Seleccione una opción -</option>
                            <?php foreach ($T_Documentos as $T_Documento) {
                                echo "<option value= '" . $T_Documento["ID"] . "'>" . $T_Documento["Nombre"] . "</option>";
                            }
                            ?>
                        </select>
                        <input type="number" name="N_documento" required>
                    </div>
                    <div class="grupo grupo-input">
                        <input type="date" required name="fecha-nacimiento" onchange="edad.innerText = 
                        new Date().getFullYear() - new Date(this.value).getFullYear()">
                        <label style="width: 100%;"> Tienes: <span id="edad">0</span> años</label>
                    </div>
                    <input type="email" name="correo" id="correo" placeholder="Correo" required>
                </div>
            </div>
            <div class="botones">
                <button class="boton-guardar" type="submit" name="guardar-huesped">
                    <div class="svg-wrapper-1">
                        <div class="svg-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                <g fill="none" fill-rule="evenodd">
                                    <path d="m12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036q-.016-.004-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.016-.018m.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092q.019.005.029-.008l.004-.014l-.034-.614q-.005-.019-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01z" />
                                    <path fill="currentColor" d="M15.586 3A2 2 0 0 1 17 3.586L19.414 6A2 2 0 0 1 20 7.414V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zM8 5H5v14h2v-5a2 2 0 0 1 2-2h5a2 2 0 0 1 2 2v5h2V7.414L15.586 5H15v2.5A1.5 1.5 0 0 1 13.5 9h-4A1.5 1.5 0 0 1 8 7.5zm6 9H9v5h5zm-1-9h-3v2h3z" />
                                </g>
                            </svg>
                        </div>
                    </div>
                    <span>Guardar</span>
                </button>
                <button class="boton-guardar" type=reset>
                    <div class="svg-wrapper-1">
                        <div class="svg-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M11 3h2v8h-2zm5 10H8c-1.65 0-3 1.35-3 3v5h2v-3c0-.55.45-1 1-1s1 .45 1 1v3h2v-3c0-.55.45-1 1-1s1 .45 1 1v3h2v-3c0-.55.45-1 1-1s1 .45 1 1v3h2v-5c0-1.65-1.35-3-3-3" opacity="0.15" />
                                <path fill="currentColor" d="M16 11h-1V3c0-1.1-.9-2-2-2h-2c-1.1 0-2 .9-2 2v8H8c-2.76 0-5 2.24-5 5v7h18v-7c0-2.76-2.24-5-5-5m-5-8h2v8h-2zm8 18h-2v-3c0-.55-.45-1-1-1s-1 .45-1 1v3h-2v-3c0-.55-.45-1-1-1s-1 .45-1 1v3H9v-3c0-.55-.45-1-1-1s-1 .45-1 1v3H5v-5c0-1.65 1.35-3 3-3h8c1.65 0 3 1.35 3 3z" />
                            </svg>
                        </div>
                    </div>
                    <span>Limpiar</span>
                </button>
            </div>
        </form>
    </main>
</body>

</html>