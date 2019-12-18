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
    if(empty($_POST['descripcion']))  
    {
      $alert = '<p class="msg_error">Debes Teclear el Tipo Componente</p>';
    }
    else
    {  
      $id_tipo_componente = $_POST['id_tipo_componente'];        
      $descripcion = $_POST['descripcion'];

          $consultar = new Conexion();        
          $consultar->query = "UPDATE t_Tipo_Componente SET descripcion = '$descripcion' WHERE id_tipo_componente = $id_tipo_componente";
          //print_r ($consultar->query);
          //exit;

          $consultar->set_query();       

          //$sql_update = mysqli_query($conection,"UPDATE usuario SET nombre = '$nombre', correo = '$correo', usuario = '$usuario', rol = '$rol clave = '$clave' WHERE idusuario = $idusuario");

        if ($consultar == true || $consultar == 1)
        {
          $alert = '<p class="msg_save">Tipo Componente Actualizado correctamente</p>';
        }
        else
        {
          $alert = '<p class="msg_error">Error Al Actualizar El Tipo Componente</p>';
        }

    } // if(empty($_POST['descripcion']) 

  } // if (!empty($_POST))

  // Si no existe el "id" que se mando atráves de la URL, regresa al listado de usuario. 
  if (empty($_GET['id']))
  {
    header ('Location:listar_tipocomp.php');
  }  // if (empty($_GET['id']))
  else
  {
    // Validar que el "id" existe en la base de datos.
    $id_tipo_componente = $_GET['id'];
    $conectar = new Conexion();
    $conectar->query = "SELECT id_tipo_componente,descripcion FROM t_Tipo_Componente WHERE id_tipo_componente = $id_tipo_componente";
    $datos2 = $conectar->get_query();


    //$sql = mysqli_query($conection,"SELECT u.idusuario,u.nombre,u.correo,u.usuario, (u.rol) as idrol, (r.rol) as rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.idusuario = $iduser ");

    if (empty($datos2)) //$conectar->rows))
    {
      header ('Location:listar_tipocomp.php');
    }  
    else
    {

      for ($n=0;$n<count($datos2);$n++)
      {                  
        $id_tipo_componente = $datos2[$n]['id_tipo_componente'];
        $descripcion = $datos2[$n]['descripcion'];

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
	<title>Actualiar Tipo Componente</title>
</head>
<body>
	<?php include "include/header.php" ?>

	<section id="container">
		<!-- Es el contenido del registro de Modelo -->
    <div class="form_register">
      <h1>Actualizar Tipo Componente</h1>
      <hr>
      <div class="alert"><?php echo isset($alert)? $alert : ''?></div>
      <!-- Con "action" vacio se autoprocesara el formulario, es decir se iniciara desde el incio del archivo cuando se oprime el boton "Crear Usuario" -->
      <form action ="" method="post">
        <!-- Se esta enviando un campo oculto "idusuario" ya que se utilizar para actualizar algunos datos -->
        <input type="hidden" name="id_tipo_componente" id="id_tipo_componente" value="<?php echo $id_tipo_componente; ?>">
        <label for="descripcion">Descripcion</label>
        <!-- Para asignar un valor al 'input Nombre '-->
        <input type="text" name="descripcion" id = "descripcion" placeholder="Capturar Tipo Componente" value = "<?php echo $descripcion; ?>">

        <input type="submit" value="Actualizar Tipo Componente" class="btn_save">

      </form>
    </div>

	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>
