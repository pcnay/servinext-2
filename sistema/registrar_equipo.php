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
		header ("Location: ./");
  }

  include "../conexion.php";
  
  if (!empty($_POST))
  {
    $alert = '';
    if(empty($_POST['num_serie']) || empty($_POST['num_inv']) || empty($_POST['num_parte']) || empty($_POST['existencia']) || empty($_POST['marca']) || empty($_POST['modelo']) || empty($_POST['tipo_comp']))  
    {
      $alert = '<p class="msg_error">Todos los campos son obligatorios </p>';
    }
    else
    {          
      $num_serie = $_POST['num_serie'];
      $num_inv = $_POST['num_inv'];
      $num_parte = $_POST['num_parte'];
      $existencia = $_POST['existencia'];
      $marca = $_POST['marca'];
			$modelo = $_POST['modelo'];
			$tipo_comp = $_POST['tipo_comp'];
  		$comentarios = $_POST['comentarios'];


        //$query_insert = mysqli_query($conection, "INSERT INTO usuario(idusuario,nombre,correo,usuario,clave,rol) VALUES (0,'$nombre','$correo','$usuario','$clave','$rol')");
        $consulta = new Conexion();        
        $consulta->query = "INSERT INTO t_Equipo(id_epo,num_serie,num_inv,num_parte,existencia,id_marca,id_modelo,id_tipo_componente,comentarios) VALUES (0,'$num_serie','$num_inv','$num_parte',$existencia,$marca,$modelo,$tipo_comp,'$comentarios')";
        //print_r ($consulta->query);
        //exit;

        $Consulta = $consulta->set_query();        
        
        //print_r ($Consulta);
        //exit;

        if ($Consulta == true || $Consulta == 1)
        {
          $alert = '<p class="msg_save">Refacción Capturada correctamente</p>'; 
        }
        else
        {
          $alert = '<p class="msg_error">Error Al Capturar La Refacción y/o Num Serie Ya Existe </p>';
        }             
    } // if(empty($_POST['descripcion']) || ...

  } // if (!empty($_POST))

?>

<!DOCTYPE html>
<!-- Se agrega este archivo a cada opción del Menu. -->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php"; ?>
	<title>Registro Sucursales</title>
</head>
<body>
	<?php include "include/header.php" ?>

	<section id="container">
		<!-- Es el contenido del registro de Refacción -->
    <div class="form_register">
      <h1>Registro De Sucursales</h1>
      <hr>
      <div class="alert"><?php echo isset($alert)? $alert : ''?></div>
      <!-- Con "action" vacio se autoprocesara el formulario, es decir se iniciara desde el incio del archivo cuando se oprime el boton "Crear Sucursal" -->
      <form action ="" method="post">
        <label for="num_serie">Numero De Serie</label>
        <input type="text" name="num_serie" id = "num_serie" placeholder="Numero de Serie">   
        <label for="num_inv">Numero De Inventario</label>
        <input type="text" name="num_inv" id = "num_inv" placeholder="Número De Inventario">
        <label for="num_parte">Numero De Parte</label>
        <input type="text" name="num_parte" id = "num_parte" placeholder="Numero De Parte">
        <label for="existencia">Existencia</label>        
        <input type="number" name="existencia" id = "existencia" placeholder="Existencia">
        <label for="marca">Marca</label>

        <?php         
          // $query_rol = mysqli_query($conection,"SELECT * FROM rol");
          // $result_rol = mysqli_num_rows($query_rol);
          $conectar = new Conexion();        
          $conectar->query = "SELECT id_marca,descripcion FROM t_Marca ORDER BY descripcion";
          $datos2 = $conectar->get_query();       

        ?>
        <select name="marca" id="marca">
          <?php 
          //print ($result_rol);
          //exit;

            if (!empty($datos2)) // $conectar->rows))
            {
              for ($n=0;$n<count($datos2);$n++)
              {                  
          ?>
                  <option value="<?php echo $datos2[$n]['id_marca'];?>"><?php echo $datos2[$n]['descripcion']; ?></option>
                <!-- <option value="2">Supervisor</option> -->               
          <?php 
                } // for ($n=0;$n<count($datos2);$n++)

            } // if (!empty($datos2))
          ?>
          
        </select>

        <label for="modelo">Modelo</label>
        <?php         
          // $query_rol = mysqli_query($conection,"SELECT * FROM rol");
          // $result_rol = mysqli_num_rows($query_rol);
          $conectar = new Conexion();        
          $conectar->query = "SELECT id_modelo,descripcion FROM t_Modelo ORDER BY descripcion";
          $datos2 = $conectar->get_query();       

        ?>
        <select name="modelo" id="modelo">
          <?php 
          //print ($result_rol);
          //exit;

            if (!empty($datos2)) // $conectar->rows))
            {
              for ($n=0;$n<count($datos2);$n++)
              {                  
          ?>
                  <option value="<?php echo $datos2[$n]['id_modelo'];?>"><?php echo $datos2[$n]['descripcion']; ?></option>
                <!-- <option value="2">Supervisor</option> -->               
          <?php 
                } // for ($n=0;$n<count($datos2);$n++)

            } // if (!empty($datos2))
          ?>
          
        </select>

        <label for="tipo_comp">Tipo Componente</label>
        <?php         
          // $query_rol = mysqli_query($conection,"SELECT * FROM rol");
          // $result_rol = mysqli_num_rows($query_rol);
          $conectar = new Conexion();        
          $conectar->query = "SELECT id_tipo_componente,descripcion FROM t_Tipo_Componente ORDER BY descripcion";
          $datos2 = $conectar->get_query();       

        ?>
        <select name="tipo_comp" id="tipo_comp">
          <?php 
          //print ($result_rol);
          //exit;

            if (!empty($datos2)) // $conectar->rows))
            {
              for ($n=0;$n<count($datos2);$n++)
              {                  
          ?>
                  <option value="<?php echo $datos2[$n]['id_tipo_componente'];?>"><?php echo $datos2[$n]['descripcion']; ?></option>
                <!-- <option value="2">Supervisor</option> -->               
          <?php 
                } // for ($n=0;$n<count($datos2);$n++)

            } // if (!empty($datos2))
          ?>
          
        </select>


        <label for="comentarios">Comentarios</label>
        <textarea name="comentarios" id="comentarios" cols="45" rows = "10" placeholder="Comentarios"></textarea>

        <input type="submit" value="Capturar Equipo" class="btn_save">

      </form>
    </div>

	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>