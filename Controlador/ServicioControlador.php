<?php
    require_once __DIR__."/../Modelo/ServicioModelo.php";

    class ServicioControlador{
        public function registrar(){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
            
            $servicioModelo = new ServicioModelo();

            $params = [
            'nombre' => $_POST['nombre'], 
            'precio' => $_POST['precio'],
            'fecha' => $_POST['fecha'],
            'descripcion' => $_POST['descripcion'],
            ];

            if($servicioModelo->guardar($params)){
                header("Location: index.php?accion=registrar-servicio&mensaje=ok");
                exit;
            } else{
                $error ="Error al registrar Servicio.";
            }
            }
        }

        public function mostrarFormularioRegistroServicio(){
            $mensaje = $_GET["mensaje"] ?? "";
            if($mensaje == "ok"){
                Exito("Servicio registrado con éxito");
            } 
            require_once __DIR__."/../Vista/Servicios/Registrar.php";
        }

        public function consultar(){
            $servicioModelo = new ServicioModelo();

            $filtros = [
                'estado' => $_GET['estado'] ?? '',
                'fechaDesde' => $_GET['filtrofechadesde'] ?? '',
                'fechaHasta' => $_GET['filtrofechahasta'] ?? '',
                'precioDesde' => $_GET['filtropreciodesde'] ?? '',
                'precioHasta' => $_GET['filtropreciohasta'] ?? ''
            ];

            if (!empty($filtros)) {
                $servicios = $servicioModelo->obtenerServiciosPorFiltro($filtros);
            } else {
                $servicios = $servicioModelo->obtenerRegistroServicios();
            }

            if (isset($_SESSION["mensaje"])) {
                Exito($_SESSION["mensaje"]);
                unset($_SESSION["mensaje"]);// Se borra para que no se muestre otra vez
            }
            require_once __DIR__ . "/../Vista/Servicios/Consultar.php";
        }

        public function editar(){
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $fecha = $_POST['fecha'];
            $descripcion = $_POST['descripcion'];

            $servicioModelo = new ServicioModelo();
            $servicioModelo->actualizar($id, $nombre, $precio, $fecha, $descripcion);

            $_SESSION['mensaje'] = "Servicio actualizado con éxito";
            header("Location: index.php?accion=consultar-servicio&mensaje=editado");
            exit;
        }

        public function eliminar(){
            $id = $_POST['id'];

            $servicioModelo = new ServicioModelo();
            $servicioModelo->eliminar($id);

            $_SESSION['mensaje'] = "Servicio eliminado con éxito";
            header("Location: index.php?accion=consultar-servicio&mensaje=eliminado");
            exit;
        }
    }
?>