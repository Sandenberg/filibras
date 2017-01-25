<?php

// Arquivo de configuração
require_once('lib/Config.php');

// Checa o usuário está logado
if (!Util::checkLoginAdmin()){
	header('Location: '.URL_ADMIN.'login/');
	exit;
}

// Constante de controle
define('_SYSTEM',1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo TITLE_DEFAULT; ?></title>
<script type="text/javascript">
URL_ADMIN = "<?php echo URL_ADMIN; ?>";
</script>
<?php 

// Load de javascript e css padrão
require_once(PATH_ADMIN.'includes/default_js.php'); 
require_once(PATH_ADMIN.'includes/default_css.php');

?>
</head>

<body>

	<div id="main" class="container_12">
		<!-- Body Wrapper Begin -->
		<?php require_once(PATH_ADMIN.'includes/header.php'); ?>
		
		<div id="userbar"><!-- Userbar Begin -->
			<?php 
			
			require_once(PATH_ADMIN.'includes/profile_bar.php'); 
			require_once(PATH_ADMIN.'includes/menu.php');
			require_once(PATH_ADMIN.'includes/message.php');
			
			?>
		</div><!-- Userbar End -->
		
		<div class="clear"></div>

		<?php

		// Verifica retorno de erro
		if ($_SESSION['return_type']){
			echo '
			<div class="'.$_SESSION['return_type'].' grid_12">
			<h3>'.$_SESSION['return_message'].'</h3>
			<a href="#" class="hide_btn">&nbsp;</a>
			</div>
			';
		}
		
		// Tratamento de model e action
		$_GET['model'] 	= isset($_GET['model'])&&$_GET['model']!=''?$_GET['model']:'';
		$_GET['action'] = isset($_GET['action'])&&$_GET['action']!=''?$_GET['action']:'listar';
			
		// Verifica se a permissão é a publica ou privada
		if ($_GET['model'] == 'perfil' || $_GET['model'] == ''){
			
			if ($_GET['model'] == 'perfil'){
			
				// Verifica se o arquivo público existe
				if (file_exists(PATH_ADMIN.'app/perfil/editar.php')){
					require_once(PATH_ADMIN.'app/perfil/editar.php');
				} else {
					echo '
					<div class="error grid_12">
						<h3>Ocorreu um erro no sistema!</h3>
						<a href="#" class="hide_btn">&nbsp;</a>
					</div>
					';
				}
				
			}
			
		} else {
			
			try {
			
				// Verifica
				if (isset($_GET['action']) && $_GET['action'] != 'listar')
					$where = ' AND p.action = "'.$_GET['action'].'"';
				else 
					$where = ' AND p.tipo = 0';
				
				// Busca por permissão de acesso
				$retPermissao = Doctrine_Query::create()
							->from('UsuarioPermissao p')
							->innerJoin('p.UsuarioGrupoPermissao g')
							->addWhere('g.usuario_grupo_id = '.$_SESSION['sess_usuario_grupo_id'])
							->addWhere('p.model = "'.$_GET['model'].'"'.$where);
				
				// Checagem de permissão de acesso
				if ($retPermissao->count() == 1){
					// Tratamento de retorno
					$resPermissao = $retPermissao->fetchOne(null,Doctrine::HYDRATE_ARRAY);
					$resPermissao['action'] = is_null($resPermissao['action'])?'listar':$resPermissao['action'];
					
					// Verifica existência dos arquivos do módulo
					if (file_exists(PATH_ADMIN.'app/'.$resPermissao['model'].'/'.$resPermissao['action'].'.php')){
						require_once(PATH_ADMIN.'app/'.$resPermissao['model'].'/'.$resPermissao['action'].'.php');
					} else {
						$_SESSION['return_type']	= 'error';
						$_SESSION['return_message'] = 'Ocorreu um erro no sistema..';
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
					$_SESSION['return_message']	= 'Aqui!!Permissão negada.';
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
		
		// Limpeza de sessões de retorno
		$_SESSION['return_type'] = false;
		$_SESSION['return_message'] = false;
		
		?>
		
	</div>
	
</body>
</html>