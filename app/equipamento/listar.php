<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Equipamentos</h3>
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
						<th>Tipo</th>
						<th width="100">Serial</th>
						<th width="100">Marca</th>
						<th width="100">Modelo</th>
						<th width="100">Situação</th>
						<th>Cliente</th>
						<th width="100">Status</th>
						<th width="120">Ações</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th></th>
						<th></th>
						<th></th>										
						<th></th>
						<th></th>										
						<th></th>										
						<th>Todos</th>										
						<th></th>
					</tr>
				</tfoot>
			</table><!-- Table Wrapper End -->
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->