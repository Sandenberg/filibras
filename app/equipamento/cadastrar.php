<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Equipamento - Cadastrar</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form">

				<div class="form_row radioui">
					<label>Tipo Impressão:</label><br /> 
					<input type="radio" id="tipo_impressao0" name="tipo_impressao" value="0" class="validate[required]" /><label for="tipo_impressao0">Monocromática</label> 
					<input type="radio" id="tipo_impressao1" name="tipo_impressao" value="1" class="validate[required]" /><label for="tipo_impressao1">Colorida</label>
					<input type="radio" id="tipo_impressao2" name="tipo_impressao" value="2" class="validate[required]" /><label for="tipo_impressao2">Não se aplica</label>
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Número de Série:</label> 
					<input type="text" name="serial" id="serial" class="input validate[required,maxSize[60]]" style="width: 370px;" />
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
									echo '<option value="'.$value['id'].'">'.$value['nome'].'</option>';
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
									echo '<option value="'.$value['id'].'">'.$value['nome'].'</option>';
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
						<option value="">Selecione uma Marca</option>
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
									echo '<option value="'.$value['id'].'">'.$value['nome'].'</option>';
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
									echo '<option value="'.$value['id'].'">'.$value['nome_completo'].'</option>';
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
					<input type="text" name="data_compra" id="data_compra" class="input" style="width: 170px;" />
				</div>
								
				<div class="form_row">
					<label>NF da Compra:</label> 
					<input type="text" name="nf_compra" id="nf_compra" class="input" style="width: 184px;" />
				</div>
				<!-- 
				<div class="clear"></div>
								
				<div class="form_row">
					<label>Procedimento:</label> 
					<textarea name="procedimento" id="procedimento" class="input" style="width: 755px; height: 100px" rows=5></textarea>
				</div>
			 -->
				<div class="clear"></div>
				
				<div class="form_row radioui">
					<label>Status:</label>
					<div class="clear"></div>
					<input checked="checked" type="radio" id="status1" name="status" value="1" class="input validate[required]"><label for="status1">Locação</label>
					<input type="radio" id="status0" name="status" value="0" class="input validate[required]"><label for="status0">Vendido</label>
					<input type="radio" id="status2" name="status" value="2" class="input validate[required]"><label for="status2">Equipamento do cliente</label>
					<input type="radio" id="status3" name="status" value="3" class="input validate[required]"><label for="status3">Estoque</label>
				</div>
				
				<div class="clear"></div><br />
				
				<div class="form_row"><input type="submit" class="submit" value="Salvar" /></div>
			</form>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->
<script type="text/javascript">
	$("#data_compra").mask("99/99/9999");
</script>