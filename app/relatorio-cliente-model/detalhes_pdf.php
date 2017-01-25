<?php
	require('../../lib/Config.php');
	// error_reporting(0);
	ini_set('memory_limit', -1);
   
    $con = mysql_connect(DB_HOST, DB_USER, DB_PSWD);
    mysql_select_db(DB_NAME);

    $sql = "
    select  m.nome as marca ,em.nome as modelo ,count(em.nome)as total from equipamento as e
    LEFT JOIN contrato_equipamento as ce on ce.equipamento_id = e.id
    LEFT JOIN contrato as c ON ce.contrato_id = c.id
    LEFT JOIN equipamento_modelo as em ON e.equipamento_modelo_id = em.id
    LEFT JOIN marca as m ON em.marca_id = m.id
    where
    ce.contrato_id = c.id
    AND ce.equipamento_id = e.id
    and e.status = 2
    GROUP BY em.nome
    ";
    /*
    where ce.contrato_id = c.id
    AND ce.equipamento_id = e.id
    AND c.tipo = 0*/

    $exe = mysql_query($sql) or die(mysql_error());

    $credito = 0;
    $debito = 0;
    $x = 0;

	$pdf = new FPDF();
	$pdf->AddPage();
	$pdf->Image(PATH_ADMIN.'images/LOGO SISTEMA.png', 10, 16, '50%'); 
	$pdf->SetFont('Arial','',10);
    $pdf->SetAutoPageBreak(false);

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetXY(65, 0);
    $pdf->Cell(128,20,utf8_decode("FILIBRAS COMERCIAL IMPORTAÇÃO E EXPORTAÇÃO LTDA."));

    $pdf->SetXY(65, 10);
    $pdf->Cell(128,10,utf8_decode("CNPJ: 05.781.815/0001-79"));

    $pdf->SetXY(65, 15);
    $pdf->Cell(128,10,utf8_decode("INSCRIÇÃO ESTADUAL: 0622453570047"));

    $pdf->SetFont('Arial', '', 8);
    $pdf->SetXY(65, 20);
    $pdf->Cell(128,10,utf8_decode("RUA BERNARDO GUMARÃES, 3.038 - BARRO PRETO"));

    $pdf->SetXY(65, 25);
    $pdf->Cell(128,10,"BELO HORIZONTE / MG - CEP: 30140-083");

    $pdf->SetXY(65, 30);
    $pdf->Cell(128,10,"FONE:   (31) 3335-8099         SITE:   www.filibras.com.br");

    $pdf->SetXY(65, 35);
    $pdf->Cell(128,10,"EMAIL:   filibras@filibras.com.br");


    $pdf->SetXY(170, 10);
    $pdf->SetFillColor(233, 233, 233);
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->Cell(30, 15, "", 1, 1, 'C', 1);

    $pdf->SetXY(180, 27);
    // Local
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(128,10,"DATA");

    // Data
    $pdf->SetXY(177, 32);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(131,10,date('d/m/Y'));

    $page_height = 320.93;
    $line_height = 70;
    $bottom_margin = 0;
	// Local

	$pdf->SetXY(5, 5);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->Cell(200, 40, "", 1, 1, 'C');

	$pdf->SetFont('Arial', 'B', 9);


	$pdf->SetFont('Arial', '', 8);
	$x=0;
	$inicio = 55;
	$soma = 0;
	while ($objEquipamento = mysql_fetch_assoc($exe)) {

        // $pdf->SetXY(8, $inicio);
        // $pdf->Cell(30, 20, "", 1, 1, 'C', 1);

        $pdf->SetXY(8+$x*65, $inicio);

        $pdf->Cell(64,16,"", 1);

        $pdf->SetFont('Arial', '', 8);

        $pdf->SetXY(10+$x*65, $inicio);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(18,10,utf8_decode("Marca:"));
        $pdf->Cell(30,10,utf8_decode("Modelo:"));
        $pdf->Cell(20,10,utf8_decode("Total:"));

        $pdf->SetXY(10+$x*65, $inicio+5);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(18,10,utf8_decode($objEquipamento['marca']));
        $pdf->Cell(30,10,utf8_decode($objEquipamento['modelo']));
        $pdf->Cell(20,10,utf8_decode($objEquipamento['total']));

        $H = $pdf->GetY();
        $height = $H-$inicio;

        $x++;

        if($x%3==0){
            $inicio = $H+12;    
            $x = 0;

            $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page
            if ($line_height > $space_left) {
            // if ($x%6==0) {
                $pdf->AddPage(); // page break
                $inicio = 10;
            }
        }

	}





	// Nome do anexo
	$filename = "relatorio-cliente-modelo.pdf";

	$eol = PHP_EOL;
	// a random hash will be necessary to send mixed content
	$separator = md5(time());

	$pdf->Output();

?>
