<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Situação do Equipamento - Cadastrar</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form">
				<div class="form_row">
					<label>Situação do Equipamento:</label>
					<input type="text" name="nome" id="nome" class="input validate[required,maxSize[60]]" style="width: 380px;" />
				</div>
				
				<div class="form_row radioui">
					<label>Status:</label>
					<div class="clear"></div>
					<input type="radio" id="status1" name="status" value="1" class="input validate[required]"><label for="status1">Ativo</label>
					<input type="radio" id="status0" name="status" value="0" class="input validate[required]"><label for="status0">Inativo</label>
				</div>
				
				<div class="clear"></div><br />
				
				<div class="form_row"><input type="submit" class="submit" value="Salvar" /></div>
			</form>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->