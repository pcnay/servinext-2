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
  fputcsv($salida,array('ID','NOMBRE','NUM_SUC','DOMICILIO','REFERENCIAS','TEL. FIJO','TEL. CEL.','CONTACTO'));

  $consulta = new Conexion();
  $consulta->query = "SELECT id_sucursal,nombre,num_suc,domicilio,referencias,tel_fijo,tel_movil,contacto
  FROM t_Sucursales          
  ORDER BY nombre ASC ";

  $datos2 = $consulta->get_query();
  
  for ($n=0;$n<count($datos2);$n++)
  {
    fputcsv($salida,array($datos2[$n]['id_sucursal'],
                           $datos2[$n]['nombre'],
                           $datos2[$n]['num_suc'],
                           $datos2[$n]['domicilio'],
                           $datos2[$n]['referencias'],
                           $datos2[$n]['tel_fijo'],
                           $datos2[$n]['tel_movil'],
                           $datos2[$n]['contacto']
                          ));
  }
 
?>
