<?php 
require_once 'utils/funciones.php';
require_once 'modelos/ConnexionDB.php';
require_once 'modelos/ProductosDAO.php';
require_once 'modelos/Productos.php';
require_once 'config/config.php';
require_once 'modelos/Sesion.php';
require_once 'modelos/Pedido.php';
require_once 'modelos/PedidoDAO.php';
require_once 'modelos/UsuariosDAO.php';


// Llama a la función para imprimir mensajes de error


$connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
$conn = $connexionDB->getConnexion();
session_start();
$productosDAO=new ProductosDAO($conn);
$pedidosDAO=new PedidoDAO($conn);
$usuariosDAO=new UsuariosDAO($conn);
$vendedor = htmlspecialchars($_GET['id']);
$pedidos=$pedidosDAO->getAllById($vendedor);








?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Usuarios</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../estilos/global.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        img {
            width: 50px;
        }
    </style>
</head>
<body>
<header>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="map.php?accion=inicio">
        <img id="logo" src="logo2.png" alt="Logo">
      </a>
      
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon men"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="btn btn-secondary dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Opciones
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <!-- Opciones de usuario -->
              <?php if (Sesion::getUsuario()) : ?>
                <?php if (str_contains(Sesion::getUsuario()->getRol(), 'admin')) : ?>
                  <li class="dropdown-item">
                    <a class="dropdown-link" href="map.php?accion=misProductos&id=<?= Sesion::getUsuario()->getId() ?>">Mis Productos</a>
                  </li>
                  <li class="dropdown-item">
                    <a class="dropdown-link" href="map.php?accion=verUsuarios">Usuarios</a>
                  </li>
                  <li>
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#exampleModalToggle">Vender</a>
                  </li>
                <?php elseif (str_contains(Sesion::getUsuario()->getRol(), 'Vendedor')) : ?>
                  <li class="dropdown-item">
                    <a class="dropdown-link" href="map.php?accion=misProductos&id=<?= Sesion::getUsuario()->getId() ?>">Mis Productos</a>
                  </li>
                  <li class="dropdown-item">
                    <a class="dropdown-link" href="map.php?accion=resumenVentas&id=<?= Sesion::getUsuario()->getId() ?>">Resumen Ventas</a>
                  </li>
                  <li class="dropdown-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#exampleModalToggle">Vender</a>
                  </li>
                <?php elseif (str_contains(Sesion::getUsuario()->getRol(), 'Cliente') || str_contains(Sesion::getUsuario()->getRol(), 'usuario')) : ?>
                  <li><a class="dropdown-link" href="#" data-bs-toggle="modal" data-bs-target="#exampleModalTogglenovendedor">Vender</a></li>
                <?php endif; ?>
              <?php endif; ?>
            </ul>
          </li>

          <li class="nav-item flex-grow-1">
          <form class="d-flex buscador" action="map.php?accion=buscar" method="post">
            <input class="form-control rounded buscador2 "  type="search" placeholder="Search" aria-label="Search" name="buscar">
            <button class="btn btn-outline lupa" type="submit"><img src="lupa-de-busqueda.png" id="lupa" alt=""></button>
            </form>
          </li>

          <!-- Autenticación y acciones de usuario -->
          <?php if (!Sesion::getUsuario()) : ?>
            <li class="nav-item">
              <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                  <h5 id="offcanvasRightLabel">Registro</h5>
                  <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                  <form action="map.php?accion=registrar" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="nombre">Nombre</label>
                      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre">
                    </div>
                    <div class="form-group">
                      <label for="apellidos">Apellido</label>
                      <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Ingrese su apellido">
                    </div>
                    <div class="form-group">
                      <label for="correo">Correo Electrónico</label>
                      <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese su correo electrónico">
                    </div>
                    <div class="form-group">
                      <label for="password">Contraseña</label>
                      <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña">
                    </div>
                    <div class="form-group">
                      <label for="foto">Foto de Perfil</label>
                      <input type="file" class="form-control" name="foto" id="foto"><br>
                    </div>
                    <button type="submit" class="btn btn-dark btn-block">Registrarse</button>
                  </form>
                </div>
              </div>
            </li>
            <li class="nav-item">
              <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalToggleLabel">Inicio Sesión</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="map.php?accion=login" method="post">
                        <div class="form-group">
                          <label for="correo">Correo Electrónico</label>
                          <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese su correo electrónico">
                        </div>
                        <div class="form-group">
                          <label for="password">Contraseña</label>
                          <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña">
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                      </form>
                      <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-dismiss="modal" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Registro</button>
                    </div>
                  </div>
                </div>
              </div>
              <a class="btn btn-primary" data-bs-toggle="modal" href="#exampleModalToggle" role="button">Inicio Sesión</a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a class="btn btn-" href="map.php?accion=logout" role="button">Cerrar Sesión</a>
            </li>
            <li class="nav-item">
              <a href="map.php?accion=ver_carrito">
                <img src="fotoUsuario/<?= Sesion::getUsuario()->getFoto() ?>" class="fotoUsuario" alt="Foto de perfil">
              </a>
              <span class="nombreUsuario"><?= Sesion::getUsuario()->getNombre() ?></span>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
  <div id="separacion">

</div>
</header>

    <h2>Resumen de Ventas</h2>
        
    <table>
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nombre Producto</th>
                <th>Precio</th>
                <th>Nombre Comprador</th>
                <th>Correo Comprador</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($pedidos as $pedido): ?>
            <?php

                $producto=$productosDAO->getById($pedido->getIdProducto());
                $usuario=$usuariosDAO->getById($pedido->getIdUsuario());
                    ?>    
            <tr>
                <td>
                    <img src="fotoProductos/<?= $producto->getFoto()?>">
                
                </td>
                <td><?=$producto->getNombre()?></td>
                <td><?= $producto->getPrecio()?></td>
                <td><?= $usuario->getNombre()?></td>
                <td><?= $usuario->getCorreo()?></td>
            </tr>
            <?php  endforeach; ?>
        </tbody>
    </table>

    
</body>
</html>
