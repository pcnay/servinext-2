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
      $this->Cell(135,10,'REPORTE SUCURSALES',0,0,'C');
      $this->Ln(20);
      //$this->Cell(10,5,'ID',1,0,'C',0);
      $this->Cell(45,5,'NOMBRE',1,0,'C',0);
      $this->Cell(10,5,'SUC',1,0,'C',0);
      $this->Cell(70,5,'DOMICILIO',1,0,'C',0);    
      $this->Cell(27,5,'TEL. FIJO',1,0,'C',0);
      $this->Cell(27,5,'TEL. CEL',1,0,'C',0);
      $this->Cell(40,5,'CONTACTO',1,0,'C',0);
      $this->Cell(40,5,'REFERENCIAS',1,1,'C',0); // 1,1 = Salto de Linea
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
  //Cell(Ancho,Alto,Texto,Border=1,SigLinea=1 0=SinSaltoLinea,'Centrado,Left,Right',Relleno 0=Sin 1=Con)
  // MultiCell(Ancho,AltoFuente(puntos),'Texto Largo',1=Border 0=SinBorder,'Alineacion',Fondo(0=SinFondo))


  $consulta = new Conexion();
          $consulta->query = "SELECT id_sucursal,nombre,num_suc,domicilio,referencias,tel_fijo,tel_movil,contacto
          FROM t_Sucursales          
          ORDER BY nombre ASC ";

  //print_r ($consulta->query);
  //exit;
  $datos2 = $consulta->get_query();
  
  for ($n=0;$n<count($datos2);$n++)
  {
    //$pdf->Cell(10,5,$datos2[$n]['id_refaccion'],0,0,'L',0);
    $pdf->Cell(45,5,$datos2[$n]['nombre'],0,0,'L',0);
    $pdf->Cell(10,5,$datos2[$n]['num_suc'],0,0,'L',0);
    $pdf->Cell(70,5,$datos2[$n]['domicilio'],0,0,'L',0);
    $pdf->Cell(27,5,$datos2[$n]['tel_fijo'],0,0,'L',0);
    $pdf->Cell(27,5,$datos2[$n]['tel_movil'],0,0,'L',0);
    // MultiCell(Ancho,AltoFuente(puntos),'Texto Largo',1=Border 0=SinBorder,'Alineacion',Fondo(0=SinFondo))
    //$pdf->MultiCell(60,5,$datos2[$n]['observaciones'],0,'L',0);
    $pdf->Cell(40,5,$datos2[$n]['contacto'],0,0,'L',0);
    
    $pdf->MultiCell(40,5,$datos2[$n]['referencias'],0,'L',0);
  }
  $pdf->Output();
  ob_end_flush();
  
?>