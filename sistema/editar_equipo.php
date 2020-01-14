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
    if(empty($_POST['num_serie']) || empty($_POST['num_inv']) || empty($_POST['num_parte']) || empty($_POST['existencia']) || empty($_POST['id_marca']) || empty($_POST['id_modelo']) || empty($_POST['id_tipo_componente']))  
    {
      $alert = '<p class="msg_error">Todos los campos son obligatorios </p>';
    }
    else
    { 
      $id_equipo = $_POST['id_equipo'];         
      $num_serie = $_POST['num_serie'];
      $num_inv = $_POST['num_inv'];
      $num_parte = $_POST['num_parte'];
      $existencia = $_POST['existencia'];
      $marca = $_POST['id_marca'];
			$modelo = $_POST['id_modelo'];
			$tipo_comp = $_POST['id_tipo_componente'];
  		$comentarios = $_POST['comentarios'];


        //$query_insert = mysqli_query($conection, "INSERT INTO usuario(idusuario,nombre,correo,usuario,clave,rol) VALUES (0,'$nombre','$correo','$usuario','$clave','$rol')");
        $consulta = new Conexion();        
        $consulta->query = "UPDATE t_Equipo SET num_serie = '$num_serie',num_inv = '$num_inv',num_parte = '$num_parte',existencia = $existencia,id_marca = $marca,id_modelo = $modelo,id_tipo_componente = $tipo_comp,comentarios = '$comentarios' WHERE id_epo = $id_equipo";
        //print_r ($consulta->query);
        //print_r($id_equipo);
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

  // si no existe el "id" que se mando a través de la URL, regresa al listado de usuario.
  if (empty($_GET['id']))
  {
    header ('Location:listar_equipo.php');
  }
  else
  {
    // Validar que el "id" existe en la base de datos., para ser mostrado en la vista de la pantalla  
    
    $id_equipo = $_GET['id'];
    $conectar = new Conexion();
    $conectar->query = "SELECT id_epo,num_serie,num_inv,id_tipo_componente,num_parte,existencia,id_marca,id_modelo,comentarios FROM t_Equipo WHERE id_epo = $id_equipo";
    $datos2 = $conectar->get_query();

    if (empty($datos2)) //$conectar->rows))
    {
      header ('Location:lista_refaccion.php');
    }  
    else
    {
      for ($n=0;$n<count($datos2);$n++)
      {                  
        $id_equipo = $datos2[$n]['id_epo'];
        $num_serie = $datos2[$n]['num_serie'];
        $num_inv = $datos2[$n]['num_inv'];
        $num_parte = $datos2[$n]['num_parte'];
        $existencia = $datos2[$n]['existencia'];        
        $id_marca = $datos2[$n]['id_marca'];
        $id_modelo = $datos2[$n]['id_modelo'];
        $id_tipo_componente = $datos2[$n]['id_tipo_componente'];
				$comentarios = $datos2[$n]['comentarios'];

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
      
      // Va obtener el "Tipo De Componente" de la base de datos.      
      $conectar = new Conexion();        
      $conectar->query = "SELECT id_tipo_componente,descripcion FROM t_Tipo_Componente";
      $datos2 = $conectar->get_query();       
      
      // Se introducen al Combobox de Select, además se activara la opción del combo que tenga la tabla de datos.
      $tipo_comp_select = '';
      for ($n=0; $n<count($datos2); $n++)
      {
        // Determina cual de la lista del ComboBox esta selecccionado, y posteriormente lo activa en el ComboBox,
        $selected = ($id_tipo_componente==$datos2[$n]['id_tipo_componente']) ? 'selected':'';

        $tipo_comp_select .= '<option value ="'.$datos2[$n]['id_tipo_componente'].'"'.$selected.'>'.$datos2[$n]['descripcion'].'</option>';
      }  
   } // if (empty($datos2))

  } // } // if (empty($_GET['id']))
?>


<!DOCTYPE html>
<!-- Se agrega este archivo a cada opción del Menu. -->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php"; ?>
	<title>Editar Equipo</title>
</head>
<body>
	<?php include "include/header.php" ?>

	<section id="container">
		<!-- Es el contenido del registro de Refacción -->
    <div class="form_register">
      <h1>Editar Equipo</h1>
      <hr>          
      <div class="alert"><?php echo isset($alert)? $alert : ''?></div>
      <!-- Con "action" vacio se autoprocesara el formulario, es decir se iniciara desde el incio del archivo cuando se oprime el boton "Crear Sucursal" -->
      <form action ="" method="post">
        <input type="hidden" name="id_equipo" id="id_equipo" value="<?php echo $id_equipo; ?>">
        <label for="num_serie">Numero De Serie</label>
        <input type="text" name="num_serie" id = "num_serie" placeholder="Numero de Serie" value="<?php echo $num_serie; ?>" >   
        <label for="num_inv">Numero De Inventario</label>
        <input type="text" name="num_inv" id = "num_inv" placeholder="Número De Inventario" value="<?php echo $num_inv; ?>">
        <label for="num_parte">Numero De Parte</label>
        <input type="text" name="num_parte" id = "num_parte" placeholder="Numero De Parte" value="<?php echo $num_parte; ?>">
        <label for="existencia">Existencia</label>        
        <input type="number" name="existencia" id = "existencia" placeholder="Existencia" value="<?php echo $existencia; ?>">
        
        <label for="marca">Marca</label>
        <select name="id_marca" id="id_marca" placeholder="Marcas">
          <option value="">Marca</option>
            <?php echo $marcas_select; ?>
        </select>

        <label for="marca">Modelo</label>
        <select name="id_modelo" id="id_modelo" placeholder="Modelos">
          <option value="">Modelo</option>
            <?php echo $modelo_select; ?>
        </select>

        <label for="marca">Tipo De Componente</label>
        <select name="id_tipo_componente" id="id_tipo_componente" placeholder="Tipo De Componente">
          <option value="">Tipo Componente</option>
            <?php echo $tipo_comp_select; ?>
        </select>

        <label for="comentarios">Comentarios</label>
        <textarea name="comentarios" id="comentarios" cols="45" rows = "10" placeholder="Comentarios"><?php echo $comentarios; ?></textarea>
        

        <input type="submit" value="Actualizar Equipo" class="btn_save">

      </form>
    </div>

	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>