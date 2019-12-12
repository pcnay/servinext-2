<?php
  // En "Form" no se coloca "action" se autoprocesa el archivo, es decir vuelve empezar desde el inicio.
  // Verifica si el usario oprimio el boton Submit INGRESAR.
  $alert = '';
  session_start([
    "use_only_cookies" => 1,
    //x Este valor es solo modificable en ".htaccess, httpd.conf,user.ini
    // No tine sentido en tiempo de ejecución decirle a PHP que autinicie sesion
    // a la vez que inicias session.
    "auto_start", // <=======
    "read_and_close" => false // La sesion se cierre automaticamente.
                              // Si se coloca a "true" no funciona la variable Global 
                              // $_SESSION['ok'],
    /* Valores originales, pero no funciona en PHP Ver 7 
    "use_only_cookies" => 1,
    "auto_start" => 1,
    "read_and_close" => true
    */
  ]); 

  // Esta linea es para que no muestre de nuevo la pantalla de Login cuando se haya iniciado la session.
  if (!empty($_SESSION['active']))
  {
    header('location: sistema/');
  }
  else
  {  
    if (!empty($_POST))
    {
      if (empty($_POST['usuario']) || empty($_POST['clave']))
      {
        $alert = 'Ingrese su usuario Y/o Contraseña ';
      }
      else
      {
        require_once "conexion.php";
        // mysqli_real_escape_string = Para pasar todo lo que se teclea a Texto, evita inyeccion de SQL, caracter "", 
        
        //$user = mysqli_real_escape_string($conection,$_POST['usuario']);
        $user = $_POST['usuario'];
        //$pass = MD5(mysqli_real_escape_string($conection,$_POST['clave']));
        $pass = MD5($_POST['clave']);
        

        $conectar = new Conexion();        
        $conectar->query = "SELECT * FROM t_Usuarios WHERE usuario = '$user' AND clave = '$pass'";
        $conectar->get_query();       
        
        //Encontro el usario
        if (!empty($conectar->rows))
        {
          $datos2 = array();
          foreach ($conectar->rows as $nombreCampo => $contenidoCampo)
          {
            // Agrega al final del arreglo una nueva posicion.
            array_push($datos2,$contenidoCampo);
            // La otra forma:
            // $datos[$nombreCampo] = $contenidoCampo;
  
          }
  
          $_SESSION['active'] = true;
          $_SESSION['nombre'] = $datos2[0]['nombre'];
          $_SESSION['email'] = $datos2[0]['email'];
          $_SESSION['usuario'] = $datos2[0]['usuario'];
          $_SESSION['id_rol'] = $datos2[0]['id_rol'];

          header('location: sistema/');
        }
        else
        {
          $alert = 'El usuario y/o clave son incorrectos';
          session_destroy();
        }

      } // if (empty($_POST['usuario']) || empty($_POST['clave']))

    } // if (!empty($_POST))

  } // else if (!empty($_SESSION['active']))

?>
<!DOCTYPE html>
  <html lang="es">
  <head>
    <meta charset = "UTF-8">
    <title>Login Sistema De Facturacion</title>
    <link rel="stylesheet" type ="text/css" href="css/style.css">
  </head>
  <body>
    <section id = "container">
      <form action = "" method ="post">
        <h3>Iniciar Sesion</h3>
        <img src="img/login.png" alt = "Login">
        <input type="text" name= "usuario" placeholder="Usuario">
        <input type="password" name= "clave" placeholder="Contraseña">
        <div class="alert"><?php echo (isset($alert)? $alert : ''); ?></div>
        <input type="submit" value ="INGRESAR">

      </form>
    </section>

  </body>

</html>