<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Delete
	$objFornecedor = Doctrine_Core::getTable('Fornecedor')->find($_GET['id']);
	$objFornecedor->delete();
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';

	Util::regLog('Fornecedor', $objFornecedor->id, 'cadastrou');
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');