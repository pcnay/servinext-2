<?php 

  include "../conexion.php";
  // Para borrar el usuario.
  if (!empty($_POST))
  {
    $idusuario = $_POST['idusuario'];
    //$query_delete = mysqli_query($conection,"DELETE FROM usuario  WHERE idusuario=$idusuario");
    $query_delete = mysqli_query($conection,"UPDATE usuario SET estatus = 0 WHERE idusuario = $idusuario");

    if ($query_delete)
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
    $query = mysqli_query($conection,"SELECT u.nombre,u.usuario,r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.idusuario=$idusuario");
    $result = mysqli_num_rows($query);
    if ($result > 0)
    {
      while ($data = mysqli_fetch_array($query))
      {
        $nombre = $data['nombre'];
        $usuario = $data['usuario'];
        $rol = $data['rol'];
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
