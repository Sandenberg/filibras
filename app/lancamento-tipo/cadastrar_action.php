<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Insert
	$objTipo			= new LancamentoTipo();
	$objTipo->nome 		= $_POST['nome'];
	$objTipo->tipo		= $_POST['tipo'];
	$objTipo->save();

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