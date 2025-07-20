<?php
require_once __DIR__ . '/../Config/Conexion.php';

class PagoModelo
{
    public function registrarPago(
        $numero_factura,
        $cedula,
        $nombre,
        $habitacion,
        $metodo,
        $total,
        $nombre_titular,
        $cedula_titular
    ) {
        try {
            $con = new Conexion();
            $pdo = $con->conectar();

            $sql = "INSERT INTO facturas (
                numero_factura, cedula_huesped, nombre_huesped, numero_habitacion, metodo_pago, total,
                nombre_titular, cedula_titular
            ) VALUES (
                :numero_factura, :cedula, :nombre, :habitacion, :metodo, :total,
                :nombre_titular, :cedula_titular
            )";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":numero_factura", $numero_factura);
            $stmt->bindParam(":cedula", $cedula);
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":habitacion", $habitacion);
            $stmt->bindParam(":metodo", $metodo);
            $stmt->bindParam(":total", $total);
            $stmt->bindParam(":nombre_titular", $nombre_titular);
            $stmt->bindParam(":cedula_titular", $cedula_titular);

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Error al registrar el pago: " . $e->getMessage());
            return false;
        }
    }

    public function buscarFacturas($termino)
    {
        $conexion = new Conexion();
        $pdo = $conexion->conectar();

        $sql = "SELECT * FROM facturas 
            WHERE estado != 'Eliminado' AND (nombre_huesped LIKE :buscar 
            OR cedula_huesped LIKE :buscar)
            ORDER BY fecha_emision DESC";

        $stmt = $pdo->prepare($sql);
        $buscarParam = "%$termino%";
        $stmt->bindParam(':buscar', $buscarParam, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerTodasFacturas()
    {
        try {
            $conexion = new Conexion();
            $pdo = $conexion->conectar();

            $sql = "SELECT * FROM facturas WHERE estado != 'Eliminado' ORDER BY fecha_emision DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener facturas: " . $e->getMessage());
            return []; // Retorna array vacío en caso de error
        }
    }
}
