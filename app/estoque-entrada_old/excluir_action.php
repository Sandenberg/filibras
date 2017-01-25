<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Delete
	$objEntrada = Doctrine_Core::getTable('Entrada')->find($_GET['id']);

	foreach ($objEntrada->EntradaMaterial as $objEntradaMaterial) {
		$objMaterial = Doctrine_Core::getTable('Material')->find($objEntradaMaterial->material_id);
		$objMaterial->estoque -= $objEntradaMaterial->quantidade;
		$objMaterial->save();
	}

	$objEntrada->delete();
    Util::regLog('Entrada no Estoque', $objEntrada->id, 'excluiu', $objEntrada->id." / ".substr($objEntrada->descricao, 0, 50));
	
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