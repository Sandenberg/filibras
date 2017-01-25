<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Trata o action
	$action = explode('_', $_GET['action']);
	$action = $action[0];

	// Cria uma variável para os respectivos ids
	$getIds = explode("-", $_GET['id']);
	$equipamento_id = $getIds[0];
	$condicao_id	= $getIds[1];
	
	// Delete
	$objCondicao = Doctrine_Core::getTable('EquipamentoCondicao')->findOneByEquipamentoIdAndCondicaoId($equipamento_id, $condicao_id);
	$objCondicao->delete();
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/'.$action.'_listar/'.$objCondicao->equipamento_id.'/');