<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Delete
	$objCliente = Doctrine_Core::getTable('Cliente')->find($_GET['id']);
	
	Util::regLog('Cliente', $objCliente->id, 'restrição', $objCliente->nome_completo);
	$objCliente->restricao = !isset($objCliente->restricao)||$objCliente->restricao==0?1:0;
	$objCliente->save();

	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
	
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e.$_GET['id'];
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');