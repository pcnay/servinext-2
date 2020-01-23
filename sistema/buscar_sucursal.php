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
	<title>Lista De Sucursales</title>
</head>
<body>
	<?php include "include/header.php" ?>

	<section id="container">
    <!-- Obtener el valor de la variable del formulario "Buscar" -->
    <?php
      // Obtiene el valor tanto de GET o POST
      $busqueda = strtolower($_REQUEST['busqueda']);
      if (empty($busqueda))
      {
        header("location: listar_sucursal.php"); 
      }
    ?>
		<h1>LISTA DE SUCURSALES</h1>
    <a href="registrar_sucursal.php" class="btn_new">Capturar Sucursal</a>
    <a href="rep_excel_sucursal.php" class="btn_new">Reporte Excel</a>
    <a href="rep_suc_busq.php?id=<?php echo $busqueda; ?>" target="_blank" class="btn_reporte">Reporte Equipos</a>

    
    <!-- Sección para Buscar Sucursal -->
    <form action="buscar_sucursal.php" method="get" class="form_search">
      <input type="text" name ="busqueda" id = "busqueda" placeholder = "Buscar" >
      <input type="submit" value="Buscar" class = "btn_search">
    </form>

    <table>
      <tr>        
        <th>ID</th>      
        <th>NOMBRE</th>
        <th>NUME SUC.</th>
        <th>DOMICILIO</th>
        <th>REFERENCIAS</th>
        <th>TEL FIJO</th>
        <th>TEL MOVIL</th>
        <th>CONTACTOS</th>
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
        $conectar->query = "SELECT COUNT(*) AS total_registro FROM t_Sucursales WHERE (id_sucursal LIKE '%$busqueda%' OR nombre LIKE '%$busqueda%' OR num_suc LIKE '%$busqueda%')";
        //print_r ($conectar->query);
        //exit;

        $datos = $conectar->get_query();

        $total_registro = $datos[0]['total_registro'];

        $por_pagina = 7;
        
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
          $consulta->query = "SELECT id_sucursal,nombre,num_suc,domicilio,referencias,tel_fijo,tel_movil,contacto
          FROM t_Sucursales     
          WHERE (id_sucursal LIKE '%$busqueda%' OR nombre LIKE '%$busqueda%' OR num_suc LIKE '%$busqueda%')     
          ORDER BY nombre ASC LIMIT $desde,$por_pagina";

          //print_r ($consulta->query);
          //exit;

          $datos2 = $consulta->get_query();
          //print_r (count($datos2));
          //exit;
        
          for ($n=0;$n<count($datos2);$n++)
          {
       ?>
            <tr>
              <td><?php echo $datos2[$n]['id_sucursal']; ?></td>
              <td><?php echo $datos2[$n]['nombre']; ?></td>
              <td><?php echo $datos2[$n]['num_suc']; ?></td>
              <td><?php echo $datos2[$n]['domicilio']; ?></td>
              <td><?php echo $datos2[$n]['referencias']; ?></td>
              <td><?php echo $datos2[$n]['tel_fijo']; ?></td>
              <td><?php echo $datos2[$n]['tel_movil']; ?></td>
              <td><?php echo $datos2[$n]['contacto']; ?></td>
              <td>
                <!-- Se pasa el "Id" de la sucursal "editar_sucursal"-->
                <a class="link_edit" href="editar_sucursal.php?id=<?php echo $datos2[$n]['id_sucursal']; ?>">Editar</a>             
                |              
                <a class="link_delete" href="eliminar_sucursal.php?id=<?php echo $datos2[$n]['id_sucursal']; ?>">Eliminar</a>
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

	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>