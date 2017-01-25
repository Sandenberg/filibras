<?php
	// require('lib/Config.php');
	error_reporting(0);
	// $_POST['numerador_atual_mono'] = '281712';
	// $_POST['numerador_anterior_mono'] = '279123';

	// $_POST['numerador_atual_colorida'] = '104498';
	// $_POST['numerador_anterior_colorida'] = '101612';

	//PARA TESTES
	// $_POST['id'] = 105;


// 	$_POST['tributos'] = "Val Aprox Tributos R$331,66 (14,42%) Fonte:IBPT";

// 	$_POST['observacao'] = "EQUIPAMENTO(S) INSTALADO(S) EM BELO HORIZONTE-MG, 
// REFERENTE AO PERIODO DO DIA : 25/03/2015 à 25/04/2015
// CONTRATO : 0016/2014
// \"DISPENSADO DE EMISSãO DE NOTA FISCAL DE ACORDO COM LEI COMPLEMENTAR 116/2003 ITEM 3.01\"
// LOCAÇÃO - LEI FEDERAL N. 8846 DE 21/01/1994";

	$_POST['fatura'] = str_pad($_POST['fatura'], 6, "0", STR_PAD_LEFT);

	// print_r($_POST);
	$objContrato 						= Doctrine_Core::getTable('Contrato')->find($_POST['id']);

	$tributo = 0;

	$pdf = new FPDF();
	$pdf->AddPage();
	$pdf->Image(PATH_ADMIN.'images/LOGO SISTEMA.png', 10, 16, '50%'); 
	$pdf->SetFont('Arial','',10);


	// Local

	$pdf->SetXY(5, 5);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->Cell(200, 40, "", 1, 1, 'C');

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

	$pdf->SetXY(173, 13);
	$pdf->SetFont('Arial', 'B', 7);
	$pdf->Cell( 90, 3, utf8_decode("Fatura de Locação:"));

	$pdf->SetXY(176, 18);
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->Cell( 40, 3, utf8_decode($_POST['fatura']));


	$pdf->SetXY(180, 27);
	// Local
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(128,10,"DATA");

	// Data
	$pdf->SetXY(177, 32);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(131,10,$_POST['data']);



	$pdf->SetXY(5, 54);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->Cell(200, 43, "", 1, 1, 'C');

	$pdf->SetXY(5, 45);
	// Local
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->Cell(128,10,utf8_decode("DESTINATÁRIO DA LOCAÇÃO"));

	$pdf->SetFont('Arial', '', 8);
	

	// muda o charset
	$objContrato->ContratoEquipamento[0]->local = utf8_decode($objContrato->ContratoEquipamento[0]->local);
	$objContrato->Cliente->nome_completo = utf8_decode($objContrato->Cliente->nome_completo);
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


	// Linha 1
	// Seta a posição

	if($objContrato->Cliente->tipo_pessoa == 1)
		$cnpj 	= isset($objContrato->Cliente->cnpj)&&$objContrato->Cliente->cnpj!=''?Util::mask('##.###.###/####-##', $objContrato->Cliente->cnpj):$cnpj;
	else
		$cnpj 	= isset($objContrato->Cliente->cpf)&&$objContrato->Cliente->cpf!=''?Util::mask('###.###.###-##', $objContrato->Cliente->cpf):'';


	// Linha 2
	// Seta a posição
	$pdf->SetXY(8, 52);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(100,10,utf8_decode("Nome / Razão Social do Cliente:"));
	$pdf->Cell(50,10,utf8_decode("CPF / CNPJ do Cliente:"));
	$pdf->Cell(40,10,utf8_decode("INSCRIÇÃO ESTADUAL:"));

	if(strlen($objContrato->Cliente->nome_completo)>55){
		$nome = explode(" ", $objContrato->Cliente->nome_completo);
		$nome1 = "";
		$nome2 = "";
		foreach ($nome as $value) {
			if(strlen($nome1." ".$value)<50)
				$nome1 .= $value." ";
			else
				$nome2 .= $value." ";
		}

	}else{
		$nome1 = $objContrato->Cliente->nome_completo;
		$nome2 = "";
	}


	$pdf->SetXY(8, 57);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(100,8,$nome1);
	$pdf->Cell(50,8,$cnpj);
	$pdf->Cell(40,8,$objContrato->Cliente->inscricao_estadual);

	$pdf->SetXY(8, 60);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(100,8,$nome2);
	// Linha 3
	// Seta a posição


	$pdf->SetXY(8, 65);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(140,10,utf8_decode("Endereço:"));
	$pdf->Cell(140,10,utf8_decode("CEP:"));

	$pdf->SetXY(8, 70);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(140,8,utf8_decode(utf8_encode($objContrato->Cliente->logradouro)).', '.$objContrato->Cliente->numero.', '.$objContrato->Cliente->complemento.' - '.utf8_decode($objContrato->Cliente->bairro));
	$pdf->Cell(10,8,$objContrato->Cliente->cep);

	// Linha 4
	// Seta a posição
	$pdf->SetXY(8, 75);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(78,10,utf8_decode("Cidade:"));
	$pdf->Cell(30,10,utf8_decode("UF:"));
	$pdf->Cell(30,10,utf8_decode("Telefone:"));
	$pdf->Cell(10,10,utf8_decode("Inscrição Municipal:"));

	$pdf->SetXY(8, 80);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(78,8,strtoupper($objContrato->Cliente->Cidade->nome));
	$pdf->Cell(30,8,$objContrato->Cliente->Cidade->Uf->sigla);
	$pdf->Cell(30,8,$telefone_principal);
	$pdf->Cell(10,8,$objContrato->Cliente->inscricao_municipal);

	// Linha 4
	// Seta a posição
	$pdf->SetXY(8, 85);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(98,10,utf8_decode("EMAIL:"));

	$pdf->SetXY(8, 90);
	$pdf->SetFont('Arial', '', 8);
	$pdf->Cell(98,8,$objContrato->Cliente->email);


	// Linha 4
	// Seta a posição
	$pdf->SetXY(8, 98);
	$pdf->SetFont('Arial', 'B', 8);
	// $pdf->Cell(18,10,utf8_decode("Código:"));
	$pdf->Cell(113,10,utf8_decode("Descrição da Locação:"));
	$pdf->Cell(13,10,utf8_decode("UN:"));
	$pdf->Cell(23,10,utf8_decode("Quantidade:"));
	$pdf->Cell(23,10,utf8_decode("Valor Item:"));
	$pdf->Cell(23,10,utf8_decode("Valor Total Item:"));

	$pdf->SetFont('Arial', '', 8);
	$x=0;
	$inicio = 107;
	$soma = 0;
	foreach ($_POST['descricao'] as $item) {
		if($_POST['descricao'][$x]!=''){

			$pdf->SetXY(8, $inicio);
			$pdf->MultiCell(113,4,utf8_decode(strtoupper($_POST['descricao'][$x])),0,'L');

			$H = $pdf->GetY();
			$height = $H-$inicio;

			$_POST['valor'][$x] = str_replace(',', '.', $_POST['valor'][$x]);
			// $pdf->SetXY(8, $inicio);
			// $pdf->Cell(18,4,utf8_decode($_POST['codigo'][$x]));

			$total = $_POST['valor'][$x]*$_POST['quantidade'][$x];
			$pdf->SetXY(121, $inicio);
			$pdf->Cell(13,4,utf8_decode("UN"));
			$pdf->Cell(23,4,utf8_decode($_POST['quantidade'][$x]));
			$pdf->Cell(23,4,utf8_decode(number_format($_POST['valor'][$x],2,',','.')));
			$pdf->Cell(23,4,utf8_decode(number_format($total,2,',','.')));

			$soma += $total;

			$inicio = $H+5;
			$x++;
		}
	}


	$pdf->SetAutoPageBreak(false);





	$pdf->SetXY(5, 225);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->Cell(200, 62, "", 1, 1, 'C');

	$pdf->SetXY(5, 225);
	$pdf->SetFillColor(233, 233, 233);
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->Cell(200, 17, "", 1, 1, 'C', 1);

	$pdf->SetXY(7, 227);
	$pdf->SetFont('Arial', 'B', 7);
	$pdf->Cell(55,3,"Valor PIS Retido :");
	$pdf->Cell(55,3,"Valor CSLL Retido :");
	$pdf->Cell(55,3,"Valor Bruto :");

	$pdf->SetXY(7, 236);
	$pdf->Cell(55,3,"Valor COFINS Retido :");
	$pdf->Cell(55,3,"Valor IR Retido :");
	$pdf->Cell(55,3,"Valor do Desconto :");

	$pdf->SetXY(7, 227);
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->Cell(50,3,"0,00",0,0,"R");
	$pdf->Cell(55,3,"0,00",0,0,"R");
	$pdf->Cell(55,3,number_format($soma, 2, ',', '.'),0,0,"R");

	$pdf->SetXY(7, 236);
	$pdf->Cell(50,3,"0,00",0,0,"R");
	$pdf->Cell(55,3,"0,00",0,0,"R");
	$pdf->Cell(55,3,"0,00",0,0,"R");



	$pdf->SetXY(173, 230);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(30,3,"Valor Total da Fatura:",0,0,"R");

	$pdf->SetXY(173, 234);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->Cell(30,3,"".number_format($soma, 2, ',', '.'),0,0,"R");

	// -----------------------------------
	$pdf->SetXY(5, 242);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->Cell(200, 25, "", 1, 1, 'C');

	$tributo = $soma * 0.1442;

	$pdf->SetXY(7, 244);
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(200,3,"Val Aprox Tributos R$".number_format($tributo, 2, ',', '.')." (14,42%) Fonte:IBPT");

	$pdf->SetXY(7, 248);
	$pdf->SetFont('Arial', '', 7);
	$pdf->MultiCell( 200, 3, utf8_decode($_POST['observacao'].'
"DISPENSADO DE EMISSÃO DE NOTA FISCAL DE ACORDO COM LEI COMPLEMENTAR 116/2003 ITEM 3.01"
LOCAÇÃO - LEI FEDERAL N. 8846 DE 21/01/1994'));


	//--------------------------------------
	$pdf->SetXY(5, 267);
	$pdf->SetFillColor(255, 255, 255);
	$pdf->SetDrawColor(0, 0, 0);
	$pdf->Cell(40, 20, "", 1, 1, 'C');

	$pdf->SetXY(12, 270);
	$pdf->SetFont('Arial', 'B', 7);
	$pdf->Cell( 90, 3, utf8_decode("Fatura de Locação:"));
	$pdf->Cell( 100, 3, utf8_decode("Estamos de Acordo com a Emissão desta Fatura:"));

	$pdf->SetXY(16, 278);
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->Cell( 40, 3, utf8_decode($_POST['fatura']));
	$pdf->SetXY(60, 281);
	$pdf->SetFont('Arial', 'B', 7);
	$pdf->Cell( 60, 3, utf8_decode("BELO HORIZONTE, ".$_POST['data']));
	$pdf->Cell( 60, 3, utf8_decode("Assinatura:  _________________________________________"));



	// Nome do anexo
	$filename = "recibo.pdf";

	$eol = PHP_EOL;
	// a random hash will be necessary to send mixed content
	$separator = md5(time());

	if($_POST['acao'] == "Visualizar"){
		$pdf->Output();
	}
	// $pdf->Output();


	if($_POST['acao'] == "Salvar"){

		$objNota = Doctrine_Core::getTable('Nota')->find($_POST['nota_id']); 
		$objNota->fatura 				= $_POST['fatura'];
		$objNota->data_envio			= Util::dateConvert($_POST['data'])." 00:00:01";
		$objNota->email1 				= $_POST['email'];
		$objNota->email2 				= $_POST['email2'];
		$objNota->contrato_id			= $_POST['id'];
		$objNota->save();

		$x=0;
		$objNota->NotaItem->delete();
		foreach ($_POST['descricao'] as $value) {
			$objNotaItem = new NotaItem();
			$objNotaItem->descricao 		= $_POST['descricao'][$x];
			$objNotaItem->quantidade 		= $_POST['quantidade'][$x];
			$objNotaItem->valor 			= $_POST['valor'][$x];
			$objNotaItem->nota_id 			= $objNota->id;
			$objNotaItem->save();
			$x++;
		}
		$_SESSION['return_type'] 	= 'success';
		$_SESSION['return_message']	= 'Executado com sucesso!';
	}

	if($_POST['acao'] == "Enviar para o Cliente"){
		$pdfdoc = $pdf->Output($filename, "S");
		$attachment = chunk_split(base64_encode($pdfdoc));

		// echo $_FILES['boleto']['tmp_name'];
		// $boleto = file_get_contents($_FILES['boleto']['tmp_name']);
		// $attachment2 = chunk_split(base64_encode($boleto));

		// email stuff (change data below)
		$to = $_POST['email']; 
		$from = "filibras@filibras.com.br"; 
		$subject = "Nota fiscal e boleto - FILIBRAS"; 
		$message = "<p>Segue em anexo o nota fiscal.</p>";


		// email stuff (change data below)
		$to = "paulo.ortiz9@gmail.com"; 
		$from = "filibras@filibras.com.br"; 

		$message = "
		Prezado Cliente,<br><br>

Segue anexo Fatura de Locação da Copiadora e boleto bancário.<br><br>

<a href='http://www.filibras.com.br/videos/ged'>Conheça os nossos serviços</a>
<br><br>

Att ,<br>
<img src='".URL."images/assinatura.PNG'>
";

		try {
			

			$mail = new PHPMailer();

			$mail->From = "filibras@filibras.com.br";
			$mail->FromName = "Filibras";
			$mail->IsHTML(true);

			// $mail->AddAddress("paulo.ortiz9@gmail.com");

			$mail->AddAddress($_POST['email']);

			if(isset($_POST['email2'])&&$_POST['email2']!='')
				$mail->AddCC($_POST['email2']); 

			$mail->Subject = "Nota fiscal e boleto - FILIBRAS";
			$mail->Body = $message;
			$mail->CharSet = 'utf-8';

			$mail->AddAttachment($_FILES['boleto1']['tmp_name'], 'boleto1.pdf');
			if(isset($_FILES['boleto2']))
				$mail->AddAttachment($_FILES['boleto2']['tmp_name'], 'boleto2.pdf');
			if(isset($_FILES['boleto3']))
				$mail->AddAttachment($_FILES['boleto3']['tmp_name'], 'boleto3.pdf');
			$mail->AddStringAttachment($pdfdoc, 'nota_fiscal.pdf');

			$enviado = $mail->Send();

			// $objConfiguracao = Doctrine_Core::getTable('Configuracao')->find(1); 
			// $objConfiguracao->fatura = $_POST['fatura']+1;
			// $objConfiguracao->save();
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
		$_SESSION['return_message']	= 'Enviado com sucesso!';

	}
	header("Location: ".URL_ADMIN."relatorio-nota/");
?>
