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
    header ("location: ./");
  }

  include "../conexion.php";
  // Para borrar la refaccion.
  if (!empty($_POST))
  {

    $id_refaccion = $_POST['id_refaccion'];
    //$query_delete = mysqli_query($conection,"DELETE FROM usuario  WHERE idusuario=$idusuario");
    $consulta = new Conexion();
    $consulta->query = "DELETE FROM t_Refaccion WHERE id_refaccion = $id_refaccion";
    //print_r ($consulta->query);
    //exit;

    
    $realizado = $consulta->set_query();       

    if ($realizado == true || $realizado == 1)
    {
      header ("Location: lista_refaccion.php");          
      exit;
    }
    else
    {
      echo "Error al eliminar";
    }
  } // if (!empty($_POST))
  else
  {
    $id_refaccion = $_REQUEST['id'];
    
    $consulta = new Conexion();
    $consulta->query = "SELECT id_refaccion,descripcion,num_parte FROM t_Refaccion WHERE id_refaccion=$id_refaccion";

    // "SELECT u.nombre,u.usuario,r.rol FROM t_Usuarios u INNER JOIN t_Rol r ON u.id_rol = r.id_rol WHERE u.idusuario=$idusuario"

    //print_r($consulta->query);
    //exit;
    
    $datos2 = $consulta->get_query();       
    //var_dump ($datos2);
    //print_r(count($datos2));
    //exit;
    
    if (count($datos2)> 0)
    {
      
      for ($n=0;$n<count($datos2);$n++)
      {
        $id_refaccion = $datos2[$n]['id_refaccion'];
        $descripcion = $datos2[$n]['descripcion'];
        $num_parte = $datos2[$n]['num_parte'];
      }
    }
    else
    {
      header("location:lista_refaccion.php");
    }

  } //   if (!empty($_POST))

//    print_r ($nombre); 
//    exit;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php"; ?>
	<title>Eliminar Refaccion</title>
</head>
<body>
	<?php include "include/header.php" ?>

	<section id="container">
    <div class ="data_delete">
		  <h2>Esta seguro de Eliminar la Refaccion</h2> 
      <p>num_parte : <span><?php echo $num_parte; ?></span></p>
      <p>descripcion : <span><?php echo $descripcion; ?></span></p>

      <!-- Se recargara el archivo cuando el action = "" -->
      <form method="post" action = "">
        <input type ="hidden" name="id_refaccion" value ="<?php echo $id_refaccion; ?>">
        <a href="lista_refaccion.php" class="btn_cancel">Cancelar</a>
        <input type = "submit" name="" value ="Aceptar" class="btn_ok">
      </form>
    </div>
	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>
