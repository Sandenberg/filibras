<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['dns'] = Util::getCleanUrl($_POST['nome']);
	
	// Verifica se existe outro registro com os dados informados
	$retModelo =	Doctrine_Query::create()->select()->from('EquipamentoModelo')
					->where('dns LIKE "'.$_POST['dns'].'"')->execute();
	
	if ($retModelo->count() > 0){
	
		// Tratamento de retorno
		$_SESSION['return_type']	= 'error';
		$_SESSION['return_message'] = 'Já existe um registro com os dados informados.';
	
	} else {
	
		// Insert
		$objModelo							= new EquipamentoModelo();
		$objModelo->nome 					= $_POST['nome'];
		$objModelo->dns						= $_POST['dns'];
		$objModelo->marca_id				= $_POST['marca_id'];
		$objModelo->equipamento_tipo_id		= $_POST['equipamento_tipo_id'];
		$objModelo->procedimento				= $_POST['procedimento'];
		$objModelo->save();
	
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