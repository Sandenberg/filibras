<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Delete
	$objOrdemServico = Doctrine_Core::getTable('OrdemServico')->find($_POST['id']);
	$objUsuario = Doctrine_Core::getTable('Usuario')->find($_SESSION['sess_usuario_id']);
	
	Util::regLog('OrdemServico', $objOrdemServico->id, 'Ordem Serviço - Rota', $objUsuario->nome);
	$objOrdemServico->rota = !isset($objOrdemServico->rota)||$objOrdemServico->rota==0?1:0;
	$objOrdemServico->rota_usuario_id = $_SESSION['sess_usuario_id'];
	$objOrdemServico->rota_ordem = $_POST['ordem'];
	$objOrdemServico->rota_turno = $_POST['turno'];
	$objOrdemServico->data_rota = date("Y-m-d H:i:s");
	$objOrdemServico->save();

	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
	
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e.$_POST['id'];
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');