<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!');

				$res = Doctrine_Core::getTable ( 'OrdemServico' )->find ( $_GET ['id'] );

?>
<div id="body">
	<div class="block big">
		<!-- Block Begin -->
		<div class="titlebar">
			<h3>Ordem de Serviço - Rota</h3>
			<!-- Open Dialog Modal -->
			<div class="hide">
				<div id="dialog" title="Filibras"></div>
			</div>
			<!-- /Open Dialog Modal -->
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form">
			
				<div class="form_row">
                    <label>Turno:</label>
                    <select class="select" name="turno">
                    	<option>Manhã</option>
                    	<option>Tarde</option>
                    </select>
                </div>
				<div class="form_row">
                    <label>Ordem:</label>
                    <select class="select" name="ordem">
                    	<option>1º</option>
                    	<option>2º</option>
                    	<option>3º</option>
                    	<option>4º</option>
                    	<option>5º</option>
                    	<option>6º</option>
                    	<option>7º</option>
                    	<option>8º</option>
                    	<option>9º</option>
                    	<option>10º</option>
                    </select>
                </div>
			
				<div class="clear"></div>
				<div class="form_row">
					<input type="hidden" name="id" value="<?php echo $res->id; ?>" />
					<input type="submit" class="submit submitform" value="Salvar" />
				</div>
			</form>
		</div>
	</div>
	<!-- Block End -->
</div>
<!-- Body Wrapper End -->


