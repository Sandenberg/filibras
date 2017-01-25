<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Lançamento</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php 
			
			// Seta as permissões de nível 1
			$objPermissao = new UsuarioPermissao();
			$objPermissao->printActions($_GET['model'], 1);
			
			?>
			<table class="data-table"><!-- Table Wrapper Begin -->
				<thead>
					<tr>
						<th width="80">Vencimento</th>
						<th width="80">Tipo</th>
						<th>Cliente</th>
						<th width="200">Beneficiário</th>
						<th width="80">Baixa</th>
						<th width="100">Tipo</th>
						<th width="140">Conta</th>
						<th width="170">Descrição</th>
						<th width="60">Valor</th>
						<th width="80">Ações</th>
					</tr>
				</thead>
			</table><!-- Table Wrapper End -->
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->