<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Lançamento - Editar</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('Lancamento')->find($_GET['id']);
				$res->data_vencimento = isset($res->data_vencimento)&&$res->data_vencimento!='1969-12-31'&&$res->data_vencimento!='0000-00-00'&&$res->data_vencimento!=''?date("d/m/Y", strtotime($res->data_vencimento)):null;

				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				
				<div class="form_row">
					<input type="radio" name="tipo" id="tipoc" class="tipo radio validate[required,maxSize[60]]" value="credito" <?php if($res->tipo == 'credito') echo "checked" ?> />
					<label style="display: inline-block;" for='tipoc'>Crédito</label>
				</div>

				<div class="form_row">
					<input type="radio" name="tipo" id="tipod" class="tipo radio validate[required,maxSize[60]]" value="debito" <?php if($res->tipo == 'debito') echo "checked" ?> />
					<label style="display: inline-block;" for='tipod'>Débito</label>
				</div>

				<div class="clear"></div>

				<div class="form_row" <?php if($res->tipo == 'debito') echo "style='display: none'" ?>>
					<label>Cliente:</label>
					<select name="cliente_id" id="cliente_id" class="select validate[required]" style="width: 215px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resCliente = Doctrine_Query::create()->select()->from('Cliente')->orderBy('nome_completo ASC')->execute();
                                        
							if ($resCliente->count() > 0){
								$resCliente->toArray();
								
								foreach ($resCliente as $value){
                                    $resFilial = Doctrine_Core::getTable('Filial')->find($value['filial_id']);
                                    $filial = $resFilial->nome;
                                    $id = $value['id'];
                                    $nome = $value['nome_completo'];
                                    $selected =  "";
                                    if($id == $res->cliente_id)
                                    	$selected = "selected";

									echo "<option value=$id ".$selected.">$nome - $filial</option>";
								}
							
							} else {
								echo '<option value="">Ocorreu um erro de sistema</option>';
							}
						
						} catch (Exception $e){
							echo '<option value="">Ocorreu um erro de sistema'.$e.'</option>';
						}
						
						
						?>
					</select>
				</div>

				<div class="form_row" <?php if($res->tipo == 'credito') echo "style='display: none'" ?>>
					<label>Beneficiario:</label>
					<select name="beneficiario_id" id="beneficiario_id" class="select validate[required]" style="width: 215px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resBeneficiario = Doctrine_Query::create()->select()->from('Beneficiario')->orderBy('nome ASC')->execute();

							echo $resBeneficiario->count();

							if ($resBeneficiario->count() > 0){
								$resBeneficiario->toArray();
								
								foreach ($resBeneficiario as $value){
                                    $id = $value['id'];
                                    $nome = $value['nome'];
                                    $selected =  "";
                                    if($id == $res->beneficiario_id)
                                    	$selected = "selected";

									echo "<option value='$id' ".$selected.">$nome</option>";
								}
							
							} else {
								echo '<option value="">Ocorreu um erro de sistema</option>';
							}
						
						} catch (Exception $e){
							echo '<option value="">Ocorreu um erro de sistema'.$e.'</option>';
						}
						
						
						?>
					</select>
				</div>
				<div class="form_row">
					<label>Conta:</label>
					<select name="conta_id" id="conta_id" class="select validate[required]" style="width: 215px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resConta = Doctrine_Query::create()->select()->from('Conta')->orderBy('nome ASC')->execute();
                                        
							if ($resConta->count() > 0){
								$resConta->toArray();
								
								foreach ($resConta as $value){
                                    $id = $value['id'];
                                    $nome = $value['nome'];
                                    $selected =  "";
                                    if($id == $res->conta_id)
                                    	$selected = "selected";

									echo "<option value=$id ".$selected.">$nome</option>";
								}
								
							} else {
								echo '<option value="">Nenhum registro encontrado</option>';
							}
						
						} catch (Exception $e){
							echo '<option value="">Ocorreu um erro de sistema</option>';
						}
						
						
						?>
					</select>
				</div>



				<div class="form_row">
					<label>Tipo:</label>
					<select name="tipo_id" id="tipo_id" class="select validate[required]" style="width: 215px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resTipo = Doctrine_Query::create()->select()->from('LancamentoTipo')->orderBy('nome ASC')->execute();
                                        
							if ($resTipo->count() > 0){
								$resTipo->toArray();
								
								foreach ($resTipo as $value){
                                    $id = $value['id'];
                                    $nome = $value['nome'];

                                    $selected =  "";
                                    if($id == $res->lancamento_tipo_id)
                                    	$selected = "selected";

									echo "<option value=$id ".$selected.">$nome</option>";
								}
								
							} else {
								echo '<option value="">Nenhum registro encontrado</option>';
							}
						
						} catch (Exception $e){
							echo '<option value="">Ocorreu um erro de sistema</option>';
						}
						
						
						?>
					</select>
				</div>


				<div class="clear"></div>

				<div class="form_row">
					<label>Descrição:</label>
					<input type="text" name="descricao" id="descricao" class="input validate[required,maxSize[60]]" style="width: 405px;" value="<?php echo $res->descricao; ?>" />
				</div>
				<div class="form_row">
					<label>Valor:</label>
					<input type="text" name="valor" id="valor" class="input validate[required,maxSize[60]]" style="width: 100px;" value="<?php echo number_format($res->valor_total, 2, '.', ''); ?>" />
				</div>
				<div class="form_row">
					<label>Vencimento:</label>
					<input type="text" name="vencimento" id="vencimento" class="input validate[required,maxSize[60],custom[dateBR]]" style="width: 102px;" value="<?php echo $res->data_vencimento; ?>" />
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