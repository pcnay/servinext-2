<?php 
  include "../conexion.php";
  
  // Como se autoprocesa, es decir vuelve a ejecutarse desde el principio cuando se oprime el boton de "Actualizar Usuario"
  if (!empty($_POST))
  {
    $alert = '';
    if(empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['rol']) || empty($_POST['cumpleanos']))  
    {
      $alert = '<p class="msg_error">Todos los campos son obligatorios </p>';
    }
    else
    {  
      $idusuario = $_POST['idusuario'];        
      $nombre = $_POST['nombre'];
      $correo = $_POST['correo'];
      $usuario = $_POST['usuario'];
      $cumpleanos = $_POST['cumpleanos'];
      $clave = MD5($_POST['clave']);
      $rol = $_POST['rol'];

      //echo "SELECT * FROM usuario WHERE (usuario = '$usuario' AND idusuario != $idusuario) OR (correo = '$correo' AND idusuario != $idusuario)";
      //exit;

      // Verificar si existe correo y usuario

      //$query = mysqli_query($conection,"SELECT * FROM usuario WHERE (usuario = '$usuario' AND idusuario != $idusuario) OR (correo = '$correo' AND idusuario != $idusuario)");
       //$result = mysqli_fetch_array($query);

       $conectar = new Conexion();        
       $conectar->query = "SELECT * FROM t_Usuarios WHERE usuario = '$usuario' AND clave = '$clave'";
       $Consulta = $conectar->get_query();       
 
       if (!empty($Consulta)) // $conectar->rows))
       {
         $alert = '<p class="msg_error">El correo o el usuario ya existe</p>';
       }
       else
       {
        // Cuando el usuario no actualiza la clave.
        if (empty($_POST['clave']))
        {
          //$sql_update = mysqli_query($conection,"UPDATE usuario SET nombre = '$nombre', correo = '$correo', usuario = '$usuario', rol = '$rol' WHERE idusuario = $idusuario");

          $consultar = new Conexion();        
          $consultar->query = "UPDATE t_Usuarios SET nombre = '$nombre', email = '$correo', usuario = '$usuario', id_rol = '$rol', cumpleanos = '$cumpleanos' WHERE idusuario = $idusuario";
          //print_r ($consultar->query);
          //exit;

          $consultar->set_query();       

        }
        else
        {
          $consultar = new Conexion();        
          $consultar->query = "UPDATE t_Usuarios SET nombre = '$nombre', email = '$correo', usuario = '$usuario', id_rol = '$rol', clave = '$clave', cumpleanos = '$cumpleanos' WHERE idusuario = $idusuario";
          //print_r ($consultar->query);
          //exit;

          $consultar->set_query();       

          //$sql_update = mysqli_query($conection,"UPDATE usuario SET nombre = '$nombre', correo = '$correo', usuario = '$usuario', rol = '$rol clave = '$clave' WHERE idusuario = $idusuario");
        }

        if ($consultar == true || $consultar == 1)
        {
          $alert = '<p class="msg_save">Usuario Actualizado correctamente</p>';
        }
        else
        {
          $alert = '<p class="msg_error">Error Al Actualizar El Usuario</p>';
        }

      } // if (!empty($conectar->rows))

    } // if(empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST

  } // if (!empty($_POST))

  // Si no existe el "id" que se mando atráves de la URL, regresa al listado de usuario. 
  if (empty($_GET['id']))
  {
    header ('Location:lista_usuario.php');
  }
  else
  {
    // Validar que el "id" existe en la base de datos.
    $iduser = $_GET['id'];
    $conectar = new Conexion();
    $conectar->query = "SELECT u.idusuario,u.nombre,u.email,u.usuario,u.cumpleanos,(u.id_rol) as idrol, (r.rol) as rol FROM t_Usuarios u INNER JOIN t_Rol r ON u.id_rol = r.id_rol WHERE u.idusuario = $iduser ";
    $datos2 = $conectar->get_query();


    //$sql = mysqli_query($conection,"SELECT u.idusuario,u.nombre,u.correo,u.usuario, (u.rol) as idrol, (r.rol) as rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE u.idusuario = $iduser ");

    if (empty($datos2)) //$conectar->rows))
    {
      header ('Location:lista_usuario.php');
    }  
    else
    {
      /*
      // mysqli_fetch_array($sql) , le asigna un arreglo a $data lo encontrando en la consulta.
      $option = '';
      while ($data = mysqli_fetch_array($sql))
      {
        $idusuario = $data['idusuario'];
        $nombre = $data['nombre'];
        $correo = $data['correo'];
        $usuario = $data['usuario'];
        $idrol = $data['idrol'];
        $rol = $data['rol'];
        // "select" para que se seleccione, dependiendo de la opcion.
        if ($idrol == 1)
        {
          $option = '<option value="'.$idrol.'" select >'.$rol.'</option> ';
        }
        // "select" para que se seleccione, dependiendo de la opcion.
        else if ($idrol == 2)      
        {
          $option = '<option value="'.$idrol.'" select >'.$rol.'</option> ';
        }
        // "select" para que se seleccione, dependiendo de la opcion.
        else if ($idrol == 3)      
        {
          $option = '<option value="'.$idrol.'" select >'.$rol.'</option> ';
        }

      }
      */
      /*
      $datos2 = array();
      foreach ($conectar->rows as $nombreCampo => $contenidoCampo)
      {
        // Agrega al final del arreglo una nueva posicion.
        array_push($datos2,$contenidoCampo);
        // La otra forma:
        // $datos[$nombreCampo] = $contenidoCampo;        
      }
      */

      for ($n=0;$n<count($datos2);$n++)
      {                  
        $idusuario = $datos2[$n]['idusuario'];
        $nombre = $datos2[$n]['nombre'];
        $correo = $datos2[$n]['email'];
        $usuario = $datos2[$n]['usuario'];
        $cumpleanos = $datos2[$n]['cumpleanos'];
        $idrol = $datos2[$n]['idrol'];
        $rol = $datos2[$n]['rol'];

        if ($idrol == 1)
        {
          $option = '<option value="'.$idrol.'" select >'.$rol.'</option> ';
        }
        // "select" para que se seleccione, dependiendo de la opcion.
        else if ($idrol == 2)      
        {
          $option = '<option value="'.$idrol.'" select >'.$rol.'</option> ';
        }
        // "select" para que se seleccione, dependiendo de la opcion.
        else if ($idrol == 3)      
        {
          $option = '<option value="'.$idrol.'" select >'.$rol.'</option> ';
        }


      } // for ($n=0;$n<count($datos2);$n++)

    } // if (empty($conectar->rows))

  } // if (empty($_GET['id']))

