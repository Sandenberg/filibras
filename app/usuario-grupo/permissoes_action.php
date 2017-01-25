<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Delete
	$objGrupo = Doctrine_Core::getTable('UsuarioGrupo')->find($_POST['id']);
	$objGrupo->UsuarioGrupoPermissao->delete();
	
	// Insert
	if (isset($_POST['usuario_permissao_id']) && count($_POST['usuario_permissao_id']) > 0){
		foreach ($_POST['usuario_permissao_id'] as $k=>$v){
			$objPermissao = new UsuarioGrupoPermissao();
			$objPermissao->usuario_grupo_id	= $_POST['id'];
			$objPermissao->permissao_id		= $v;
			$objPermissao->save();
		}
	}
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');