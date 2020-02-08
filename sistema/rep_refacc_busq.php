<?php
  //empty($_GET['id']))
  //print_r($_GET['id']);  
  //exit;
    //ob_start();
  //ob_clean();
  require_once('../FPDF/fpdf.php');
  include "../conexion.php";

  while (ob_get_level())
  ob_end_clean();
  header("Content-Encoding: None", true);
  
  $busqueda = $_GET['id'];

  class PDF extends FPDF
  {
    // Definiendo la cabecera
    function Header()
    {
      //Cell(Ancho,Alto,Texto,Border=1,SigLinea=1 0=SinSaltoLinea,'Centrado,Left,Right',Relleno 0=Sin 1=Con)
  
      $this->SetFont('Arial','B',12);
      $this->Cell(60);
      // Este valor "135" es para centrar, independiente del texto escrito
      $this->Cell(135,10,'REPORTE REFACCIONES',0,0,'C');
      $this->Ln(20);
      $this->Cell(10,5,'ID',1,0,'C',0);
      $this->Cell(50,5,'DESCRIPCION',1,0,'C',0);
      $this->Cell(40,5,'NUM_PARTE',1,0,'C',0);
      $this->Cell(10,5,'CANT',1,0,'C',0);
      $this->Cell(25,5,'FECHA',1,0,'C',0);  
      $this->Cell(35,5,'MARCA',1,0,'C',0);
      $this->Cell(35,5,'MODELO',1,0,'C',0);
      $this->Cell(60,5,'OBSERVACIONES',1,1,'C',0); // 1,1 = Salto de Linea
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

  $consulta = new Conexion();
  $consulta->query = "SELECT r.id_refaccion,r.descripcion,r.num_parte,r.existencia,r.fecha,marca.descripcion AS mar_descripcion,modelo.descripcion AS mod_descripcion,r.observaciones 
  FROM t_Refaccion r 
  INNER JOIN t_Marca AS marca ON r.id_marca = marca.id_marca
  INNER JOIN t_Modelo AS modelo ON r.id_modelo = modelo.id_modelo     
  
  WHERE (
  r.id_refaccion LIKE '%$busqueda%' OR 
  r.descripcion LIKE '%$busqueda%' OR 
  r.fecha LIKE '%$busqueda%' OR 
  r.num_parte LIKE '%$busqueda%') 
  ORDER BY r.descripcion ASC";
  //print_r ($consulta->query);
  //exit;

  $datos2 = $consulta->get_query();
  //print_r (count($datos2));
  //exit;
  //var_dump ($datos2);
    //print_r ($datos2[0]['id_refaccion'].'+'.$datos2[0]['descripcion'].'+'.$datos2[0]['num_parte'].'+'.$datos2[0]['existencia'].'+'.$datos2[0]['fecha'].'+'.$datos2[0]['mar_descripcion'].'+'.$datos2[0]['mod_descripcion'].'+'.$datos2[0]['observaciones']);
    //exit;
  if (count($datos2)<= 0)
  {
    header ('Location:lista_refaccion.php');
  }
  else
  {
    for ($n=0;$n<count($datos2);$n++)
    {      
      $pdf->Cell(10,5,$datos2[$n]['id_refaccion'],1,0,'L',0);      
      $pdf->Cell(50,5,$datos2[$n]['descripcion'],1,0,'L',0);
      $pdf->Cell(40,5,$datos2[$n]['num_parte'],1,0,'L',0);
      $pdf->Cell(10,5,$datos2[$n]['existencia'],1,0,'L',0);
      $pdf->Cell(25,5,$datos2[$n]['fecha'],1,0,'L',0);
      $pdf->Cell(35,5,$datos2[$n]['mar_descripcion'],1,0,'L',0);
      $pdf->Cell(35,5,$datos2[$n]['mod_descripcion'],1,0,'L',0);
      // MultiCell(Ancho,AltoFuente(puntos),'Texto Largo',1=Border 0=SinBorder,'Alineacion',Fondo(0=SinFondo))
      $pdf->MultiCell(60,5,$datos2[$n]['observaciones'],1,'L',0);
      
    }
  }


  $pdf->Output();
  ob_end_flush();

?>
