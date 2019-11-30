<?php

// En "Form" no se coloca "action" se autoprocesa el archivo, es decir vuelve empezar desde el inicio.
  // Verifica si el usuario oprimio el boton Submit INGRESAR.

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