<?php

include('lib/Config.php');

try {
	
	// Insert
	$objOrdemServico 					= Doctrine_Core::getTable('OrdemServico')->find($_GET['id']);
	$objOrdemServico->tecnico			= $_GET['usuario_id'];
	$objOrdemServico->save();

	// Tratamento de retorno
	// $_SESSION['return_type'] 	= 'success';
	// $_SESSION['return_message']	= 'Executado com sucesso!';
		

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
