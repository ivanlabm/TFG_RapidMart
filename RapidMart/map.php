<?php

require_once 'config/config.php';
require_once 'modelos/ConnexionDB.php';
require_once 'modelos/Administradores.php';
require_once 'modelos/Usuarios.php';
require_once 'modelos/UsuariosDAO.php';
require_once 'modelos/Productos.php';
require_once 'modelos/Venta.php';
require_once 'modelos/Sesion.php';
require_once 'controladores/ControladorTienda.php';
require_once 'controladores/ControladorUsuarios.php';


session_start();

$mapa = array(
    'inicio' => array(
        "controlador" => 'ControladorTienda',
        'metodo' => 'inicio',
        'privada' => false,
        
    ),
    'insertar_producto' => array(
        'controlador' => 'ControladorTienda',
        'metodo' => 'insertar',
        'privada' => true,
        
    ),
    'insertar_carrito' => array(
        'controlador' => 'ControladorTienda',
        'metodo' => 'addToCarrito',
        'privada' => true,
      
    ),
    'ver_carrito' => array(
        'controlador' => 'ControladorTienda',
        'metodo' => 'verCarrito',
        'privada' => true,
      
    ),
    'ver_compra' => array(
        'controlador' => 'ControladorTienda',
        'metodo' => 'verCompra',
        'privada' => true,
      
    ),
    'insertar_compra' => array(
        'controlador' => 'ControladorTienda',
        'metodo' => 'comprar',
        'privada' => true,
    
    ),
    'ver_compra_dir' => array(
        'controlador' => 'ControladorTienda',
        'metodo' => 'verCompraDirecta',
        'privada' => true,
       
    ),
    'buscar' => array(
        'controlador' => 'ControladorTienda',
        'metodo' => 'buscar',
        'privada' => false,
    
    ),
    'misProductos' => array(
        'controlador' => 'ControladorTienda',
        'metodo' => 'misProductos',
        'privada' => true,
       
    ),
    'resumenVentas' => array(
        'controlador' => 'ControladorTienda',
        'metodo' => 'resumenVentas',
        'privada' => true,
       
    ),
    'verUsuarios' => array(
        'controlador' => 'ControladorUsuarios',
        'metodo' => 'verUsuarios',
        'privada' => true,
       
    ),
    'verProductos' => array(
        'controlador' => 'ControladorTienda',
        'metodo' => 'verProductos',
        'privada' => true,
       
    ),
    'editar' => array(
        'controlador' => 'ControladorTienda',
        'metodo' => 'productoEditar',
        'privada' => true,
      
    ),
    'login' => array(
        'controlador' => 'ControladorUsuarios',
        'metodo' => 'login',
        'privada' => false,
     
    ),
    'editarusu' => array(
        'controlador' => 'ControladorUsuarios',
        'metodo' => 'usuarioEditar',
        'privada' => true,
      
    ),
    'logout' => array(
        'controlador' => 'ControladorUsuarios',
        'metodo' => 'logout',
        'privada' => true,
        'rol'=>'usuario'
    ),
    'registrar' => array(
        'controlador' => 'ControladorUsuarios',
        'metodo' => 'registrar',
        'privada' => false,
   
    ),
    'añadirVendedor' => array(
        'controlador' => 'ControladorUsuarios',
        'metodo' => 'insertarVendedor',
        'privada' => true,
   
    ),
    
);


if (isset($_GET['accion'])) { 
    if (isset($mapa[$_GET['accion']])) {  
        $accion = $_GET['accion'];
    } else {
       
        header('Status: 404 Not found');
        echo 'Página no encontrada';
        die();
    }
} else {
    $accion = 'login';  
}

if (!Sesion::existeSesion() && isset($_COOKIE['sid'])) {

    $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();

    
    $usuariosDAO = new UsuariosDAO($conn);
    if ($usuario = $usuariosDAO->getBySid($_COOKIE['sid'])) {
        Sesion::iniciarSesion($usuario);
    }
}

if (!Sesion::existeSesion() && $mapa[$accion]['privada']) {
    header('location: map.php?accion=inicio');
    die();
}


$controlador = $mapa[$accion]['controlador'];
$metodo = $mapa[$accion]['metodo'];


$objeto = new $controlador();
$objeto->$metodo();
