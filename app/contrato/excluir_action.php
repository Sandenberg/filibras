<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	$objContrato	= Doctrine_Core::getTable('Contrato')->find($_GET['id']);

	foreach ($objContrato->ContratoEquipamento as $key => $objEquipamentoContrato) {
		$objEquipamento = Doctrine_Core::getTable('Equipamento')->find($objEquipamentoContrato->equipamento_id);
		$objEquipamento->status = 3;
		$objEquipamento->save();
	}	

	Util::regLog('Contrato', $objContrato->id, 'excluiu', $objContrato->Cliente->nome_completo);
	$objContrato->delete();
	
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