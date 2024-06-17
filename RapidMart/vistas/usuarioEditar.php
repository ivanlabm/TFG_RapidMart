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
$usuariosDAO = new UsuariosDAO($conn);

$id = htmlspecialchars($_GET['id']);
$usuarios = $usuariosDAO->getById($id);

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil de Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="../estilos/global.css">
  <link rel="stylesheet" href="../estilos/usuarioEditar.css">

</head>

<body>
<header>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="map.php?accion=inicio">
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
              <a href="map.php?accion=ver_carrito">
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
  <div class="container">
    <form action="../map.php?accion=editarusu&id=<?= $usuarios->getId() ?>" method="post" enctype="multipart/form-data">

      <div class="card">
        <div class="row no-gutters">

          <div class="col-md-4">
            <img src="../fotoUsuario/<?= $usuarios->getFoto() ?>" class="card-img" alt="Foto del Usuario">
          </div>
          <div class="col-md-8">
            <div class="card-body">

              <?php if (str_contains(Sesion::getUsuario()->getRol(), 'admin')) : ?>
                <input type="text" name="nombre" value="<?= $usuarios->getNombre() ?>">
                <input type="text" name="apellidos" value="<?= $usuarios->getApellidos() ?>">
                <input type="text" name="correo" value="<?= $usuarios->getCorreo() ?>">
                <input type="text" name="rol" value="<?= $usuarios->getRol() ?>">
              <?php else : ?>
                <input type="text" name="nombre" value="<?= $usuarios->getNombre() ?>">
                <input type="text" name="apellidos" value="<?= $usuarios->getApellidos() ?>">
                <input type="text" name="correo" value="<?= $usuarios->getCorreo() ?>">
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Confirmar Edición</button>
        </div>

      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-Tt2sE3Qo0SmigUi2ziUpzUigp4wLeQ7EgIoT5CISdkC99Pb04EgeFu0xNsPEnpu7" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9E+of+FF2XCI5vYd6u5l1w5iRtP4vv9ZZTtmI3lNliT3GJ7Skos6L9p" crossorigin="anonymous"></script>
</body>

</html>