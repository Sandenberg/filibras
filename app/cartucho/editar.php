<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Problema e Solução - Editar</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('Problema')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				<div class="form_row">
					<label>Problema:</label>
					<input type="text" name="titulo" id="titulo" class="input validate[required,maxSize[60]]" style="width: 380px;" value="<?php echo $res->titulo; ?>" />
				</div>
				
				<div class="form_row radioui">
					<label>Status:</label>
					<div class="clear"></div>
					<?php
					
					$s0 = $res->status==0?'checked="checked"':'';
					$s1 = $res->status==1?'checked="checked"':'';
					
					?>
					<input type="radio" id="status1" name="status" value="1" class="input validate[required]" <?php echo $s1; ?>><label for="status1">Solucionado</label>
					<input type="radio" id="status0" name="status" value="0" class="input validate[required]"  <?php echo $s0; ?>><label for="status0">Em aberto</label>
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Descrição:</label>
					<textarea name="descricao" id="descricao" class="textarea validate[required]" cols="90" rows="10" ><?php echo $res->descricao; ?></textarea>
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Causa:</label>
					<textarea name="causa" id="causa" class="textarea" cols="90" rows="10" ><?php echo $res->causa; ?></textarea>
				</div>
				
				<div class="clear"></div>
						
				<div class="form_row">
					<label>Solução:</label>
					<textarea name="solucao" id="solucao" class="textarea" cols="90" rows="10" ><?php echo $res->solucao; ?></textarea>
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Serviço:</label>
					<select name="servico_id" id="servico_id" class="select" style="width: 755px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resServico = Doctrine_Query::create()->select()->from('Servico')->orderBy('id DESC')->execute();
							
							if ($resServico->count() > 0){
								$resServico->toArray();
								
								foreach ($resServico as $value){
									$selected = $value['id']==$res->servico_id?' selected="selected"':'';
									echo '<option value="'.$value['id'].'"'.$selected.'>'.$value['nome'].'</option>';
								}
								
							} else {
								echo '<option value="">Nenhum registro encontrado.</option>';
							}
						
						} catch (Exception $e){
							echo '<option value="">Ocorreu um erro de sistema</option>';
						}
						
						
						?>
					</select>
				</div>
				
				
				
				<div class="clear"></div><br />
				
				<input type="hidden" name="id" value="<?php echo $res->id; ?>" />
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