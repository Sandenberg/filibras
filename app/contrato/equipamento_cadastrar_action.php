<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Trata o action
	$action = explode('_', $_GET['action']);
	$action = $action[0];
		
	// Insert
	$objContratoEquipamento					= new ContratoEquipamento();
	$objContratoEquipamento->local			= $_POST['local'];
	$objContratoEquipamento->contrato_id	= $_POST['contrato_id'];
	$objContratoEquipamento->equipamento_id	= $_POST['equipamento_id'];
	$objContratoEquipamento->save();

	$status = "";

	$objContrato = Doctrine_Core::getTable('Contrato')->find($_POST['contrato_id']);
	if(isset($objContrato->tipo)){
		switch ($objContrato->tipo) {
			case '0': // Locação
				$status = 1;
				break;
			case '1': // Venda
				$status = 0;
				break;
			case '4': // Equipamento do Cliente
				$status = 2;
				break;
		}
	}else{
		$status = 1;
	}

	$objEquipamento = Doctrine_Core::getTable('Equipamento')->find($_POST['equipamento_id']);
	$objEquipamento->status = $status!=''?$status:$objEquipamento->status;
	$objEquipamento->save();
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
		
	
	
	Util::regLog('Equipamento do Contrato', $objContratoEquipamento->equipamento_id, 'cadastrou');
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e;
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/'.$action.'_listar/'.$_POST['contrato_id'].'/');