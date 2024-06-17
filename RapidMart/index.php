<?php
require_once 'utils/funciones.php';
require_once 'modelos/ConnexionDB.php';
require_once 'modelos/ProductosDAO.php';
require_once 'modelos/Productos.php';
require_once 'config/config.php';
require_once 'modelos/Sesion.php';



// Llama a la función para imprimir mensajes de error


$connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
$conn = $connexionDB->getConnexion();




$productosDAO = new ProductosDAO($conn);
$productos = $productosDAO->getAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $categoria = htmlspecialchars($_POST["buscar"]);
  $arrayfiltrar = array();
  $arrayfiltrar = $productosDAO->getByCategoria($categoria);
}
imprimirMensaje();



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

  <script src="productos.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="estilos/global.css">

  <link rel="stylesheet" href="estilos/index.css">

  <!DOCTYPE html>
  <html lang="es">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="path/to/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Asegúrate de enlazar tu archivo CSS -->
    <title>Página con header</title>
    <style>
 
  .lupa{
    background-color: white;
    border: 0px;
    border-radius: 100%;
  }
  html, body {
  height: 100%;
  margin: 0;
}

body {
  display: flex;
  flex-direction: column;
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
            <a class="btn btn-secondary dropdown-toggle drop" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Opciones
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <!-- Opciones de usuario -->
              <?php if (Sesion::getUsuario()) : ?>
                <?php if (str_contains(Sesion::getUsuario()->getRol(), 'admin')) : ?>
                  <li class="dropdown-item">
                    <a class="dropdown-link opciones" href="map.php?accion=misProductos&id=<?= Sesion::getUsuario()->getId() ?>">Mis Productos</a>
                  </li>
                  <li class="dropdown-item">
                    <a class="dropdown-link opciones" href="map.php?accion=verUsuarios">Usuarios</a>
                  </li>
                  <li>
                    <a class="btn btn-primary opcionesbtn" data-bs-toggle="modal" data-bs-target="#exampleModalTogglevender" role="button">Vender</a>
                    
                  </li>
                <?php elseif (str_contains(Sesion::getUsuario()->getRol(), 'Vendedor')) : ?>
                  <li class="dropdown-item">
                    <a class="dropdown-link opciones " href="map.php?accion=misProductos&id=<?= Sesion::getUsuario()->getId() ?>">Mis Productos</a>
                  </li>
                  <li class="dropdown-item">
                    <a class="dropdown-link opciones" href="map.php?accion=resumenVentas&id=<?= Sesion::getUsuario()->getId() ?>">Resumen Ventas</a>
                  </li>
                  <li class="dropdown-item">
                  <a class="btn btn-primary opcionesbtn" data-bs-toggle="modal" data-bs-target="#exampleModalTogglevender" role="button">Vender</a>
                  </li>
                <?php elseif (str_contains(Sesion::getUsuario()->getRol(), 'Cliente') || str_contains(Sesion::getUsuario()->getRol(), 'usuario')) : ?>
                  <li><a class="dropdown-link opcionesbtn" href="#" data-bs-toggle="modal" data-bs-target="#exampleModalTogglenovendedor">Vender</a></li>
                <?php endif; ?>
              <?php endif; ?>
            </ul>
          </li>

          <li class="nav-item flex-grow-1">
          <form class="d-flex buscador" action="map.php?accion=buscar" method="post">
            <input class="form-control rounded buscador2 "  type="search" placeholder="Search" aria-label="Search" name="buscar">
            <button class="lupa " type="submit"><img src="lupa-de-busqueda.png" id="lupa" alt=""></button>
            </form>
          </li>
          <li class="nav-item">
              <div class="modal fade" id="exampleModalTogglevender" aria-hidden="true" aria-labelledby="exampleModalTogglevender" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalTogglevender">Vender</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="map.php?accion=insertar_producto" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                          <label for="nombre">Nombre</label>
                          <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su nombre electrónico">
                        </div>
                        <div class="form-group">
                          <label for="descripcion">Descripcion</label>
                          <input type="descripcion" class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese su breve descripcion">
                        </div>
                        <div class="form-group">
                          <label for="precio">Precio</label>
                          <input type="num" class="form-control" id="precio" name="precio" placeholder="Ingrese su precio">
                        </div>
                        <div class="form-group">
                          <label for="stock">Stock</label>
                          <input type="num" class="form-control" id="stock" name="stock" placeholder="Ingrese su Stock">
                        </div>
                        <div class="form-group">
                          <label for="categoria">Categoria</label>
                          <input type="text" class="form-control" id="categoria" name="categoria" placeholder="Ingrese su Categoria">
                        </div>
                        <div class="form-group">
                          <label for="especificaciones">Especificaciones</label>
                          <input type="text" class="form-control" id="especificaciones" name="especificaciones" placeholder="Ingrese su especificaciones">
                        </div>
                        <div class="form-group">
                      <label for="foto">Foto</label>
                      <input type="file" class="form-control" name="foto" id="foto"  ><br>
                    </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary btn-block">Vender</button>
                      </form>
                      <button class="btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-dismiss="modal" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Registro</button>
                    </div>
                  </div>
                </div>
              </div>
            
            </li>
            <li class="nav-item">
              <div class="modal fade" id="exampleModalTogglenovendedor" aria-hidden="true" aria-labelledby="exampleModalTogglenovendedor" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalTogglenovendedor">Aun no eres Vendedor</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-dark btn-block" data-bs-dismiss="modal" aria-label="Close">Hacerse Vendedor</button>
                    </div>
                  </div>
                </div>
              </div>
              
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
  <button class="btn btn-primary drop" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Registrarse</button>
</li>


            <li class="nav-item">
              <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggle" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalToggle">Iniciar Sesion</h5>
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
                      <button type="submit" class="btn btn-primary btn-block">Inicio Sesion</button>
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


  <div data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-offset="0" class="scrollspy-example secciones" tabindex="0">
    <div class="contenedor">
    

      <div class="row justify-content-start" id="productosContainer">
      <div id="separacion">

      </div>

        <?php if (empty($arrayfiltrar)) : ?>
          <?php foreach ($productos as $producto) : ?>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 carta">
              <a href="vistas/producto.php?id=<?= $producto->getId() ?>">
                <div class="card">
                  <img src="./fotoProductos/<?= $producto->getFoto() ?>" class="card-img-top" id="imgcarta" alt="<?= $producto->getNombre() ?>">
                  <div class="card-body">
                    <h5 class="card-title"><?= $producto->getNombre() ?></h5>
                    <p class="card-text"><?= $producto->getDescripcion() ?></p>
                    <div id="piecarta">
                      <h5 class="card-title"><?= $producto->getPrecio() ?>€</h5>
                      <div>

                        <a href="map.php?accion=ver_compra_dir&id=<?= $producto->getId() ?>" class="btn btncomprar">Comprar</a>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        <?php else : ?>
          <?php foreach ($arrayfiltrar as $producto) : ?>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 carta">
              <a href="/vistas/producto.php?id=<?= $producto->getId() ?>">
                <div class="card">
                  <img src="./fotoProductos/<?= $producto->getFoto() ?>" class="card-img-top" id="imgcarta" alt="<?= $producto->getNombre() ?>">
                  <div class="card-body">
                    <h5 class="card-title"><?= $producto->getNombre() ?></h5>
                    <p class="card-text"><?= $producto->getDescripcion() ?></p>
                    <div id="piecarta">
                      <h5 class="card-title"><?= $producto->getPrecio() ?>€</h5>
                      <div>

                        <a href="map.php?accion=ver_compra_dir&id=<?= $producto->getId() ?>" class="btn btn-primary">Comprar</a>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script src="path/to/bootstrap.bundle.min.js"></script>







</div>
  <footer>
    <div class="copyright">
      <p>© 2024 Todos los derechos reservados. El contenido de este sitio web está protegido por las leyes de
        derechos de autor. Queda prohibida la reproducción total o parcial sin autorización previa por escrito.
      </p>
    </div>
    <div class="links">

      <a href="vistas/sobre-nosotros.html">Sobre nosotros</a>
      <a href="contacto.html">Contáctanos</a>
      <a href="terminos-de-servicio.html">Términos de servicio</a>
      <a href="politica-de-privacidad.html">Política de privacidad</a>
      </ul>
    </div>
  </footer>
  

</body>

</html>


