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
        //$consulta->get_query();  
        
        // Seccion del paginador 
        //$sql_registe = mysqli_query ($conection,"SELECT COUNT(*) AS total_registro FROM usuario WHERE estatus=1");
        //$result_register = mysqli_fetch_array($sql_registe);
        //$total_registro = $result_register['total_registro'];
        $conectar = new Conexion();
        $conectar->query = "SELECT COUNT(*) AS total_registro FROM t_Usuarios WHERE estatus='1'";
        //print_r ($conectar->query);
        //exit;

        $datos = $conectar->get_query();

        $total_registro = $datos[0]['total_registro'];

        $por_pagina = 3;
        
        // Este valor es que se pasara por la URL, cuando se oprime un número del paginador.
        if (empty ($_GET['pagina']))
        {
          $pagina = 1;
        }
        else
        {
          $pagina = $_GET['pagina'];
        }

        $desde = ($pagina-1)*$por_pagina;
        $total_paginas = ceil($total_registro/$por_pagina);

        //$query = mysqli_query($conection,"SELECT u.idusuario,u.nombre,u.correo,u.usuario,r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.estatus = 1 ORDER BY u.nombre ASC LIMIT $desde,$por_pagina");        

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

          $consulta = new Conexion();
          $consulta->query = "SELECT u.idusuario,u.nombre,u.email,u.usuario,u.cumpleanos,r.rol FROM t_Usuarios u INNER JOIN t_Rol r ON u.id_rol = r.id_rol WHERE u.estatus = '1' ORDER BY u.nombre ASC LIMIT $desde,$por_pagina";
          //print_r ($consulta->query);
          //exit;

          $datos2 = $consulta->get_query();
          //print_r (count($datos2));
          //exit;
        
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
                |              
                <a class="link_delete" href="eliminar_usuario.php?id=<?php echo $datos2[$n]['idusuario']; ?>">Eliminar</a>
              </td>
            </tr>
      <?php      
          } // for ($n=0;$n<count($datos2);$n++)         
      ?>

    </table>

    <!-- Es la sección de Páginador. -->
    <div class="paginador">
      <ul>
        <li><a href="#">|<</a></li>
        <li><a href="#"><<</a></li>
        <?php 
          for ($i=1;$i<=$total_paginas;$i++)
          {
            // pagina = Esta variable es la que se pasa en la URL.
            echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
          }
        ?>
        <li><a href="#">>></a></li>
        <li><a href="#">>|</a></li>
      </ul>
    </div>

	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>