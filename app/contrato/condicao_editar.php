<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<?php 
		
		try {
			
			// Seleciona o registro
			$obj = Doctrine_Core::getTable('Equipamento')->find($_GET['id']);
			$res = 'Equipamento - '.$obj->serial.' - Condição - Editar';
	
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

				// Cria uma variável para os respectivos ids
				$getIds = explode("-", $_GET['id']);
				$equipamento_id = $getIds[0];
				$condicao_id	= $getIds[1];
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('EquipamentoCondicao')->findOneByEquipamentoIdAndCondicaoId($equipamento_id, $condicao_id);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="form">
				
				<div class="form_row">
					<label>Condição do Equipamento:</label>
					<select name="condicao_id" id="condicao_id" class="select validate[required]" style="width: 382px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resCondicao = Doctrine_Query::create()->select()->from('Condicao')->orderBy('nome ASC')->execute();
							
							if ($resCondicao->count() > 0){
								$resCondicao->toArray();
								
								foreach ($resCondicao as $value){
									$selected = $value['id']==$res->condicao_id?' selected="selected"':'';
									echo '<option value="'.$value['id'].'"'.$selected.'>'.$value['nome'].'</option>';
								}
								
							} else {
								echo '<option value="">Ocorreu um erro de sistema</option>';
							}
						
						} catch (Exception $e){
							echo '<option value="">Ocorreu um erro de sistema</option>';
						}
						
						
						?>
					</select>
				</div>
				
				<div class="form_row">
					<label>Data de Verificação</label> 
					<input type="text" name="data_verificacao" id="data_verificacao" class="input validate[required,custom[dateBR]]" style="width: 100px;" value="<?php echo date('d/m/Y', strtotime($res->data_verificacao)); ?>" />
				</div>
				
				<div class="form_row">
					<label>Hora:</label>
					<input type="text" name="hora_verificacao" id="hora_verificacao" class="input validate[required]" style="width: 60px;" value="<?php echo date('H:i', strtotime($res->data_verificacao)); ?>" />
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Serviço:</label>
					<select name="servico_id" id="servico_id" class="select" style="width: 575px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resServico = Doctrine_Query::create()->select()->from('Servico')->orderBy('tipo ASC')->execute();
							
							if ($resServico->count() > 0){
								$resServico->toArray();
								
								foreach ($resServico as $value){
									$selected = $value['id']==$res->servico_id?' selected="selected"':'';
									echo '<option value="'.$value['id'].'"'.$selected.'>'.$value['nome'].'</option>';
								}
								
							} else {
								echo '<option value="">Ocorreu um erro de sistema</option>';
							}
						
						} catch (Exception $e){
							echo '<option value="">Ocorreu um erro de sistema</option>';
						}
						
						
						?>
					</select>
				</div>

				<div class="clear"></div><br />
				
				<input type="hidden" name="equipamento_id" value="<?php echo $res->equipamento_id; ?>" />
				<input type="hidden" name="condicao_id" value="<?php echo $res->condicao_id; ?>" />
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