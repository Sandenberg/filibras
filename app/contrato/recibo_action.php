<?php
	// require('lib/Config.php');
	error_reporting(0);
	// $_POST['numerador_atual_mono'] = '281712';
	// $_POST['numerador_anterior_mono'] = '279123';

	// $_POST['numerador_atual_colorida'] = '104498';
	// $_POST['numerador_anterior_colorida'] = '101612';

	// print_r($_POST);
	$objContrato 						= Doctrine_Core::getTable('Contrato')->find($_POST['id']);

	$pdf = new FPDF();
	$pdf->AddPage();
	$pdf->Image(PATH_ADMIN.'images/fundo_recibo.jpg', 0, 0, '210%'); 
	$pdf->SetFont('Arial','',10);

	// muda o charset
	$objContrato->ContratoEquipamento[0]->local = utf8_decode($objContrato->ContratoEquipamento[0]->local);
	$objContrato->Cliente->nome_completo = substr(utf8_decode($objContrato->Cliente->nome_completo), 0, 75);
	$objContrato->Cliente->logradouro = utf8_decode($objContrato->Cliente->logradouro);
	$objContrato->Cliente->complemento = utf8_decode($objContrato->Cliente->complemento);
	$objContrato->Cliente->Cidade->nome = utf8_decode($objContrato->Cliente->Cidade->nome);

	// Tratamento de dados
	$objContrato->Cliente->cnpj = $objContrato->Cliente->cnpj==''?$objContrato->Cliente->cpf:$objContrato->Cliente->cnpj;
	$objContrato->Cliente->inscricao_estadual = $objContrato->Cliente->inscricao_estadual==''?'-------':$objContrato->Cliente->inscricao_estadual;
    // $objContrato->Cliente->telefone_principal = Util::mask('(##)####-####', $objContrato->Cliente->telefone_principal);  


    // $objContrato->Cliente->telefone_principal = substr($objContrato->Cliente->telefone_principal, 1, 11); 
	$telefone_principal = ltrim($objContrato->Cliente->telefone_principal, '0');  
	$telefone_principal = strlen($telefone_principal)==10?Util::mask('(##)####-####', $telefone_principal):Util::mask('(##)#####-####', $telefone_principal);  
		
    $objContrato->Cliente->cep = Util::mask('#####-###', $objContrato->Cliente->cep); 

    //Calcula o total de páginas monocromáticas
    // $numeradores_atual = explode('/', $_POST['numerador_atual_mono']);
    // $numeradores_anteriores = explode('/', $_POST['numerador_anterior_mono']);
    $numeradores_atual		 = $_POST['numerador_atual_mono'];
    $numeradores_anteriores	 = $_POST['numerador_anterior_mono'];

    $totalPaginasMono = 0;
    if(is_array($numeradores_atual)){
	    foreach ($numeradores_atual as $key => $value) {
	    	$totalPaginasMono += $numeradores_atual[$key] - $numeradores_anteriores[$key];
	    }
	}else{
    	$totalPaginasMono += $_POST['numerador_atual_mono'] - $_POST['numerador_anterior_mono'];
	}

    //Calcula o total de páginas coloridas
    // $numeradores_atual = explode('/', $_POST['numerador_atual_colorida']);
    // $numeradores_anteriores = explode('/', $_POST['numerador_anterior_colorida']);
    $totalPaginasColor = 0;
    if(isset($_POST['numerador_atual_colorida'])){
	    $numeradores_atual		 = $_POST['numerador_atual_colorida'];
	    $numeradores_anteriores	 = $_POST['numerador_anterior_colorida'];

	    if(is_array($numeradores_atual)){
		    foreach ($numeradores_atual as $key => $value) {
		    	$totalPaginasColor += $numeradores_atual[$key] - $numeradores_anteriores[$key];
		    }
		}else{
	    	$totalPaginasColor += $_POST['numerador_atual_mono'] - $_POST['numerador_anterior_mono'];
		}
	}

	// Linha 1
	// Seta a posição
	$pdf->SetXY(25, 22);
	// Local
	$pdf->Cell(128,50,"Belo Horizonte");
	// $pdf->Cell(128,50,$objContrato->ContratoEquipamento[0]->local);
	// Dia
	$pdf->Cell(13,50,date('d'));
	// Mês
	$pdf->Cell(14,50,date('m'));
	// Ano
	$pdf->Cell(10,50,date('Y'));

	// Linha 2
	// Seta a posição
	$pdf->SetXY(28, 32);
	// Cliente
	$pdf->Cell(100,50,$objContrato->Cliente->nome_completo);

	// Linha 3
	// Seta a posição
	$pdf->SetXY(30, 41.8);
	// Endereço
	$pdf->Cell(140,50,$objContrato->Cliente->logradouro.', '.$objContrato->Cliente->numero.', '.$objContrato->Cliente->complemento.' - '.$objContrato->Cliente->bairro);
	// CEP
	$pdf->Cell(10,50,$objContrato->Cliente->cep);

	// Linha 4
	// Seta a posição
	$pdf->SetXY(27, 52);
	// Cidade
	$pdf->Cell(88,50,strtoupper($objContrato->Cliente->Cidade->nome));
	// Estado
	$pdf->Cell(30,50,$objContrato->Cliente->Cidade->Uf->sigla);
	// Tel.
	$pdf->Cell(10,50,$telefone_principal);

	// Linha 5
	// Seta a posição
	$pdf->SetXY(25, 61.7);
	// CNPJ
	if($objContrato->Cliente->tipo_pessoa == 1)
		$cnpj 	= isset($objContrato->Cliente->cnpj)&&$objContrato->Cliente->cnpj!=''?Util::mask('##.###.###/####-##', $objContrato->Cliente->cnpj):$cnpj;
	else
		$cnpj 	= isset($objContrato->Cliente->cpf)&&$objContrato->Cliente->cpf!=''?Util::mask('###.###.###-##', $objContrato->Cliente->cpf):'';

	$pdf->Cell(92,50,$cnpj);
	// Inscrição Estadual
	$ie = $objContrato->Cliente->tipo_pessoa == 1?$objContrato->Cliente->inscricao_estadual:$objContrato->Cliente->rg;
	$pdf->Cell(30,49,$ie);

	// Linha 5
	// Seta a posição
	$pdf->SetXY(53, 71);
	// Condições de Pagamento
	$pdf->Cell(92,50,$_POST['condicao']);

	// foreach ($objContrato->ContratoEquipamento as $key => $objContratoEquipamento) {
	// 	$modelo = 
	// }
	// Linha 6
	// Seta a posição
	$pdf->SetXY(40, 81.5);
	// Maquina Modelo:
	$pdf->Cell(107,50,$objContrato->ContratoEquipamento[0]->Equipamento->Marca->nome.' '.$objContrato->ContratoEquipamento[0]->Equipamento->EquipamentoModelo->nome);
	// Série
	$pdf->Cell(10,50,$objContrato->ContratoEquipamento[0]->Equipamento->serial);



	$numerador_atual = isset($_POST['numerador_atual_mono'])?implode(" / ", $_POST['numerador_atual_mono']):'';
	$numerador_atual = isset($_POST['numerador_atual_colorida'])&&$numerador_atual!=''?$numerador_atual.'/'.implode(" / ", $_POST['numerador_atual_colorida']):$numerador_atual;

	$numerador_anterior = isset($_POST['numerador_anterior_mono'])?implode(" / ", $_POST['numerador_anterior_mono']):0;
	$numerador_anterior = isset($_POST['numerador_anterior_colorida'])&&$numerador_anterior!=''?$numerador_anterior.'/'.implode(" / ", $_POST['numerador_anterior_colorida']):$numerador_anterior;


	$pdf->SetFont('Arial','',8);
	// Linha 7
	// Seta a posição
	$pdf->SetXY(40, 91.7);
	// Numerador Atual
	$pdf->Cell(66,50,substr($numerador_atual, 0, 23));
	// Numerador Anterior
	$pdf->Cell(55,50,substr($numerador_anterior, 0, 23));
	// Total de Páginas
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(10,50,$totalPaginasColor+$totalPaginasMono);


	$y = 118;
	$i = 0;
	$quant = 0;
	$valorFinal = 0;

	if($objContrato->franquia_monocromatica > 0){
		
		$i++;

		$quant = $objContrato->franquia_monocromatica;
		// Linha Produtos
		// Seta a posição
		$pdf->SetXY(16, $y);
		// Unid.
		$pdf->Cell(13,50,$i);
		// Quant.
		$pdf->Cell(16,50,$quant);
		// Discrimicação
		$pdf->Cell(88,50,utf8_decode("Franquia monocromática"));
		// Unitario
		$pdf->Cell(30,50,'R$'.number_format($objContrato->valor_monocromatica, 4, ',', '.'),0,0,'R');
		// Total
		$pdf->Cell(30,50,'R$'.number_format($objContrato->valor_monocromatica, 4, ',', '.'),0,0,'R');

		// Seta a distancia para a próxima linha
		$y += 12;

		$valorFinal += $objContrato->valor_monocromatica;
	}

	if($totalPaginasMono > $objContrato->franquia_monocromatica){
		
		$paginasAdicional = $totalPaginasMono - $objContrato->franquia_monocromatica;
		if($objContrato->franquia_monocromatica > 0)
			$valorTotal = $objContrato->adicional_monocromatica * $paginasAdicional;
		else
			$valorTotal = $objContrato->valor_monocromatica * $paginasAdicional;
		$i++;

		$quant = $paginasAdicional;
		// Linha Produtos
		// Seta a posição
		$pdf->SetXY(16, $y);
		// Unid.
		$pdf->Cell(13,50,$i);
		// Quant.
		$pdf->Cell(16,50,$quant);
		// Discrimicação
		$pdf->Cell(88,50,utf8_decode("Adicional monocromática"));
		// Unitario
		if($objContrato->franquia_monocromatica > 0)
			$pdf->Cell(30,50,'R$'.number_format($objContrato->adicional_monocromatica, 4, ',', '.'),0,0,'R');
		else
			$pdf->Cell(30,50,'R$'.number_format($objContrato->valor_monocromatica, 4, ',', '.'),0,0,'R');
		// Total
		$pdf->Cell(30,50,'R$'.number_format($valorTotal, 4, ',', '.'),0,0,'R');

		// Seta a distancia para a próxima linha
		$y += 12;

		$valorFinal += $valorTotal;
	}


	if($objContrato->franquia_colorida > 0){
		
		$i++;

		$quant = $objContrato->franquia_colorida;
		// Linha Produtos
		// Seta a posição
		$pdf->SetXY(16, $y);
		// Unid.
		$pdf->Cell(13,50,$i);
		// Quant.
		$pdf->Cell(16,50,$quant);
		// Discrimicação
		$pdf->Cell(88,50,utf8_decode("Franquia colorida"));
		// Unitario
		$pdf->Cell(30,50,'R$'.number_format($objContrato->valor_colorida, 4, ',', '.'),0,0,'R');
		// Total
		$pdf->Cell(30,50,'R$'.number_format($objContrato->valor_colorida, 4, ',', '.'),0,0,'R');

		// Seta a distancia para a próxima linha
		$y += 12;

		$valorFinal += $objContrato->valor_colorida;
	}

	if($totalPaginasColor > $objContrato->franquia_colorida){
		
		$paginasAdicional = $totalPaginasColor - $objContrato->franquia_colorida;
		$valorTotal = $objContrato->adicional_colorida * $paginasAdicional;
		$i++;

		$quant = $paginasAdicional;
		// Linha Produtos
		// Seta a posição
		$pdf->SetXY(16, $y);
		// Unid.
		$pdf->Cell(13,50,$i);
		// Quant.
		$pdf->Cell(16,50,$quant);
		// Discrimicação
		$pdf->Cell(88,50,utf8_decode("Adicional colorida"));
		// Unitario
		$pdf->Cell(30,50,'R$'.number_format($objContrato->adicional_colorida, 4, ',', '.'),0,0,'R');
		// Total
		$pdf->Cell(30,50,'R$'.number_format($valorTotal, 4, ',', '.'),0,0,'R');

		// Seta a distancia para a próxima linha
		$y += 12;

		$valorFinal += $valorTotal;
	}

	if(isset($_POST['adic_descricao1'])&&$_POST['adic_descricao1'] != ''){
		
		$i++;

		$_POST['adic_valor1'] = str_replace(',', '.', $_POST['adic_valor1']);
		$valorTotal = number_format($_POST['adic_valor1'], 4, '.', '')*$_POST['adic_quantidade1'];
		// Linha Produtos
		// Seta a posição
		$pdf->SetXY(16, $y);
		// Unid.
		$pdf->Cell(13,50,$i);
		// Quant.
		$pdf->Cell(16,50,$_POST['adic_quantidade1']);
		// Discrimicação
		$pdf->Cell(88,50,utf8_decode($_POST['adic_descricao1']));
		// Unitario
		$pdf->Cell(30,50,'R$'.number_format($_POST['adic_valor1'], 4, ',', '.'),0,0,'R');
		// Total
		$pdf->Cell(30,50,'R$'.number_format($valorTotal, 4, ',', '.'),0,0,'R');
		// Seta a distancia para a próxima linha
		$y += 12;

		$valorFinal += $valorTotal;
	}
	if(isset($_POST['adic_descricao2'])&&$_POST['adic_descricao2'] != ''){
		
		$i++;
		$_POST['adic_valor2'] = str_replace(',', '.', $_POST['adic_valor2']);
		$valorTotal = number_format($_POST['adic_valor2'], 4, '.', '')*$_POST['adic_quantidade2'];
		// Linha Produtos
		// Seta a posição
		$pdf->SetXY(16, $y);
		// Unid.
		$pdf->Cell(13,50,$i);
		// Quant.
		$pdf->Cell(16,50,$_POST['adic_quantidade2']);
		// Discrimicação
		$pdf->Cell(88,50,utf8_decode($_POST['adic_descricao2']));
		// Unitario
		$pdf->Cell(30,50,'R$'.number_format($_POST['adic_valor2'], 4, ',', '.'),0,0,'R');
		// Total
		$pdf->Cell(30,50,'R$'.number_format($valorTotal, 4, ',', '.'),0,0,'R');

		// Seta a distancia para a próxima linha
		$y += 12;

		$valorFinal += $valorTotal;
	}
	if(isset($_POST['adic_descricao3'])&&$_POST['adic_descricao3'] != ''){
		
		$i++;

		$_POST['adic_valor3'] = str_replace(',', '.', $_POST['adic_valor3']);
		$valorTotal = number_format($_POST['adic_valor3'], 4, '.', '')*$_POST['adic_quantidade3'];
		// Linha Produtos
		// Seta a posição
		$pdf->SetXY(16, $y);
		// Unid.
		$pdf->Cell(13,50,$i);
		// Quant.
		$pdf->Cell(16,50,$_POST['adic_quantidade3']);
		// Discrimicação
		$pdf->Cell(88,50,utf8_decode($_POST['adic_descricao3']));
		// Unitario
		$pdf->Cell(30,50,'R$'.number_format($_POST['adic_valor3'], 4, ',', '.'),0,0,'R');
		// Total
		$pdf->Cell(30,50,'R$'.number_format($valorTotal, 4, ',', '.'),0,0,'R');

		// Seta a distancia para a próxima linha
		$y += 12;

		$valorFinal += $valorTotal;
	}

	$valorRecibo = $valorFinal;
	$valorFinal = 'R$'.number_format($valorFinal, 2, ',', '.');
	// Linha Final
	// Seta a posição
	$pdf->SetXY(160, 272);
	// Total de Páginas
	$pdf->Cell(20,0,$valorFinal,0,0,'R');

	// Nome do anexo
	$filename = "recibo.pdf";

	$eol = PHP_EOL;
	// a random hash will be necessary to send mixed content
	$separator = md5(time());

	if($_POST['acao'] == "Visualizar"){
		$pdf->Output();
	}


	if($_POST['acao'] == "Salvar"){

		$objRecibo = new Recibo();
		$objRecibo->email 			= $_POST['email'];
		$objRecibo->pagamento 		= $_POST['condicao'];
		$objRecibo->contrato_id		= $_POST['id'];
		$objRecibo->save();

		$x=0;
		foreach ($_POST['equipamento_id'] as $value) {
			$objReciboEquipamento = new ReciboEquipamento();
			$objReciboEquipamento->equipamento_id 	= $_POST['equipamento_id'][$x];
			$objReciboEquipamento->recibo_id 		= $objRecibo->id;
			$objReciboEquipamento->num_atual_pb 	= isset($_POST['numerador_atual_mono'][$x])?$_POST['numerador_atual_mono'][$x]:null;
			$objReciboEquipamento->num_ant_pb 		= isset($_POST['numerador_anterior_mono'][$x])?$_POST['numerador_anterior_mono'][$x]:null;
			$objReciboEquipamento->num_atual_color = isset($_POST['numerador_atual_colorida'][$x])?$_POST['numerador_atual_colorida'][$x]:null;
			$objReciboEquipamento->num_ant_color 	= isset($_POST['numerador_anterior_colorida'][$x])?$_POST['numerador_anterior_colorida'][$x]:null;
			$objReciboEquipamento->save();
			$x++;
		}

		$where = "os.cliente_id = '".$objContrato->cliente_id."' or oss.cliente_id = '".$objContrato->cliente_id."'";
			$where .= " and osm.data_cadastro > '".date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')." - 30 days"))."'";
		$retOrderServicoMaterial = Doctrine_Query::create()->select('sum(valor_total) as total')->from('OrdemServicoMaterial osm')
					->leftJoin('osm.OrdemServico os')->leftJoin('osm.OrdemServToner ost')->leftJoin('ost.OrdemServico oss')
					->leftJoin('osm.Material m')->where($where)
					->execute();

		$objFechamento = new Fechamento();
		$objFechamento->cliente_id			= $objContrato->cliente_id;
		$objFechamento->contrato_id			= $objContrato->id;
		$objFechamento->data_fechamento		= date('Y-m-d H:i:s');
		$objFechamento->recibo_id 			= $objRecibo->id;
		$objFechamento->valor 				= isset($valorRecibo)&&$valorRecibo>0?$valorRecibo:0;
		$objFechamento->custo 				= isset($retOrderServicoMaterial[0]->total)&&$retOrderServicoMaterial[0]->total>0?$retOrderServicoMaterial[0]->total:0;
		$objFechamento->save();

		$pdfdoc = $pdf->Output($filename, "S");
		$attachment = chunk_split(base64_encode($pdfdoc));

		// echo $_FILES['boleto']['tmp_name'];
		// $boleto = file_get_contents($_FILES['boleto']['tmp_name']);
		// $attachment2 = chunk_split(base64_encode($boleto));

		// email stuff (change data below)
		$to = $_POST['email']; 
		$from = "filibras@filibras.com.br"; 
		$subject = "Recibo"; 
		$message = "<p>Segue em anexo o recibo.</p>";


		// email stuff (change data below)
		$to = "paulo.ortiz9@gmail.com"; 
		$from = "filibras@filibras.com.br"; 

		$message = "
Prezado Cliente ,<br><br>

Segue anexo recibo e boleto referente a locação da maquina copiadora.<br><br>

Att,<br>
<img src='".URL."images/assinatura.PNG'>
";

		try {
			

			$mail = new PHPMailer();

			$mail->From = "filibras@filibras.com.br";
			$mail->FromName = "Filibras";
			$mail->ConfirmReadingTo = "filibras@filibras.com.br";
			$mail->IsHTML(true);

			$mail->AddAddress($_POST['email']);

			if(isset($_POST['email2'])&&$_POST['email2']!='')
				$mail->AddCC($_POST['email2']); 

			$mail->Subject = "Recibo e Boleto Filibras";
			$mail->Body = $message;
			$mail->CharSet = 'utf-8';

			$mail->AddAttachment($_FILES['boleto1']['tmp_name'], 'boleto1.pdf');
			if(isset($_FILES['boleto2']))
				$mail->AddAttachment($_FILES['boleto2']['tmp_name'], 'boleto2.pdf');
			if(isset($_FILES['boleto3']))
				$mail->AddAttachment($_FILES['boleto3']['tmp_name'], 'boleto2.pdf');
			$mail->AddStringAttachment($pdfdoc, 'recibo.pdf');

			$enviado = $mail->Send();
			// if ($enviado) {
			//   echo "E-mail enviado com sucesso!";
			// } else {
			//   echo "Não foi possível enviar o e-mail.";
			//   echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
			// }
		} catch (Exception $e) {
			
		}

		// main header
		$headers  = "From: ".$from.$eol;
		$headers .= "MIME-Version: 1.0".$eol; 
		$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

		// no more headers after this, we start the body! //

		$body = "--".$separator.$eol;
		// $body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
		// $body .= "This is a MIME encoded message.".$eol;

		// message
		$body .= "--".$separator.$eol;
		$body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
		$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
		$body .= $message.$eol;

		// attachment
		$body .= "--".$separator.$eol;
		$body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
		$body .= "Content-Transfer-Encoding: base64".$eol;
		$body .= "Content-Disposition: attachment".$eol.$eol;
		$body .= $attachment.$eol;
		$body .= "--".$separator."--";

		// // attachment
		// $body .= "--".$separator.$eol;
		// $body .= "Content-Type: application/octet-stream; name=\"boleto.pdf\"".$eol; 
		// $body .= "Content-Transfer-Encoding: base64".$eol;
		// $body .= "Content-Disposition: attachment2".$eol.$eol;
		// $body .= $attachment2.$eol;
		// $body .= "--".$separator."--";

		// send message
		// mail($to, $subject, $body, $headers);

		// Tratamento de retorno
		$_SESSION['return_type'] 	= 'success';
		$_SESSION['return_message']	= 'Executado com sucesso!';

		header("Location: ".URL_ADMIN."contrato/recibo/".$_POST['id']);
	}
?>
