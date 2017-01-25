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
			
			$res = 	'Ocorreu um erro de sistema!';
			echo 	'<h1>Ocorreu um erro de sistema!</h1>';
			
		}
		
		?>
		<div class="titlebar">
			<h3><?php echo $res; ?></h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form">
		
				<div class="form_row">
					<label>Equipamento:</label>
					<select name="equipamento_id" id="equipamento_id" class="select validate[required]" style="width: 612px;">
						<option value=""></option>
						<?php 
						
						try {
							
							// Seleciona os equipamentos
							$equipamento_id =	Doctrine_Query::create()->select('equipamento_id')->from('ContratoEquipamento')
												->execute(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);

							$resEquipamento =	Doctrine_Query::create()->select()->from('Equipamento e')
												->leftJoin('e.Marca m')->leftJoin('e.EquipamentoModelo em')
												->whereNotIn('e.id', $equipamento_id)
												->execute();
							
							if ($resEquipamento->count() > 0){
								$resEquipamento->toArray();
								
								foreach ($resEquipamento as $value){
									echo '<option value="'.$value['id'].'">'.$value->EquipamentoTipo->nome.' => '.$value->Marca->nome.' => '.$value->EquipamentoModelo->nome.' => '.$value->serial.'</option>';
								}
								
							} else {
								echo '<option value="">Nenhum equipamento disponível</option>';
							}
						
						} catch (Exception $e){
							echo $e->getMessage();
							echo '<option value="">Ocorreu um erro de sistema</option>';
						}
						
						
						?>
					</select>
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Local:</label> 
					<input type="text" name="local" id="local" class="input " style="width: 600px;" />
				</div>
					
				<div class="clear"></div><br />
				
				<input type="hidden" name="contrato_id" value="<?php echo $_GET['id']; ?>" />
				<div class="form_row"><input type="submit" class="submit" value="Salvar" /></div>
			</form>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->