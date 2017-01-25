<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Contrato - Cadastrar</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form">

				<div class="form_row radioui">
					<label>Tipo:</label><br /> 
					<input type="radio" id="tipo0" name="tipo" value="0" class="validate[required]" /><label for="tipo0">Locação</label> 
					<input type="radio" id="tipo1" name="tipo" value="1" class="validate[required]" /><label for="tipo1">Venda</label>				
					<input type="radio" id="tipo3" name="tipo" value="3" class="validate[required]" /><label for="tipo3">Contrato de Manutenção</label>
				    <input type="radio" id="tipo4" name="tipo" value="4" class="validate[required]" /><label for="tipo4">Equipamento do Cliente</label>  
				</div>
				
				<div class="form_row radioui">
					<label>Garantia:</label><br /> 
					<input type="radio" id="garantia0" name="garantia" value="0"  /><label for="garantia0">Não</label> 
					<input type="radio" id="garantia1" name="garantia" value="1"  /><label for="garantia1">Sim</label>
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Número do Contrato:</label> 
					<input type="text" name="numero" id="numero" class="input" style="width: 370px;" />
				</div>
				
				<div class="form_row">
					<label><span id="venda_locacao">Início da Vigência:</span></label>
					<input type="text" name="data_inicio" id="data_inicio" class="input validate[required,custom[dateBR]]" style="width: 100px;" />
				</div>
				
				<div class="form_row">
					<label>Fim da Vigência:</label>
					<input type="text" name="data_fim" id="data_fim" class="input" style="width: 100px;" />
				</div>
				<span class="valor_dive">
				<div class="form_row">
					<label>Valor:</label> 
					<input type="text" name="valor" id="valor" class="input"  style="width: 100px;" />
				</div>
				
				<div class="form_row">
					<label>Identificação:</label> 
					<input type="text" name="identificacao" id="identificacao" class="input"  style="width: 100px;" />
				</div>
				</span>
				<div class="clear"></div>
				
				<div class="form_row garantia">
					<label>Início da Garantia:</label>
					<input type="text" name="inicio_garantia" id="inicio_garantia" class="input validate[custom[dateBR]]" style="width: 110px;" />
				</div>
				
				<div class="form_row garantia">
					<label>Fim da Garantia:</label>
					<input type="text" name="fim_garantia" id="fim_garantia" class="input validate[custom[dateBR]]" style="width: 110px;" />
				</div>
				
				<div class="form_row">
					<label>Dia de Leitura:</label>
					<input type="text" name="dia_leitura" id="dia_leitura" class="input validate[custom[onlyNumberSp],min[1],max[31]]" style="width: 100px;" />
				</div>
				
				<div class="form_row">
					<label>Franquia P&B:</label>
					<input type="text" name="franquia_monocromatica" id="franquia_monocromatica" class="input" style="width: 110px;" />
				</div>
				
				<div class="form_row">
					<label>Franquia Color:</label>
					<input type="text" name="franquia_colorida" id="franquia_colorida" class="input" style="width: 110px;" />
				</div>


				<div class="form_row">
					<label>Renovação:</label>
					<select name="renovacao" id="renovacao" class="select validate[required]" style="width: 110px;">
						<option value="0">Manual</option>
						<option value="1">Automática</option>
					</select>
				</div>

				<div class="clear"></div>
				
				<div class="form_row">
					<label>Valor P&B:</label>
					<input type="text" name="valor_monocromatica" id="valor_monocromatica" class="input validate[maxSize[10,2]]" style="width: 139px;" />
				</div>
				
				<div class="form_row">
					<label>Valor Color:</label>
					<input type="text" name="valor_colorida" id="valor_colorida" class="input validate[maxSize[10,2]]" style="width: 139px;" />
				</div>
				
				<div class="form_row">
					<label>Valor P&B Adicional:</label>
					<input type="text" name="adicional_monocromatica" id="adicional_monocromatica" class="input validate[maxSize[10,2]]" style="width: 139px;" />
				</div>
				
				<div class="form_row">
					<label>Valor Color Adicional:</label>
					<input type="text" name="adicional_colorida" id="adicional_colorida" class="input validate[maxSize[10,2]]" style="width: 139px;" />
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
				
				<div class="clear"></div><br />
				
				<div class="form_row"><input type="submit" class="submit" value="Salvar" /></div>
			</form>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->