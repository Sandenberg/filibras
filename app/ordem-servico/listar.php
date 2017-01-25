<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<?php $_SESSION['OrdemServico']['sSearch_4'] = isset($_SESSION['OrdemServico']['sSearch_4'])?$_SESSION['OrdemServico']['sSearch_4']:""; ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Ordem de Serviço</h3>
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
						<th width="100">Numero:</th>
						<th>Cliente</th>
						<th>Tipo</th>
						<th>Data</th>
						<th>Status</th>										
						<th>Rota</th>										
						<th width="140">Ações</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th width="100"></th>
						<th></th>
						<th>Todos</th>										
						<th></th>
						<th>Todos</th>										
						<th></th>										
						<th width="110"></th>
					</tr>
				</tfoot>
			</table><!-- Table Wrapper End -->
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->
<script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.9/filtering/row-based/TableTools.ShowSelectedOnly.js"></script>
<input id='filtro' type='hidden' name="filtro" value="<?php echo $_SESSION['OrdemServico']['sSearch_4'] ?>">
<input id='usuario_nome' type='hidden' name="usuario_nome" value="<?php echo $_SESSION['sess_usuario_nome'] ?>">

<style type="text/css">
	.data-table th{
		color: #fff;
	}
</style>