?>

<!DOCTYPE html>
<!-- Se agrega este archivo a cada opción del Menu. -->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php"; ?>
	<title>Actualiar Usuario</title>
</head>
<body>
	<?php include "include/header.php" ?>

	<section id="container">
		<!-- Es el contenido del registro de Usuarios -->
    <div class="form_register">
      <h1>Actualizar Usuarios</h1>
      <hr>
      <div class="alert"><?php echo isset($alert)? $alert : ''?></div>
      <!-- Con "action" vacio se autoprocesara el formulario, es decir se iniciara desde el incio del archivo cuando se oprime el boton "Crear Usuario" -->
      <form action ="" method="post">
        <!-- Se esta enviando un campo oculto "idusuario" ya que se utilizar para actualizar algunos datos -->
        <input type="hidden" name="idusuario" id="idusario" value="<?php echo $idusuario; ?>">
        <label for="nombre">Nombre</label>
        <!-- Para asignar un valor al 'input Nombre '-->
        <input type="text" name="nombre" id = "nombre" placeholder="Nombre Completo" value = "<?php echo $nombre ?>">
        <label for="correo">Correo Electrónico</label>
        <input type="email" name="correo" id = "correo" placeholder="Correo Electrónico" value = "<?php echo $correo ?>">
        <label for="usuario">Usuario</label>
        <input type="text" name="usuario" id = "usuario" placeholder="Usuario" 
        value = "<?php echo $usuario ?>">
        <label for="cumpleanos">Cumpleanos</label>
        <input type="text" name="cumpleanos" id = "cumpleanos" placeholder="AAAA-MM-DD" 
        value = "<?php echo $cumpleanos ?>">

        <label for="clave">Clave</label>
        <input type="password" name="clave" id = "clave" placeholder="Clave de Acceso">
        <label for="rol">Tipo Usuario</label>

        <?php         
          // $query_rol = mysqli_query($conection,"SELECT * FROM rol");
          // $result_rol = mysqli_num_rows($query_rol);
          $conectar = new Conexion();        
          $conectar->query = "SELECT * FROM t_Rol";
          $datos2 = $conectar->get_query();       

        ?>
        <select name="rol" id="rol" class="notitemOne">
          <?php 
          //print ($result_rol);
          //exit;
          echo $option;

            if (!empty($datos2)) //$conectar->rows))
            {
               //while ($rol = mysqli_fetch_array($query_rol))
              //{
                /*
                $datos2 = array();
                foreach ($conectar->rows as $nombreCampo => $contenidoCampo)
                {
                  // Agrega al final del arreglo una nueva posicion.
                  array_push($datos2,$contenidoCampo);
                  // La otra forma:
                  // $datos[$nombreCampo] = $contenidoCampo;        
                }
              */
                
                for ($n=0;$n<count($datos2);$n++)
                {                              
          ?>
                <!-- <option value="2">Supervisor</option> -->
                <option value="<?php echo $datos2[$n]['id_rol'];?>"><?php echo $datos2[$n]['rol']; ?></option>

          <?php 
              } // for ($n=0;$n<count($datos2);$n++)

            } // if (!empty($conectar->rows))

          ?>
          
        </select>

        <input type="submit" value="Actualizar Usuario" class="btn_save">

      </form>
    </div>

	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>
