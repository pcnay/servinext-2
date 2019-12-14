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
	<title>Lista De Clientes</title>
</head>
<body>
	<?php include "include/header.php" ?>

	<section id="container">
		<h1>LISTA DE CLIENTES</h1>
    <a href="registro_clientes.php" class="btn_new">Crear Cliente</a>
    <a href="reporte-clientes.php" target="_blank" class="btn_reporte">Reporte Clientes</a>

    <!-- Sección para Buscar usuarios -->
    <form action="buscar_cliente.php" method="get" class="form_search">
      <input type="text" name ="busqueda" id = "busqueda" placeholder = "Buscar" >
      <input type="submit" value="Buscar" class = "btn_search">
    </form>

    <table>
      <tr>        
        <th>ID</th>      
        <th>NOMBRE</th>
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
        $conectar->query = "SELECT COUNT(*) AS total_registro FROM t_Clientes ";
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
          $consulta->query = "SELECT id_Clientes,nombre FROM t_Clientes ORDER BY nombre ASC LIMIT $desde,$por_pagina";
          //print_r ($consulta->query);
          //exit;

          $datos2 = $consulta->get_query();
          //print_r (count($datos2));
          //exit;
        
          for ($n=0;$n<count($datos2);$n++)
          {
       ?>
            <tr>
              <td><?php echo $datos2[$n]['id_Clientes']; ?></td>
              <td><?php echo $datos2[$n]['nombre']; ?></td>
              <td>
                <!-- Se pasa el "Id" del cliente al archivo "editar_cliente"-->
                <a class="link_edit" href="editar_clientes.php?id=<?php echo $datos2[$n]['id_Clientes']; ?>">Editar</a>             
                |              
                <a class="link_delete" href="eliminar_cliente.php?id=<?php echo $datos2[$n]['id_Clientes']; ?>">Eliminar</a>
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