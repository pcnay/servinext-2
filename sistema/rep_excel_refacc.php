<?php
  //ob_start();
  //ob_clean();
  //require_once('../FPDF/fpdf.php');
  include "../conexion.php";

  // Nombre Del archivo y Charset
  header ('Content-Type:text/csv; charset-latin1');
  header ('Content-Disposition: attachment; filename="Reporte_Inventario.csv"');
  // Salida Del Archivo
  $salida = fopen('php://output','w');

  // Encabezados.
  fputcsv($salida,array('ID','DESCRIPCION','NUM_PARTE','CANT','FECHA','MARCA','MODELO','OBSERVACIONES'));

  $consulta = new Conexion();
  $consulta->query = "SELECT r.id_refaccion,r.descripcion,r.num_parte,r.existencia,r.fecha,mar.descripcion AS marca,modl.descripcion AS modelo,r.observaciones FROM t_Refaccion AS r 
  INNER JOIN t_Marca AS mar ON r.id_marca = mar.id_marca 
  INNER JOIN t_Modelo AS modl ON r.id_modelo = modl.id_modelo 
  ORDER BY r.descripcion ASC";
  //print_r ($consulta->query);
  //exit;

  $datos2 = $consulta->get_query();
  
  for ($n=0;$n<count($datos2);$n++)
  {
    fputcsv($salida,array($datos2[$n]['id_refaccion'],
                           $datos2[$n]['descripcion'],
                           $datos2[$n]['num_parte'],
                           $datos2[$n]['existencia'],
                           $datos2[$n]['fecha'],
                           $datos2[$n]['marca'],
                           $datos2[$n]['modelo']
                          ));
  }
 
?>