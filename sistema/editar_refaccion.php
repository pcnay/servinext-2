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
    if(empty($_POST['descripcion']) || empty($_POST['num_parte']) || empty($_POST['existencia']) || empty($_POST['fecha']) || empty($_POST['marca']) || empty($_POST['modelo']))  
    {
      $alert = '<p class="msg_error">Todos los campos son obligatorios </p>';
    }
    else
    {
      $id_refaccion = $_POST['id_refaccion'];          
      $descripcion = $_POST['descripcion'];
      $num_parte = $_POST['num_parte'];
      $existencia = $_POST['existencia'];
      $fecha = $_POST['fecha'];
      $marca = $_POST['marca'];
      $modelo = $_POST['modelo'];
      $observaciones = $_POST['observaciones'];


        //$query_insert = mysqli_query($conection, "INSERT INTO usuario(idusuario,nombre,correo,usuario,clave,rol) VALUES (0,'$nombre','$correo','$usuario','$clave','$rol')");
        $consulta = new Conexion();        
        $consulta->query = "UPDATE t_Refaccion SET descripcion = '$descripcion',num_parte = '$num_parte' ,existencia = $existencia ,fecha = '$fecha' ,id_marca = $marca ,id_modelo = $modelo ,observaciones = '$observaciones' WHERE id_refaccion = $id_refaccion)";
        //print_r ($consulta->query);
        //exit;

        $Consulta = $consulta->set_query();        
        
        //print_r ($Consulta);
        //exit;

        if ($Consulta == true || $Consulta == 1)
        {
          $alert = '<p class="msg_save">Refacción Actualizada Correctamente</p>'; 
        }
        else
        {
          $alert = '<p class="msg_error">Error Al Actualizar La Refacción</p>';
        }             
    } // if(empty($_POST['descripcion']) || ...

  } // if (!empty($_POST))

  // Si no existe el "id" que se mando atráves de la URL, regresa al listado de usuario. 
  if (empty($_GET['id']))
  {
    header ('Location:lista_refaccion.php');
  }
  else
  {
    // Validar que el "id" existe en la base de datos.
    $id_refaccion = $_GET['id'];
    $conectar = new Conexion();
    $conectar->query = "SELECT id_refaccion,descripcion,num_parte,existencia,fecha,id_marca,id_modelo FROM t_Refaccion WHERE id_refaccion = $id_refaccion ";
    $datos2 = $conectar->get_query();


    //$sql = mysqli_query($conection,"SELECT u.idusuario,u.nombre,u.correo,u.usuario, (u.rol) as idrol, (r.rol) as rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.idusuario = $iduser ");

    if (empty($datos2)) //$conectar->rows))
    {
      header ('Location:lista_refaccion.php');
    }  
    else
    {
      for ($n=0;$n<count($datos2);$n++)
      {                  
        $id_refaccion = $datos2[$n]['id_refaccion'];
        $descripcion = $datos2[$n]['descripcion'];
        $num_parte = $datos2[$n]['num_parte'];
        $existencia = $datos2[$n]['existencia'];
        $fecha = $datos2[$n]['fecha'];
        $id_marca = $datos2[$n]['id_marca'];
        $id_modelo = $datos2[$n]['id_modelo'];

      } // for ($n=0;$n<count($datos2);$n++)
  
      // Va obtener la "marca" de la base de datos.      
      $conectar = new Conexion();        
      $conectar->query = "SELECT id_marca,descripcion FROM t_Marca";
      $datos2 = $conectar->get_query();       
      
      // Se introducen al Combobox de Select, además se activara la opción del combo que tenga la tabla de datos.
      $marcas_select = '';
      for ($n=0; $n<count($datos2); $n++)
      {
        // Determina cual de la lista del ComboBox esta selecccionado, y posteriormente lo activa en el ComboBox,
        // $marcas[0]['id_marca'] = Proviene de la tabla "t_Marca" de la base de datos
        $selected = ($id_marca==$datos2[$n]['id_marca']) ? 'selected':'';

        $marcas_select .= '<option value ="'.$datos2[$n]['id_marca'].'"'.$selected.'>'.$datos2[$n]['descripcion'].'</option>';
      }

      // Va obtener el "modelo" de la base de datos.      
      $conectar = new Conexion();        
      $conectar->query = "SELECT id_modelo,descripcion FROM t_Modelo";
      $datos2 = $conectar->get_query();       
      
      // Se introducen al Combobox de Select, además se activara la opción del combo que tenga la tabla de datos.
      $modelo_select = '';
      for ($n=0; $n<count($datos2); $n++)
      {
        // Determina cual de la lista del ComboBox esta selecccionado, y posteriormente lo activa en el ComboBox,
        // $marcas[0]['id_marca'] = Proviene de la tabla "t_Marca" de la base de datos
        $selected = ($id_modelo==$datos2[$n]['id_modelo']) ? 'selected':'';

        $modelo_select .= '<option value ="'.$datos2[$n]['id_modelo'].'"'.$selected.'>'.$datos2[$n]['descripcion'].'</option>';
      }
      
    } // if (empty($datos2))

  } // if (empty($_GET['id']))


?>

<!DOCTYPE html>
<!-- Se agrega este archivo a cada opción del Menu. -->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php"; ?>
	<title>Registro Refacción</title>
</head>
<body>
	<?php include "include/header.php" ?>

	<section id="container">
		<!-- Es el contenido del registro de Refacción -->
    <div class="form_register">
      <h1>Actualizar De Refaccion</h1>
      <hr>
      <div class="alert"><?php echo isset($alert)? $alert : ''?></div>
      <!-- Con "action" vacio se autoprocesara el formulario, es decir se iniciara desde el incio del archivo cuando se oprime el boton "Crear Usuario" -->
      <form action ="" method="post">
        <label for="descripcion">Descripcion</label>
        <input type="text" name="descripcion" id = "descripcion" placeholder="Descripcion" value = "<?php echo $descripcion; ?>">         
        <label for="num_parte">Numero de parte</label>
        <input type="text" name="num_parte" id = "num_parte" placeholder="Número de Parte" value = "<?php echo $num_parte
        ; ?>">
        <label for="existencia">Existencia</label>
        <input type="number" name="existencia" id = "existencia" placeholder="Existencia" value = "<?php echo $existencia; ?>">
        <label for="fecha">Fecha</label>        
        <input type="date" name="fecha" id = "fecha" placeholder="Fecha De Captura" value = "<?php echo $fecha; ?>">
        <label for="marca">Marca</label>
      
        <select name="id_marca" id="id_marca" placeholder="Marcas">
          <option value="">Marca</option>
            <?php echo $marcas_select; ?>
        </select>

        <label for="modelo">Modelo</label>
        <select name="id_modelo" id="id_modelo" placeholder="Modelo">
          <option value="">Modelo</option>
            <?php echo $modelo_select; ?>
        </select>

        <input type="submit" value="Actualizar Refaccion" class="btn_save">

      </form>

    </div>

	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>