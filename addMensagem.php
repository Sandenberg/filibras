<?php

include('lib/Config.php');

try {
	
	// Insert
	$objMensagem					= new Mensagem();
	$objMensagem->data_mensagem 	= date("Y-m-d H:i:s");
	$objMensagem->enviada_por 		= $_SESSION['sess_usuario_id'];
	$objMensagem->recebida_por		= $_GET['usuario_id'];
	$objMensagem->titulo			= $_GET['titulo'];
	$objMensagem->texto				= $_GET['mensagem'];
	$objMensagem->status			= 0;
	$objMensagem->save();

	// Tratamento de retorno
	// $_SESSION['return_type'] 	= 'success';
	// $_SESSION['return_message']	= 'Executado com sucesso!';
		

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
