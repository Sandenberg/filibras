<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Financeiro - Débito - Cadastrar</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form">
				
				<div class="form_row" style='display: none;'>
					<input type="radio" name="tipo" id="tipoc" class="tipo radio validate[required,maxSize[60]]"  value="credito" />
					<label style="display: inline-block;" for='tipoc'>Crédito</label>
				</div>

				<div class="form_row">
					<input type="radio" name="tipo" id="tipod" class="tipo radio validate[required,maxSize[60]]" checked value="debito" />
					<label style="display: inline-block;" for='tipod'>Débito</label>
				</div>

				<div class="clear"></div>

				<div class="form_row" style='display: none'>
					<label>Cliente:</label>
					<select name="cliente_id" id="cliente_id" class="select validate[required]" style="width: 215px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resCliente = Doctrine_Query::create()->select('c.id, c.nome_completo, c.filial_id')->from('Cliente c')->orderBy('nome_completo ASC')->execute();
                                        
							if ($resCliente->count() > 0){
								$resCliente->toArray();
								
								foreach ($resCliente as $value){
                                    $resFilial = Doctrine_Core::getTable('Filial')->find($value['filial_id']);
                                    $filial = $resFilial->nome;
                                    $id = $value['id'];
                                    $nome = $value['nome_completo'];
									echo "<option value=$id>$nome - $filial</option>";
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
					<label>Beneficiario:</label>
					<select name="beneficiario_id" id="beneficiario_id" class="select validate[required]" style="width: 215px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resBeneficiario = Doctrine_Query::create()->select()->from('Beneficiario')->orderBy('nome ASC')->execute();
                                        // 
							if ($resBeneficiario->count() > 0){
								$resBeneficiario->toArray();
								
								foreach ($resBeneficiario as $value){
                                    $id = $value['id'];
                                    $nome = $value['nome'];

									echo "<option value='$id'>$nome</option>";
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
<!-- 
				<div class="form_row" style='display: none'>
					<label>Beneficiário:</label>
					<input type="text" name="beneficiario" id="beneficiario" class="input validate[required,maxSize[60]]" style="width: 205px;" />
				</div>
 -->
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
									echo "<option value=$id>$nome</option>";
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
									echo "<option value=$id>$nome</option>";
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

				<!-- <div class="form_row">
					<label>Descrição:</label>
					<input type="text" name="descricao" id="descricao" class="input validate[maxSize[60]]" style="width: 405px;" />
				</div> -->
				<div class="form_row">
					<label>Valor:</label>
					<input type="text" name="valor" id="valor" class="input validate[required,maxSize[60]]" style="width: 100px;" />
				</div>
				<div class="form_row venc">
					<label>Vencimento:</label>
					<input type="text" name="vencimento" id="vencimento" class="input validate[maxSize[60],custom[dateBR]]" style="width: 102px;" />
				</div>
				
				
				<div class="clear"></div>
				
				<!-- <div class="form_row">
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
									echo "<option value=$id>$nome</option>";
								}
								
							} else {
								echo '<option value="">Nenhum registro encontrado</option>';
							}
						
						} catch (Exception $e){
							echo '<option value="">Ocorreu um erro de sistema</option>';
						}
						
						
						?>
					</select>
				</div> -->

				<div class="form_row">
					<label>NF:</label>
					<input type="text" name="nf" id="nf" class="input validate[maxSize[60]]" style="width: 102px;" value="" />
				</div>
				<!-- <div class="form_row" style='display: none'>
					<label>Lançamento de NF:</label>
					<input type="text" name="lancamento_nf" id="lancamento_nf" class="input validate[maxSize[60],custom[dateBR]]" style="width: 102px;" value="" />
				</div> -->

				<div class="form_row" style="margin-left: 10px;">
					<label style="display: inline-block;">Recibo:</label>
					<input name="recibo" id="recibo" class="validate[maxSize[60]]" style="width: auto; display: inline-block;" value="REC" type="checkbox">
				</div>

				<div class="clear"></div>


				<div class="form_row" style="width: 100px">
					<label>
						<input type="checkbox" name="parcelado" id="parcelado" value="Sim" />
						Parcelado
					</label>
				</div>

				<div class="clear"></div>
				<div id='qtdparcela' style="display: none;">
					
					<div class="form_row">
						<label>Periodo:</label>
						<select nome='periodo' id='periodo' class='select'>
							<option value="1">Diário</option>
							<option value="2">Semanal</option>
							<option value="3">Mensal</option>
							<option value="4">Trimestral</option>
							<option value="5">Semestral</option>
							<option value="6">Anual</option>
						</select>
					</div>

					<div class="form_row">
						<label>Periodo inicio:</label>
						<input type="text" name="data_periodo" id="data_periodo" class="input validate[maxSize[60],custom[dateBR]]" value="<?php echo date('d/m/Y') ?>" />
					</div>

					<div class="form_row">
						<label>Qtde. de Parcelas:</label>
						<input type="text" name="parcelas" id="parcelas" class="input" />
					</div>

				</div>

				<div class="clear"></div>

				<div id='valueparcelas'></div>

				<div class="clear"></div><br />
				
				<div class="form_row"><input type="submit" class="submit" value="Salvar" /></div>
			</form>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->