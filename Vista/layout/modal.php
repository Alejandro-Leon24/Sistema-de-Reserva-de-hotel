<?php
function Error($mensaje)
{ ?>
    <dialog open>
        <article style="width: 350px;" class="animate__animated animate__fadeInDown">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" style="display: block; margin: 10px auto;">
                <mask id="lineMdCloseCircleFilled0">
                    <g fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="3">
                        <path fill="#fff" fill-opacity="0" stroke-dasharray="64" stroke-dashoffset="64" d="M12 3c4.97 0 9 4.03 9 9c0 4.97 -4.03 9 -9 9c-4.97 0 -9 -4.03 -9 -9c0 -4.97 4.03 -9 9 -9Z">
                            <animate fill="freeze" attributeName="fill-opacity" begin="0.33s" dur="0.275s" values="0;1" />
                            <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.33s" values="64;0" />
                        </path>
                        <path stroke="#000" stroke-dasharray="8" stroke-dashoffset="8" d="M12 12l4 4M12 12l-4 -4M12 12l-4 4M12 12l4 -4">
                            <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.605s" dur="0.11s" values="8;0" />
                        </path>
                    </g>
                </mask>
                <rect width="24" height="24" fill="#f90000" mask="url(#lineMdCloseCircleFilled0)" />
            </svg>
            <p style="text-align: center;">
                <?php echo $mensaje; ?>
            </p>
            <form method="dialog">
                <button style="justify-content: center; display: flex; margin: 0 auto;">Aceptar</button>
            </form>
        </article>
    </dialog>
<?php
}
function Exito($mensaje)
{
?>

    <dialog open>
        <article style="width: 350px;" class="animate__animated animate__fadeInDown">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" style="display: block; margin: 10px auto;">
                <mask id="lineMdConfirmCircleFilled0">
                    <g fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="3">
                        <path fill="#fff" fill-opacity="0" stroke-dasharray="64" stroke-dashoffset="64" d="M3 12c0 -4.97 4.03 -9 9 -9c4.97 0 9 4.03 9 9c0 4.97 -4.03 9 -9 9c-4.97 0 -9 -4.03 -9 -9Z">
                            <animate fill="freeze" attributeName="fill-opacity" begin="0.33s" dur="0.275s" values="0;1" />
                            <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.33s" values="64;0" />
                        </path>
                        <path stroke="#000" stroke-dasharray="14" stroke-dashoffset="14" d="M8 12l3 3l5 -5">
                            <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.605s" dur="0.11s" values="14;0" />
                        </path>
                    </g>
                </mask>
                <rect width="24" height="24" fill="#37dd1b" mask="url(#lineMdConfirmCircleFilled0)" />
            </svg>
            <p style="text-align: center;">
                <?php echo $mensaje; ?>
            </p>
            <form method="dialog">
                <button style="justify-content: center; display: flex; margin: 0 auto;">Aceptar</button>
            </form>
        </article>
    </dialog>

<?php
}
function Dialog_Editar()
{
?>
    <dialog id="Dialog_Editar">
        <?php $HuespedControlador = new HuespedControlador();
        $T_Documentos = $HuespedControlador->ListaTipoDocumento(); ?>
        <article class="animate__animated animate__fadeInDown" style="border-radius: 16px;">
            <form method="POST" action="index.php?accion=actualizarHuesped" class="form-registrar form-editar animate__animated animate__fadeIn">
                <div class="form-content">
                    <div class="row1">
                        <label for="nombre"><b>Nombres:</b></label>
                        <label for="genero"><b>Genero:</b></label>
                        <label for="documento"><b>Documento:</b></label>
                        <label for="fecha-nacimiento" style="position: relative; top: -5px;"><b>Fecha de nacimiento:</b></label>
                        <label for="correo" style="position: relative; top: -30px;"><b>Correo:</b></label>
                    </div>
                    <div class="row2">
                        <input type="text" name="ID" id="ID" hidden>
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
                            <input type="number" name="N_documento" id="N_documento" required>
                        </div>
                        <div class="grupo grupo-input">
                            <input type="date" required name="fecha-nacimiento" id="fecha-nacimiento">
                        </div>
                        <input type="email" name="correo" id="correo" placeholder="Correo" required>
                    </div>
                </div>
                <div class="botones">
                    <button class="boton-guardar" type="submit" name="editar-huesped">
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
                        <span>Editar</span>
                    </button>
                    <button class="boton-guardar pico-background-red-400" type="button" onclick="this.closest('dialog').close();">
                        <div class="svg-wrapper-1">
                            <div class="svg-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M10.03 8.97a.75.75 0 0 0-1.06 1.06L10.94 12l-1.97 1.97a.75.75 0 1 0 1.06 1.06L12 13.06l1.97 1.97a.75.75 0 0 0 1.06-1.06L13.06 12l1.97-1.97a.75.75 0 1 0-1.06-1.06L12 10.94z" />
                                    <path fill="currentColor" fill-rule="evenodd" d="M12.057 1.25h-.114c-2.309 0-4.118 0-5.53.19c-1.444.194-2.584.6-3.479 1.494c-.895.895-1.3 2.035-1.494 3.48c-.19 1.411-.19 3.22-.19 5.529v.114c0 2.309 0 4.118.19 5.53c.194 1.444.6 2.584 1.494 3.479c.895.895 2.035 1.3 3.48 1.494c1.411.19 3.22.19 5.529.19h.114c2.309 0 4.118 0 5.53-.19c1.444-.194 2.584-.6 3.479-1.494c.895-.895 1.3-2.035 1.494-3.48c.19-1.411.19-3.22.19-5.529v-.114c0-2.309 0-4.118-.19-5.53c-.194-1.444-.6-2.584-1.494-3.479c-.895-.895-2.035-1.3-3.48-1.494c-1.411-.19-3.22-.19-5.529-.19M3.995 3.995c.57-.57 1.34-.897 2.619-1.069c1.3-.174 3.008-.176 5.386-.176s4.086.002 5.386.176c1.279.172 2.05.5 2.62 1.069c.569.57.896 1.34 1.068 2.619c.174 1.3.176 3.008.176 5.386s-.002 4.086-.176 5.386c-.172 1.279-.5 2.05-1.069 2.62c-.57.569-1.34.896-2.619 1.068c-1.3.174-3.008.176-5.386.176s-4.086-.002-5.386-.176c-1.279-.172-2.05-.5-2.62-1.069c-.569-.57-.896-1.34-1.068-2.619c-.174-1.3-.176-3.008-.176-5.386s.002-4.086.176-5.386c.172-1.279.5-2.05 1.069-2.62" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <span>Cerrar</span>
                    </button>
                </div>
            </form>
        </article>
    </dialog>
<?php
}

