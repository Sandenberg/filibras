<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Delete
	$objProblema = Doctrine_Core::getTable('Problema')->find($_GET['id']);
	$objProblema->delete();
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');