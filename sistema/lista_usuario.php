<?php
  include "../conexion.php"

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php"; ?>
	<title>Lista De Usuarios</title>
</head>
<body>
	<?php include "include/header.php" ?>

	<section id="container">
		<h1>LISTA DE USUARIOS</h1>
    <a href="registro_usuario.php" class="btn_new">Crear Usuario</a>
    <table>
      <tr>        
        <th>ID</th>      
        <th>NOMBRE</th>
        <th>CORREO</th>
        <th>USUARIO</th>
        <th>CUMPLEAÑOS</th>
        <th>PERFIL</th>
        <th>ACCIONES</th>        
      </tr>

      <?php
        //$query = mysqli_query($conection,"SELECT u.idusuario,u.nombre,u.correo,u.usuario,r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.estatus=1");
        $consulta = new Conexion();
        $consulta->query = "SELECT u.idusuario,u.nombre,u.email,u.usuario,u.cumpleanos,u.id_rol,r.rol FROM t_Usuarios u INNER JOIN t_Rol r ON u.id_rol = r.id_rol WHERE u.estatus = '1'";
        //$consulta->get_query();       
  /*
        if (!empty($consulta->rows))        
        {
          $datos2 = array();
          foreach ($consulta->rows as $nombreCampo => $contenidoCampo)
          {
            // Agrega al final del arreglo una nueva posicion.
            array_push($datos2,$contenidoCampo);
            // La otra forma:
            // $datos[$nombreCampo] = $contenidoCampo;  
          }  
*/

          $datos2 = $consulta->get_query();

        
          for ($n=0;$n<count($datos2);$n++)
          {
       ?>
            <tr>
              <td><?php echo $datos2[$n]['idusuario']; ?></td>
              <td><?php echo $datos2[$n]['nombre']; ?></td>
              <td><?php echo $datos2[$n]['email']; ?></td>
              <td><?php echo $datos2[$n]['usuario']; ?></td>
              <td><?php echo $datos2[$n]['cumpleanos']; ?></td>
              <td><?php echo $datos2[$n]['rol']; ?></td>
              <td>
                <!-- Se pasa el "Id" del usuario al archivo "editar_usuario"-->
                <a class="link_edit" href="editar_usuario.php?id=<?php echo $datos2[$n]['idusuario']; ?>">Editar</a>
                
                <!-- NO permite borrar al Usuario Administrador principal. -->
                <?php if ($datos2[$n]['idusuario'] != 1) { ?>
                    |              
                    <a class="link_delete" href="eliminar_usuario.php?id=<?php echo $datos2[$n]['idusuario']; ?>">Eliminar</a>
                <?php } ?>
              </td>
            </tr>
      <?php      
        } // if (!empty($conectar->rows))

         // } // for ($n=0;$n<count($datos2);$n++)
      ?>

    </table>

    <!-- Es la sección de Páginador. -->
    <div class="paginador">
      <ul>
        <li><a href="#">|<</a></li>
        <li><a href="#"><<</a></li>
        <li class="pageSelected" >1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
        <li><a href="#">>></a></li>
        <li><a href="#">>|</a></li>
      </ul>
    </div>

	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>