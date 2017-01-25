<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['id'] 	= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;
	
	// Verifica se existe outro registro com os dados informados
	$retTipo =	Doctrine_Query::create()->select()->from('Filial')
				->where('nome LIKE "'.$_POST['nome'].'" AND id <> "'.$_POST['id'].'"')
				->execute();
	
	if ($retTipo->count() > 0){
	
		// Tratamento de retorno
		$_SESSION['return_type']	= 'error';
		$_SESSION['return_message'] = 'Já existe um registro com os dados informados.';
	
	} else {
	
		// Update
		$objTipo			= Doctrine_Core::getTable('Filial')->find($_POST['id']);
		$objTipo->nome 		= $_POST['nome'];	
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