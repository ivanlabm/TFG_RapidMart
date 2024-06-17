<?php 
require_once 'modelos/ConnexionDB.php';
require_once 'modelos/Usuarios.php';
require_once 'modelos/UsuariosDAO.php';
require_once 'config/config.php';
require_once 'utils/funciones.php';

        
Class ControladorUsuarios {
    public function registrar() {
        $error = "";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Corrección: 'correo' a 'email'
            $nombre = htmlentities($_POST['nombre']);
            $apellidos = htmlentities($_POST['apellidos']); // Añadido: recuperar apellidos
            $correo = htmlentities($_POST['correo']);
            $password = htmlentities($_POST['password']);
            $rol = "usuario";
            $foto = "";
           

            $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
            $conn = $connexionDB->getConnexion();

            $usuarioDAO = new UsuariosDAO($conn);

            if ($usuarioDAO->getByCorreo($correo) != null) { // Corrección: 'email' a 'correo'
                $error = "Ya hay un usuario con este email";

            }  if ($_FILES['foto']['type'] != 'image/jpeg' && $_FILES['foto']['type'] != 'image/webp' && $_FILES['foto']['type'] != 'image/png' ) {
                $error = "La foto no tiene el formato adecuado";
                guardarMensaje($foto);
                header('location:map.php?accion=inicio');

               
            } else {
                $foto = $usuarioDAO->generarNombreArchivo($_FILES['foto']['name']); // Corrección: $DAO a $usuarioDAO
                while (file_exists("fotoUsuario/$foto")) {
                    $foto = $usuarioDAO->generarNombreArchivo($_FILES['foto']['name']); // Corrección: $DAO a $usuarioDAO
                }
                if (!move_uploaded_file($_FILES['foto']['tmp_name'], "fotoUsuario/$foto")) {
                    $error="Error al copiar la foto a la carpeta fotoUsuario";
                    
                 
                } else {
                    $foto = $usuarioDAO->generarNombreArchivo($_FILES['foto']['name']);

                }

                if ($error == "") {
                    $usuario = new Usuarios();
                    $usuario->setNombre($nombre);
                    $usuario->setApellidos($apellidos);
                    $usuario->setCorreo($correo);
                    $usuario->setRol($rol);
                    $passwordCifrado = password_hash($password, PASSWORD_DEFAULT);
                    $usuario->setPassword($passwordCifrado);
                    $usuario->setFoto($foto);
                    $usuario->setSid(sha1(rand() . time()), true);

                    if ($usuarioDAO->insert($usuario)) {
                        header('location: map.php?accion=inicio');
                        exit();
                    } else {
                        $error = "No se ha podido insertar el usuario";
                    }
                }
            }
        }
    }





    

    public function login(){
        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        //limpiamos los datos que vienen del usuario
        $correo = htmlentities($_POST['correo']);  // Añadido: recuperar apellidos
        $password = htmlentities($_POST['password']);

        //Validamos el usuario
        $usuariosDAO = new UsuariosDAO($conn);
        if($usuario = $usuariosDAO->getByCorreo($correo)){
            
       if(password_verify($password, $usuario->getPassword()))
        {
            //email y password correctos. Inciamos sesión
            Sesion::iniciarSesion($usuario);
    
            //Creamos la cookie para que nos recuerde 1 semana
            setcookie('sid',$usuario->getSid(),time()+24*60*60,'/');
            
            //Redirigimos a map.php
            header('location: map.php?accion=inicio');
            require 'vistas/index.php';
            die();
        }
        
    }
        
       
    }

    public function logout(){
        Sesion::cerrarSesion();
        setcookie('sid','',0,'/');
        header('location: map.php?accion=inicio');
        require 'vistas/index.php';
        die();
    }


    public function verUsuarios() {

        //Creamos la conexión utilizando la clase que hemos creado
        $connexionDB = new ConnexionDB(MYSQL_USER,MYSQL_PASS,MYSQL_HOST,MYSQL_DB);
        $conn = $connexionDB->getConnexion();

        //Creamos el objeto TareasDAO para acceder a BBDD a través de este objeto
        $usuario=array();
        $usuarioDAO = new UsuariosDAO($conn);
        
       
        //Incluyo la vista
        require 'vistas/vistaUsuarios.php';
   }

   public function usuarioEditar() {
    $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
    $conn = $connexionDB->getConnexion();
    $usuariosDAO = new UsuariosDAO($conn);
    $idUsuario = htmlspecialchars($_GET['id']);
    $usuario = $usuariosDAO->getById($idUsuario);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = htmlspecialchars($_POST['nombre']);
        $apellidos = htmlspecialchars($_POST['apellidos']);
        $rol = htmlspecialchars($_POST['rol']);
        

        $usuario->setNombre($nombre);
        $usuario->setApellidos($apellidos);
        $usuario->setRol($rol);
       
        guardarMensaje($nombre);
        if ($usuariosDAO->update($usuario)) {
            //guardarMensaje("usuario actualizado correctamente");
        } else {
           // guardarMensaje("Error al actualizar el usuario");
        }

        header('Location: map.php?accion=verUsuarios');
        exit;
    }
    }


    public function insertarVendedor() {
        $connexionDB = new ConnexionDB(MYSQL_USER, MYSQL_PASS, MYSQL_HOST, MYSQL_DB);
        $conn = $connexionDB->getConnexion();
        $usuariosDAO = new UsuariosDAO($conn);
        $idUsuario = htmlspecialchars($_GET['id']);
        $usuario = $usuariosDAO->getById($idUsuario);
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $rol = "Vendedor";
        
          guardarMensaje($rol);
            $usuario->setRol($rol);
           
    
            if ($usuariosDAO->update($usuario)) {
                //guardarMensaje("usuario actualizado correctamente");
            } else {
               // guardarMensaje("Error al actualizar el usuario");
            }
    
            header('Location: map.php?accion=verUsuarios');
            exit;
        }
        }

}