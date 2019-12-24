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
    if(empty($_POST['descripcion']))
    {
      $alert = '<p class="msg_error">Debe Teclear un Nombre de Modelo</p>';
    }
    else
    {          
      $descripcion = $_POST['descripcion'];

        $consulta = new Conexion();        
        $consulta->query = "INSERT INTO t_Modelo(id_modelo,descripcion) VALUES (0,'$descripcion')";
        //print_r ($consulta->query);

        $Consulta = $consulta->set_query();        
        
        //print_r ($Consulta);
        //exit;

        if ($Consulta == true || $Consulta == 1)
        {
          $alert = '<p class="msg_save">Modelo Capturado correctamente</p>'; 
        }
        else
        {
          $alert = '<p class="msg_error">Error Al Capturar El Modelo</p>';
        }            
    } // if(empty($_POST['descripcion']))

  } // if (!empty($_POST))
  
?>

<!DOCTYPE html>
<!-- Se agrega este archivo a cada opción del Menu. -->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php"; ?>  
	<title>Registrando El Modelo</title>
</head>
<body>
	<?php include "include/header.php"; ?>

	<section id="container">
		<!-- Es el contenido del registro de Clientes -->
    <div class="form_register">
      <h1>Registrando El Modelo</h1>
      <hr>
      <div class="alert"><?php echo isset($alert)? $alert : ''?></div>
      <!-- Con "action" vacio se autoprocesara el formulario, es decir se iniciara desde el incio del archivo cuando se oprime el boton "Crear Usuario" -->
      <form action ="" method="post">
        <label for="descripcion">Modelo</label>
        <input type="text" name="descripcion" id = "descripcion" placeholder="Capturar El Modelo">         

        <input type="submit" value="Capturar Modelo" class="btn_save">

      </form>
    </div>

	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>