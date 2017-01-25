<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Verifica se existe outro registro com os dados informados
	$retTipo =	Doctrine_Query::create()->select()->from('MovimentacaoTipo')
				->where('nome LIKE "'.$_POST['nome'].'"')->execute();
	
	if ($retTipo->count() > 0){
	
		// Tratamento de retorno
		$_SESSION['return_type']	= 'error';
		$_SESSION['return_message'] = 'Já existe um registro com os dados informados.';
	
	} else {
		
		// Insert
		$objTipo			= new MovimentacaoTipo();
		$objTipo->nome 		= $_POST['nome'];
		$objTipo->descricao	= $_POST['descricao'];
		$objTipo->tipo		= $_POST['tipo'];
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