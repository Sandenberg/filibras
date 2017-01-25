<?php
	include("lib/Config.php");
	// unset($_SESSION['geo_loc']);
	// unset($_SESSION['geo_cidade']);
	print_r($_SESSION);
	echo "<br><br><br>";
	print_r($_COOKIE);

	$mail = new PHPMailer();

	$mail->From = "filibras@filibras.com.br";
	$mail->FromName = "Filibras";


	$mail->AddAddress('paulo.ortiz9@gmail.com', 'Fulano da Silva');
	// $mail->AddAddress('ciclano@site.net');

	$mail->Subject  = "Mensagem Teste";
	$mail->Body = "Este é o corpo da mensagem de teste, em <b>HTML</b>!  :)";
	$mail->AltBody = "Este é o corpo da mensagem de teste, em Texto Plano! \r\n :)";

	$enviado = $mail->Send();
	if ($enviado) {
	  echo "E-mail enviado com sucesso!";
	} else {
	  echo "Não foi possível enviar o e-mail.";
	  echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
	}
?>