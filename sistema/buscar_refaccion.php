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
        header ("location: lista_refaccion.php");
      }
    ?>

		<h1>LISTA DE USUARIOS</h1>
    <a href="registrar_refaccion.php" class="btn_new">Capturar Refaccion</a>
    <a href="rep_refacc_busq.php?id=<?php echo $busqueda; ?>" target="_blank" class="btn_reporte">Reporte Refacciones</a>

    <!-- Sección para Buscar usuarios -->
    <form action="buscar_refaccion.php" method="get" class="form_search">
      <input type="text" name ="busqueda" id = "busqueda" placeholder = "Buscar" value="<?php echo $busqueda; ?>" >
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
        
        // Seccion del paginador 
        //$sql_registe = mysqli_query ($conection,"SELECT COUNT(*) AS total_registro FROM usuario WHERE estatus=1");
        //$result_register = mysqli_fetch_array($sql_registe);
        //$total_registro = $result_register['total_registro'];

        $conectar = new Conexion();
        $conectar->query = "SELECT COUNT(*) AS total_registro FROM t_Refaccion WHERE (id_refaccion LIKE '%$busqueda%' OR 
        descripcion LIKE '%$busqueda%' OR 
        fecha LIKE '%$busqueda%' OR
        num_parte LIKE '%$busqueda%')";
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
          $consulta->query = "SELECT r.id_refaccion,r.descripcion,r.num_parte,r.existencia,r.fecha,marca.descripcion AS mar_descripcion,modelo.descripcion AS mod_descripcion,r.observaciones 
          FROM t_Refaccion r 
          INNER JOIN t_Marca AS marca ON r.id_marca = marca.id_marca
          INNER JOIN t_Modelo AS modelo ON r.id_modelo = modelo.id_modelo     
          WHERE (
          r.id_refaccion LIKE '%$busqueda%' OR 
          r.descripcion LIKE '%$busqueda%' OR 
          r.fecha LIKE '%$busqueda%' OR 
          r.num_parte LIKE '%$busqueda%') 
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