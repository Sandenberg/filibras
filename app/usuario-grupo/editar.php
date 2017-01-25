<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Grupo de Usuário - Editar</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('UsuarioGrupo')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				<div class="form_row">
					<label>Nome:</label>
					<input type="text"  name="nome" id="nome" <?php echo ($res->id==1||$res->id==2||$res->id==3?'disabled="disabled"':''); ?> class="input validate[required,maxSize[45]]" style="width: 300px;" value="<?php echo $res->nome; ?>" />
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row radioui">
					<label>Status:</label>
					<div class="clear"></div>
					<?php 
					
					$s0 = $res->status==0?'checked="checked"':'';
					$s1 = $res->status==1?'checked="checked"':'';
					
					?>
					<input type="radio" id="status1" name="status" value="1" class="input validate[required]" <?php echo $s1; ?>><label for="status1">Ativo</label>
					<input type="radio" id="status0" name="status" value="0" class="input validate[required]"  <?php echo $s0; ?>><label for="status0">Inativo</label>
				</div>
				
				<div class="clear"></div><br />
				
				<input type="hidden" name="id" value="<?php echo $res->id; ?>" />
				<div class="form_row"><input type="submit" class="submit" value="Salvar" /></div>
				
			</form>
			<?php 
			
			} catch (Exception $e){
				echo 'Ocorreu um erro!';
			}
			
			unset($res);
			
			?>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->