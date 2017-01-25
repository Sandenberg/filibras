<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	// print_r($_POST);

	// Insert
	$objSaida					= new Saida();
	$objSaida->data_cadastro	= date('Y-m-d H:i:s');
	$objSaida->descricao 		= $_POST['descricao'];
	$objSaida->usuario_id		= $_SESSION['sess_usuario_id'];
	$objSaida->save();

	foreach ($_POST['material_id'] as $key => $value) {
		$objSaidaMaterial = new SaidaMaterial();
		$objSaidaMaterial->material_id = $_POST['material_id'][$key];
		$objSaidaMaterial->quantidade = $_POST['quantidade'][$key];
		$objSaidaMaterial->saida_id = $objSaida->id;
		$objSaidaMaterial->save();

		$objMaterial = Doctrine_Core::getTable('Material')->find($_POST['material_id'][$key]);
		$objMaterial->estoque -= $_POST['quantidade'][$key];
		$objMaterial->save();
	}
    Util::regLog('Saída no Estoque', $objSaida->id, 'cadastrou', $objSaida->id." / ".substr($objSaida->descricao, 0, 50));

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