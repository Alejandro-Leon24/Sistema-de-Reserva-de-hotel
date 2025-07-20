<!DOCTYPE html>
<html lang="es" data-theme="light">
<?php
$HuespedControlador = new HuespedControlador();
$L_Huespedes = $HuespedControlador->DatosHuesped();
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
    <title>Consulta Huesped</title>
</head>

<body>
    <?php require_once __DIR__ . "/../layout/barra-navegacion.php";
    require_once __DIR__ . "/../layout/modal.php" ?>

    <main>
        <section style="display: flex;justify-content: space-between;">
            <a href="index.php?accion=registrar-huesped">
                <button class="boton-estatico pico-background-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M15 14c-2.67 0-8 1.33-8 4v2h16v-2c0-2.67-5.33-4-8-4m-9-4V7H4v3H1v2h3v3h2v-3h3v-2m6 2a4 4 0 0 0 4-4a4 4 0 0 0-4-4a4 4 0 0 0-4 4a4 4 0 0 0 4 4" />
                    </svg>
                    Agregar huesped
                </button>
            </a>
            <a href="index.php?accion=listar-huesped">
                
                <button class="boton-estatico button">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-arrow-repeat"
                        viewBox="0 0 16 16">
                        <path
                            d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"></path>
                        <path
                            fill-rule="evenodd"
                            d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"></path>
                    </svg>
                    Refresh
                </button>
            </a>
        </section>
        <section class="filtros">
            <div class="busqueda" role="search" style="height: 45px">
                <input name="search" type="search" placeholder="Nombre o Apellido" id="buscar" />
                <input type="button" value="Buscar" id="boton-buscar" />
            </div>
            <div class="filtros">
                <div style="display: flex; flex-direction: row; gap: 20px;">
                    <select name="estado" id="estado">
                        <option value="Activo" selected>Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                    <select name="genero" id="genero">
                        <option value="todos" selected>Todos</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <fieldset>
                    <legend><b>Rango de fecha</b></legend>
                    <input type="date" id="desde-fecha">
                    <input type="date" id="hasta-fecha">
                </fieldset>
            </div>
        </section>
        <section class="overflow-auto" style="max-height: 60vh;">
            <table class="animate__animated animate__fadeIn">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Nombre y Apellido</th>
                        <th>Tipo Documento</th>
                        <th>Nº Documento</th>
                        <th>Correo</th>
                        <th>Estado</th>
                        <th style="min-width: 150px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $contador = 1;
                    foreach ($L_Huespedes as $Huesped) : ?>
                        <tr>
                            <td><?php echo $contador++; ?></td>
                            <td><?php echo $Huesped["Nombre"] . " " . $Huesped["Apellido"]; ?></td>
                            <td><?php echo $Huesped["Tipo_Documento"] ?> </td>
                            <td><?php echo $Huesped["N_Documento"]; ?></td>
                            <td><?php echo $Huesped["Correo"]; ?></td>
                            <?php if ($Huesped["Estado"] == "Activo") {
                                $color = "green";
                            } else if ($Huesped["Estado"] == "Inactivo") {
                                $color = "red";
                            } ?>
                            <td><kbd style="background-color: <?php echo $color; ?>;"><?php echo $Huesped["Estado"]; ?></kbd></td>
                            <td>
                                <a onclick="AbrirInfor(<?php echo $Huesped['ID']; ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                        <g fill="none" stroke="#0b8d00" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5">
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0-4 0" />
                                            <path d="M12 18q-5.4 0-9-6q3.6-6 9-6t9 6m-5 7h6m-3-3v6" />
                                        </g>
                                    </svg></a>
                                <a onclick="Abrir(<?php echo $Huesped['ID']; ?>)"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="m21.7 13.35l-1 1l-2.05-2.05l1-1a.55.55 0 0 1 .77 0l1.28 1.28c.21.21.21.56 0 .77M12 18.94l6.06-6.06l2.05 2.05L14.06 21H12zM12 14c-4.42 0-8 1.79-8 4v2h6v-1.89l4-4c-.66-.08-1.33-.11-2-.11m0-10a4 4 0 0 0-4 4a4 4 0 0 0 4 4a4 4 0 0 0 4-4a4 4 0 0 0-4-4" stroke-width="0.5" stroke="currentColor" />
                                    </svg></a>
                                <a id="confirmar" href="index.php?accion=eliminar-huesped&id=<?php echo $Huesped['ID']; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                        <path fill="#f00" d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6zm2.46-7.12l1.41-1.41L12 12.59l2.12-2.12l1.41 1.41L13.41 14l2.12 2.12l-1.41 1.41L12 15.41l-2.12 2.12l-1.41-1.41L10.59 14zM15.5 4l-1-1h-5l-1 1H5v2h14V4z" />
                                    </svg></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <section>
            <?php Dialog_Editar();
            ver();
            ?>
        </section>
    </main>
    <script>
        window.L_Huespedes = <?php echo json_encode($L_Huespedes); ?>;
    </script>
    <script src="/assets/js/Listar-Huesped.js"></script>
</body>

</html>