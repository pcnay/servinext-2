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

  include "../conexion.php"

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php"; ?>
	<title>Lista De Refacciones</title>
</head>
<body>
	<?php include "include/header.php" ?>

	<section id="container">
		<h1>LISTA DE REFACCIONES</h1>
    <a href="registrar_refaccion.php" class="btn_new">Capturar Refaccion</a>
    <a href="reporte_refaccion.php" target="_blank" class="btn_reporte">Reporte Refaccion</a>

    <!-- Sección para Buscar usuarios -->
    <form action="buscar_refaccion.php" method="get" class="form_search">
      <input type="text" name ="busqueda" id = "busqueda" placeholder = "Buscar" >
      <input type="submit" value="Buscar" class = "btn_search">
    </form>

    <table>
      <tr>        
        <th>ID</th>      
        <th>DESCRIPCION</th>
        <th>NUMERO PARTE</th>
        <th>CANT</th>
        <th>FECHA</th>
        <th>MARCA</th>
        <th>MODELO</th>
        <th>OBSERVACIONES</th>
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
        $conectar->query = "SELECT COUNT(*) AS total_registro FROM t_Refaccion ";
        //print_r ($conectar->query);
        //exit;

        $datos = $conectar->get_query();

        $total_registro = $datos[0]['total_registro'];

        $por_pagina = 15;
        
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
/*
SELECT r.id_refaccion,r.descripcion,r.num_parte,r.existencia,r.fecha,marca.descripcion AS mar_nombre,modelo.descripcion, AS mod_nombre,r.observaciones 
          FROM t_Refaccion r 
          INNER JOIN t_Marca AS marca ON r.id_marca = marca.id_marca 
          INNER JOIN t_Modelo AS modelo ON r.id_modelo = modelo.id_modelo 
          ORDER BY r.descripcion ASC LIMIT $desde,$por_pagina";
*/

          $consulta = new Conexion();
          $consulta->query = "SELECT r.id_refaccion,r.descripcion,r.num_parte,r.existencia,r.fecha,r.id_marca,r.id_modelo,marca.descripcion AS mar_descripcion,modelo.descripcion AS mod_descripcion,r.observaciones 
          FROM t_Refaccion r 
          INNER JOIN t_Marca AS marca ON r.id_marca = marca.id_marca
          INNER JOIN t_Modelo AS modelo ON r.id_modelo = modelo.id_modelo
          ORDER BY r.descripcion ASC LIMIT $desde,$por_pagina";

          //print_r ($consulta->query);
          //exit;

          $datos2 = $consulta->get_query();
          //print_r (count($datos2));
          //exit;
        
          for ($n=0;$n<count($datos2);$n++)
          {
       ?>
            <tr>
              <td><?php echo $datos2[$n]['id_refaccion']; ?></td>
              <td><?php echo $datos2[$n]['descripcion']; ?></td>
              <td><?php echo $datos2[$n]['num_parte']; ?></td>
              <td><?php echo $datos2[$n]['existencia']; ?></td>
              <td><?php echo $datos2[$n]['fecha']; ?></td>
              <td><?php echo $datos2[$n]['mar_descripcion']; ?></td>
              <td><?php echo $datos2[$n]['mod_descripcion']; ?></td>
              <td><?php echo $datos2[$n]['observaciones']; ?></td>
              <td>
                <!-- Se pasa el "Id" del usuario al archivo "editar_usuario"-->
                <a class="link_edit" href="editar_refaccion.php?id=<?php echo $datos2[$n]['id_refaccion']; ?>">Editar</a>             
                |              
                <a class="link_delete" href="eliminar_refaccion.php?id=<?php echo $datos2[$n]['id_refaccion']; ?>">Eliminar</a>
              </td>
            </tr>
      <?php      
          } // for ($n=0;$n<count($datos2);$n++)         
      ?>

    </table>

    <!-- Es la sección de Páginador. -->
    <div class="paginador">
      <ul>
      <!-- Desaparece estos numeros de paginador cuando esta en el primero. -->
        <?php 
          if ($pagina != 1)
          {
        ?>      
            <li><a href="?pagina=<?php echo 1; ?>">|<</a></li>
            <li><a href="?pagina=<?php echo $pagina-1; ?>"><<</a></li>
  
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
              echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
            }            
          }
          // Desaparece los últimos botones del paginador cuando sea la última página.
          if ($pagina != $total_paginas)
          {          
        ?>
        <li><a href="?pagina=<?php echo $pagina+1; ?>">>></a></li>
        <li><a href="?pagina=<?php echo $total_paginas; ?>">>|</a></li>
    <?php }?>

      </ul>
    </div>

	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>