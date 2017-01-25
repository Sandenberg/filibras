<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['id'] 	= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;
	$_POST['dns']	= Util::getCleanUrl($_POST['nome']);
	
	if ($_POST['id'] == 1 || $_POST['id'] == 2 || $_POST['id'] == 3){
	
		// Tratamento de retorno
		$_SESSION['return_type'] 	= 'warning';
		$_SESSION['return_message']	= 'Não é possível editar esse registro.';
		
	} else {
		
		// Verifica se existe outro registro com os dados informados
		$retGrupo = 	Doctrine_Query::create()->select()->from('UsuarioGrupo')
						->where('dns LIKE ?', $_POST['dns'])
						->addWhere('id <> ?', $_POST['id'])
						->execute();
		
		if ($retGrupo->count() > 0){
		
			// Tratamento de retorno
			$_SESSION['return_type']	= 'error';
			$_SESSION['return_message'] = 'Já existe um registro com os dados informados.';
		
		} else {
		
			$objGrupo			= Doctrine_Core::getTable('UsuarioGrupo')->find($_POST['id']);
			$objGrupo->nome 	= $_POST['nome'];
			$objGrupo->status	= $_POST['status'];
			$objGrupo->dns		= $_POST['dns'];
			$objGrupo->save();
		
			// Tratamento de retorno
			$_SESSION['return_type'] 	= 'success';
			$_SESSION['return_message']	= 'Executado com sucesso!';
			
		}
		
	}

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');