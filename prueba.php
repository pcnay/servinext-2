<?php 
  include ('conexion.php');
  $conectar = new Conexion();
  $conectar->query = "SELECT * FROM t_Clientes";
  //var_dump($conectar->query);
  $contenido = $conectar->get_query();
//  var_dump($conectar->rows);

  $datos2 = array();

  
  // Permite recorre un arreglo de una forma mas optimizada.
  //http://php.net/manual/es/control-structures.foreach.php
  foreach ($conectar->rows as $nombreCampo => $contenidoCampo)
  {
    // Agrega al final del arreglo una nueva posicion.
    array_push($datos2,$contenidoCampo);
    // La otra forma:
    // $datos[$nombreCampo] = $contenidoCampo;

  }
  print_r ($datos2[0]['id_clientes']);
  print_r ($datos2[0]['nombre']);

  print ("Insertar un dato");
  $conectar->query = "INSERT INTO t_Clientes (id_clientes,nombre) VALUES (0,'Agregando Campo desde el objeto')";
  $conectar->set_query();
  
  // INSERT INTO t_Clientes (id_Clientes,nombre) VALUES(0,'Probando Nombre'")


?>