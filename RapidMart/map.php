<?php

require_once 'config/config.php';
require_once 'modelos/ConnexionDB.php';
require_once 'modelos/Administradores.php';
require_once 'modelos/Categoria.php'; // Corrección: Agregué el ".php" que faltaba
require_once 'modelos/Usuarios.php';
require_once 'modelos/UsuariosDAO.php';
require_once 'modelos/Productos.php';
require_once 'modelos/Tiket.php';
require_once 'modelos/Vendedor.php'; // Corrección: Cambié "Vendedor" a "vendedor"
require_once 'modelos/Venta.php';
require_once 'modelos/Cliente.php';
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

// Parseo de la ruta
if (isset($_GET['accion'])) { // Compruebo si me han pasado una acción concreta, sino pongo la accción por defecto inicio
    if (isset($mapa[$_GET['accion']])) {  // Compruebo si la accción existe en el mapa, sino muestro error 404
        $accion = $_GET['accion'];
    } else {
        // La acción no existe
        header('Status: 404 Not found');
        echo 'Página no encontrada';
        die();
    }
} else {
    $accion = 'login';   // Acción por defecto
}

// Si existe la cookie y no ha iniciado sesión, le iniciamos sesión de forma automática
// if( !isset($_SESSION['email']) && isset($_COOKIE['sid'])){
if (!Sesion::existeSesion() && isset($_COOKIE['sid'])) {
    // Conectamos con la bD
    $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();

    // Nos conectamos para obtener el id y la foto del usuario
    $usuariosDAO = new UsuariosDAO($conn);
    if ($usuario = $usuariosDAO->getBySid($_COOKIE['sid'])) {
        // $_SESSION['email']=$usuario->getEmail();
        // $_SESSION['id']=$usuario->getId();
        // $_SESSION['foto']=$usuario->getFoto();
        Sesion::iniciarSesion($usuario);
    }
}

// Si la acción es privada compruebo que ha iniciado sesión, sino, lo echamos a index
// if(!isset($_SESSION['email']) && $mapa[$accion]['privada']){
if (!Sesion::existeSesion() && $mapa[$accion]['privada']) {
    header('location: map.php?accion=inicio');
    // guardarMensaje("Debes iniciar sesión para acceder a $accion");
    die();
}

// $acción ya tiene la acción a ejecutar, cogemos el controlador y metodo a ejecutar del mapa
$controlador = $mapa[$accion]['controlador'];
$metodo = $mapa[$accion]['metodo'];

// Ejecutamos el método de la clase controlador
$objeto = new $controlador();
$objeto->$metodo();
