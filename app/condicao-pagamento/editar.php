<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Condição de Pagamento - Editar</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('CondicaoPagamento')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				<div class="form_row">
					<label>Condição de Pagamento:</label>
					<input type="text" name="nome" id="nome" class="input validate[required,maxSize[60]]" style="width: 380px;" value="<?php echo $res->nome; ?>" />
				</div>
				
				<div class="form_row">
					<label>Periodicidade:</label>
					<input type="text" name="periodicidade" id="periodicidade" class="input validate[required,maxSize[5],custom[integer],min[1],max[99999]]" style="width: 50px;" maxlength="5" value="<?php echo $res->periodicidade; ?>" />
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