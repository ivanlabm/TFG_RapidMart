<?php
require_once '../modelos/ConnexionDB.php';
require_once '../config/config.php';
require_once '../modelos/Productos.php';
require_once '../modelos/ProductosDAO.php';
require_once '../modelos/UsuariosDAO.php';
require_once '../modelos/Foto.php';
require_once '../modelos/Sesion.php';
require_once '../modelos/FotosDAO.php';

$connexionDB = new ConnexionDB('alumno', '', 'localhost', 'market');
$conn = $connexionDB->getConnexion();
session_start();
$productosDAO = new ProductosDAO($conn);

$idProducto = htmlspecialchars($_GET['id']);
$producto = $productosDAO->getById($idProducto);


$fotosDAO = new FotosDAO($conn);
$fotos = $fotosDAO->getFotosById($idProducto);



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../estilos/global.css">
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
        }

        .header {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border: 1px solid #000;
        }

        .header div {
            border: 1px solid #000;
            padding: 5px 10px;
        }

        .main-content {
            display: flex;
            flex: 1;
            flex-direction: column;
            padding: 10px;
        }

        .top-section {
            display: flex;
            flex: 1;
            gap: 10px;
        }

        .left-column {
            display: flex;
            flex-direction: column;
            gap: 10px;
           
            flex: 1;
        }

        .right-column {
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex: 1;
        }

        .product-photo {
            flex: 2;
            border: 1px solid #000;
            padding: 10px;
        }

        .other-photos {
            display: flex;
            gap: 10px;
            border: 1px solid #000;
            padding: 10px;
        }

        .other-photos img {
            width: 100px;
            height: 100px;
            border: 1px solid #000;
        }

        .product-name,
        .product-description,
        .product-specs {
            border: 1px solid #000;
            padding: 10px;
        }

        

        .product-description {
            flex: 1;
        }

        .product-specs {
            border: 1px solid #000;
            padding: 10px;
            margin-top: 10px;
        }
        .boton{
          background-color: #8E2F5C;
        }
    </style>
</head>

<body>
<header>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="../map.php?accion=inicio">
        <img id="logo" src="../logo2.png" alt="Logo">
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
              <a href="../map.php?accion=ver_carrito">
                <img src="../fotoUsuario/<?= Sesion::getUsuario()->getFoto() ?>" class="fotoUsuario" alt="Foto de perfil">
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
  
    <div class="main-content">
        <div class="top-section">
            <div class="left-column">
                <div class="product-photo">
                    <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active" data-bs-interval="2000">
                                <img src="../fotoProductos/<?= $producto->getFoto() ?>" class="d-block w-100 h-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <img src="" class="d-block w-25">
                                </div>
                            </div>
                            <div class="carousel-item" data-bs-interval="2000">
                                <img src="../fotoProductos/<?= $producto->getFoto() ?>" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <img src="" class="d-block w-25">
                                </div>
                            </div>
                            <div class="carousel-item" data-bs-interval="2000">
                                <img src="../fotoProductos/<?= $producto->getFoto() ?>" class="d-block w-100" alt="...">
                                <div class="carousel-caption d-none d-md-block">
                                    <img src="" class="d-block w-25">
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

            </div>
            <div class="right-column">
                <div class="product-name">
                    <h2><?= $producto->getNombre() ?></h2>
                    <h2><?= $producto->getPrecio() ?>€</h2>
                </div>
                <div class="product-description">
                  <h3>Descripcion</h3>
                    <p><?= $producto->getDescripcion() ?></p>
                  
                    <p>Stock:<?= $producto->getStock() ?></p>
                </div>
            </div>
        </div>
        <div class="product-specs">
            <h3>Especificaciones del Producto</h3>
            <p><?= $producto->getEspecificaciones() ?></p>
            
            <a href="../map.php?accion=insertar_carrito&id=<?= $producto->getId() ?>" class="btn btn-dark boton">Carrito</a>

            <a href="../map.php?accion=ver_compra_dir&id=<?= $producto->getId() ?>"class="btn btn-success boton">Comprar</a>
            
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-Tt2sE3Qo0SmigUi2ziUpzUigp4wLeQ7EgIoT5CISdkC99Pb04EgeFu0xNsPEnpu7" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9E+of+FF2XCI5vYd6u5l1w5iRtP4vv9ZZTtmI3lNliT3GJ7Skos6L9p" crossorigin="anonymous"></script>
</body>

</html>