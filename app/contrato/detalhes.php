<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<?php
		try {
				
			// Seleciona os dados do usuário
			$res = Doctrine_Core::getTable('Contrato')->find($_GET['id']);
				
		} catch (Exception $e){
		
		}
		?>
		<div class="titlebar">
			<h3>Contrato - <?php echo $res->numero.' - Cliente - '.$res->Cliente->nome_completo; ?> - Detalhes</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php 

			try {
				
				// Seleciona os dados do usuário
				$res = Doctrine_Core::getTable('Contrato')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
			
				<div class="form_row">
					<label><b>NÚMERO:</b></label>
					<div style="width: 400px;"><?php echo $res->numero; ?></div>
				</div>
				
				<div class="form_row">
					<label><b>TIPO:</b></label>
					<?php 
					
					$tipo = $res->tipo;
					$tipo = $tipo==0?'Locação':$tipo;
					$tipo = $tipo==1?'Venda':$tipo;
					$tipo = $tipo==2?'Venda sem contrato':$tipo;
					$tipo = $tipo==3?'Contrato de Manutenção':$tipo;
					$tipo = $tipo==4?'Equipamento do Cliente':$tipo;
					
					?>
					<div style="width: 150px;"><?php echo $tipo; ?></div>
				</div>
				
				<div class="clear"></div>
			
				<div class="form_row">
					<label><b>CLIENTE:</b></label>
					<div style="width: 600px;"><?php echo $res->Cliente->nome_completo; ?></div>
				</div>
                            
				<div class="clear"></div>
                                    <div class="form_row">
					<label><b>FILIAL:</b></label>
                                        <?php
                                        $cliente = $res->cliente_id;
                                        $resCliente = Doctrine_Core::getTable('Cliente')->find($cliente);
                                        $filial = $resCliente->filial_id;
                                        $resFilial = Doctrine_Core::getTable('Filial')->find($filial);
                                        
                                        ?>
                                        
					<div style="width: 600px;"><?php echo $resFilial->nome; ?></div>
				</div>
				<div class="clear"></div>
				
				<div class="form_row">
					<label><b><?php echo $res->Cliente->tipo_pessoa==0?'CPF':'CNPJ'; ?>:</b></label>
					<?php 
						$cpf 	= $res->Cliente->cpf!=''?Util::mask('###.###.###-##', $res->Cliente->cpf):'-';
						$cnpj 	= $res->Cliente->cnpj!=''?Util::mask('##.###.###/####-##', $res->Cliente->cnpj):'-';
					?>
					<div style="width: 270px;"><?php echo $res->Cliente->tipo_pessoa==0?$cpf:$cnpj; ?></div>
				</div>
			
				<div class="clear"></div>
				
				<div class="form_row">
					<label><b>VIGÊNCIA DO CONTRATO:</b></label>
					<div style="width: 400px;"><?php echo $res->data_inicio!=''?strftime('%d/%m/%Y', strtotime($res->data_inicio)):'-'; echo $res->data_fim!=''?' A '.strftime('%d/%m/%Y', strtotime($res->data_fim)):''; ?></div>
				</div>
				
				<div class="form_row">
					<label><b>DIA DE LEITURA:</b></label>
					<div style="width: 150px;"><?php echo $res->dia_leitura!=''?$res->dia_leitura:'-'; ?></div>
				</div>
				<?php if(isset($res->valor)||isset($res->identificacao)){ ?>
					<div class="clear"></div>
					
					<div class="form_row">
						<label><b>VALOR:</b></label>
						<div style="width: 400px;"><?php echo $res->valor!=''?'R$ '.number_format($res->valor,4,',','.'):'-'; ?></div>
					</div>
					
					<div class="form_row">
						<label><b>IDENTIFICAÇÃO:</b></label>
						<div style="width: 400px;"><?php echo $res->identificacao!=''?$res->identificacao:'-'; ?></div>
					</div>
				<?php } ?>
				<div class="clear"></div>
				
				<div class="form_row">
					<label><b>VALOR MONOCROMÁTICA:</b></label>
					<div style="width: 400px;"><?php echo $res->valor_monocromatica!=''?'R$ '.number_format($res->valor_monocromatica,4,',','.'):'-'; ?></div>
				</div>
				
				<div class="form_row">
					<label><b>FRANQUIA MONOCROMÁTICA:</b></label>
					<div style="width: 400px;"><?php echo $res->franquia_monocromatica!=''?number_format($res->franquia_monocromatica,0,'','.'):0; ?></div>
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label><b>VALOR DA CÓPIA ADICIONAL (P&B):</b></label>
					<div style="width: 150px;"><?php echo $res->adicional_monocromatica!=''?'R$ '.number_format($res->adicional_monocromatica,4,',','.'):'-'; ?></div>
				</div>

				<div class="clear"></div>
				
				<div class="form_row">
					<label><b>VALOR COLOR:</b></label>
					<div style="width: 400px;"><?php echo $res->valor_colorida!=''?'R$ '.number_format($res->valor_colorida,4,',','.'):'-'; ?></div>
				</div>
				
				<div class="form_row">
					<label><b>FRANQUIA COLOR:</b></label>
					<div style="width: 400px;"><?php echo $res->franquia_colorida!=''?number_format($res->franquia_colorida,0,'','.'):0; ?></div>
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label><b>VALOR DA CÓPIA ADICIONAL (COLOR):</b></label>
					<div style="width: 150px;"><?php echo $res->adicional_colorida!=''?'R$ '.number_format($res->adicional_colorida,4,',','.'):'-'; ?></div>
				</div>

				<?php 
				
				// Verifica se existem contatos registrados
				if ($res->ContratoEquipamento->count() > 0){
					$res->ContratoEquipamento->toArray();	
				
				?>
					<h4>Equipamentos</h4>
					<hr />
				<?php 
				
					// Cria as informações para cada Contato
					foreach ($res->ContratoEquipamento as $value){

				?>
					
					<div class="form_row">
						<label><b>TIPO:</b></label>
						<div style="width: 250px;"><?php echo $value['Equipamento']['EquipamentoTipo']['nome']; ?></div>
					</div>
					
					<div class="form_row">
						<label><b>MARCA:</b></label>
						<div style="width: 250px;"><?php echo $value['Equipamento']['Marca']['nome']; ?></div>
					</div>
					
					<div class="form_row">
						<label><b>MODELO:</b></label>
						<div style="width: 250px;"><?php echo $value['Equipamento']['EquipamentoModelo']['nome']; ?></div>
					</div>
					
					<div class="form_row">
						<label><b>SÉRIE:</b></label>
						<div style="width: 250px;"><?php echo $value['Equipamento']['serial']; ?></div>
					</div>
					
					<div class="clear"></div>
				
				<?php 
					}
				}?>
				
			
				<div class="clear"></div><br />
				
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