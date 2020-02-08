<?php
  //ob_start();
  //ob_clean();
  //require_once('../FPDF/fpdf.php');
  include "../conexion.php";

  // Nombre Del archivo y Charset
  header ('Content-Type:text/csv; charset-latin1');
  header ('Content-Disposition: attachment; filename="Reporte_Equipos.csv"');
  // Salida Del Archivo
  $salida = fopen('php://output','w');

  // Encabezados.
  fputcsv($salida,array('ID','NUM_SERIE','NUM_INV','NUM_PARTE','CANT','MARCA','MODELO','COMPONENTE','COMENTARIOS'));

  $consulta = new Conexion();


  $consulta->query = "SELECT e.id_epo,e.num_serie,e.num_inv,e.existencia,e.num_parte,e.comentarios,
  mar.descripcion AS marca,modl.descripcion AS modelo,tipo_comp.descripcion AS tipo_comp
  FROM t_Equipo AS e
    INNER JOIN t_Modelo AS modl ON e.id_modelo = modl.id_modelo 
    INNER JOIN t_Marca AS mar ON e.id_marca = mar.id_marca 
    INNER JOIN t_Tipo_Componente AS tipo_comp ON e.id_tipo_componente = tipo_comp.id_tipo_componente   
    ORDER BY e.num_serie ASC";
  //print_r ($consulta->query);
  //exit;

  $datos2 = $consulta->get_query();
  
  for ($n=0;$n<count($datos2);$n++)
  {
    fputcsv($salida,array($datos2[$n]['id_epo'],
                           $datos2[$n]['num_serie'],
                           $datos2[$n]['num_inv'],
                           $datos2[$n]['num_parte'],
                           $datos2[$n]['existencia'],
                           $datos2[$n]['marca'],
                           $datos2[$n]['modelo'],
                           $datos2[$n]['tipo_comp'],
                           $datos2[$n]['comentarios']
                          ));
  }
 
?>
