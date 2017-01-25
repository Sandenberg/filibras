<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	if ($_GET['id'] == 1 || $_GET['id'] == 2 || $_GET['id'] == 3){
		
		// Tratamento de retorno
		$_SESSION['return_type'] 	= 'warning';
		$_SESSION['return_message']	= 'Não é possível excluir esse registro.';
		
	} else {
	
		$objGrupo = Doctrine_Core::getTable('UsuarioGrupo')->find($_GET['id']);
		$objGrupo->delete();
		
		// Tratamento de retorno
		$_SESSION['return_type'] 	= 'success';
		$_SESSION['return_message']	= 'Executado com sucesso!';
		
	}

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');