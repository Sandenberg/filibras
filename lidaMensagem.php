<?php

include('lib/Config.php');

try {
	
	// Insert
	$retMensagem					= Doctrine_Core::getTable('Mensagem')->findByRecebidaPorAndLida($_SESSION['sess_usuario_id'], 0);
	foreach ($retMensagem as $objMensagem) {
		$objMensagem->lida				= 1;
		$objMensagem->data_lida			= date("Y-m-d H:i:s");
		$objMensagem->save();
	}

	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
		

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
