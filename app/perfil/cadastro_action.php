<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de Data
	if ($_POST['nascimento'] != ''){
		$aux_date				= explode('/',$_POST['nascimento']);
		$_POST['nascimento']	= $aux_date[2].'-'.$aux_date[1].'-'.$aux_date[0];
	}
	
	$objUsuario 			= Doctrine_Core::getTable('Usuario')->find($_SESSION['sess_usuario_id']);
	$objUsuario->nome 		= $_POST['nome'];
	$objUsuario->email		= $_POST['email'];
	$objUsuario->apelido	= $_POST['apelido'];
	$objUsuario->nascimento	= $_POST['nascimento']==''?null:$_POST['nascimento'];
	$objUsuario->sexo		= $_POST['sexo']==''?null:$_POST['sexo'];
	$objUsuario->login		= $_POST['login'];
	$objUsuario->save();
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN);