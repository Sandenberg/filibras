<?php

/**
 * Autenticação de Usuário
 */

require('lib/Config.php');

try {

	// Checa se o usuário está logado
	if (Util::checkLoginAdmin()){
		header('Location: '.URL_ADMIN);
        exit;
	}

	// Verifica dados de login
	if (isset($_POST['login']) && isset($_POST['senha'])){
		$comercial = false;
		// Realiza a autenticação
		$res = Doctrine_Core::getTable('Usuario')->findOneByLoginAndSenhaAndStatus($_POST['login'],md5($_POST['senha']),1);


		$hora = date('H:i:s');
		$dia = date('w');
		if($dia > 0 && $dia < 6 && $hora > '08:00:00' && $hora < '18:00:00')
			$comercial = true;
		
		// Verifica se o grupo está ativo autenticação
		if ($res && $res->UsuarioGrupo->status && ($res->usuario_grupo_id == 1 || $comercial == true)){
			// echo "entrou".$res->usuario_grupo_id;
			// Seta seção
			$_SESSION['sess_usuario_id']		= $res->id;
			$_SESSION['sess_usuario_grupo_id']	= $res->usuario_grupo_id;
			
			// Seta seções de retorno
			$_SESSION['return_type']	= false;
			$_SESSION['return_message']	= false;
			
			header('Location: '.URL_ADMIN);
			
		} else {
			
			// Tratamento de retorno
			$_SESSION['return_type']	= 'error';
			$_SESSION['return_message'] = 'Acesso negado!';

			if($comercial == false)
				$_SESSION['return_message'] = 'Horário não permitido!';
			
			include_once(PATH_ADMIN.'login.php');
			
		}
		
	} else {
		
		// Tratamento de retorno
		$_SESSION['return_type']	= 'error';
		$_SESSION['return_message'] = 'Acesso negado!';
		include_once(PATH_ADMIN.'login.php');
		
	}
	
} catch (Exception $e){
	echo $e->getMessage();exit;
	@session_destroy();
	
	// Tratamento de retorno
	$_SESSION['return_type']	= 'warning';
	$_SESSION['return_message'] = 'Ocorreu um erro, tente novamente!';
	include_once(PATH_ADMIN.'login.php');
	
}