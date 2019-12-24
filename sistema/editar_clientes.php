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
  
  // Como se autoprocesa, es decir vuelve a ejecutarse desde el principio cuando se oprime el boton de "Actualizar Usuario"
  if (!empty($_POST))
  {
    $alert = '';
    if(empty($_POST['nombre']))  
    {
      $alert = '<p class="msg_error">Debes Teclear un nombre Cliente</p>';
    }
    else
    {  
      $id_Clientes = $_POST['id_Clientes'];        
      $nombre = $_POST['nombre'];

          $consultar = new Conexion();        
          $consultar->query = "UPDATE t_Clientes SET nombre = '$nombre' WHERE id_Clientes = $id_Clientes";
          //print_r ($consultar->query);
          //exit;

          $consultar->set_query();       

          //$sql_update = mysqli_query($conection,"UPDATE usuario SET nombre = '$nombre', correo = '$correo', usuario = '$usuario', rol = '$rol clave = '$clave' WHERE idusuario = $idusuario");

        if ($consultar == true || $consultar == 1)
        {
          $alert = '<p class="msg_save">Cliente Actualizado correctamente</p>';
        }
        else
        {
          $alert = '<p class="msg_error">Error Al Actualizar El Cliente</p>';
        }

    } // if(empty($_POST['nombre']) 

  } // if (!empty($_POST))

  // Si no existe el "id" que se mando atráves de la URL, regresa al listado de usuario. 
  if (empty($_GET['id']))
  {
    header ('Location:listar_clientes.php');
  }  // if (empty($_GET['id']))
  else
  {
    // Validar que el "id" existe en la base de datos.
    $id_Clientes = $_GET['id'];
    $conectar = new Conexion();
    $conectar->query = "SELECT id_Clientes,nombre FROM t_Clientes WHERE id_Clientes = $id_Clientes";
    $datos2 = $conectar->get_query();


    //$sql = mysqli_query($conection,"SELECT u.idusuario,u.nombre,u.correo,u.usuario, (u.rol) as idrol, (r.rol) as rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.idusuario = $iduser ");

    if (empty($datos2)) //$conectar->rows))
    {
      header ('Location:lista_usuario.php');
    }  
    else
    {

      for ($n=0;$n<count($datos2);$n++)
      {                  
        $id_Clientes = $datos2[$n]['id_Clientes'];
        $nombre = $datos2[$n]['nombre'];

      } // for ($n=0;$n<count($datos2);$n++)

    } // if (empty($datos2)

  } // if (empty($_GET['id']))

?>

<!DOCTYPE html>
<!-- Se agrega este archivo a cada opción del Menu. -->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php"; ?>
	<title>Actualiar Clientes</title>
</head>
<body>
	<?php include "include/header.php" ?>

	<section id="container">
		<!-- Es el contenido del registro de Usuarios -->
    <div class="form_register">
      <h1>Actualizar Clientes</h1>
      <hr>
      <div class="alert"><?php echo isset($alert)? $alert : ''?></div>
      <!-- Con "action" vacio se autoprocesara el formulario, es decir se iniciara desde el incio del archivo cuando se oprime el boton "Crear Usuario" -->
      <form action ="" method="post">
        <!-- Se esta enviando un campo oculto "idusuario" ya que se utilizar para actualizar algunos datos -->
        <input type="hidden" name="id_Clientes" id="id_Clientes" value="<?php echo $id_Clientes; ?>">
        <label for="nombre">Nombre</label>
        <!-- Para asignar un valor al 'input Nombre '-->
        <input type="text" name="nombre" id = "nombre" placeholder="Nombre Completo" value = "<?php echo $nombre ?>">

        <input type="submit" value="Actualizar Usuario" class="btn_save">

      </form>
    </div>

	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>
