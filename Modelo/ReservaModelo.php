<?php
require_once __DIR__ . '/../config/Conexion.php';

class ReservaModelo
{
    private $db;

    public function __construct()
    {
        $con = new Conexion();
        $this->db = $con->Conectar();
    }

    public function obtenerHabitacionesDisponibles($idReserva = null)
    {
        // Primero obtenemos todas las habitaciones reservadas que no están canceladas
        $sql1 = "SELECT ID_Habitacion, ID FROM reserva WHERE Estado != 'Cancelada'";
        $stmt1 = $this->db->query($sql1);
        $reservas = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        
        // Creamos un array con las habitaciones reservadas
        $habitacionesReservadas = [];
        $habitacionDeReservaActual = null;
        
        foreach ($reservas as $reserva) {
            // Si estamos editando esta reserva específica, guardamos su habitación
            if ($idReserva !== null && $reserva['ID'] == $idReserva) {
                $habitacionDeReservaActual = $reserva['ID_Habitacion'];
            } else {
                // Almacenamos las demás habitaciones reservadas
                $habitacionesReservadas[] = $reserva['ID_Habitacion'];
            }
        }

        // Obtenemos todas las habitaciones activas
        $sql = "SELECT ID, num_habitacion, tipo_habitacion FROM habitacion WHERE estado = 'Activo'";
        $stmt = $this->db->query($sql);
        $habitaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Filtramos las habitaciones disponibles
        return array_filter($habitaciones, function ($habitacion) use ($habitacionesReservadas, $habitacionDeReservaActual) {
            // Una habitación está disponible si:
            // 1. No está en la lista de habitaciones reservadas, o
            // 2. Es la habitación de la reserva que estamos editando
            return !in_array($habitacion['ID'], $habitacionesReservadas) || 
                   $habitacion['ID'] == $habitacionDeReservaActual;
        });
    }

    public function obtenerIdHuespedPorCedula($cedula)
    {
        $sql = "SELECT ID FROM huesped WHERE N_Documento = :cedula";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? $resultado['ID'] : null;
    }

    public function existeReservaActivaPorCedula($cedula)
    {
        $sql = "SELECT COUNT(*) FROM reserva r
                JOIN huesped h ON r.ID_Huesped = h.ID
                WHERE h.N_Documento = :cedula AND r.Estado != 'Cancelada' AND r.Estado != 'Pagado'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function insertarReserva($id_huesped, $habitacion, $fecha_ingreso, $fecha_salida)
    {
        $sql = "INSERT INTO reserva (id_huesped, id_habitacion, fecha_ingreso, fecha_salida)
                VALUES (:id_huesped, :id_habitacion, :fecha_ingreso, :fecha_salida)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_huesped', $id_huesped);
        $stmt->bindParam(':id_habitacion', $habitacion);
        $stmt->bindParam(':fecha_ingreso', $fecha_ingreso);
        $stmt->bindParam(':fecha_salida', $fecha_salida);
        $stmt->execute();
    }

    public function listarReservas()
    {
        $sql = "SELECT r.ID, r.Fecha_Ingreso, r.Fecha_Salida, r.Estado, r.Motivo,
                    h.Nombre, h.Apellido, h.Correo, h.N_Documento,
                    ha.ID AS habitacion_id, ha.num_habitacion AS habitacion, ha.tipo_habitacion
                FROM reserva r
                INNER JOIN huesped h ON r.ID_Huesped = h.ID
                INNER JOIN habitacion ha ON r.ID_Habitacion = ha.ID
                ORDER BY r.ID ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function obtenerDetalleReserva($id)
    {
        $sql = "SELECT r.ID, r.Fecha_Ingreso, r.Fecha_Salida, r.Estado, r.Motivo,
                       h.N_Documento, h.Nombre, h.Apellido, h.Correo,
                       ha.num_habitacion AS Habitacion, ha.tipo_habitacion
                FROM reserva r
                JOIN huesped h ON r.ID_Huesped = h.ID
                JOIN habitacion ha ON r.ID_Habitacion = ha.ID
                WHERE r.ID = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarReserva($id, $datos)
    {
        $sql = "UPDATE reserva SET 
                    ID_Habitacion = :habitacion,
                    Fecha_Ingreso = :fecha_ingreso,
                    Fecha_Salida  = :fecha_salida,
                    Estado        = :estado,
                    Motivo        = :motivo
                WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':habitacion',   $datos['habitacion']);
        $stmt->bindParam(':fecha_ingreso', $datos['fecha_ingreso']);
        $stmt->bindParam(':fecha_salida',  $datos['fecha_salida']);
        $stmt->bindParam(':estado',        $datos['estado']);
        $stmt->bindParam(':motivo',        $datos['motivo']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    public function EliminarReserva($id, $datos)
    {
        $sql = "UPDATE reserva SET 
                    Estado        = :estado,
                    Motivo        = :motivo
                WHERE ID = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':estado',        $datos['estado']);
        $stmt->bindParam(':motivo',        $datos['motivo']);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    public function BuscarHabitacionPorId($id)
    {
        $sql = "SELECT ID ,ID_Habitacion FROM reserva WHERE ID_Huesped = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() > 0) {
            $sentencia = "SELECT num_habitacion, precio from habitacion WHERE ID = :id";
            $stmt2 = $this->db->prepare($sentencia);
            $stmt2->bindParam(':id', $resultado['ID_Habitacion'], PDO::PARAM_INT);
            $stmt2->execute();
            return $stmt2->fetch(PDO::FETCH_ASSOC);
        }
    }
}
