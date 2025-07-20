<?php
require_once __DIR__."/../Config/Conexion.php";
class HuespedModelo{
    public function Registrar($Nombre, $Apellido, $Genero, $Tipo_Documento, $N_Documento, $Fecha_Nacimiento, $Correo){
        try{
            $con = new Conexion();
            $conexion = $con->Conectar();
            $sentencia = "INSERT INTO huesped (Nombre, Apellido, Genero, Tipo_Documento, N_Documento, Fecha_Nacimiento, Correo) 
            values(:Nombre, :Apellido, :Genero, :Tipo_Documento, :N_Documento, :Fecha_Nacimiento, :Correo)";

            $resultado = $conexion->prepare($sentencia);
            $resultado->bindParam("Nombre", $Nombre);
            $resultado->bindParam("Apellido", $Apellido);
            $resultado->bindParam("Genero", $Genero);
            $resultado->bindParam("Tipo_Documento", $Tipo_Documento);
            $resultado->bindParam("N_Documento", $N_Documento);
            $resultado->bindParam("Fecha_Nacimiento", $Fecha_Nacimiento);
            $resultado->bindParam("Correo", $Correo);
            $resultado->execute();
            
            return $resultado->rowCount();

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function ListarTipoDocumento(){
        try{
            $con = new Conexion();
            $conexion = $con->Conectar();
            $sentencia = "SELECT * From tipo_documento";
            $resultado = $conexion->prepare($sentencia);
            $resultado->execute();

            return $resultado->fetchAll(PDO::FETCH_ASSOC);

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    public function ListarHuesped(){
        try{
            $con = new Conexion();
            $conexion = $con->Conectar();
            $sentencia = "SELECT h.*, t.Nombre as Tipo_Documento  
                          FROM huesped h 
                          JOIN tipo_documento t ON h.Tipo_Documento = t.ID ORDER BY h.ID ASC";
    
            $resultado = $conexion->prepare($sentencia);
            $resultado->execute();
            return $resultado->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function editarHuesped($Nombre, $Apellido, $Genero, $Tipo_Documento, $N_Documento, $Fecha_Nacimiento, $Correo, $ID){
        try{
            $con = new Conexion();
            $conexion = $con->Conectar();
            $sentencia = "UPDATE huesped set Nombre = :Nombre, Apellido = :Apellido, Genero = :Genero, 
            Tipo_Documento = :Tipo_Documento, N_Documento = :N_Documento, Fecha_Nacimiento = :Fecha_Nacimiento, Correo = :Correo where ID = :ID";
            $resultado = $conexion->prepare($sentencia);
            $resultado->bindParam("Nombre", $Nombre);
            $resultado->bindParam("Apellido", $Apellido);
            $resultado->bindParam("Genero", $Genero);
            $resultado->bindParam("Tipo_Documento", $Tipo_Documento);
            $resultado->bindParam("N_Documento", $N_Documento);
            $resultado->bindParam("Fecha_Nacimiento", $Fecha_Nacimiento);
            $resultado->bindParam("Correo", $Correo);
            $resultado->bindParam("ID", $ID);
            $resultado->execute();

            return $resultado->rowCount();
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function EliminarHuesped($ID){
        try{
            $con = new Conexion();
            $conexion = $con->Conectar();
            $sentencia = "UPDATE huesped set Estado = 'Inactivo' where ID = :ID";
            $resultado = $conexion->prepare($sentencia);
            $resultado->bindParam("ID", $ID);
            $resultado->execute();
            return $resultado->rowCount();
        }catch(PDOException $e){
            echo $e->getMessage();
        }

    }
    public function buscarPorCedula($cedula) {
        $conexion = new Conexion();
        $db = $conexion->conectar();

        $sql = "SELECT ID, Nombre, Apellido, Correo, N_Documento FROM huesped WHERE N_Documento = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$cedula]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>