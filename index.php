<?php
require_once __DIR__ . "/Controlador/LoginControlador.php";
require_once __DIR__ . "/Controlador/HuespedControlador.php";
require_once __DIR__ . "/Controlador/ServicioControlador.php";
require_once __DIR__ . "/Controlador/HabitacionControlador.php";
require_once __DIR__ . "/Controlador/ReservaControlador.php";
require_once __DIR__ . "/Controlador/PagoControlador.php";
$loginControlador = new LoginControlador();
$HuespedControlador = new HuespedControlador();
$servicioControlador = new ServicioControlador();
$habitacionControlador = new HabitacionControlador();
$reservaControlador = new ReservaControlador();
$pagoControlador = new PagoControlador();

session_start();
$accion = $_GET['accion'] ?? "";

switch ($accion) {
    case "inicio":
        $loginControlador->mostrarInicio();
        break;

    case "iniciar_sesion":
        $loginControlador->mostrarFormulario();
        break;

    case "autenticar":
        $loginControlador->autenticar();
        break;

    case "logout":
        $loginControlador->logout();
        break;

    //Huesped
    case "registrar-huesped":
        $HuespedControlador->formularioRegistrarHuesped();
        break;

    case "form-huesped":
        $HuespedControlador->RegistrarHuesped();
        break;

    case "listar-huesped":
        $HuespedControlador->ListarHuesped();
        break;

    case "eliminar-huesped":
        $HuespedControlador->EliminarHuesped();
        break;
    case "actualizarHuesped":
        $HuespedControlador->EditarHuesped();
        break;
    //Habitacion
    case "registrarHabitacion":
        $habitacionControlador->mostrarFormularioRegistro();
        break;

    case "guardarHabitacion":
        $habitacionControlador->guardar();
        break;

    case "listarHabitaciones":
        $habitacionControlador->listarHabitaciones($_GET);
        break;

    case "actualizarHabitacion":
        $habitacionControlador->actualizarHabitacion();
        break;

    case "eliminarHabitacion":
        $habitacionControlador->eliminarHabitacion();
        break;
    //Servicios
    case "registrar-servicio":
        $servicioControlador->mostrarFormularioRegistroServicio();
        break;
    case "registro":
        $servicioControlador->registrar();
        break;
    case "consultar-servicio":
        $servicioControlador->consultar();
        break;
    case "editar-servicio":
        $servicioControlador->editar();
        break;
    case "eliminar-servicio":
        $servicioControlador->eliminar();
        break;

    //Reservas
    case "Registrar":
        require_once __DIR__ . "/Vista/Reserva/Reserva.php";
        break;
    case "buscar_huesped":
        require_once __DIR__ . "/Controlador/HuespedControlador.php";
        $HuespedControlador->buscarPorCedula($_GET['cedula'] ?? '');
        break;
    case "guardar_reserva":
        $reservaControlador->guardar();
        break;

    case "consultar":
        require_once __DIR__ . "/Vista/Reserva/Consulta.php";
        break;

    case "cancelar_reserva":
        $reservaControlador->eliminar();
        break;
    case "editar_reserva":
        $reservaControlador->editar();
        break;

    case "actualizar_reserva":
        $reservaControlador->actualizar();
        break;

    //Factura
    case "registrar_pago":
        $pagoControlador->mostrarFormularioPago();
        break;

    case "guardar_pago":
        $pagoControlador->guardarPagoFinal();
        break;

    case "listar_pagos":
        $pagoControlador->mostrarListar();
        break;

    case "editar_factura":
        $pagoControlador->editarFactura();
        break;

    case "eliminar_factura":
        $pagoControlador->eliminarFactura();
        break;
    default:
        require_once __DIR__ . "/Vista/Principal.php";
        break;
}
