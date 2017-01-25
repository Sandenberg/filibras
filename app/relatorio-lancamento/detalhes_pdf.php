<?php
	require('../../lib/Config.php');
	// error_reporting(0);
	ini_set('memory_limit', -1);
    $where = '1 = 1';

    // Filtro de Tipo
    $where .= isset($_GET['tipo'])&&$_GET['tipo']!=''?" and tipo = '".$_GET['tipo']."'":'';

    $where .= isset($_GET['nf'])&&$_GET['nf']!=''?" and nf = '".$_GET['nf']."' ":'';


    if(isset($_GET['tipo_nf_id'])&&$_GET['tipo_nf_id']!=''){
        if($_GET['tipo_nf_id'] == 'TNF')
            $where .= " and nf <> ''";
        else if($_GET['tipo_nf_id'] == 'REC')
            $where .= " and recibo <> ''";
        else if($_GET['tipo_nf_id'] == 'RECTNF')
            $where .= " and (nf <> '' or recibo <> '')";
        else
            $where .= " and tipo_nf_id = '".$_GET['tipo_nf_id']."'";
    }

    // $where .= isset($_GET['tipo_nf_id'])&&$_GET['tipo_nf_id']!=''&&$_GET['tipo_nf_id']!='TNF'?" and tipo_nf_id = '".$_GET['tipo_nf_id']."' ":'';
    // $where .= isset($_GET['tipo_nf_id'])&&$_GET['tipo_nf_id']=='TNF'?" and nf <> ''":'';

    // $where .= isset($_GET['recibo'])&&$_GET['recibo']!=''?" and recibo <> '' ":'';

    // Filtro de Cliente
    $where .= isset($_GET['cliente_id'])&&$_GET['cliente_id']!=''?" and cliente_id = '".$_GET['cliente_id']."'":'';

    // Filtro de Beneficiario
    $where .= isset($_GET['beneficiario_id'])&&$_GET['beneficiario_id']!=''?" and beneficiario_id = '".$_GET['beneficiario_id']."'":'';

    // Filtro de Tipo de Lançamento
    $where .= isset($_GET['lancamento_tipo_id'])&&$_GET['lancamento_tipo_id']!=''?" and lancamento_tipo_id = '".$_GET['lancamento_tipo_id']."'":'';

    // Filtro de Conta
    $where .= isset($_GET['conta_id'])&&$_GET['conta_id']!=''?" and conta_id = '".$_GET['conta_id']."'":'';
    
    // Tratamento de dados
    $_GET['data_lancamento_I'] = isset($_GET['data_lancamento_I'])&&$_GET['data_lancamento_I']!=''?$_GET['data_lancamento_I']:null;
    $_GET['data_lancamento_F'] = isset($_GET['data_lancamento_F'])&&$_GET['data_lancamento_F']!=''?$_GET['data_lancamento_F']:null;
                

    if ($_GET['data_lancamento_I'] != '' && $_GET['data_lancamento_F'] != ''){
        $where .= ' and l.data_lancamento BETWEEN "'.$_GET['data_lancamento_I'].' 00:00:00" AND "'.$_GET['data_lancamento_F'].' 23:59:59"';
    }

    // Tratamento de dados
    $_GET['data_vencimento_I'] = isset($_GET['data_vencimento_I'])&&$_GET['data_vencimento_I']!=''?$_GET['data_vencimento_I']:null;
    $_GET['data_vencimento_F'] = isset($_GET['data_vencimento_F'])&&$_GET['data_vencimento_F']!=''?$_GET['data_vencimento_F']:null;
                

    if ($_GET['data_vencimento_I'] != '' && $_GET['data_vencimento_F'] != ''){
        $where .= ' and l.data_vencimento BETWEEN "'.$_GET['data_vencimento_I'].'" AND "'.$_GET['data_vencimento_F'].'"';
    }

    // Tratamento de dados
    $_GET['data_baixa_I'] = isset($_GET['data_baixa_I'])&&$_GET['data_baixa_I']!=''?$_GET['data_baixa_I']:null;
    $_GET['data_baixa_F'] = isset($_GET['data_baixa_F'])&&$_GET['data_baixa_F']!=''?$_GET['data_baixa_F']:null;
                

    if ($_GET['data_baixa_I'] != '' && $_GET['data_baixa_F'] != ''){
        $where .= ' and l.data_baixa BETWEEN "'.$_GET['data_baixa_I'].'" AND "'.$_GET['data_baixa_F'].'"';
    }

    $order = 'data_lancamento asc';

    if(isset($_GET['tipo_nf_id']))
        $order = "nf asc";

    $retAll     =   Doctrine_Query::create()->select()->from('Lancamento l')
                        ->leftJoin('l.LancamentoTipo lt')->leftJoin('l.TipoNf nf')
                        ->orderBy($order)
                        ->where($where)->execute();

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

    // $pdf->SetXY(170, 10);
    // $pdf->SetFillColor(233, 233, 233);
    // $pdf->SetDrawColor(0, 0, 0);
    // $pdf->Cell(30, 15, "", 1, 1, 'C', 1);

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

	// Linha 4
	// Seta a posição
	$pdf->SetXY(8, 48);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(15,10,utf8_decode("Código"));
    if($_GET['tipo']=="debito"){
        $pdf->Cell(45,10,utf8_decode("Beneficiário"));
    }else{
        $pdf->Cell(45,10,utf8_decode("Cliente"));
    }
	$pdf->Cell(20,10,utf8_decode("Lançamento"));
    $pdf->Cell(20,10,utf8_decode("Vencimento"));
    $pdf->Cell(20,10,utf8_decode("Baixa"));
    $pdf->Cell(13,10,utf8_decode("Tipo"));
    $pdf->Cell(25,10,utf8_decode("Tipo/NF"));
	$pdf->Cell(20,10,utf8_decode("Conta"));
	$pdf->Cell(20,10,utf8_decode("Valor"));

	$pdf->SetFont('Arial', '', 8);
	$x=0;
	$inicio = 55;
	$soma = 0;
	foreach ($retAll as $objLancamento) {

        if($objLancamento->beneficiario_id){
            $res = Doctrine_Core::getTable('Beneficiario')->find($objLancamento->beneficiario_id);
            $beneficiario = $res->nome;
            $cliente = '-';
            $debito += $objLancamento->valor_total;
        }else{
            $res = Doctrine_Core::getTable('Cliente')->find($objLancamento->cliente_id);
            $cliente = isset($res->nome_completo)?$res->nome_completo:'';
            $beneficiario = '-';
            $credito += $objLancamento->valor_total;
        }

        if($objLancamento->conta_id){
            $resConta = Doctrine_Core::getTable('Conta')->find($objLancamento->conta_id);
            $conta = $resConta->nome;
        }else{
            $conta = '-';
        }

        $data_lancamento = isset($objLancamento->data_lancamento)&&$objLancamento->data_lancamento!='0000-00-00'&&$objLancamento->data_lancamento!=''?date('d/m/Y', strtotime($objLancamento->data_lancamento)):'-';
        $data_vencimento = isset($objLancamento->data_vencimento)&&$objLancamento->data_vencimento!='0000-00-00'&&$objLancamento->data_vencimento!=''?date('d/m/Y', strtotime($objLancamento->data_vencimento)):'-';
        $data_baixa = isset($objLancamento->data_baixa)&&$objLancamento->data_baixa!='0000-00-00'&&$objLancamento->data_baixa!=''?date('d/m/Y', strtotime($objLancamento->data_baixa)):'-';


        $tipoNf = isset($objLancamento->TipoNf->nome)?$objLancamento->TipoNf->nome:'- ';
        $nf = isset($objLancamento->nf)&&$objLancamento->nf!=''?$objLancamento->nf:' -';

        $textoNf = $tipoNf."/".$nf;

        if(isset($objLancamento->recibo)&&$objLancamento->recibo!='')
            $textoNf = "RECIBO";

		$pdf->SetXY(23, $inicio);
		if($objLancamento->tipo == 'debito'){
			$pdf->MultiCell(45,4,utf8_decode(strtoupper($beneficiario)),0,'L');
            $tipo = "Débito";
		}else{
			$pdf->MultiCell(45,4,utf8_decode(strtoupper($cliente)),0,'L');	
            $tipo = "Crédito";
		}

        $valor_total = isset($objLancamento->valor_total)&&$objLancamento->valor_total>0&&is_numeric($objLancamento->valor_total)?$objLancamento->valor_total:0;

		$H = $pdf->GetY();
		$height = $H-$inicio;

		$pdf->SetXY(8, $inicio);
		$pdf->Cell(18,4,utf8_decode($objLancamento->id));

		$pdf->SetXY(68, $inicio-3);

        $pdf->Cell(20,10,utf8_decode($data_lancamento));
        $pdf->Cell(20,10,utf8_decode($data_vencimento));
        $pdf->Cell(20,10,utf8_decode($data_baixa));
        $pdf->Cell(13,10,utf8_decode($tipo));
        $pdf->Cell(25,10,utf8_decode($textoNf));
        $pdf->Cell(20,10,utf8_decode($conta));
        $pdf->Cell(20,10,utf8_decode("R$".number_format($valor_total,2,',','.')));


		$inicio = $H+5;
		$x++;

        $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page
        if ($line_height > $space_left) {
        // if ($x%6==0) {
            $pdf->AddPage(); // page break
            $inicio = 10;
        }
	}





	// Nome do anexo
	$filename = "relatorio-lancamento.pdf";

	$eol = PHP_EOL;
	// a random hash will be necessary to send mixed content
	$separator = md5(time());

	$pdf->Output();

?>
