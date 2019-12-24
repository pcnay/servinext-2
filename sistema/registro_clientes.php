<?php

  session_start([
    "use_only_cookies" => 1,
    //x Este valor es solo modificable en ".htaccess, httpd.conf,user.ini
    // No tine sentido en tiempo de ejecución decirle a PHP que autinicie sesion
    // a la vez que inicias session.
    "auto_start", // <=======
    "read_and_close" => false // La sesion se cierre automaticamente.
                              // Si se coloca a "true" no funciona la variable Global 
                              // $_SESSION['ok'],
    // Valores originales, pero no funciona en PHP Ver 7 
    //"use_only_cookies" => 1,
    //"auto_start" => 1,
    //"read_and_close" => true
    
  ]); 

  if ($_SESSION['id_rol'] != 1)
  {
    header ("Location: ./");
  }

  include "../conexion.php";
  
  if (!empty($_POST))
  {
    $alert = '';
    if(empty($_POST['nombre']))
    {
      $alert = '<p class="msg_error">Debe Teclear un Nombre Cliente</p>';
    }
    else
    {          
      $nombre = $_POST['nombre'];

        $consulta = new Conexion();        
        $consulta->query = "INSERT INTO t_Clientes(id_Clientes,nombre) VALUES (0,'$nombre')";
        //print_r ($consulta->query);

        $Consulta = $consulta->set_query();        
        
        //print_r ($Consulta);
        //exit;

        if ($Consulta == true || $Consulta == 1)
        {
          $alert = '<p class="msg_save">Cliente creado correctamente</p>'; 
        }
        else
        {
          $alert = '<p class="msg_error">Error Al Crear El Usuario</p>';
        }            
    } // if(empty($_POST['nombre']))

  } // if (!empty($_POST))
  
?>

<!DOCTYPE html>
<!-- Se agrega este archivo a cada opción del Menu. -->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php"; ?>  
	<title>Registro Clientes</title>
</head>
<body>
	<?php include "include/header.php"; ?>

	<section id="container">
		<!-- Es el contenido del registro de Clientes -->
    <div class="form_register">
      <h1>Registro Clientes</h1>
      <hr>
      <div class="alert"><?php echo isset($alert)? $alert : ''?></div>
      <!-- Con "action" vacio se autoprocesara el formulario, es decir se iniciara desde el incio del archivo cuando se oprime el boton "Crear Usuario" -->
      <form action ="" method="post">
        <label for="nombre">Cliente</label>
        <input type="text" name="nombre" id = "nombre" placeholder="Nombre Cliente">         

        <input type="submit" value="Crear Cliente" class="btn_save">

      </form>
    </div>

	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>