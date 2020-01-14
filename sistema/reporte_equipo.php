<?php
  //ob_start();
  //ob_clean();
  require_once('../FPDF/fpdf.php');
  include "../conexion.php";

  while (ob_get_level())
  ob_end_clean();
  header("Content-Encoding: None", true);


  
  class PDF extends FPDF
  {
    // Definiendo la cabecera
    function Header()
    {
      //Cell(Ancho,Alto,Texto,Border=1,SigLinea=1 0=SinSaltoLinea,'Centrado,Left,Right',Relleno 0=Sin 1=Con)
  
      $this->SetFont('Arial','B',12);
      $this->Cell(60);
      // Este valor "135" es para centrar, independiente del texto escrito
      $this->Cell(135,10,'REPORTE EQUIPOS',0,0,'C');
      $this->Ln(20);
      //$this->Cell(10,5,'ID',1,0,'C',0);
      $this->Cell(35,5,'NUM. SERIE',1,0,'C',0);
      $this->Cell(35,5,'NUM. INV',1,0,'C',0);
      $this->Cell(35,5,'NUM. PARTE',1,0,'C',0);
      $this->Cell(10,5,'CANT',1,0,'C',0);  
      $this->Cell(25,5,'MARCA',1,0,'C',0);
      $this->Cell(25,5,'MODELO',1,0,'C',0);
      $this->Cell(25,5,'TIPO COMP',1,0,'C',0);
      $this->Cell(70,5,'COMENTARIOS',1,1,'C',0); // 1,1 = Salto de Linea
    }
    function Footer()
    {
      $this->SetY(-15);
      $this->SetFont('Arial','I',8);
      $this->Cell(0,10,utf8_decode('Página').$this->PageNo().'/{nb}',0,0,'C');
    }

  }


  // 'L' = Horizontal(Acostada), 'P' = Vertical (Normal)
  // $pdf = new PDF('L','cm','Letter');
  $pdf = new PDF('L','mm','Letter');
  $pdf->AliasNbPages(); // Para determinar el número total de hojas.
  $pdf->AddPage();
  $pdf->SetFont('Arial','',10);
  // Imprimir los datos.


  //$inventario_controller = new InventariosController();
  //$inventarios = $inventario_controller->get();
  //Cell(Ancho,Alto,Texto,Border=1,SigLinea=1 0=SinSaltoLinea,'Centrado,Left,Right',Relleno 0=Sin 1=Con)
  // MultiCell(Ancho,AltoFuente(puntos),'Texto Largo',1=Border 0=SinBorder,'Alineacion',Fondo(0=SinFondo))

/*
SELECT e.id_epo,e.num_serie,e.num_inv,e.existencia,e.num_parte,e.comentarios,
mar.descripcion AS marca,modl.descripcion AS modelo,tipo_comp.descripcion AS tipo_comp
FROM t_Equipo AS e
  INNER JOIN t_Modelo AS modl ON e.id_modelo = modl.id_modelo 
  INNER JOIN t_Marca AS mar ON e.id_marca = mar.id_marca 
  INNER JOIN t_Tipo_Componente AS tipo_comp ON e.id_tipo_componente = tipo_comp.id_tipo_componente   
  ORDER BY e.num_serie ASC;




AS marca,modl.descripcion AS modelo,tipo_comp.descripcion AS tipo-comp, FROM t_Equipo AS e 
  INNER JOIN t_Marca AS mar ON e.id_marca = mar.id_marca 
  
  
  INNER JOIN t_Modelo AS modl ON e.id_modelo = modl.id_modelo 
  INNER JOIN t_Tipo_Componente AS tipo_comp ON e.id_tipo_componente = tipo_comp.id_tipo_componente 
  ORDER BY e.num_serie ASC

*/

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
    //$pdf->Cell(10,5,$datos2[$n]['id_refaccion'],0,0,'L',0);
    $pdf->Cell(35,5,$datos2[$n]['num_serie'],0,0,'L',0);
    $pdf->Cell(35,5,$datos2[$n]['num_inv'],0,0,'L',0);
    $pdf->Cell(35,5,$datos2[$n]['num_parte'],0,0,'L',0);
    $pdf->Cell(10,5,$datos2[$n]['existencia'],0,0,'L',0);
    $pdf->Cell(25,5,$datos2[$n]['marca'],0,0,'L',0);
    $pdf->Cell(25,5,$datos2[$n]['modelo'],0,0,'L',0);
    $pdf->Cell(25,5,$datos2[$n]['tipo_comp'],0,0,'L',0);
    // MultiCell(Ancho,AltoFuente(puntos),'Texto Largo',1=Border 0=SinBorder,'Alineacion',Fondo(0=SinFondo))
    $pdf->MultiCell(70,5,$datos2[$n]['comentarios'],0,'L',0);

  }

  $pdf->Output();
  ob_end_flush();

  
?>
