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
  // Para borrar el modelo.
  if (!empty($_POST))
  {
    // Si cambian el valor desde "Inspeccionar elemento".
    /*
    if ($_POST['id_Clientes'] == 1)
    {
      header ("location:listar_clientes.php");
      exit;
    }
    */

    $id_tipo_componente = $_POST['id_tipo_componente'];
    //$query_delete = mysqli_query($conection,"DELETE FROM usuario  WHERE idusuario=$idusuario");
    $consulta = new Conexion();
    $consulta->query = "DELETE FROM t_Tipo_Componente WHERE id_tipo_componente = $id_tipo_componente";
    //print_r ($consulta->query);
    //exit;

    
    $realizado = $consulta->set_query();       

    if ($realizado == true || $realizado == 1)
    {
      header ("Location: listar_tipocomp.php");          
      exit;
    }
    else
    {
      echo "Error al eliminar";
    }
  } // if (!empty($_POST))
  else
  {
    $id_tipo_componente = $_REQUEST['id'];
    
    $consulta = new Conexion();
    $consulta->query = "SELECT id_tipo_componente,descripcion FROM t_Tipo_Componente WHERE id_tipo_componente=$id_tipo_componente";

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
        $id_tipo_componente = $datos2[$n]['id_tipo_componente'];
        $descripcion = $datos2[$n]['descripcion'];
      }
    }
    else
    {
      header("location:listar_tipocomp.php");
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
	<title>Eliminar Tipo Componente</title>
</head>
<body>
	<?php include "include/header.php" ?>

	<section id="container">
    <div class ="data_delete">
		  <h2>Esta seguro de Eliminar el Tipo Componente</h2> 
      <p>ID : <span><?php echo $id_tipo_componente; ?></span></p>
      <p>Descripcion : <span><?php echo $descripcion; ?></span></p>

      <!-- Se recargara el archivo cuando el action = "" -->
      <form method="post" action = "">
        <input type ="hidden" name="id_tipo_componente" value ="<?php echo $id_tipo_componente; ?>">
        <a href="listar_tipocomp.php" class="btn_cancel">Cancelar</a>
        <input type = "submit" name="" value ="Aceptar" class="btn_ok">
      </form>
    </div>
	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>
