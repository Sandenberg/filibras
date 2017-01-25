<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['id'] 	= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;
	
	// Verifica se existe outro registro com os dados informados
	$retUsuario = 	Doctrine_Query::create()->select()->from('Usuario')
					->where('login LIKE ?', $_POST['login'])
					->addWhere('id <> ?', $_POST['id'])
					->execute();
	
	if ($retUsuario->count() > 0){
	
		// Tratamento de retorno
		$_SESSION['return_type']	= 'error';
		$_SESSION['return_message'] = 'Já existe um registro com os dados informados.';
	
	} else {
	
		$objUsuario			= Doctrine_Core::getTable('Usuario')->find($_POST['id']);
		$objUsuario->nome 				= $_POST['nome'];
		// $objUsuario->email 				= $_POST['email'];
		$objUsuario->apelido			= $_POST['apelido'];
		$objUsuario->login				= $_POST['login'];
		$objUsuario->senha				= $_POST['senha']==''?$objUsuario->senha:md5($_POST['senha']);
		$objUsuario->status				= $_POST['status'];
		$objUsuario->usuario_grupo_id	= $_POST['usuario_grupo_id'];
		$objUsuario->save();
	
		// Tratamento de retorno
		$_SESSION['return_type'] 	= 'success';
		$_SESSION['return_message']	= 'Executado com sucesso!';
		
		Util::regLog('Usuário', $objUsuario->id, 'editou');
		
	}

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');