<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Verifica se existe outro registro com os dados informados
	$retFilial =	Doctrine_Query::create()->select()->from('Filial')
				->where('nome LIKE "'.$_POST['nome'].'"')->execute();
	
	if ($retFilial->count() > 0){
	
		// Tratamento de retorno
		$_SESSION['return_type']	= 'error';
		$_SESSION['return_message'] = 'Já existe um registro com os dados informados.';
	
	} else {
	
		// Insert
		$objFilial			= new Filial();
		$objFilial->nome 	= $_POST['nome'];	
		$objFilial->save();
	
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