function ver()
{
?>
    <dialog id="Ver-Informacion">
        <article class="box animate__animated animate__fadeInDown" style="border-radius: 16px;">
            <header class="modal-container-header">
                <span class="modal-container-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4">
                            <path stroke-dasharray="20" stroke-dashoffset="20" d="M5 21v-1c0 -2.21 1.79 -4 4 -4h4c2.21 0 4 1.79 4 4v1">
                                <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.15s" values="20;0" />
                            </path>
                            <path stroke-dasharray="20" stroke-dashoffset="20" d="M11 13c-1.66 0 -3 -1.34 -3 -3c0 -1.66 1.34 -3 3 -3c1.66 0 3 1.34 3 3c0 1.66 -1.34 3 -3 3Z">
                                <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.15s" dur="0.15s" values="20;0" />
                            </path>
                            <path stroke-dasharray="6" stroke-dashoffset="6" d="M20 3v4">
                                <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.375s" dur="0.15s" values="6;0" />
                                <animate attributeName="stroke-width" begin="0.75s" dur="2.25s" keyTimes="0;0.1;0.2;0.3;1" repeatCount="indefinite" values="2.4;3.5;3.5;2.4;2.4" />
                            </path>
                            <path stroke-dasharray="2" stroke-dashoffset="2" d="M20 11v0.01">
                                <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.525s" dur="0.15s" values="2;0" />
                                <animate attributeName="stroke-width" begin="0.975s" dur="2.25s" keyTimes="0;0.1;0.2;0.3;1" repeatCount="indefinite" values="2.4;3.5;3.5;2.4;2.4" />
                            </path>
                        </g>
                    </svg>
                    Información del Huesped
                </span>
            </header>
            <section class="modal-container-body rtf">
                <p id="Informacion-huesped"></p>
            </section>
            <footer class="modal-container-footer">
                <button class="button2 is-primary" onclick="this.closest('dialog').close();">Accept</button>
            </footer>
        </article>
    </dialog>


<?php } ?>