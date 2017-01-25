<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	$objUsuario	= Doctrine_Core::getTable('Usuario')->find($_GET['id']);
	$objUsuario->delete();
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';

		
	Util::regLog('Usuário', $objUsuario->id, 'excluiu');
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e;
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');