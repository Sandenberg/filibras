<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<?php 
		
		try {
			
			// Seleciona o registro
			$obj = Doctrine_Core::getTable('ClienteResponsavel')->find($_GET['id']);
			$res = 'Cliente - '.$obj->Cliente->nome_completo.' - Contato - Editar';
	
		} catch (Exception $e){
			
			$res = 	'Ocorreu um erro de sistema!';
			echo 	'<h1>Ocorreu um erro de sistema!</h1>';
			
		}
		
		?>
		<div class="titlebar">
			<h3><?php echo $res; ?></h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('ClienteResponsavel')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				
				<div class="form_row">
					<label>Nome:</label>
					<input type="text" name="nome" id="nome" class="input validate[required,maxSize[60]]" style="width: 500px;" value="<?php echo $res->nome; ?>" />
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>E-mail:</label>
					<input type="text" name="email" id="email" class="input validate[maxSize[100],custom[email]]" style="width: 270px;" value="<?php echo $res->email; ?>" />
				</div>
				
				<div class="form_row">
					<label>Telefone:</label>
					<input type="text" name="telefone" id="telefone" class="input" style="width: 130px;" value="<?php echo $res->telefone; ?>" />
				</div>
				
				<div class="form_row">
					<label>Ramal:</label>
					<input type="text" name="ramal" id="ramal" class="input validate[maxSize[4],custom[onlyNumberSp]]" style="width: 65px;" value="<?php echo $res->ramal; ?>" />
				</div>
				
				

				<div class="clear"></div><br />
				
				<input type="hidden" name="cliente_id" value="<?php echo $res->cliente_id; ?>" />
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