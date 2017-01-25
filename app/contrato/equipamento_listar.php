<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<?php 
		
		try {
			
			// Seleciona o registro
			$obj = Doctrine_Core::getTable('Contrato')->find($_GET['id']);
			
			$numero = $obj->numero!=''?$obj->numero:'S/N';
			$res = 'Contrato - '.$numero.' - Cliente - '.$obj->Cliente->nome_completo.' - Equipamentos'; 	
						
		} catch (Exception $e){
			
			$res = 'Ocorreu um erro de sistema!';
			echo '<h1>Ocorreu um erro de sistema!</h1>';
		}
		
		?>
		<div class="titlebar">
			<h3><?php echo $res; ?></h3>
			<a href="#" class="toggle">&nbsp;</a>
			<input type="hidden" name="contrato_id" value="<?php echo $obj->id; ?>" />
		</div>
		<div class="block_cont">
			<?php 
			
			// Seta as permissões de nível 1
			$objPermissao = new UsuarioPermissao();
			$objPermissao->printActions($_GET['model'], 4, $_GET['id'], $_GET['action']);
			
			?>
			<table class="data-table"><!-- Table Wrapper Begin -->
				<thead>
					<tr>
						<th>Equipamento</th>
						<th>Local</th>
						<th width="60">Ações</th>
					</tr>
				</thead>
			</table><!-- Table Wrapper End -->
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->