<?php
require_once __DIR__ . '/../Modelo/HabitacionModelo.php';

class HabitacionControlador {
    public function guardar() {
        $datos = [
            'num_habitacion' => $_POST['numero'],
            'tipo_habitacion' => $_POST['tipo'],
            'capacidad' => $_POST['capacidad'],
            'precio' => $_POST['precio'],
            'servicios' => $_POST['servicios'] ?? [],
            'descripcion' => $_POST['descripcion'],
            'estado' => 'Activo'
        ];

        $habitacionModelo = new HabitacionModelo();
        if ($habitacionModelo->registrarHabitacion($datos)) {
            $_SESSION['mensaje'] = "Habitación registrada con éxito";
            header("Location: index.php?accion=listarHabitaciones");
        } else {
            echo "Error al registrar habitación";
        }
        exit;
    }

    public function mostrarFormularioRegistro() {
        $mensaje = $_GET["mensaje"] ?? "";
            if($mensaje == "ok"){
                Exito("Habitación registrada con éxito");
            } 
        require_once __DIR__ . '/../Vista/Habitaciones/RegistrarHabitaciones.php';
    }

    public function listarHabitaciones($filtros = []) {
        $modelo = new HabitacionModelo();

        if (empty($filtros)) {
            $habitaciones = $modelo->obtenerHabitacionesConFiltros(['estado' => 'Activo']);
        } else {
        $habitaciones = $modelo->obtenerHabitacionesConFiltros($filtros);
        }

        require_once __DIR__ . '/../Vista/Habitaciones/ListarHabitaciones.php';
    }

    public function actualizarHabitacion() {
        $datos = [
            'id' => $_POST['id'],
            'num_habitacion' => $_POST['numero'],
            'tipo_habitacion' => $_POST['tipo'],
            'capacidad' => $_POST['capacidad'],
            'precio' => $_POST['precio'],
            'servicios' => $_POST['servicios'] ?? [],
            'descripcion' => $_POST['descripcion']
        ];

        $habitacionModelo = new HabitacionModelo();
        if ($habitacionModelo->actualizarHabitacion($datos)) {
            $_SESSION['mensaje'] = "Habitación actualizada con éxito";
            header("Location: index.php?accion=listarHabitaciones&mensaje=editado");
        } else {
            echo "Error al actualizar habitación.";
        }
        exit;
    }

    public function eliminarHabitacion() {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $habitacionModelo = new HabitacionModelo();
            if ($habitacionModelo->eliminarHabitacion($id)) {
                $_SESSION['mensaje'] = "Habitación eliminada con éxito";
                header("Location: index.php?accion=listarHabitaciones&mensaje=eliminado");
            } else {
                echo "Error al eliminar habitación.";
            }
        } else {
            echo "ID no válido.";
        }
        exit;
    }
}
?>