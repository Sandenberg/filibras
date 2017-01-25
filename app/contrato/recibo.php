<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Contrato - Enviar recibo</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<?php 
			$res = Doctrine_Core::getTable('Contrato')->find($_GET['id']); 
			
			
			
		?>
		<div class="block_cont">
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil" target='_blank' enctype="multipart/form-data">
				<?php 
					
					$where = 'contrato_id = '.$_GET['id'];
					$retRecibo	 = Doctrine_Query::create()->select()->from('Recibo r')->where($where)->orderBy('r.id desc')->execute();

					foreach ($res->ContratoEquipamento as $objContratoEquipamento) {
						$equipamento = $objContratoEquipamento->Equipamento->EquipamentoTipo->nome.' => '.$objContratoEquipamento->Equipamento->Marca->nome.' => '.$objContratoEquipamento->Equipamento->EquipamentoModelo->nome.' => '.$objContratoEquipamento->Equipamento->serial;
						

						$where = 'equipamento_id = '.$objContratoEquipamento->Equipamento->id;
						$retReciboEquipamento	 = Doctrine_Query::create()->select()->from('ReciboEquipamento re')
														->where($where)->orderBy('id desc')->execute();


						?>
						<b><?php echo $equipamento ?></b>						
						<div class="clear"></div>
						<input type="hidden" name='equipamento_id[]' value='<?php echo $objContratoEquipamento->equipamento_id ?>'>
						<?php if($res->franquia_monocromatica>0||$res->valor_monocromatica>0){ ?>
							<div class="form_row">
								<label>Anterior <b>P&B</b>:</label>
								<input type="text" name="numerador_anterior_mono[]" id="numerador_anterior_mono" class="input validate[maxSize[10]]" style="width: 139px;" value="<?php echo $retReciboEquipamento[0]->num_atual_pb ?>" />
							</div>
							<div class="form_row">
								<label>Atual <b>P&B</b>:</label>
								<input type="text" name="numerador_atual_mono[]" id="numerador_atual_mono" class="input validate[maxSize[10]]" style="width: 139px;" value="<?php echo $retReciboEquipamento[0]->num_atual_pb ?>" />
							</div>
						<?php } ?>

						<?php if($res->franquia_colorida>0||$res->valor_colorida>0){ ?>
							<div class="form_row">
								<label>Anterior <b>Colorido</b>:</label>
								<input type="text" name="numerador_anterior_colorida[]" id="numerador_anterior_colorida" class="input validate[maxSize[10]]" style="width: 139px;" value="<?php echo $retReciboEquipamento[0]->num_atual_color ?>" />
							</div>
							<div class="form_row">
								<label>Atual <b>Colorido</b>:</label>
								<input type="text" name="numerador_atual_colorida[]" id="numerador_atual_colorida" class="input validate[maxSize[10]]" style="width: 139px;" value="<?php echo $retReciboEquipamento[0]->num_atual_color ?>" />
							</div>
						<?php } ?>
						
								
						<div class="clear"></div><br>
						<?php 
					} 
				?>

				<br><br>
				<div class="form_row">
					<label>Condição de Pagamento:</label>
					<input type="text" name="condicao" id="condicao" class="input validate[required]" style="width: 139px;" value='<?php echo $retRecibo[0]->pagamento ?>' />
				</div>
				<div class="form_row">
					<label>Email:</label>
					<input type="text" name="email" id="email" class="input validate[required]" style="width: 453px;" value='<?php echo $retRecibo[0]->email!=''?$retRecibo[0]->email:$res->Cliente->email ?>' />
				</div>
				<div class="form_row">
					<label>CC:</label>
					<input type="text" name="email2" id="email2" class="input" style="width: 453px;" value='<?php echo $retRecibo[0]->email2!=''?$retRecibo[0]->email2:'' ?>' />
				</div>
				<div class="clear"></div>

				<b>Adicional 1</b>						
				<div class="clear"></div>
				<div class="form_row">
					<label>Descrição:</label>
					<input type="text" name="adic_descricao1" id="adic_descricao1" class="input" style="width: 439px;" />
				</div>
				<div class="form_row">
					<label>Valor:</label>
					<input type="text" name="adic_valor1" id="adic_valor1" class="input" style="width: 153px;" />
				</div>
				<div class="form_row">
					<label>Quantidade:</label>
					<input type="text" name="adic_quantidade1" id="adic_quantidade1" class="input" style="width: 153px;" />
				</div>


				<?php 

					$where = "cliente_id = ".$res->cliente_id;
					$retFechamento = Doctrine_Query::create()->select()->from('Fechamento')->where($where)->execute();

					if($retFechamento->count()==0){
						$text = "Últimos 30 dias";
					}else{
						$text = "Desde última leitura";
					}
				?>
				<div class="form_row" style='margin-left: 30px'>
					<!-- <label>Custo Total (<?php echo $text ?>):</label> -->
					<a target="_blank" href="<?php echo URL_ADMIN."lancamento-material/?cliente_id=".$res->cliente_id ?>">
						<?php 

							$where = "os.cliente_id = '".$res->cliente_id."' or oss.cliente_id = '".$res->cliente_id."'";
							if($retFechamento->count()==0){
								$where .= " and osm.data_cadastro > '".date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')." - 30 days"))."'";
							}
							$retOrderServicoMaterial = Doctrine_Query::create()->select('sum(valor_total) as total')->from('OrdemServicoMaterial osm')
										->leftJoin('osm.OrdemServico os')->leftJoin('osm.OrdemServToner ost')->leftJoin('ost.OrdemServico oss')
										->leftJoin('osm.Material m')->where($where)
										->execute();

							// echo $retOrderServicoMaterial->count();
							// echo "R$".number_format($retOrderServicoMaterial[0]->total, 2, ',', '.');
						?>
					</a>
					<span style="display: block; ">&nbsp;</span>
				</div>
				<div class="clear"></div>

				<b>Adicional 2</b>						
				<div class="clear"></div>
				<div class="form_row">
					<label>Descrição:</label>
					<input type="text" name="adic_descricao2" id="adic_descricao2" class="input" style="width: 439px;" />
				</div>
				<div class="form_row">
					<label>Valor:</label>
					<input type="text" name="adic_valor2" id="adic_valor2" class="input" style="width: 153px;" />
				</div>
				<div class="form_row">
					<label>Quantidade:</label>
					<input type="text" name="adic_quantidade2" id="adic_quantidade2" class="input" style="width: 153px;" />
				</div>
				<div class="clear"></div>

				<b>Adicional 3</b>						
				<div class="clear"></div>
				<div class="form_row">
					<label>Descrição:</label>
					<input type="text" name="adic_descricao3" id="adic_descricao3" class="input" style="width: 439px;" />
				</div>
				<div class="form_row">
					<label>Valor:</label>
					<input type="text" name="adic_valor3" id="adic_valor3" class="input" style="width: 153px;" />
				</div>
				<div class="form_row">
					<label>Quantidade:</label>
					<input type="text" name="adic_quantidade3" id="adic_quantidade3" class="input" style="width: 153px;" />
				</div>
				<div class="clear"></div>

				<div class="form_row">
					<label>Boleto 1:</label>
					<input type="file" name="boleto1" id="boleto1" class="" style="width: 453px;" />
				</div>
				<div class="clear"></div>

				<div class="form_row">
					<label>Boleto 2:</label>
					<input type="file" name="boleto2" id="boleto2" class="" style="width: 453px;" />
				</div>
				<div class="clear"></div>

				<div class="form_row">
					<label>Boleto 3:</label>
					<input type="file" name="boleto3" id="boleto3" class="" style="width: 453px;" />
				</div>
				<div class="clear"></div><br />
				
				<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
				<div class="form_row"><input type="submit" class="submit" name="acao" value="Salvar" /></div>
				<div class="form_row"><input type="submit" class="submit" name="acao" value="Visualizar" /></div>
				
			</form>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->