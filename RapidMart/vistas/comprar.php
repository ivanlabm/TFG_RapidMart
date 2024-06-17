<?php
require_once 'modelos/ConnexionDB.php';
require_once 'config/config.php';
require_once 'modelos/Productos.php';
require_once 'modelos/ProductosDAO.php';
require_once 'modelos/UsuariosDAO.php';
require_once 'modelos/Foto.php';
require_once 'modelos/Sesion.php';
require_once 'modelos/FotosDAO.php';

$connexionDB = new ConnexionDB('alumno', '', 'localhost', 'market');
$conn = $connexionDB->getConnexion();
session_start();
$productosDAO = new ProductosDAO($conn);

$carritoDAO = new CarritoDAO($conn);

$usuario = Sesion::getUsuario();

$carrito = $carritoDAO->getById($usuario->getId());






?>








<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario de Compra</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="../estilos/global.css">
  <style>
    header .navbar {
  width: 100%;
  padding: 0;
  justify-content: space-between;
}
header img{
  width: 50px;
}
#logo{
  width:200px;

}
header{
  justify-content: space-between;
}
 header li{
  
    margin: 20px;
 }
header .container-fluid {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

header .navbar-brand {
  flex: 1;
}

header .navbar-toggler {
  flex: 0;
}

header .navbar-collapse {
  flex: 4;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

header .navbar-nav {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: flex-end;
}

header .buscador {
  border-radius: 50px; /* Ajusta esto según tus necesidades */
  width: 100%;
  justify-content: space-between;
  border: 1px solid black;
  
}

header .buscador2 {
  flex: 0 0 85%;
  border: none;
  outline: none;

  background-color: transparent;
  
}

.buscador2:focus {
  border: none;
  outline: none;
}
#lupa{
  width: 25px;
}
.lupa{
  width: 50px;
}



header .navbar-toggler-icon.men {
  background-image: url('path-to-your-custom-icon.png');
  /* Puedes personalizar el ícono aquí */
}

header .fotoUsuario {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  border:1px solid black;
}

header .emailUsuario {
  margin-left: 0.5rem;
}

#separacion{
  margin: 20px;
}





    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    .container {
      width: 60%;
      margin: auto;
      overflow: hidden;
      background: #fff;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      margin-top: 50px;
    }

    .container #img{
      width: 50px;
    }

    

    form {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    .form-group {
      width: 48%;
      margin-bottom: 20px;
    }

    .form-group.full-width {
      width: 100%;
    }

    form label {
      display: block;
      margin-bottom: 5px;
    }

    form input,
    form textarea,
    form select,
    form button {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-sizing: border-box;
    }

    form button {
      background-color: #5cb85c;
      color: #fff;
      border: none;
      cursor: pointer;
    }

    form button:hover {
      background-color: #4cae4c;
    }

    #cart {
      margin: 20px 0;
    }

    #cart div {
      border: 1px solid #ddd;
      padding: 20px;
      margin: 10px;
    }

    #cart div {
      background: #f4f4f4;
    }

    #cart-items {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }

    .izq {
      flex: 0 0 90%;
      margin: 0% 5% 0% 0%;
      display: flex;
      align-items: center;
      height: 60px;
    }

    .der {
      flex: 0 0 10%;
      margin: 0;
      display: flex;
      align-items: center;
      height: 60px;
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
  <div class="container">

    <h1>Resumen de Compra</h1>
    <section id="cart">
      <h2>Carrito de Compras</h2>
      <?php foreach ($carrito as $producto) : ?>
        <?php $productos = $productosDAO->getById($producto->getIdProducto()); ?>
        <div id="cart-items">
          <div class="der">
          <p class="text "><?= $productos->getPrecio()?>€</p>
          </div>
          <div class="izq">
            <img id="img" src="./fotoProductos/<?= $productos->getFoto() ?>" alt="">
            <p class="text"><?= $productos->getNombre() ?></p>
          </div>
        </div>
        <?php $precioTotal += $productos->getPrecio()  ?>
      <?php endforeach; ?>

      <p>Total: $<span id="total"><?= $precioTotal ?>€</span></p>
    </section>


    <h1>Formulario de Compra</h1>
    <form id="purchase-form" action="map.php?accion=insertar_compra" method="post">
      <div class="form-group">
        <label for="first-name">Nombre:</label>
        <input type="text" id="first-name" name="first-name" value="<?= $usuario->getNombre() ?>" required>
      </div>

      <div class="form-group">
        <label for="last-name">Apellidos:</label>
        <input type="text" id="last-name" name="last-name" value="<?= $usuario->getApellidos() ?>" required>
      </div>

      <div class="form-group">

        <label for="residence">Residencia:</label>
        <input type="text" id="residence" name="residencia"  required>
      </div>

      <div class="form-group">
        <label for="address">Dirección:</label>
        <input type="text" id="address" name="direccion"  required>
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= $usuario->getCorreo() ?>" required>
      </div>



      <div class="form-group">
        <label for="phone">Teléfono:</label>
        <input type="tel" id="phone" name="phone"  required>
      </div>

      <div class="form-group">
        <label for="country">País:</label>
        <select id="country" name="country" required>
          <option value="">Seleccione un país</option>
          <option value="Argentina">Argentina</option>
          <option value="Bolivia">Bolivia</option>
          <option value="Chile">Chile</option>
          <option value="Colombia">Colombia</option>
          <option value="Ecuador">Ecuador</option>
          <option value="España">España</option>
          <option value="México">México</option>
          <option value="Perú">Perú</option>
          <option value="Venezuela">Venezuela</option>
          <!-- Añadir más países según sea necesario -->
        </select>
      </div>

      <div class="form-group">
        <label for="city">Ciudad:</label>
        <input type="text" id="city" name="city" required>
      </div>

      <div class="form-group">
        <label for="zip-code">Código Postal:</label>
        <input type="text" id="zip-code" name="zip-code" required>
      </div>

      <div class="form-group full-width">
        <label for="payment-method">Método de Pago:</label>
        <select id="payment-method" name="payment-method" required>
          <option value="">Seleccione un método de pago</option>
          <option value="credit-card">Tarjeta de Crédito</option>
          <option value="debit-card">Tarjeta de Débito</option>
          <option value="paypal">PayPal</option>
          <!-- Añadir más métodos de pago según sea necesario -->
        </select>
      </div>

      <div class="form-group full-width">
        <label for="comments">Comentarios:</label>
        <textarea id="comments" name="comments" rows="4"></textarea>
      </div>

      <div class="form-group full-width">
        <button type="submit">gfh</button>
      </div>
    </form>
  </div>


</body>

</html>