<?php
$host = "localhost";
$usuario = "root";
$contrasena = "admin";
$base_datos = "sistema_facturacion_hotel";

$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>