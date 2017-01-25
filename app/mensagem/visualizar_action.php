<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['id'] 	= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;
	$_POST['baixa'] = isset($_POST['baixa'])&&$_POST['baixa']!=''&&$_POST['baixa']!='__/__/____'?Util::dateConvert($_POST['baixa']):null;
	


	$objMensagem							= Doctrine_Core::getTable('Mensagem')->find($_POST['id']);
	$objMensagem->status 					= 2;
	$objMensagem->data_ok 					= date('Y-m-d H:i:s');
	$objMensagem->save();

	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
	


	
	// Util::regLog('Débito', $objMensagem->id, 'cadastrou', $objMensagem->);
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e;
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');