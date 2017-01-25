<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['servico_id'] = $_POST['servico_id']>0?$_POST['servico_id']:NULL;
	
	// Insert
	$objProblema				= new Problema();
	$objProblema->titulo 		= $_POST['titulo'];
	$objProblema->descricao		= $_POST['descricao'];
	$objProblema->causa			= $_POST['causa'];
	$objProblema->solucao		= $_POST['solucao'];
	$objProblema->servico_id	= $_POST['servico_id'];
	$objProblema->status		= $_POST['status'];
	$objProblema->save();

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