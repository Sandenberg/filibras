<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Trata o action
	$action = explode('_', $_GET['action']);
	$action = $action[0];
	
	// Pega os ids via GET
	$aux 			= explode("-", $_GET['id']);
	$equipamento_id = $aux[0];
	$contrato_id 	= $aux[1];
	
	$objEquipamento = Doctrine_Core::getTable('Equipamento')->find($equipamento_id);
	$objEquipamento->status = 3;
	$objEquipamento->save();

	// Delete
	$objContratoEquipamento = Doctrine_Core::getTable('ContratoEquipamento')->findOneByEquipamentoIdAndContratoId($equipamento_id, $contrato_id);
	$objContratoEquipamento->delete();
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/'.$action.'_listar/'.$objContratoEquipamento->contrato_id.'/');