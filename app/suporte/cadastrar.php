<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Suporte - Cadastrar</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form">
				<div class="form_row">
					<label>Suporte:</label>
					<input type="text" name="nome" id="nome" class="input validate[required,maxSize[60]]" style="width: 380px;" />
				</div>
				
				<div class="form_row radioui">
					<label>Houve troca de Peça:</label>
					<div class="clear"></div>
					<input type="radio" id="troca_peca1" name="troca_peca" value="1" class="input validate[required]"><label for="troca_peca1">Sim</label>
					<input type="radio" id="troca_peca0" name="troca_peca" value="0" class="input validate[required]"><label for="troca_peca0">Não</label>
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Descrição:</label>
					<textarea name="descricao" id="descricao" class="textarea validate[required]" cols="90" rows="10"></textarea>
				</div>
				
				
				
				<div class="clear"></div><br />
				
				<div class="form_row"><input type="submit" class="submit" value="Salvar" /></div>
			</form>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->