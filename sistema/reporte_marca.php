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
      $this->Cell(102.50,10,'REPORTE DE MARCAS',0,0,'C');
      $this->Ln(20);
      $this->Cell(10,5,'ID',1,0,'C',0);
      $this->Cell(90,5,'DESCRIPCION',1,1,'C',0);
      
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
  $pdf = new PDF('P','mm','Letter');
  $pdf->AliasNbPages(); // Para determinar el número total de hojas.
  $pdf->AddPage();
  $pdf->SetFont('Arial','',10);
  // Imprimir los datos.


  //$inventario_controller = new InventariosController();
  //$inventarios = $inventario_controller->get();
  //Cell(Ancho,Alto,Texto,Border=1,SigLinea=1 0=SinSaltoLinea,'Centrado,Left,Right',Relleno 0=Sin 1=Con)
  // MultiCell(Ancho,AltoFuente(puntos),'Texto Largo',1=Border 0=SinBorder,'Alineacion',Fondo(0=SinFondo))

  $consulta = new Conexion();
  $consulta->query = "SELECT id_marca,descripcion FROM t_Marca ORDER BY descripcion ASC";
  //print_r ($consulta->query);
  //exit;

  $datos2 = $consulta->get_query();
  
  for ($n=0;$n<count($datos2);$n++)
  {
    $pdf->Cell(10,5,$datos2[$n]['id_marca'],1,0,'L',0);
    $pdf->Cell(90,5,$datos2[$n]['descripcion'],1,1,'L',0);
  }

  $pdf->Output();
  ob_end_flush();

  
?>
