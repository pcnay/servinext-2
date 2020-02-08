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
      $id_sucursal = $_POST['id_sucursal'];          
      $nombre = $_POST['nombre'];
      $num_suc = $_POST['num_suc'];
      $domicilio = $_POST['domicilio'];
      $referencias = $_POST['referencias'];
      $tel_fijo = $_POST['tel_fijo'];
      $tel_movil = $_POST['tel_movil'];
      $contacto = $_POST['contacto'];

      // ,contacto = '$contacto' 


        $consulta = new Conexion();        
        $consulta->query = "UPDATE t_Sucursales SET nombre = '$nombre',num_suc ='$num_suc',domicilio = '$domicilio' ,referencias = '$referencias',tel_fijo = '$tel_fijo',tel_movil = '$tel_movil',contacto = '$contacto' WHERE id_sucursal = $id_sucursal";
        //print_r ($consulta->query);
        //exit;

        $Consulta = $consulta->set_query();        
        
        //print_r ($Consulta);
        //exit;

        if ($Consulta == true || $Consulta == 1)
        {
          $alert = '<p class="msg_save">Sucursal Actualizada Correctamente</p>'; 
        }
        else
        {
          $alert = '<p class="msg_error">Error Al Actualizar La Sucursal</p>';
        }             
    } // if(empty($_POST['descripcion']) || ...

  } // if (!empty($_POST))

  // Si no existe el "id" que se mando atráves de la URL, regresa al listado de usuario. 
  if (empty($_GET['id']))
  {
    header ('Location:listar_sucursal.php');
  }
  else
  {
    // Validar que el "id" existe en la base de datos., para ser mostrado en la vista de la pantalla  
    $id_sucursal = $_GET['id'];
    $conectar = new Conexion();
    $conectar->query = "SELECT id_sucursal,nombre,num_suc,domicilio,referencias,tel_fijo,tel_movil,contacto FROM t_Sucursales WHERE id_sucursal = $id_sucursal";
    $datos2 = $conectar->get_query();


    //$sql = mysqli_query($conection,"SELECT u.idusuario,u.nombre,u.correo,u.usuario, (u.rol) as idrol, (r.rol) as rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.idusuario = $iduser ");

    if (empty($datos2)) //$conectar->rows))
    {
      header ('Location:listar_sucursal.php');
    }  
    else
    {
      for ($n=0;$n<count($datos2);$n++)
      {                  
        $id_sucursal = $datos2[$n]['id_sucursal'];
        $nombre = $datos2[$n]['nombre'];
        $num_suc = $datos2[$n]['num_suc'];
        $domicilio = $datos2[$n]['domicilio'];
        $referencias = $datos2[$n]['referencias'];
        $tel_fijo = $datos2[$n]['tel_fijo'];
				$tel_movil = $datos2[$n]['tel_movil'];
				$contacto = $datos2[$n]['contacto'];

      } // for ($n=0;$n<count($datos2);$n++)
  
      
    } // if (empty($datos2))

  } // if (empty($_GET['id']))


?>

<!DOCTYPE html>
<!-- Se agrega este archivo a cada opción del Menu. -->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php"; ?>
	<title>Actualizar Sucursal</title>
</head>
<body>
	<?php include "include/header.php" ?>

	<section id="container">
		<!-- Es el contenido del registro de Refacción -->
    <div class="form_register">
      <h1>Actualizar Sucursal</h1>
      <hr>
      <div class="alert"><?php echo isset($alert)? $alert : ''?></div>
      <!-- Con "action" vacio se autoprocesara el formulario, es decir se iniciara desde el incio del archivo cuando se oprime el boton "Crear Usuario" -->
      <form action ="" method="post">
        <input type="hidden" name="id_sucursal" id="id_sucursal" value="<?php echo $id_sucursal; ?>">

        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id = "nombre" placeholder="Nombre" value = "<?php echo $nombre; ?>">         
        <label for="num_suc">Numero de Sucursal</label>
        <input type="text" name="num_suc" id = "num_suc" placeholder="Número de Sucursal" value = "<?php echo $num_suc
        ; ?>">
        <label for="domicilio">Domicilio</label>
        <input type="text" name="domicilio" id = "domicilio" placeholder="Domicilio" value = "<?php echo $domicilio; ?>">
        <label for="referencias">Referencias</label>        
        <input type="text" name="referencias" id = "referencias" placeholder="Referencias de la Sucursal" value = "<?php echo $referencias; ?>">
        <label for="tel_fijo">Telefono Fijo</label>
        <input type="text" name="tel_fijo" id = "tel_fijo" placeholder="Telefono fijo" value = "<?php echo $tel_fijo; ?>">
        <label for="tel_movil">Telefono Movil</label>
        <input type="text" name="tel_movil" id = "tel_movil" placeholder="Telefono movil" value = "<?php echo $tel_movil; ?>">

				<br/>
        <label for="contacto">Contacto</label>
        <input type="text" name="contacto" id = "contacto" placeholder="Contactos" value = "<?php echo $contacto; ?>">


        <input type="submit" value="Actualizar Sucursal" class="btn_save">

      </form>

    </div>

	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>