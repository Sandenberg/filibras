<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Lançamento - Crédito - Editar</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('Lancamento')->find($_GET['id']);
				$res->data_vencimento = isset($res->data_vencimento)&&$res->data_vencimento!='1969-12-31'&&$res->data_vencimento!='0000-00-00'&&$res->data_vencimento!=''?date("d/m/Y", strtotime($res->data_vencimento)):null;
				$res->data_lancamento = isset($res->data_lancamento)&&$res->data_lancamento!='1969-12-31'&&$res->data_lancamento!='0000-00-00'&&$res->data_lancamento!=''?date("d/m/Y", strtotime($res->data_lancamento)):null;
				$res->data_lancamento_nf = isset($res->data_lancamento_nf)&&$res->data_lancamento_nf!='1969-12-31'&&$res->data_lancamento_nf!='0000-00-00'&&$res->data_lancamento_nf!=''?date("d/m/Y", strtotime($res->data_lancamento_nf)):null;

				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				
				<div class="form_row">
					<input type="radio" name="tipo" id="tipoc" class="tipo radio validate[required,maxSize[60]]" value="credito" <?php if($res->tipo == 'credito') echo "checked" ?> />
					<label style="display: inline-block;" for='tipoc'>Crédito</label>
				</div>

				<div class="form_row" style='display: none;'>
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
						
							$where = "id = 4";
							$resConta = Doctrine_Query::create()->select()->from('Conta')->where($where)->orderBy('nome ASC')->execute();
                                        
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
							
							if($res->lancamento_tipo_id==46)
								$where = "id = 46";
							else
								$where = "id = 29 or id = 30 or id = 28";
							
							$resTipo = Doctrine_Query::create()->select()->from('LancamentoTipo')->where($where)->orderBy('nome ASC')->execute();
                                        
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
<!-- 
				<div class="form_row">
					<label>Descrição:</label>
					<input type="text" name="descricao" id="descricao" class="input validate[maxSize[60]]" style="width: 405px;" value="<?php echo $res->descricao; ?>" />
				</div> -->
				<div class="form_row">
					<label>Valor:</label>
					<input type="text" name="valor" id="valor" class="input validate[required,maxSize[60]]" style="width: 100px;" value="<?php echo number_format($res->valor_total, 2, '.', ''); ?>" />
				</div>
				<div class="form_row">
					<label>Vencimento:</label>
					<input type="text" name="vencimento" id="vencimento" class="input validate[required,maxSize[60],custom[dateBR]]" style="width: 102px;" value="<?php echo $res->data_vencimento; ?>" />
				</div>
				<div class="form_row">
					<label>Lançamento:</label>
					<input type="text" name="lancamento" id="lancamento" class="input validate[required,maxSize[60],custom[dateBR]]" style="width: 102px;" value="<?php echo $res->data_lancamento; ?>" />
				</div>

				
				<div class="clear"></div>

				<div class="form_row">
					<label>Tipo de NF:</label>
					<select name="tipo_nf_id" id="tipo_nf_id" class="select" style="width: 215px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resTipoNf = Doctrine_Query::create()->select()->from('TipoNf')->orderBy('nome ASC')->execute();
                                        
							if ($resTipoNf->count() > 0){
								$resTipoNf->toArray();
								
								foreach ($resTipoNf as $value){
                                    $id = $value['id'];
                                    $nome = $value['nome'];
                                    $selected =  "";
                                    if($id == $res->tipo_nf_id)
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

				<div class="form_row" <?php if(!isset($res->tipo_nf_id)) echo "style='display: none'" ?>>
					<label>NF:</label>
					<input type="text" name="nf" id="nf" class="input validate[maxSize[60]]" style="width: 102px;" value="<?php echo $res->nf; ?>" />
				</div>
				<!-- <div class="form_row" <?php if(!isset($res->tipo_nf_id)) echo "style='display: none'" ?>>
					<label>Lançamento de NF:</label>
					<input type="text" name="lancamento_nf" id="lancamento_nf" class="input validate[maxSize[60],custom[dateBR]]" style="width: 102px;" value="<?php echo $res->data_lancamento_nf; ?>" />
				</div> -->

				<div class="form_row" style="margin-left: 10px;">
					<label style="display: inline-block;">Recibo:</label>
					<input name="recibo" id="recibo"  <?php if($res->recibo == 'REC') echo "checked" ?> class="validate[maxSize[60]]" style="width: auto; display: inline-block;" value="REC" type="checkbox">
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