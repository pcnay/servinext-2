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

  if ($_SESSION['rol'] != 1)
  {
    header ("Location: ./");
  }

  include "../conexion.php";
  
  if (!empty($_POST))
  {
    $alert = '';
    if(empty($_POST['usuario']) || empty($_POST['correo']) || empty($_POST['nombre']) || empty($_POST['cumpleanos']) || empty($_POST['rol']))  
    {
      $alert = '<p class="msg_error">Todos los campos son obligatorios </p>';
    }
    else
    {          
      $usuario = $_POST['usuario'];
      $correo = $_POST['correo'];
      $nombre = $_POST['nombre'];
      $cumpleanos = $_POST['cumpleanos'];
      $clave = MD5($_POST['clave']);
      $rol = $_POST['rol'];

      // Verificar si existe correo y usuario 

      //$query = mysqli_query($conection,"SELECT * FROM usuario WHERE usuario = '$usuario' OR correo = '$correo'");
      // $result = mysqli_fetch_array($query);
      $conectar = new Conexion();        
      $conectar->query = "SELECT * FROM t_Usuarios WHERE usuario = '$usuario' AND clave = '$clave'";
       //print_r($conectar->query);      
      
      $datos = $conectar->get_query();

      //var_dump($datos); // $conectar->query);
      //exit;
      
      if (!empty($datos))
      {
        $alert = '<p class="msg_error">El correo o el usuario ya existe</p>';
      }
      else
      {

        //$query_insert = mysqli_query($conection, "INSERT INTO usuario(idusuario,nombre,correo,usuario,clave,rol) VALUES (0,'$nombre','$correo','$usuario','$clave','$rol')");
        $consulta = new Conexion();        
        $consulta->query = "INSERT INTO t_Usuarios(usuario,email,nombre,cumpleanos,clave,id_rol) VALUES ('$usuario','$correo','$nombre','$cumpleanos','$clave','$rol')";
        //print_r ($consulta->query);

        $Consulta = $consulta->set_query();        
        
        //print_r ($Consulta);
        //exit;

        if ($Consulta == true || $Consulta == 1)
        {
          $alert = '<p class="msg_save">Usuario creado correctamente</p>'; 
        }
        else
        {
          $alert = '<p class="msg_error">Error Al Crear El Usuario</p>';
        }        

      }

    }
  }
?>

<!DOCTYPE html>
<!-- Se agrega este archivo a cada opción del Menu. -->
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "include/scripts.php"; ?>
	<title>Registro Usuarios</title>
</head>
<body>
	<?php include "include/header.php" ?>

	<section id="container">
		<!-- Es el contenido del registro de Usuarios -->
    <div class="form_register">
      <h1>Registro Usuarios</h1>
      <hr>
      <div class="alert"><?php echo isset($alert)? $alert : ''?></div>
      <!-- Con "action" vacio se autoprocesara el formulario, es decir se iniciara desde el incio del archivo cuando se oprime el boton "Crear Usuario" -->
      <form action ="" method="post">
        <label for="usuario">Usuario</label>
        <input type="text" name="usuario" id = "usuario" placeholder="Usuario">
         
        <label for="correo">Correo Electrónico</label>
        <input type="email" name="correo" id = "correo" placeholder="Correo Electrónico">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id = "nombre" placeholder="Nombre">
        <label for="clave">Clave</label>        
        <input type="password" name="clave" id = "clave" placeholder="Clave de Acceso">
        <label for="cumpleanos">Cumpleanos</label>        
        <input type="text" name="cumpleanos" id = "cumpleanos" placeholder="Fecha Cumpleanos">
        <label for="rol">Tipo Usuario</label>

        <?php         
          // $query_rol = mysqli_query($conection,"SELECT * FROM rol");
          // $result_rol = mysqli_num_rows($query_rol);
          $conectar = new Conexion();        
          $conectar->query = "SELECT * FROM t_Rol";
          $datos2 = $conectar->get_query();       

        ?>
        <select name="rol" id="rol">
          <?php 
          //print ($result_rol);
          //exit;

            if (!empty($datos2)) // $conectar->rows))
            {
              for ($n=0;$n<count($datos2);$n++)
              {                  
          ?>
                  <option value="<?php echo $datos2[$n]['id_rol'];?>"><?php echo $datos2[$n]['rol']; ?></option>
                <!-- <option value="2">Supervisor</option> -->               
          <?php 
                } // for ($n=0;$n<count($datos2);$n++)

            } // if (!empty($datos2))
          ?>
          
        </select>

        <input type="submit" value="Crear Usuario" class="btn_save">

      </form>
    </div>

	</section>
	
	<?php include "include/footer.php"; ?>

</body>
</html>