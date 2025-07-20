<?php
    require_once __DIR__ . "/../Config/Conexion.php";

    class ServicioModelo{
        public function guardar($params){
            try{
                $conexion = new Conexion();
                $conn = $conexion->Conectar();

                $sql = "INSERT INTO servicios (nombre, precio, fecha, descripcion)
                        VALUES (:nombre, :precio, :fecha, :descripcion)";

                $stmt = $conn->prepare($sql);
                return $stmt->execute([':nombre' => $params['nombre'], 
                            ':precio' => $params['precio'],
                            ':fecha' => $params['fecha'],
                            ':descripcion' => $params['descripcion']
                        ]);
            }catch(PDOException $e){
                error_log("Error en Servicio-Modelo->guardar: " . $e->getMessage());
            }
        }

        public function obtenerRegistroServicios(){
            try {
                $conexion = new Conexion();
                $conn = $conexion->Conectar();

                $sql = "SELECT * FROM servicios ORDER BY fecha DESC";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch(PDOException $e) {
                error_log("Error en Servicio-Modelo->ObtenerRegistroServicios: " . $e->getMessage());
                return [];
            }
        }

        public function obtenerServiciosPorFiltro($filtros){
            try {
                $conexion = new Conexion();
                $conn = $conexion->Conectar();

                $sql = "SELECT * FROM servicios
                        WHERE (:estado IS NULL OR estado = :estado)
                        AND (:fechaDesde IS NULL OR fecha >= :fechaDesde)
                        AND (:fechaHasta IS NULL OR fecha <= :fechaHasta)
                        AND (:precioDesde IS NULL OR precio >= :precioDesde)
                        AND (:precioHasta IS NULL OR precio <= :precioHasta)
                        ORDER BY fecha DESC";

                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    ':estado' => $filtros['estado'] ?: null,
                    ':fechaDesde' => $filtros['fechaDesde'] ?: null,
                    ':fechaHasta' => $filtros['fechaHasta'] ?: null,
                    ':precioDesde' => $filtros['precioDesde'] ?: null,
                    ':precioHasta' => $filtros['precioHasta'] ?: null,
                    ]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                    error_log("Error en Servicio-Modelo->obtenerServiciosPorFiltro: " . $e->getMessage());
                    return [];
            }
        }

        public function actualizar($id, $nombre, $precio, $fecha, $descripcion){
            try {
                $conexion = new Conexion();
                $conn = $conexion->Conectar();

                $sql = "UPDATE servicios 
                    SET nombre = :nombre, 
                        precio = :precio, 
                        fecha = :fecha, 
                        descripcion = :descripcion 
                    WHERE id = :id";

                $stmt = $conn->prepare($sql);
            
                return $stmt->execute([
                    ':nombre' => $nombre,
                    ':precio' => $precio,
                    ':fecha' => $fecha,
                    ':descripcion' => $descripcion,
                    ':id' => $id
            ]);
            } catch (PDOException $e) {
                error_log("Error en ServicioModelo->actualizar: " . $e->getMessage());
                return false;
            }
        }

        public function eliminar($id){
            try {
                $conexion = new Conexion();
                $conn = $conexion->Conectar();

                $sql = "UPDATE servicios SET estado = 'inactivo' WHERE id = :id";
                $stmt = $conn->prepare($sql);
                
                return $stmt->execute([':id' => $id]);
            } catch (PDOException $e) {
                error_log("Error en ServicioModelo->eliminar: " . $e->getMessage());
                return false;
            }
        }
    }
?>