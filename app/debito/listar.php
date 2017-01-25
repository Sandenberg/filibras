<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Lançamento - Débito</h3>
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
						<th width="80">Lançamento</th>
						<th class='cliente'>Beneficiário</th>
						<th width="80">Vencimento</th>
						<th width="50">NF/REC</th>
						<th width="80">Baixa</th>
						<th width="160">Tipo</th>
						<th width="140">Conta</th>
						<!-- <th width="170">Descrição</th> -->
						<th width="60">Valor</th>
						<th width="80">Ações</th>
					</tr>
				</thead>
			</table><!-- Table Wrapper End -->
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->