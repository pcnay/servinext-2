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

  if ($_SESSION['rol'] != 1)
  {
    header ("location: ./");
  }

  include "../conexion.php";
  // Para borrar el usuario.
  if (!empty($_POST))
  {
    // Si cambian el valor desde "Inspeccionar elemento".
    if ($_POST['idusuario'] == 1)
    {
      header ("location:lista_usuario.php");
      exit;
    }
    
    $idusuario = $_POST['idusuario'];
    //$query_delete = mysqli_query($conection,"DELETE FROM usuario  WHERE idusuario=$idusuario");
    $consulta = new Conexion();
    $consulta->query = "UPDATE t_Usuarios SET estatus = '0' WHERE idusuario = $idusuario";
    
    $realizado = $consulta->set_query();       

    if ($realizado == true || $realizado == 1)
    {
      header ("location:lista_usuario.php");          
    }
    else
    {
      echo "Error al eliminar";
    }
  }

  // $_REQUEST = permite tomar valores de $_GET, $_POST 
  //$_REQUEST['id'] == 1 para no borrar el Usuario Administrador Principal. 
  if (empty($_REQUEST['id']) || $_REQUEST['id']==1)
  {
    header ("location:lista_usuario.php");    
  }
  else
  {    
    $idusuario = $_REQUEST['id'];
    
    $consulta = new Conexion();
    $consulta->query = "SELECT u.nombre,u.usuario,r.rol FROM t_Usuarios u INNER JOIN t_Rol r ON u.id_rol = r.id_rol WHERE u.idusuario=$idusuario";

    // "SELECT u.nombre,u.usuario,r.rol FROM t_Usuarios u INNER JOIN t_Rol r ON u.id_rol = r.id_rol WHERE u.idusuario=$idusuario"

    //print_r($consulta->query);
    //exit;
    
    $datos2 = $consulta->get_query();       
    //var_dump ($consulta->rows);
    //exit;
    
    if (!empty($consulta->rows))
    {
      /*      
      $datos2 = array();
      foreach ($consulta->rows as $nombreCampo => $contenidoCampo)
      {
        // Agrega al final del arreglo una nueva posicion.
        array_push($datos2,$contenidoCampo);
        // La otra forma:
        // $datos[$nombreCampo] = $contenidoCampo;  
      }  
      */
      
      for ($n=0;$n<count($datos2);$n++)
      {
        $nombre = $datos2[$n]['nombre'];
        $usuario = $datos2[$n]['usuario'];
        $rol = $datos2[$n]['rol'];
      }
    }
    else
    {
      header("location:lista_usuario.php");
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php"; ?>
	<title>Eliminar Usuario</title>
</head>
<body>
	<?php include "include/header.php" ?>

	<section id="container">
    <div class ="data_delete">
		  <h2>Esta seguro de Eliminar el Usuario</h2> 
      <p>Nombre : <span><?php echo $nombre; ?></span></p>
      <p>Usuario : <span><?php echo $usuario; ?></span></p>
      <p>Rol : <span><?php echo $rol; ?></span></p>
      <!-- Se recargara el archivo cuando el action = "" -->
      <form method="post" action = "">
        <input type ="hidden" name="idusuario" value ="<?php echo $idusuario; ?>">
        <a href="lista_usuario.php" class="btn_cancel">Cancelar</a>
        <input type = "submit" name="" value ="Aceptar" class="btn_ok">
      </form>
    </div>
	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>
