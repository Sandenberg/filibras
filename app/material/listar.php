<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>

<div id="body">

	<div class="block big"><!-- Block Begin -->

		<div class="titlebar">

			<h3>Peças e Materiais</h3>

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

						<th>Peça e Material</th>

						<th width="120">Localização</th>
						<th width="80">Valor</th>

						<th width="126">Estoque Atual</th>

						<th width="120">Estoque Min.</th>

						<th width="60">Ações</th>

					</tr>

				</thead>

			</table><!-- Table Wrapper End -->

		</div>

	</div><!-- Block End -->

</div><!-- Body Wrapper End -->