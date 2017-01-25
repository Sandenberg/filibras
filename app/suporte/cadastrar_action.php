<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Verifica se existe outro registro com os dados informados
	$retSuporte =	Doctrine_Query::create()->select()->from('Suporte')
					->where('nome LIKE "'.$_POST['nome'].'"')->execute();
	
	if ($retSuporte->count() > 0){
	
		// Tratamento de retorno
		$_SESSION['return_type']	= 'error';
		$_SESSION['return_message'] = 'Já existe um registro com os dados informados.';
	
	} else {
		
		// Insert
		$objSuporte				= new Suporte();
		$objSuporte->nome 		= $_POST['nome'];
		$objSuporte->descricao	= $_POST['descricao'];
		$objSuporte->troca_peca	= $_POST['troca_peca'];
		$objSuporte->save();
	
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