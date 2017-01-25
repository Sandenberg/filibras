<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Contrato - Editar</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php 

			try {
				
				// Seleciona os dados do usuário
				$res = Doctrine_Core::getTable('Contrato')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				<?php 
					
					$t0 = $res->tipo==0?'checked="checked"':'';
					$t1 = $res->tipo==1?'checked="checked"':'';
					$t2 = $res->tipo==2?'checked="checked"':'';
					$t3 = $res->tipo==3?'checked="checked"':'';
					$t4 = $res->tipo==4?'checked="checked"':'';
					
					?>
				
				<div class="form_row radioui">
					<label>Tipo de Contrato:</label><br /> 
					<input type="radio" id="tipo0" name="tipo" value="0" class="validate[required]" <?php echo $t0; ?> /><label for="tipo0">Locação</label> 
					<input type="radio" id="tipo1" name="tipo" value="1" class="validate[required]" <?php echo $t1; ?> /><label for="tipo1">Venda</label>
					<input type="radio" id="tipo3" name="tipo" value="3" class="validate[required]" <?php echo $t3; ?> /><label for="tipo3">Contrato de Manutenção</label>
				    <input type="radio" id="tipo4" name="tipo" value="4" class="validate[required]" <?php echo $t4; ?> /><label for="tipo4">Diversos</label>
				</div>
				
				<?php 
				
					$tg0 = $res->garantia==0?'checked="checked"':'';
					$tg1 = $res->garantia==1?'checked="checked"':'';
					
				?>
				
				<div class="form_row radioui">
					<label>Garantia:</label><br /> 
					<input type="radio" id="garantia0" name="garantia" value="0" class="validate[required]" <?php echo $tg0; ?> /><label for="garantia0">Não</label> 
					<input type="radio" id="garantia1" name="garantia" value="1" class="validate[required]" <?php echo $tg1; ?> /><label for="garantia1">Sim</label>
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Número do Contrato:</label> 
					<input type="text" name="numero" id="numero" class="input" style="width: 370px;" value="<?php echo $res->numero; ?>" />
				</div>
				
				<div class="form_row">
					<label><span id="venda_locacao">Início da Vigência:</span></label>
					<input type="text" name="data_inicio" id="data_inicio" class="input validate[required,custom[dateBR]]" style="width: 100px;" value="<?php echo $res->data_inicio!=''?date('d/m/Y', strtotime($res->data_inicio)):""; ?>" />
				</div>
				
				<div class="form_row">
					<label>Fim da Vigência:</label>
					<input type="text" name="data_fim" id="data_fim" class="input" style="width: 100px;" value="<?php echo $res->data_fim!=''?date('d/m/Y', strtotime($res->data_fim)):''; ?>" />
				</div>
				
				<div class="form_row">
				<label>Valor:</label> 
					<input type="text" name="valor" id="valor" class="input" value="<?php echo $res->valor ?>" style="width: 100px;" />
				</div>	
				
				<div class="form_row">
				<label>Identificação:</label> 
					<input type="text" name="identificacao" id="identificacao" class="input" value="<?php echo $res->identificacao ?>" style="width: 100px;" />
				</div>	
				
				<div class="clear"></div>
				
				<div class="form_row garantia">
					<label>Início da Garantia:</label>
					<input type="text" name="inicio_garantia" id="inicio_garantia" class="input validate[custom[dateBR]]" style="width: 110px;"  value="<?php echo ($res->inicio_garantia!=''?date('d/m/Y', strtotime($res->inicio_garantia)):''); ?>" />
				</div>
				
				<div class="form_row garantia">
					<label>Fim da Garantia:</label>
					<input type="text" name="fim_garantia" id="fim_garantia" class="input validate[custom[dateBR]]" style="width: 110px;" value="<?php echo ($res->fim_garantia!=''?date('d/m/Y', strtotime($res->fim_garantia)):''); ?>" />
				</div>
				
				<div class="form_row">
					<label>Dia de Leitura:</label>
					<input type="text" name="dia_leitura" id="dia_leitura" class="input validate[custom[onlyNumberSp],min[1],max[31]]" style="width: 100px;"value="<?php echo $res->dia_leitura; ?>" />
				</div>
				
				<div class="form_row">
					<label>Franquia P&B:</label>
					<input type="text" name="franquia_monocromatica" id="franquia_monocromatica" class="input" style="width: 110px;" value="<?php echo $res->franquia_monocromatica!=''?number_format($res->franquia_monocromatica,0,'','.'):0; ?>" />
				</div>
				
				<div class="form_row">
					<label>Franquia Color:</label>
					<input type="text" name="franquia_colorida" id="franquia_colorida" class="input" style="width: 110px;" value="<?php echo $res->franquia_colorida!=''?number_format($res->franquia_colorida,0,'','.'):0; ?>" />
				</div>

				<div class="form_row">
					<label>Renovação:</label>
					<select name="renovacao" id="renovacao" class="select validate[required]" style="width: 110px;">
						<option value="0" <?php if($res->renovacao==0) echo "selected"; ?>>Manual</option>
						<option value="1" <?php if($res->renovacao==1) echo "selected"; ?>>Automática</option>
					</select>
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Valor P&B:</label>
					<input type="text" name="valor_monocromatica" id="valor_monocromatica" class="input validate[maxSize[10,2]]" style="width: 139px;" value="<?php echo $res->valor_monocromatica!=''?number_format($res->valor_monocromatica,4,',','.'):0; ?>" />
				</div>
				
				<div class="form_row">
					<label>Valor Color:</label>
					<input type="text" name="valor_colorida" id="valor_colorida" class="input validate[maxSize[10,2]]" style="width: 139px;" value="<?php echo $res->valor_colorida!=''?number_format($res->valor_colorida,4,',','.'):0; ?>" />
				</div>
				
				<div class="form_row">
					<label>Valor P&B Adicional:</label>
					<input type="text" name="adicional_monocromatica" id="adicional_monocromatica" class="input validate[required,maxSize[10,2]]" style="width: 139px;" value="<?php echo $res->adicional_monocromatica!=''?number_format($res->adicional_monocromatica,4,',','.'):0; ?>" />
				</div>
				
				<div class="form_row">
					<label>Valor Color Adicional:</label>
					<input type="text" name="adicional_colorida" id="adicional_colorida" class="input validate[required,maxSize[10,2]]" style="width: 139px;" value="<?php echo $res->adicional_colorida!=''?number_format($res->adicional_colorida,4,',','.'):0; ?>" />
				</div>
				
				<div class="clear"></div>
						
				<div class="form_row">
					<label>Cliente:</label>
					<select name="cliente_id" id="cliente_id" class="select validate[required]" style="width: 615px;">
						<option value=""></option>
						<?php 
						
							try {
						
							$resCliente = Doctrine_Query::create()->select()->from('Cliente')->orderBy('nome_completo ASC')->execute();
                                                        
                                                        
                                                        
							
							if ($resCliente->count() > 0){
								$resCliente->toArray();
								
								foreach ($resCliente as $value){
                                                                    $resFilial = Doctrine_Core::getTable('Filial')->find($value['filial_id']);
                                                                    $filial = $resFilial->nome;                                                                   
                                                                    $nome = $value['nome_completo'];
                                                                    $id_cliente = $res->cliente_id;
                                                                   
                                $selected = $value['id']==$res->cliente_id?' selected="selected"':'';
									echo '<option value= "'.$value['id'].'"'.$selected.'.>'."$nome - $filial </option>";
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