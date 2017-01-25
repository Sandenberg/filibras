<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Trata o action
	$action = explode('_', $_GET['action']);
	$action = $action[0];
	
	// Tratamento de dados
	$_POST['id'] 				= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;
	$_POST['email']				= $_POST['email']!=''?$_POST['email']:null;
	$_POST['telefone']			= $_POST['telefone']!=''?$_POST['telefone']:null;
	$_POST['ramal']				= $_POST['ramal']!=''?$_POST['ramal']:null;
	$_POST['telefone']			= $_POST['telefone']!=''?Util::getNumbers($_POST['telefone']):null;
	
	// Update
	$objContato						= Doctrine_Core::getTable('ClienteResponsavel')->find($_POST['id']);
	$objContato->nome				= $_POST['nome'];
	$objContato->email				= $_POST['email'];
	$objContato->telefone			= $_POST['telefone'];
	$objContato->ramal				= $_POST['ramal'];
	$objContato->tipo				= 0;
	$objContato->cliente_id			= $_POST['cliente_id'];
	$objContato->save();
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
		
	
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/'.$action.'_listar/'.$_POST['cliente_id'].'/');