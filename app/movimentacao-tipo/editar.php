<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Tipo de Movimentação - Editar</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('MovimentacaoTipo')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				<div class="form_row">
					<label>Tipo de Movimentação:</label>
					<input type="text" name="nome" id="nome" class="input validate[required,maxSize[60]]" style="width: 380px;" value="<?php echo $res->nome; ?>" />
				</div>
				
				<div class="form_row radioui">
					<label>Tipo:</label>
					<div class="clear"></div>
					<?php
					
					$s0 = $res->tipo==0?'checked="checked"':'';
					$s1 = $res->tipo==1?'checked="checked"':'';
					
					?>
					<input type="radio" id="tipo1" name="tipo" value="1" class="input validate[required]" <?php echo $s1; ?>><label for="tipo1">Entrada</label>
					<input type="radio" id="tipo0" name="tipo" value="0" class="input validate[required]"  <?php echo $s0; ?>><label for="tipo0">Saída</label>
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Descrição:</label>
					<textarea name="descricao" id="descricao" class="textarea validate[required]" cols="80" rows="10" ><?php echo $res->descricao; ?></textarea>
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