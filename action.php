<?php

require_once('lib/Config.php');

if (isset($_GET['model']) && isset($_GET['action'])){
	
	// Verifica se a solicitação é a pública 
	if ($_GET['model'] == 'perfil' && ($_GET['action'] == 'cadastro'
		|| $_GET['action'] == 'foto' || $_GET['action'] == 'senha')){
		
		// Verifica se o arquivo existe
		if (file_exists(PATH_ADMIN.'app/perfil/'.$_GET['action'].'_action.php')){

			// Define constante de liberação
			define('_ACTION',1);

			// Inclusão de arquivo de ação
			require_once(PATH_ADMIN.'app/perfil/'.$_GET['action'].'_action.php');
			
		} else {
			$_SESSION['return_type'] 	= 'error';
			$_SESSION['return_message']	= 'Ocorreu um erro no sistema!';
			require_once(PATH_ADMIN.'index.php');
		}
		
	} else {
		
		try {
		
			if (isset($_GET['action']) && $_GET['action'] != 'listar'){

				// Busca por permissão de acesso
				$retPermissao = Doctrine_Query::create()
				->from('UsuarioPermissao p')
				->innerJoin('p.UsuarioGrupoPermissao g')
				->addWhere('g.usuario_grupo_id = '.$_SESSION['sess_usuario_grupo_id'])
				->addWhere('p.tipo = 1 OR p.tipo = 2 OR p.tipo = 3 OR p.tipo = 4 OR p.tipo = 5 OR p.tipo = 6')
				->addWhere('p.model = "'.$_GET['model'].'" AND p.action = "'.$_GET['action'].'"');
				
			} else {
			
				// Busca por permissão de acesso
				$retPermissao = Doctrine_Query::create()
							->from('UsuarioPermissao p')
							->innerJoin('p.UsuarioGrupoPermissao g')
							->addWhere('g.usuario_grupo_id = '.$_SESSION['sess_usuario_grupo_id'])
							->addWhere('p.tipo = 0')
							->addWhere('p.model = "'.$_GET['model'].'"');
			}
			
			// Checagem de permissão de acesso
			if ($retPermissao->count() == 1){
				
				// Tratamento de retorno
				$resPermissao = $retPermissao->fetchOne(null,Doctrine::HYDRATE_ARRAY);
				$resPermissao['action'] = is_null($resPermissao['action'])?'listar':$resPermissao['action'];
				
				// Verifica existência dos arquivos do módulo
				if (file_exists(PATH_ADMIN.'app/'.$resPermissao['model'].'/'.$resPermissao['action'].'_action.php')){
					define('_ACTION',1);
					require_once(PATH_ADMIN.'app/'.$resPermissao['model'].'/'.$resPermissao['action'].'_action.php');
				} else {
					$_SESSION['return_type']	= 'error';
					$_SESSION['return_message'] = 'Ocorreu um erro no sistema.';
					echo '
					<div class="'.$_SESSION['return_type'].' grid_12">
					<h3>'.$_SESSION['return_message'].'</h3>
					<a href="#" class="hide_btn">&nbsp;</a>
					</div>
					';
				}
				
			} else {
				// Tratamento de retorno
				$_SESSION['return_type']	= 'warning';
				$_SESSION['return_message']	= 'Permissão negada.';
				echo '
				<div class="'.$_SESSION['return_type'].' grid_12">
					<h3>'.$_SESSION['return_message'].'</h3>
					<a href="#" class="hide_btn">&nbsp;</a>
				</div>
				';
			}
			
		} catch (Exception $e){
			// Tratamento de retorno
			$_SESSION['return_type'] 	= 'error';
			$_SESSION['return_message']	= 'Ocorreu um erro de permissão, tente novamente.'.$e;
			echo '
			<div class="'.$_SESSION['return_type'].' grid_12">
			<h3>'.$_SESSION['return_message'].'</h3>
			<a href="#" class="hide_btn">&nbsp;</a>
			</div>
			';
		}
		
	}
	
} else {
	
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'A requisição não foi realizada corretamente!';
	require_once(PATH_ADMIN.'index.php');
	
}

?>