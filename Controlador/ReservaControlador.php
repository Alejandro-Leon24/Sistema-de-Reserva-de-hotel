<?php
require_once __DIR__ . '/../Modelo/ReservaModelo.php';

class ReservaControlador
{
    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cedula        = trim($_POST['cedula'] ?? '');
            $habitacion    = $_POST['habitacion'] ?? '';
            $fecha_ingreso = $_POST['fecha_ingreso'] ?? '';
            $fecha_salida  = $_POST['fecha_salida'] ?? '';

            $modelo = new ReservaModelo();
            $id_huesped = $modelo->obtenerIdHuespedPorCedula($cedula);

            if (!$id_huesped) {
                header('Location: index.php?accion=Registrar&mensaje=error');
                exit;
            }

            if (strtotime($fecha_salida) <= strtotime($fecha_ingreso)) {
                header('Location: index.php?accion=Registrar&mensaje=fechas_invalidas');
                exit;
            }

            $reservaExistente = $modelo->existeReservaActivaPorCedula($cedula);
            if ($reservaExistente) {
                header('Location: index.php?accion=Registrar&mensaje=huesped_ocupado');
                exit;
            }

            $modelo->insertarReserva(
                $id_huesped,
                $habitacion,
                $fecha_ingreso,
                $fecha_salida
            );

            header('Location: index.php?accion=Registrar&mensaje=ok');
            exit;
        }
    }

    public function editar()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "<p class='text-center mt-5'>ID no proporcionado.</p>";
            return;
        }

        $modelo = new ReservaModelo();
        $reserva = $modelo->obtenerDetalleReserva($id);
        if (!$reserva) {
            echo "<p class='text-center mt-5'>Reserva no encontrada.</p>";
            return;
        }

        include_once __DIR__ . '/../Vista/Editar.php';
    }

    public function actualizar()
    {
        $id            = $_POST['ID'];
        $Habitacion   = $_POST['habitacion'];
        $fecha_ingreso = $_POST['fecha_ingreso'];
        $fecha_salida  = $_POST['fecha_salida'];
        $estado        = $_POST['estado'];
        $motivo        = ($estado === 'Cancelada') ? trim($_POST['motivo'] ?? '') : '';

        $modelo = new ReservaModelo();

        try {

            $modelo->actualizarReserva($id, [
                'habitacion'   => $Habitacion,
                'fecha_ingreso' => $fecha_ingreso,
                'fecha_salida'  => $fecha_salida,
                'estado'        => $estado,
                'motivo'        => $motivo
            ]);

            header('Location: index.php?accion=consultar&mensaje=ok');
            exit;

        } catch (Exception $e) {
            header('Location: index.php?accion=consultar&mensaje=error');
            exit;
        }
    }

    public function eliminar()
    {
        $id     = $_GET['id'];
        $motivo = trim($_POST['motivo'] ?? 'Cancelación manual');

        if ($id) {
            $modelo = new ReservaModelo();

            $modelo->EliminarReserva($id, [
                'estado' => 'Cancelada',
                'motivo' => $motivo
            ]);
        }

        header('Location: index.php?accion=consultar&mensaje=cancelada');
        exit;
    }
}
