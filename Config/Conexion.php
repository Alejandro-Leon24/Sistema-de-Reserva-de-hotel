<?php
class Conexion{
    public function Conectar(){
        $host = "localhost";
        $port = "3306";
        $dbname = "hotel";
        $user = "root";
        
        try{
            $conexion = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $conexion;
        }catch (PDOException $e){
            echo "Error de base de datos: " . $e->getMessage();
        }
    }
}
?>