<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Criptografia de senhas
	$_POST['senha_atual']	= md5($_POST['senha_atual']);
	$_POST['senha_nova']	= md5($_POST['senha_nova']);
	
	// Carrega os dados do usuário
	$objUsuario = Doctrine_Core::getTable('Usuario')->find($_SESSION['sess_usuario_id']);
	
	// Verifica se a senha atual está correta
	if ($objUsuario->senha == $_POST['senha_atual']){
		
		// Atribui a nova senha
		$objUsuario->senha = $_POST['senha_nova'];
				
		// Tratamento de retorno
		$_SESSION['return_type'] 	= 'success';
		$_SESSION['return_message']	= 'Executado com sucesso!';

		// Salva os dados do usuário
		$objUsuario->save();
		
	} else {
		// Tratamento de retorno
		$_SESSION['return_type'] 	= 'error';
		$_SESSION['return_message']	= 'A senha atual é inválida!';
	}

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN);