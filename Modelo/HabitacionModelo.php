<?php require_once __DIR__ . '/../Config/Conexion.php'; 

class HabitacionModelo {
    public function registrarHabitacion($datos) {
        try{
            $pdo = (new Conexion())->conectar();

            $sql = "INSERT INTO habitacion (num_habitacion, tipo_habitacion, capacidad, precio, servicios, descripcion, estado)
                    VALUES (:num_habitacion, :tipo_habitacion, :capacidad, :precio, :servicios, :descripcion, :estado)";
            $stmt = $pdo->prepare($sql);
            
            return $stmt->execute([
                ':num_habitacion' => $datos['num_habitacion'],
                ':tipo_habitacion' => $datos['tipo_habitacion'],
                ':capacidad' => $datos['capacidad'],
                ':precio' => $datos['precio'],
                ':servicios' => implode(', ', $datos['servicios']),
                ':descripcion' => $datos['descripcion'],
                ':estado' => $datos['estado']
            ]);
        } catch (PDOException $e){
            error_log("Error en HabitacionModelo->registrarHabitacion: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerHabitaciones() {
        try {
            $pdo = (new Conexion())->conectar();
            $sql = "SELECT * FROM habitacion WHERE estado = 'Activo'";
            $stmt = $pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            error_log("Error en HabitacionModelo->obtenerHabitaciones: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerHabitacionPorId($id) {
        try{
            $pdo = (new Conexion())->conectar();
            $stmt = $pdo->prepare("SELECT * FROM habitacion WHERE ID = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            error_log("Error en HabitacionModelo->obtenerHabitacionPorId: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerHabitacionesConFiltros($datos) {
        $pdo = (new Conexion())->conectar();
        $sql = "SELECT * FROM habitacion WHERE 1=1";
        $filtros = [];
        
        if (!empty($datos['num_habitacion'])) {
            $sql .= " AND num_habitacion = :num_habitacion";
            $filtros[':num_habitacion'] = $datos['num_habitacion'];
        }
        
        if (!empty($datos['tipo_habitacion'])) {
            $sql .= " AND tipo_habitacion = :tipo_habitacion";
            $filtros[':tipo_habitacion'] = $datos['tipo_habitacion'];
        }

        if (!empty($datos['estado'])) {
            $sql .= " AND estado = :estado";
            $filtros[':estado'] = $datos['estado'];
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($filtros);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarHabitacion($datos) {
        try{
            $pdo = (new Conexion())->conectar();
            $sql = "UPDATE habitacion 
                    SET num_habitacion = :numero,
                        tipo_habitacion = :tipo,
                        capacidad = :capacidad,
                        precio = :precio,
                        servicios = :servicios,
                        descripcion = :descripcion
                    WHERE ID = :id";
            
            $stmt = $pdo->prepare($sql);
            
            return $stmt->execute([
                ':numero' => $datos['num_habitacion'],
                ':tipo' => $datos['tipo_habitacion'],
                ':capacidad' => $datos['capacidad'],
                ':precio' => $datos['precio'],
                ':servicios' => implode(', ', $datos['servicios']),
                ':descripcion' => $datos['descripcion'],
                ':id' => $datos['id']
            ]);
        } catch (PDOException $e){
            error_log("Error en HabitacionModelo->actualizarHabitacion: " . $e->getMessage());
            return false;
        }
    }

    public function eliminarHabitacion($id) {
        try{
            $pdo = (new Conexion())->conectar();
            $sql = "UPDATE habitacion SET estado = 'Inactivo' WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e){
            error_log("Error en HabitacionModelo->eliminarHabitacion: " . $e->getMessage());
            return false;
        }
    }
}
?>
