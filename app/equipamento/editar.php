<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Equipamento - Editar</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php 

			try {
				
				// Seleciona os dados do usuário
				$res = Doctrine_Core::getTable('Equipamento')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				<?php 
					
					$t0 = $res->tipo_impressao==0?'checked="checked"':'';
					$t1 = $res->tipo_impressao==1?'checked="checked"':'';
					$t2 = $res->tipo_impressao==2?'checked="checked"':'';
					
					?>
				<div class="form_row radioui">
					<label>Tipo Impressão:</label><br /> 
					<input type="radio" id="tipo_impressao0" name="tipo_impressao" value="0" class="validate[required]" <?php echo $t0; ?> /><label for="tipo_impressao0">Monocromática</label> 
					<input type="radio" id="tipo_impressao1" name="tipo_impressao" value="1" class="validate[required]" <?php echo $t1; ?>/><label for="tipo_impressao1">Colorida</label>
					<input type="radio" id="tipo_impressao2" name="tipo_impressao" value="2" class="validate[required]" <?php echo $t2; ?>/><label for="tipo_impressao2">Não se aplica</label>
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Número de Série:</label> 
					<input type="text" name="serial" id="serial" class="input validate[required,maxSize[60]]" style="width: 370px;" value="<?php echo $res->serial; ?>" />
				</div>
				
				<div class="form_row">
					<label>Patrimônio:</label> 
					<input readonly="readonly" type="text" name="patrimonio" id="patrimonio" class="input validate[required,maxSize[60],custom[onlyLetterNumber]]" style="width: 370px;" value="<?php echo $res->patrimonio; ?>" />
				</div>
				
				<div class="clear"></div>
			
				<div class="form_row">
					<label>Marca:</label>
					<select name="marca_id" id="marca_id" class="select validate[required]" style="width: 382px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resMarca = Doctrine_Query::create()->select()->from('Marca')->orderBy('nome ASC')->execute();
							
							if ($resMarca->count() > 0){
								$resMarca->toArray();
								
								foreach ($resMarca as $value){
									$selected = $value['id']==$res->marca_id?' selected="selected"':'';
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
					<label>Tipo de Equipamento:</label>
					<select name="equipamento_tipo_id" id="equipamento_tipo_id" class="select validate[required]" style="width: 382px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resTipo = Doctrine_Query::create()->select()->from('EquipamentoTipo')->orderBy('nome ASC')->execute();
							
							if ($resTipo->count() > 0){
								$resTipo->toArray();
								
								foreach ($resTipo as $value){
									$selected = $value['id']==$res->equipamento_tipo_id?' selected="selected"':'';
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
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Modelo de Equipamento:</label>
					<select name="equipamento_modelo_id" id="equipamento_modelo_id" class="select validate[required]" style="width: 382px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resModelo = Doctrine_Query::create()->select()->from('EquipamentoModelo')->where('marca_id = '.$res->marca_id)->orderBy('nome ASC')->execute();
							
							if ($resModelo->count() > 0){
								$resModelo->toArray();
								
								foreach ($resModelo as $value){
									$selected = $value['id']==$res->equipamento_modelo_id?' selected="selected"':'';
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
					<label>Situação do Equipamento:</label>
					<select name="equipamento_situacao_id" id="equipamento_situacao_id" class="select validate[required]" style="width: 382px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resSituacao = Doctrine_Query::create()->select()->from('EquipamentoSituacao')->orderBy('nome ASC')->execute();
							
							if ($resSituacao->count() > 0){
								$resSituacao->toArray();
								
								foreach ($resSituacao as $value){
									$selected = $value['id']==$res->equipamento_situacao_id?' selected="selected"':'';
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
				
				<div class="clear"></div>

				<div class="form_row">
					<label>Fornecedor:</label>
					<select name="fornecedor_id" id="fornecedor_id" class="select" style="width: 382px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resFornecedor = Doctrine_Query::create()->select()->from('Fornecedor')->orderBy('nome_completo ASC')->execute();
							
							if ($resFornecedor->count() > 0){
								$resFornecedor->toArray();
								
								foreach ($resFornecedor as $value){
									$selected = $value['id']==$res->fornecedor_id?' selected="selected"':'';
									echo '<option value="'.$value['id'].'"'.$selected.'>'.$value['nome_completo'].'</option>';
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
					<label>Data da Compra:</label> 
					<input type="text" name="data_compra" id="data_compra" class="input" style="width: 170px;" value="<?php echo isset($res->data_compra)&&$res->data_compra!=''&&$res->data_compra!='0000-00-00'?date('d/m/Y', strtotime($res->data_compra)):''; ?>" />
				</div>
				<div class="form_row">
					<label>NF da Compra:</label> 
					<input type="text" name="nf_compra" id="nf_compra" class="input" style="width: 184px;" value="<?php echo $res->nf_compra; ?>" />
				</div>
				
				<div class="clear"></div>
								
				<div class="form_row">
					<label>Procedimento:</label> 
					<textarea name="procedimento" id="procedimento" class="input" style="width: 755px; height: 100px" rows=5><?php echo $res->procedimento; ?></textarea>
				</div>
			
				<div class="clear"></div>
				
				<div class="form_row radioui">
					<label>Status:</label>
					<div class="clear"></div>
					<?php 
					
					$s0 = $res->status==0?'checked="checked"':'';
					$s1 = $res->status==1?'checked="checked"':'';
					$s2 = $res->status==2?'checked="checked"':'';
					$s3 = $res->status==3?'checked="checked"':'';
					
					?>
					<input type="radio" id="status1" name="status" value="1" class="input validate[required]" <?php echo $s1; ?>><label for="status1">Locação</label>
					<input type="radio" id="status0" name="status" value="0" class="input validate[required]"  <?php echo $s0; ?>><label for="status0">Vendido</label>
					<input type="radio" id="status2" name="status" value="2" class="input validate[required]"  <?php echo $s2; ?>><label for="status2">Equipamento do cliente</label>
					<input type="radio" id="status3" name="status" value="3" class="input validate[required]"  <?php echo $s3; ?>><label for="status3">Estoque</label>
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