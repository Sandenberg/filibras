<?php

/**
 * Autenticação de Usuário
 */
ini_set('allow_url_fopen', 1);

require('lib/Config.php');

try {
	// Checa se o usuário está logado
	if (Util::checkLoginAdmin()){
		header('Location: '.URL_ADMIN);
        exit;
	}


	define('URL_LINK', 'http://192.168.1.250/Clientes/Filibras/Sistema/login_interno.php');

	//SOLUCAO 1

	// function getMac(){
	// 	ob_start();
	// 	system('/sbin/ifconfig -a');

	// 	$info = ob_get_contents();
	// 	ob_clean();

	// 	return substr($info, 37, 18);
	// }
	// echo getMac();
	// // Seta os mac adress que poderão acessar
	// $macLiberado[] = '12:9e:d7:f6:70:dd'; // AcessoWeb
	
	// Verifica dados de login
	if (isset($_POST['login']) && isset($_POST['senha'])){
		$comercial = false;
		// Realiza a autenticação
		$res = Doctrine_Core::getTable('Usuario')->findOneByLoginAndSenhaAndStatus($_POST['login'],md5($_POST['senha']),1);

		// print_r($_POST);

		// echo md5($_POST['senha']);
		
		$hora = date('H:i:s');
		$dia = date('w');
		if($dia > 0 && $dia < 6 && $hora > '08:00:00' && $hora < '18:00:00')
			$comercial = true;


		if($res && $res->usuario_grupo_id > 1){
			// if(isset($_POST['flag']) && $comercial == true && URL_LINK == $_POST['url']){
			if(isset($_POST['flag']) && $comercial == true){


				$_SESSION['sess_usuario_id']		= $res->id;
				$_SESSION['sess_usuario_nome']		= $res->nome;
				$_SESSION['sess_usuario_grupo_id']	= $res->usuario_grupo_id;

				// Seta seções de retorno
				$_SESSION['return_type']	= false;
				$_SESSION['return_message']	= false;

				header('Location: '.URL_ADMIN);
			}else{

				$_SESSION['return_type']	= 'error';
				$_SESSION['return_message'] = 'Acesso externo negado!';	
				
				include_once(PATH_ADMIN.'login.php');
			}
		}else if ($res && $res->UsuarioGrupo->status==1 && ($res->usuario_grupo_id == 1 || $comercial == true)){
			
			$_SESSION['sess_usuario_id']		= $res->id;
			$_SESSION['sess_usuario_nome']		= $res->nome;
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
			

			if(isset($_POST['flag']))
				header("Location: ".URL_LINK);

			include_once(PATH_ADMIN.'login.php');
			
		}
		
	} else {
		
		// Tratamento de retorno
		$_SESSION['return_type']	= 'error';
		$_SESSION['return_message'] = 'Acesso negado!';


		if(isset($_POST['flag']))
			header("Location: ".URL_LINK);

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