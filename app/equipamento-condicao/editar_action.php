<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['id'] 	= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;
	$_POST['dns']	= Util::getCleanUrl($_POST['nome']);
	
	// Verifica se existe outro registro com os dados informados
	$retCondicao =	Doctrine_Query::create()->select()->from('Condicao')
					->where('dns LIKE "'.$_POST['dns'].'" AND id <> "'.$_POST['id'].'"')
					->execute();
	
	if ($retCondicao->count() > 0){
	
		// Tratamento de retorno
		$_SESSION['return_type']	= 'error';
		$_SESSION['return_message'] = 'Já existe um registro com os dados informados.';
	
	} else {
	
		// Update
		$objCondicao			= Doctrine_Core::getTable('Condicao')->find($_POST['id']);
		$objCondicao->nome 		= $_POST['nome'];
		$objCondicao->dns		= $_POST['dns'];
		$objCondicao->status	= $_POST['status'];
		$objCondicao->save();
	
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