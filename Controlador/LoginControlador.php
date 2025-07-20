<?php
require_once __DIR__."/../Modelo/LoginModelo.php";
require_once __DIR__."/../Vista/layout/modal.php";
class LoginControlador{
    public function autenticar(){
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["iniciar-sesion"])){
            $usuario = $_POST["correo"] ?? "";

            $clave = $_POST["contraseña"] ?? "";

            $loginModelo = new LoginModelo();
            $usuario = $loginModelo->Autenticar($usuario, $clave);
            if($usuario){
                session_start();
                $_SESSION["usuario"] = $usuario;
                header("location: index.php?accion=inicio&mensaje=ok");
                error_log("");

            }else{
                header("location: index.php?accion=iniciar_sesion&mensaje=error");
            }
        }
    }
    public function mostrarInicio(){
        if(isset($_SESSION["usuario"])){
            $mensaje = $_GET["mensaje"] ?? "";
            if($mensaje == "ok"){
                Exito("Autenticación con exito");
            }
            require_once __DIR__."/../Vista/Inicio.php";
        }else{
            header("location: index.php?accion=iniciar_sesion");
        }
    }
    public function mostrarFormulario(){
        $mensaje = $_GET["mensaje"] ?? "";
        if(isset($_SESSION["usuario"])){
            if($mensaje == "ok"){
                Exito("Autenticación con exito");
            }
            require_once __DIR__."/../Vista/Inicio.php";
        }else{
            if($mensaje == "error"){
                Error("Usuario o contraseña incorrecto");
            }
            require_once __DIR__."/../Vista/IniciarSesion.php";
        }
    }
    public function logout(){
        if(isset($_SESSION["usuario"])){
            session_unset();
            session_destroy();
        }
        header("location: index.php?accion=iniciar_sesion");
    }
}

?>