<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['dns'] = Util::getCleanUrl($_POST['nome']);
	
	// Verifica se existe outro registro com os dados informados
	$retTipo =	Doctrine_Query::create()->select()->from('Conta')
				->where('dns LIKE "'.$_POST['dns'].'"')->execute();
	
	if ($retTipo->count() > 0){
	
		// Tratamento de retorno
		$_SESSION['return_type']	= 'error';
		$_SESSION['return_message'] = 'Já existe um registro com os dados informados.';
	
	} else {
	
		// Insert
		$objTipo			= new Conta();
		$objTipo->nome 		= $_POST['nome'];
		$objTipo->dns		= $_POST['dns'];
		$objTipo->save();
	
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