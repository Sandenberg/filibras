<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<?php 
		
		try {

			// Pega os ids via GET
			$aux 			= explode("-", $_GET['id']);
			$equipamento_id = $aux[0];
			$contrato_id 	= $aux[1];
			
			// Seleciona o registro
			$obj = Doctrine_Core::getTable('ContratoEquipamento')->findOneByEquipamentoIdAndContratoId($equipamento_id, $contrato_id);
			
			$res 	= 'Contrato - '.($obj->Contrato->numero!=''?$obj->Contrato->numero:'S/N').'- Cliente - '.$obj->Contrato->Cliente->nome_completo.' - Contato - Editar';
	
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
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('ContratoEquipamento')->findOneByEquipamentoIdAndContratoId($equipamento_id, $contrato_id);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				
				<div class="form_row">
					<label>Equipamento:</label>
					<select name="equipamento_id" id="equipamento_id" class="select" style="width: 612px;">
						<option value="" disabled="disabled" selected="selected"><?php echo $res->Equipamento->EquipamentoTipo->nome.' => '.$res->Equipamento->Marca->nome.' => '.$res->Equipamento->EquipamentoModelo->nome.' => '.$res->Equipamento->serial; ?></option>
					</select>
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Local:</label>
					<input type="text" name="local" id="local" class="input " style="width: 600px;" value="<?php echo $res->local; ?>" />
				</div>

				<div class="clear"></div><br />
				
				<input type="hidden" name="contrato_id" value="<?php echo $res->contrato_id; ?>" />
				<input type="hidden" name="equipamento_id" value="<?php echo $res->equipamento_id; ?>" />
				<div class="form_row"><input type="submit" class="submit" value="Salvar" /></div>
				
			</form>
			<?php 
			
			} catch (Exception $e){
				echo 'Ocorreu um erro!';
			}
			
			unset($res);
			
			?>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->