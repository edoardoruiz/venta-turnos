<?php

require('utils/fpdf/fpdf.php');
require_once "config.php";

    $id =  trim($_GET["id"]);
    $DPI = trim($_GET["DPI"]);
    $Turno = trim($_GET["Turno"]);
    $sql = "SELECT devoto.ID, devoto.DPI,devoto.Fecha_compra, Concat(devoto.Primer_nombre,' ',devoto.Segundo_nombre,' ',devoto.Primer_apellido,' ',devoto.segundo_apellido) as Nombre, turno.Turno, devoto.Cantidad, devoto.Cantidad * turno.Precio as Total from devoto Inner join Turno on devoto.ID_turno = turno.ID where devoto.ID = $id";
    $result = mysqli_query($link, $sql);

    class PDF extends FPDF
{
    function Header()
    {
        $this->Ln(50);
    }
    
    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-43);
        // Arial italic 8
        $this->SetFont('Arial','B',7);
        // Número de página
        $this->cell(0,3,'Indicaciones Generales:',0,1,'C');
        $this->cell(0,3,utf8_decode("Los turnos serán entregados los días sábado 1 de julio de 14:00 a 15:00 horas y domingo 2 de julio de 8:00 a 13:00 horas."),0,1,'C');
        $this->cell(0,3,utf8_decode("Las andas procesionales serán levantadas a las 15:00 horas en punto."),0,1,'C');
        $this->cell(0,3,utf8_decode("Evite llevar niños en brazos, de la mano o debajo del anda al momento de cargar."),0,1,'C');
        $this->cell(0,3,'Presentarse 15 minutos antes de su turno en la fila asignada.',0,1,'C');
        $this->cell(0,3,'Uniformidad:',0,1,'C');
        $this->cell(0,3,'Damas: Vestido blanco o blusa blanca y falda blanca/cafe debajo de la rodilla, medias, zapatos y mantilla.',0,1,'C');
        $this->cell(0,3,utf8_decode("Caballeros: Traje formal oscuro, camisa blanca y corbata (NO CORBATIN) y zapatos formales (No chumpa, no suéteres, no lentes de sol, no aretes, no tenis)."),0,1,'C');
;
    }
    }



$pdf = new PDF();
$pdf->AddPage();
$pdf->Image('img/INSCRIPCIONES.jpg',0,10,210,140,'JPG');
$pdf->Image('img/INSCRIPCIONES.jpg',0,150,210,140,'JPG');
$pdf->SetFont('Arial','',11);



while ($row = $result->fetch_assoc())
{
    $pdf->Ln(05);
    $pdf->cell(35,6,'Fecha de Compra:',0,0,'L');
    $pdf->Cell(30,6,$row['Fecha_compra'],0,1,'L');
    $pdf->cell(35,6,'DPI:',0,0,'L');
    $pdf->Cell(35,6,$row['DPI'],0,1,'L');
    $pdf->cell(35,6,'Nombre:',0,0,'L');
    $pdf->Cell(35,6,$row['Nombre'],0,1,'L');
    $pdf->cell(35,6,'Turno:',0,0,'L');
    $pdf->Cell(30,6,$row['Turno'],0,1,'L');
    $pdf->cell(35,6,'Cantidad:',0,0,'L');
    $pdf->Cell(30,6,$row['Cantidad'],0,1,'L');
    $pdf->cell(35,6,'Total:',0,0,'L');
    $pdf->Cell(8,6,$row['Total'],0,0,'L');
    $pdf->cell(35,6,'Quetzales',0,0,'L'); 
    $pdf->SetFont('Arial','B',7);
    $pdf->Ln(20);
    $pdf->cell(0,3,'Indicaciones Generales:',0,1,'C');
    $pdf->cell(0,3,utf8_decode("Los turnos serán entregados los días sábado 1 de julio de 14:00 a 15:00 horas y domingo 2 de julio de 8:00 a 13:00 horas."),0,1,'C');
    $pdf->cell(0,3,utf8_decode("Las andas procesionales serán levantadas a las 15:00 horas en punto."),0,1,'C');
    $pdf->cell(0,3,utf8_decode("Evite llevar niños en brazos, de la mano o debajo del anda al momento de cargar."),0,1,'C');
    $pdf->cell(0,3,'Presentarse 15 minutos antes de su turno en la fila asignada.',0,1,'C');
    $pdf->cell(0,3,'Uniformidad:',0,1,'C');
    $pdf->cell(0,3,'Damas: Vestido blanco o blusa blanca y falda blanca/cafe debajo de la rodilla, medias, zapatos y mantilla.',0,1,'C');
    $pdf->cell(0,3,utf8_decode("Caballeros: Traje formal oscuro, camisa blanca y corbata (NO CORBATIN) y zapatos formales (No chumpa, no suéteres, no lentes de sol, no aretes, no tenis)."),0,1,'C');

    $pdf->Ln(60);
    $pdf->SetFont('Arial','',11);
    $pdf->cell(35,6,'Fecha de Compra:',0,0,'L');
    $pdf->Cell(30,6,$row['Fecha_compra'],0,1,'L');
    $pdf->cell(35,6,'DPI:',0,0,'L');
    $pdf->Cell(35,6,$row['DPI'],0,1,'L');
    $pdf->cell(35,6,'Nombre:',0,0,'L');
    $pdf->Cell(35,6,$row['Nombre'],0,1,'L');
    $pdf->cell(35,6,'Turno:',0,0,'L');
    $pdf->Cell(30,6,$row['Turno'],0,1,'L');
    $pdf->cell(35,6,'Cantidad:',0,0,'L');
    $pdf->Cell(30,6,$row['Cantidad'],0,1,'L');
    $pdf->cell(35,6,'Total:',0,0,'L');
    $pdf->Cell(8,6,$row['Total'],0,0,'L');
    $pdf->cell(35,6,'Quetzales',0,0,'L');
}
$nombrepdf = $DPI. ' ' .$Turno;
$pdf->Output('i',$nombrepdf.'.pdf',false);
?>   