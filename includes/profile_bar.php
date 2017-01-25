<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="profile"><!-- Profile Begin -->
	<div id="avatar">
		<?php 
		
		try {
		
			// Seleciona os dados do usuário		
			$res = Doctrine_Core::getTable('Usuario')->find($_SESSION['sess_usuario_id']);

			// Define avatar
			$avatar = 	URL_USUARIO;
			$avatar .= 	$res->avatar!=''?$res->avatar:'default.png';
		
		} catch (Exception $e){
			exit('Ocorreu um erro!');
		}
			
		?>
		<img src="<?php echo $avatar; ?>" alt="<?php echo $res->nome; ?>" height="48" />
		<!-- Contador de Alerta - Não será utilizado-->
		<!-- <a href="#" id="unreadcount"></a> -->
	</div>
	<div id="profileinfo">
		<h3 id="username"><?php echo $res->apelido; ?></h3>
		<span id="subline"><?php echo $res->UsuarioGrupo->nome; ?></span>
		<div class="clear"></div>
		<?php if($_SESSION['sess_usuario_grupo_id'] == 1){ ?>
			<a href="<?php echo URL_ADMIN.'perfil/'; ?>" class="profilebutton">Perfil</a>
		<?php } ?>
	</div>
</div><!-- Userbar End -->
<?php 

unset($avatar);
unset($res); 

?>