<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<?php 
		
		try {
			
			// Seleciona o registro
			$obj 	= Doctrine_Core::getTable('UsuarioGrupo')->find($_GET['id']);
			$res	= $obj->nome;
			
		} catch (Exception $e){
			
			$res = 	'Ocorreu um erro de sistema!';
			echo 	'<h1>Ocorreu um erro de sistema!</h1>';
			
		}
		
		?>
		<div class="titlebar">
			<h3>Grupo de Usuário - <?php echo $res; ?> - Permissões</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('UsuarioGrupo')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				<ul style="list-style: none !important;">
					<?php
					
					$objPermissao = new UsuarioPermissao();
					$objPermissao->getPermission(0, $_GET['id']);
					
					?>
				</ul>
				
				<div class="clear"></div><br />
				
				<input type="hidden" name="id" value="<?php echo $res->id; ?>" />
				<div class="form_row"><input type="submit" class="submit" value="Salvar" /></div>
				
			</form>
			<?php 
			
			} catch (Exception $e){
				echo 'Ocorreu um erro!'.$e;
			}
			
			unset($res);
			
			?>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->