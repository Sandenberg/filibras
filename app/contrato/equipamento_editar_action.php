<?php 
try {

	// Trata o action
	$action = explode('_', $_GET['action']);
	$action = $action[0];
	
	//Tratamento
	$_POST['id']	= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;

	// Update
	$objEquipamento			= Doctrine_Core::getTable('ContratoEquipamento')->findOneByEquipamentoIdAndContratoId($_POST['equipamento_id'], $_POST['contrato_id']);
	$objEquipamento->local	= $_POST['local'];
	$objEquipamento->save();

	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';

} catch(Exception $e){

	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';

}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/'.$action.'_listar/'.$_POST['contrato_id'].'/');