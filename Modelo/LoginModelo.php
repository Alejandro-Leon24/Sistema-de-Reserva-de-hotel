<?php
require_once __DIR__ . "/../Config/Conexion.php";

class LoginModelo
{
    public function Autenticar($usuario, $clave)
    {
        try {
            $con = new Conexion();
            $conexion = $con->Conectar();
            $sentencia = "SELECT * from usuario where Correo = :usuario and Contraseña = :clave";
            $resultado = $conexion->prepare($sentencia);
            $resultado->bindParam("usuario", $usuario);
            $resultado->bindParam("clave", $clave);
            $resultado->execute();
            return $resultado->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "error" . $e->getMessage();
        }
    }
}
