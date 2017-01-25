<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Lançamento - Material</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<style type="text/css">
			.cliente{
				width: auto !important;
			}
		</style>
		<div class="block_cont">
			<?php 
			
			// Seta as permissões de nível 1
			$objPermissao = new UsuarioPermissao();
			$objPermissao->printActions($_GET['model'], 1);
			
			?>
			<table class="data-table"><!-- Table Wrapper Begin -->
				<thead>
					<tr>
						<th width="140">Lançamento</th>
						<th class='cliente'>Material</th>
						<th width="80">Quantidade</th>
						<th width="80">Valor UN</th>
						<th width="120">Valor Total</th>
						<th width="200">Tipo</th>
					</tr>
				</thead>
			</table><!-- Table Wrapper End -->
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->
<input type="hidden" name="cliente_id" id="cliente_id" value="<?php echo isset($_GET['cliente_id'])&&$_GET['cliente_id']!=''?$_GET['cliente_id']:""; ?>">
<input type="hidden" name="fechamento" id="fechamento" value="<?php echo isset($_GET['fechamento'])&&$_GET['fechamento']!=''?$_GET['fechamento']:""; ?>">