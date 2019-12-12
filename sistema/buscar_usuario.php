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
    <!-- Obtener el valor de la variable del formulario "Buscador" -->
    <?php 
      // Obtiene el valor tanto de GET y POST
      $busqueda = strtolower($_REQUEST['busqueda']);
      if (empty($busqueda))
      {
        header ("location: lista_usuario.php");
      }
    ?>

		<h1>LISTA DE USUARIOS</h1>
    <a href="registro_usuario.php" class="btn_new">Crear Usuario</a>

    <!-- Sección para Buscar usuarios -->
    <form action="buscar_usuario.php" method="get" class="form_search">
      <input type="text" name ="busqueda" id = "busqueda" placeholder = "Buscar" value="<?php echo $busqueda; ?>" >
      <input type="submit" value="Buscar" class = "btn_search">
    </form>

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
        
        // Seccion del paginador 
        //$sql_registe = mysqli_query ($conection,"SELECT COUNT(*) AS total_registro FROM usuario WHERE estatus=1");
        //$result_register = mysqli_fetch_array($sql_registe);
        //$total_registro = $result_register['total_registro'];

        $rol = '';
        if ($busqueda == 'administrador')
        {
          $rol = "OR id_rol LIKE '%1%'";
        }
        else if ($busqueda == 'supervisor')
        {
          $rol = "OR id_rol LIKE '%2%'";
        }
        else if ($busqueda == 'ingenieria')
        {
          $rol = "OR id_rol LIKE '%3%'";
        }

        $conectar = new Conexion();
        $conectar->query = "SELECT COUNT(*) AS total_registro FROM t_Usuarios WHERE (idusuario LIKE '%$busqueda%' OR 
        nombre LIKE '%$busqueda%' OR 
        email LIKE '%$busqueda%' OR 
        usuario LIKE '%$busqueda%'
        $rol ) 
        AND estatus = '1'";
        //print_r ($conectar->query);
        //exit;

        $datos = $conectar->get_query();

        $total_registro = $datos[0]['total_registro'];

        //print_r (count($datos));
        //exit;

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

        //print_r ($desde);
        //print_r ($total_paginas);
        //exit;

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
          $consulta->query = "SELECT u.idusuario,u.nombre,u.email,u.usuario,u.cumpleanos,r.rol FROM t_Usuarios u INNER JOIN t_Rol r ON u.id_rol = r.id_rol WHERE (
          u.idusuario LIKE '%$busqueda%' OR 
          u.nombre LIKE '%$busqueda%' OR 
          u.email LIKE '%$busqueda%' OR 
          u.usuario LIKE '%$busqueda%' OR
          r.rol LIKE '%$busqueda%') AND                    
          (u.estatus = '1') ORDER BY u.nombre ASC LIMIT $desde,$por_pagina";

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
    <!-- Si no existen registros, no mostrara el paginador. -->
    <?php 
      if ($total_registro != 0)
      {      
    ?>

    <div class="paginador">
      <ul>
      <!-- Desaparece estos numeros de paginador cuando esta en el primero. -->
        <?php 
          if ($pagina != 1)
          {
        ?>      
            <li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>">|<</a></li>
            <li><a href="?pagina=<?php echo $pagina-1; ?>&busqueda=<?php echo $busqueda; ?>"><<</a></li>
  
        <?php 
          }
          for ($i=1;$i<=$total_paginas;$i++)
          {
            // Para selecccionar el número de página.
            if ($i == $pagina)
            {
              // pagina = Esta variable es la que se pasa en la URL.
              echo '<li class="pageSelected">'.$i.'</li>';
            }
            else
            {
              echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
            }            
          }
          // Desaparece los últimos botones del paginador cuando sea la última página.
          if ($pagina != $total_paginas)
          {          
        ?>
        <li><a href="?pagina=<?php echo $pagina+1; ?>&busqueda=<?php echo $busqueda; ?>">>></a></li>
        <li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?>">>|</a></li>
    <?php }?>

      </ul>
    </div>

  <?php }  //if ($total_registro != 0) ?>

	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>