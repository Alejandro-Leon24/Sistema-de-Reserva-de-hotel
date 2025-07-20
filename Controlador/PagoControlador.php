<?php
require_once __DIR__ . '/../Modelo/PagoModelo.php';
require_once __DIR__ . '/../Modelo/HuespedModelo.php';
require_once __DIR__ . '/../Modelo/ReservaModelo.php';
require_once __DIR__ . '/../Config/Conexion.php';

class PagoControlador
{
    public function mostrarFormularioPago()
    {
        $buscar = $_GET['cedula'] ?? '';
        if ($buscar) {
            $reserva = new ReservaModelo();
            $existe = $reserva->existeReservaActivaPorCedula($buscar);
            if ($existe) {
                $modelo = new HuespedModelo();
                $huesped = $modelo->buscarPorCedula($buscar);
                $ResultadoReserva = $reserva->BuscarHabitacionPorId($huesped["ID"]);
            }else{
                $_SESSION['error_pago'] = "No hay reserva activa para esta cédula.";
            }
        }
        require_once __DIR__ . '/../Vista/Pago/Registrar.php';
    }
    public function mostrarListar()
    {
        if (!isset($_SESSION["usuario"])) {
            header("Location: index.php?accion=iniciar_sesion");
            exit;
        }
        $modelo = new PagoModelo();

        $buscar = $_GET['buscar'] ?? '';
        $facturas = $buscar ? $modelo->buscarFacturas($buscar) : $modelo->obtenerTodasFacturas();

        require_once __DIR__ . '/../Vista/Pago/Listar.php';
    }

    public function guardarPagoFinal()
    {
        $modelo = new PagoModelo();

        $numero_factura = 'FACT-' . date('Ymd') . '-' . rand(1000, 9999);
        $cedula = $_POST["cedula_huesped"];
        $nombre = $_POST["nombre_huesped"];
        $habitacion = $_POST["numero_habitacion"];
        $metodo = $_POST["metodo_pago"];
        $total = $_POST["precio_habitacion"];
        $nombre_titular = !empty($_POST["nombre_titular_tarjeta"]) ? $_POST["nombre_titular_tarjeta"] : $_POST["nombre_titular"];
        $cedula_titular = !empty($_POST["cedula_titular_tarjeta"]) ? $_POST["cedula_titular_tarjeta"] : $_POST["cedula_titular"];

        $resultado = $modelo->registrarPago(
            $numero_factura,
            $cedula,
            $nombre,
            $habitacion,
            $metodo,
            $total,
            $nombre_titular,
            $cedula_titular
        );

        if ($resultado) {
            $_SESSION['mensaje_exito'] = "Pago registrado correctamente";
            header("Location: index.php?accion=listar_pagos");
        } else {
            $_SESSION['error_pago'] = "Error al procesar el pago";
            header("Location: index.php?accion=registrar_pago");
        }
        exit;
    }

    public function eliminarFactura()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_factura'] ?? null;

            if ($id) {
                $conexion = new Conexion();
                $pdo = $conexion->conectar();

                $sql = "UPDATE facturas SET estado = 'Eliminado' WHERE numero_factura = ?";
                $stmt = $pdo->prepare($sql);

                if ($stmt->execute([$id])) {
                    $_SESSION['mensaje'] = "Factura eliminada correctamente";
                    $_SESSION['tipo_mensaje'] = "exito";
                } else {
                    $_SESSION['mensaje'] = "Error al eliminar la factura";
                    $_SESSION['tipo_mensaje'] = "error";
                }
            }
        }

        header("Location: index.php?accion=listar_pagos");
        exit;
    }


    public function editarFactura()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?accion=listar_pagos");
            exit;
        }

        $id = $_POST['id_factura'] ?? null;
        $nombre = $_POST['nombre'] ?? null;
        $cedula = $_POST['cedula'] ?? null;
        $total = $_POST['total'] ?? null;

        if (!$id || !$nombre || !$cedula || !$total) {
            $_SESSION['mensaje'] = "Datos incompletos";
            $_SESSION['tipo_mensaje'] = "error";
            header("Location: index.php?accion=listar_pagos");
            exit;
        }

        try {
            $conexion = new Conexion();
            $pdo = $conexion->conectar();

            $sql = "UPDATE facturas SET 
                nombre_huesped = :nombre,
                cedula_huesped = :cedula,
                total = :total
                WHERE numero_factura = :id";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':cedula', $cedula);
            $stmt->bindParam(':total', $total);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                $_SESSION['mensaje'] = "Factura actualizada correctamente";
                $_SESSION['tipo_mensaje'] = "exito";
            } else {
                $_SESSION['mensaje'] = "Error al actualizar";
                $_SESSION['tipo_mensaje'] = "error";
            }
        } catch (PDOException $e) {
            $_SESSION['mensaje'] = "Error en base de datos: " . $e->getMessage();
            $_SESSION['tipo_mensaje'] = "error";
        }

        header("Location: index.php?accion=listar_pagos");
        exit;
    }
}
