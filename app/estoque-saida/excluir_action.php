<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Delete
	$objSaida = Doctrine_Core::getTable('Saida')->find($_GET['id']);

	foreach ($objSaida->SaidaMaterial as $objSaidaMaterial) {
		$objMaterial = Doctrine_Core::getTable('Material')->find($objSaidaMaterial->material_id);
		$objMaterial->estoque += $objSaidaMaterial->quantidade;
		$objMaterial->save();
	}

	$objSaida->delete();
	
    Util::regLog('Saída no Estoque', $objSaida->id, 'excluiu', $objSaida->id." / ".substr($objSaida->descricao, 0, 50));
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