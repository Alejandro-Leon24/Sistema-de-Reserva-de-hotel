<?php
require_once __DIR__ . "/../Modelo/HuespedModelo.php";
require_once __DIR__ . "/../Vista/layout/modal.php";
class HuespedControlador
{
    public function RegistrarHuesped()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["guardar-huesped"])) {
            $Nombre = $_POST["nombre"];
            $Apellido = $_POST["apellido"];
            $Genero = $_POST["genero"];
            $T_Documento = $_POST["T_documento"];
            $N_Documento = $_POST["N_documento"];
            $Fecha_Nac = $_POST["fecha-nacimiento"];
            $Correo = $_POST["correo"];
            $huespedModelo = new HuespedModelo();
            $resultado = $huespedModelo->Registrar($Nombre, $Apellido, $Genero, $T_Documento, $N_Documento, $Fecha_Nac, $Correo);
            if ($resultado) {
                header("location: index.php?accion=registrar-huesped&mensaje=ok");
            } else {
                header("location: index.php?accion=registrar-huesped&mensaje=error");
            }
        }
    }


    public function formularioRegistrarHuesped()
    {
        if (isset($_SESSION["usuario"])) {
            $mensaje = $_GET["mensaje"] ?? "";
            if ($mensaje == "ok") {
                Exito("Huesped registrado con exito");
            } else if ($mensaje == "error") {
                Error("Error al registrar el huesped, intentelo denuevo");
            }
            require_once __DIR__ . "/../Vista/Huesped/Registrar-Huesped.php";
        } else {
            header("location: index.php?accion=iniciar_sesion");
        }
    }

    public function ListaTipoDocumento()
    {
        if (isset($_SESSION["usuario"])) {
            $HuespedModelo = new HuespedModelo();
            return $HuespedModelo->ListarTipoDocumento();
        } else {
            header("location: index.php?accion=iniciar_sesion");
        }
    }
    public function ListarHuesped()
    {
        if (isset($_SESSION["usuario"])) {
            $mensaje = $_GET["mensaje"] ?? "";
            $tipo = $_GET["tipo"] ?? "";
            if ($mensaje == "ok" && $tipo == "eliminar") {
                Exito("Huesped eliminado con exito.");
            } else if ($mensaje == "ok" && $tipo == "editar") {
                Exito("Huesped editado con exito.");
            }
            if ($mensaje == "error") {
                Error("Huesped no encontrado o ya editado, intentelo denuevo");
            }
            require_once __DIR__ . "/../Vista/Huesped/Listar-Huesped.php";
        } else {
            header("location: index.php?accion=iniciar_sesion");
        }
    }
    public function DatosHuesped()
    {
        if (isset($_SESSION["usuario"])) {
            $huespedModelo = new HuespedModelo();
            return $huespedModelo->ListarHuesped();
        } else {
            header("location: index.php?accion=iniciar_sesion");
        }
    }

    public function EditarHuesped()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar-huesped"])) {
            $ID = $_POST["ID"];
            $Nombre = $_POST["nombre"];
            $Apellido = $_POST["apellido"];
            $Genero = $_POST["genero"];
            $T_Documento = $_POST["T_documento"];
            $N_Documento = $_POST["N_documento"];
            $Fecha_Nac = $_POST["fecha-nacimiento"];
            $Correo = $_POST["correo"];
            $huespedModelo = new HuespedModelo();
            $resultado = $huespedModelo->editarHuesped($Nombre, $Apellido, $Genero, $T_Documento, $N_Documento, $Fecha_Nac, $Correo, $ID);

            if ($resultado) {
                header("location: index.php?accion=listar-huesped&mensaje=ok&tipo=editar");
            } else {
                header("location: index.php?accion=listar-huesped&mensaje=error");
            }
        }
    }

    public function EliminarHuesped()
    {
        $ID = $_GET["id"];
        $huespedModelo = new HuespedModelo();
        $resultado = $huespedModelo->EliminarHuesped($ID);

        if ($resultado) {
            header("location: index.php?accion=listar-huesped&mensaje=ok&tipo=eliminar");
        } else {
            header("location: index.php?accion=listar-huesped&mensaje=error");
        }
    }
    public function buscarPorCedula($cedula) {
        if (empty($cedula)) {
            echo json_encode(['error' => 'Cédula vacía']);
            return;
        }

        $modelo = new HuespedModelo();
        $huesped = $modelo->buscarPorCedula($cedula);

        echo json_encode($huesped ?: []);
    }
}
