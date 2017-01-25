<?php

include('lib/Config.php');

try {
	
	// Insert
	$objMensagem					= Doctrine_Core::getTable('Mensagem')->find($_GET['mensagem_id']);
	$objMensagem->confirmacao_lida	= 1;
	$objMensagem->save();

	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
		

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
