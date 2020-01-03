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
    /* Valores originales, pero no funciona en PHP Ver 7 
    "use_only_cookies" => 1,
    "auto_start" => 1,
    "read_and_close" => true
    */
  ]); 

  if ($_SESSION['id_rol'] != 1)
  {
    header ("Location: ./");
  }

  include "../conexion.php";
  
  if (!empty($_POST))
  {
    $alert = '';
    if(empty($_POST['nombre']) || empty($_POST['num_suc']) || empty($_POST['domicilio']) || empty($_POST['referencias']) || empty($_POST['tel_fijo']) || empty($_POST['tel_movil']) || empty($_POST['contacto']))  
    {
      $alert = '<p class="msg_error">Todos los campos son obligatorios </p>';
    }
    else
    {          
      $nombre = $_POST['nombre'];
      $num_suc = $_POST['num_suc'];
      $domicilio = $_POST['domicilio'];
      $referencias = $_POST['referencias'];
      $tel_fijo = $_POST['tel_fijo'];
      $tel_movil = $_POST['tel_movil'];
      $contacto = $_POST['contacto'];


        //$query_insert = mysqli_query($conection, "INSERT INTO usuario(idusuario,nombre,correo,usuario,clave,rol) VALUES (0,'$nombre','$correo','$usuario','$clave','$rol')");
        $consulta = new Conexion();        
        $consulta->query = "INSERT INTO t_Sucursales(id_sucursal,nombre,num_suc,domicilio,referencias,tel_fijo,tel_movil,contacto) VALUES (0,'$nombre','$num_suc','$domicilio','$referencias','$tel_fijo','$tel_movil','$contacto')";
        //print_r ($consulta->query);
        //exit;

        $Consulta = $consulta->set_query();        
        
        //print_r ($consulta->query);
        //exit;

        if ($Consulta == true || $Consulta == 1)
        {
          $alert = '<p class="msg_save">Sucursal Capturada correctamente</p>'; 
        }
        else
        {
          $alert = '<p class="msg_error">Error Al Capturar La Sucursal</p>';
        }             
    } // if(empty($_POST['descripcion']) || ...

  } // if (!empty($_POST))

?>

<!DOCTYPE html>
<!-- Se agrega este archivo a cada opción del Menu. -->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php"; ?>
	<title>Registrar Sucursal</title>
</head>
<body>
	<?php include "include/header.php" ?>

	<section id="container">
		<!-- Es el contenido del registro de Refacción -->
    <div class="form_register">
      <h1>Registrar Sucursal</h1>
      <hr>
      <div class="alert"><?php echo isset($alert)? $alert : ''?></div>
      <!-- Con "action" vacio se autoprocesara el formulario, es decir se iniciara desde el incio del archivo cuando se oprime el boton "Crear Usuario" -->
      <form action ="" method="post">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id = "nombre" placeholder="Nombre de Sucursal">         
        <label for="num_suc">Numero De Sucursal</label>
        <input type="text" name="num_suc" id = "num_suc" placeholder="Número de Sucursal">
        <label for="domicilio">Domicilio</label>
        <input type="text" name="domicilio" id = "domicilio" placeholder="Domicilio">
        <label for="tel_fijo">Telefono Fijo</label>
        <input type="text" name="tel_fijo" id = "tel_fijo" placeholder="Telefono Fijo">
        <label for="tel_cel">Telefono Celular</label>
        <input type="text" name="tel_movil" id = "tel_movil" placeholder="Telefono Celular">
        <label for="contacto">Contacto</label>
        <input type="text" name="contacto" id = "contacto" placeholder="Contacto">
        
        <label for="referencia">Referencia</label>
        <textarea name="referencias" id="referencias" cols="42" rows = "10" placeholder="Referencias"></textarea>

        <input type="submit" value="Alta Sucursal" class="btn_save">

      </form>
    </div>

	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>