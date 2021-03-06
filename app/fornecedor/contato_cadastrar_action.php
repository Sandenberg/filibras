<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Trata o action
	$action = explode('_', $_GET['action']);
	$action = $action[0];
	
	// Tratamento de dados
	$_POST['email']				= $_POST['email']!=''?$_POST['email']:null;
	$_POST['telefone']			= $_POST['telefone']!=''?$_POST['telefone']:null;
	$_POST['ramal']				= $_POST['ramal']!=''?$_POST['ramal']:null;
	$_POST['telefone']			= $_POST['telefone']!=''?Util::getNumbers($_POST['telefone']):null;
	
	// Insert
	$objContato						= new FornecedorResponsavel();
	$objContato->nome				= $_POST['nome'];
	$objContato->email				= $_POST['email'];
	$objContato->telefone			= $_POST['telefone'];
	$objContato->ramal				= $_POST['ramal'];
	$objContato->tipo				= 0;
	$objContato->fornecedor_id		= $_POST['fornecedor_id'];
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
header('Location: '.URL_ADMIN.$_GET['model'].'/'.$action.'_listar/'.$_POST['fornecedor_id'].'/');