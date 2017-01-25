<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {

	// Verifica se existe outro registro com os dados informados
	$retUsuario	= 	Doctrine_Query::create()->select()->from('Usuario')
					->where('login LIKE ?', $_POST['login'])->execute();
	
	if ($retUsuario->count() > 0){
	
		// Tratamento de retorno
		$_SESSION['return_type']	= 'error';
		$_SESSION['return_message'] = 'Já existe um registro com os dados informados.';
	
	} else {
	
		$objUsuario						= new Usuario();
		$objUsuario->nome 				= $_POST['nome'];
		// $objUsuario->email 				= $_POST['email'];
		$objUsuario->apelido			= $_POST['apelido'];
		$objUsuario->login				= $_POST['login'];
		$objUsuario->senha				= md5($_POST['senha']);
		$objUsuario->data_cadastro		= date('Y-m-d');
		$objUsuario->status				= $_POST['status'];
		$objUsuario->usuario_grupo_id	= $_POST['usuario_grupo_id'];
		$objUsuario->save();
	
		// Tratamento de retorno
		$_SESSION['return_type'] 	= 'success';
		$_SESSION['return_message']	= 'Executado com sucesso!';
		
		Util::regLog('Usuário', $objUsuario->id, 'cadastrou');
	}

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e;
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');