<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Exportar - Banco de Dados</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>

		<div class="block_cont">
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form" target="_blank">

                <div class="clear"></div><br>
				<div class="form_row"><input type="submit" class="submit" value="Gerar arquivo" /></div>
			</form>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->