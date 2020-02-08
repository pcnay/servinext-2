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
  // Para borrar la sucursal.
  if (!empty($_POST))
  {
    $id_sucursal = $_POST['id_sucursal'];
    //$query_delete = mysqli_query($conection,"DELETE FROM usuario  WHERE idusuario=$idusuario");
    $consulta = new Conexion();
    $consulta->query = "DELETE FROM t_Sucursales WHERE id_sucursal = $id_sucursal";
    //print_r ($consulta->query);
    //exit;

    
    $realizado = $consulta->set_query();       

    if ($realizado == true || $realizado == 1)
    {
      header ("Location: listar_sucursal.php");          
      exit;
    }
    else
    {
      echo "Error al eliminar";
    }
  } // if (!empty($_POST))
  else
  {
    $id_sucursal = $_REQUEST['id'];
    
    $consulta = new Conexion();
    $consulta->query = "SELECT id_sucursal,nombre,num_suc FROM t_Sucursales WHERE id_sucursal=$id_sucursal";
    
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
        $id_sucursal = $datos2[$n]['id_sucursal'];
        $nombre = $datos2[$n]['nombre'];
        $num_suc = $datos2[$n]['num_suc'];
      }
    }
    else
    {
      header("location:listar_sucursal.php");
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
	<title>Eliminar Sucursal</title>
</head>
<body>
	<?php include "include/header.php" ?>

	<section id="container">
    <div class ="data_delete">
		  <h2>Esta seguro de Eliminar la Sucursal</h2> 
      <p>num_suc : <span><?php echo $num_suc; ?></span></p>
      <p>nombre : <span><?php echo $nombre; ?></span></p>

      <!-- Se recargara el archivo cuando el action = "" -->
      <form method="post" action = "">
        <input type ="hidden" name="id_sucursal" value ="<?php echo $id_sucursal; ?>">
        <a href="listar_sucursal.php" class="btn_cancel">Cancelar</a>
        <input type = "submit" name="" value ="Aceptar" class="btn_ok">
      </form>
    </div>
	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>
