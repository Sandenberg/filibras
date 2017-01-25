<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big">
		<!-- Block Begin -->
		<style type="text/css">
			.ui-multiselect-filter input{
				background: #fff;
			}
			.ui-multiselect-filter{
				margin-top: 8px;
			}
		</style>
		<script type="text/javascript" src='<?php URL ?>js/jquery.multiselect.filter.js'></script>
		<script type="text/javascript" src='<?php URL ?>css/jquery.multiselect.filter.css'></script>
		<div class="titlebar">
			<h3>Cliente - Editar</h3>
			<!-- Open Dialog Modal -->
			<div class="hide">
				<div id="dialog" title="Filibras"></div>
			</div>
			<!-- /Open Dialog Modal -->
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		
		<div class="block_cont">
		
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form">
				
			<?php
			
			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable ( 'OrdemServico' )->find ( $_GET ['id'] );

                $resUser = Doctrine_Core::getTable ( 'Usuario' )->find ($_SESSION['sess_usuario_id'] );


				
				?>
			<div class="form_row">
					<label><b>NÚMERO:</b></label>
					<div style="width: 400px;"><?php echo $res->id; ?></div>
				</div>
				
				<div class="form_row">
					<label><b>TIPO:</b></label>
					<?php 

					$tipo = $res->tipo_ordem;
					$tipo = $tipo==0?'Manutenção no Equipamento':$tipo;
					$tipo = $tipo==1?'Troca de Cilindro/Toner':$tipo;
					$tipo = $tipo==2?'Leitura de Numerador':$tipo;					
					$tipo = $tipo==3?'Instalação de Equipamento':$tipo;
                    $tipo = $tipo==4?'Troca de Equipamento':$tipo;
                    $tipo = $tipo==5?'Retirada de Equipamento':$tipo;
                    $tipo = $tipo==6?'Manutenção Preventiva':$tipo;
                    $tipo = $tipo==7?'Serviços de Informática':$tipo;
                    $tipo = $tipo==8?'Acesso Remoto':$tipo;
                    $tipo = $tipo==9?'Atendimento Avulso':$tipo;
					
					?>
					<div style="width: 200px;"><?php echo $tipo; ?></div>
				</div>
				
				<div class="clear"></div>
			
				<div class="form_row">
					<label><b>CLIENTE:</b></label>
					<div style="width: 600px;"><?php echo $res->Cliente->nome_completo; ?></div>
				</div>

                <div class="form_row">
                    <label><b>RESPONSAVEL:</b></label>
                    <div style="width: 600px;"><?php echo $resUser->nome; ?></div>
                </div>
				<div class="clear"></div>
				<?php if($res->tipo_ordem==1){ ?>
							<hr>
				<?php 
					$resMan = Doctrine_Core::getTable('OrdemServToner')->findBy('id_ordem_servico', $_GET['id']);
							
			
					foreach ($resMan as $key => $objEquipamento) {
						?>
							<div class="form_row">
								<label>Equipamento: <?php echo $objEquipamento->Equipamento->EquipamentoModelo->Marca->nome.' - '.$objEquipamento->Equipamento->EquipamentoModelo->nome.' ('.$objEquipamento->serial.')'; ?>:</label>
								<input name="idOrdemServToner[]" id="idOrdemServToner[]" value="<?php echo $objEquipamento->id ?>" type="hidden">
							</div>
							<!-- <div class="clear"></div> -->
							<?php 

								$where2 = "(m.tipo = 2 or m.tipo = 3)";
								// $where2 = "(m.tipo = 2 or m.tipo = 3) and me.equipamento_id = '".$objEquipamento->Equipamento->EquipamentoModelo->id."'";
								$retEquipamento	= Doctrine_Query::create()->select()->from('MaterialEquipamento me')
														->leftJoin('me.Material m')
														->where($where2)->execute();

								if($retEquipamento->count()){

									$objCilindro = Doctrine_Core::getTable('Material')->find($objEquipamento->cilindro_id);
									$objToner = Doctrine_Core::getTable('Material')->find($objEquipamento->toner_id);
									?>
										
      
										<div class="clear"></div>
									       <span class="troca">
											<div class="form_row">
												<label>Quant Cilindro:</label> 
												<input type="hidden" name="idToner[]" class="input" value='<?php echo $objEquipamento->id ?>' />
												<input type="text" name="quant_c[]" id="quan_c" class="input" value='<?php echo $objEquipamento->quant_cilindro ?>' style="width: 70px;" />
											</div>
											<div class="form_row">
												<label>Cilindro</label>
												<input type="text" value="<?php echo isset($objCilindro->nome)&&$objCilindro->nome!=''?$objCilindro->nome:"NÃO INFORMADO" ?>" style="width: 250px;" class='input' disabled="">
											</div>
											
												<div class="form_row">
												<label>Quant Toner:</label> 
												<input type="text" name="quant_t[]" id="quant_t" value="<?php echo $objEquipamento->quant_toner ?>" class="input" style="width: 70px;" />
											</div>
												
											<div class="form_row">
												<label>Toner</label>
												<input type="text" value="<?php echo isset($objToner->nome)&&$objToner->nome!=''?$objToner->nome:"NÃO INFORMADO" ?>" style="width: 250px;" class='input' disabled="">
											</div>
									<?php
								}
							?>
							<hr>
							<div class="clear"></div>
						<?php
					}

				?>

                <div class="form_row">
                    <label><b>Entregue:</b></label>
                    <label style="display: inline-block;"><input type='radio' name="entregue" class="validate[required]" value="0">Não</label>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <label style="display: inline-block;"><input type='radio' name="entregue" class="validate[required]" value="1">Sim</label>
                </div>
				<div class="clear"></div>

				<?php } ?>

				<?php if($res->tipo_ordem !=6&&$res->tipo_ordem !=0&&$res->tipo_ordem !=8&&$res->tipo_ordem !=2){ ?>

				<div class="form_row">
					<label>Breve Descrição:</label>
					<textarea name="descricao" id="descricao" class="textarea" maxlength='65' style="width: 500px; text-transform: uppercase;" rows="2" ></textarea>
				</div>
					<?php 

						if($res->tipo_ordem == 3){

							$resOrdemServInst = Doctrine_Core::getTable('OrdemServInstalacao')->findBy('id_ordem_servico', $_GET['id']);
										
							foreach ($resOrdemServInst as $objOrdemServInst) {
								?>
									
									<?php 
										try {

										// $where2 = "m.tipo = 4";
										$resEquip = Doctrine_Core::getTable('Equipamento')->findOneBy('serial', $objOrdemServInst->serial);

										$where2 = "m.tipo = 3 and me.equipamento_id = '".$resEquip->EquipamentoModelo->id."'";
										$retEquipamento2	= Doctrine_Query::create()->select()->from('MaterialEquipamento me')
																->leftJoin('me.Material m')
																->where($where2)->orderBy('m.nome asc')->execute();
												
											if($retEquipamento2->count()){
												?>
													<div class="clear"></div>
													<div class="form_row">
														<label>Cartucho Reserva (<?php echo $objOrdemServInst->serial ?>):</label>
														<select name="material_id[]" id='material_id<?php echo $_GET['id'] ?>' style="width: 500px;" class='select'>
															<?php
																foreach ($retEquipamento2 as $objEquipamento2) {
																	?><option value="<?php echo $resEquip->id.'-'.$objEquipamento2->Material->id ?>"><?php echo $objEquipamento2->Material->nome ?></option><?php
																}
															?>
														</select>
													</div>
													<div class="form_row">
														<label>Quantidade:</label>
														<input type="text" class='input' name='quantidade[]' value="<?php echo $objOrdemServInst->cart_reserva ?>">
													</div>
												<?php
											}

										} catch (Exception $e) {
											echo $e;	
										}
									?>
								<?php
							}

						}
					?>

				<div class="clear"></div>
				<br />
				<?php 
					} else { 

						/* TROCA DE CILINDRO E TONNER */
						if($res->tipo_ordem == 6){
							$where = "c.cliente_id = ".$res->Cliente->id;
			
							// Buscas (Geral e Paginada)
							$retEquipamento	= Doctrine_Query::create()->select()->from('ContratoEquipamento co')
													->leftJoin('co.Contrato c')->leftJoin("co.Equipamento e")
													->leftJoin("e.EquipamentoModelo em")->leftJoin("em.Marca m")
													->where($where)->execute();
			
							foreach ($retEquipamento as $key => $objEquipamento) {
								?>
									<div class="form_row">
										<label><?php echo $objEquipamento->Equipamento->EquipamentoModelo->Marca->nome.' - '.$objEquipamento->Equipamento->EquipamentoModelo->nome.' ('.$objEquipamento->Equipamento->serial.')'; ?>:</label>
										<input name="IdEquip[]" id="IdEquip[]" value="<?php echo $objEquipamento->Equipamento->id ?>" type="hidden">
										<textarea name="descricaoEquip[]" id="descricaoEquip[]" class="textarea" maxlength='65' style="width: 500px; text-transform: uppercase;" rows="2" ></textarea>
									</div>
									<?php 

										// $where2 = "m.tipo = 4";
										$where2 = "(m.tipo = 4 or m.cobranca = 1) and me.equipamento_id = '".$objEquipamento->Equipamento->EquipamentoModelo->id."'";
										$retEquipamento2	= Doctrine_Query::create()->select()->from('MaterialEquipamento me')
																->leftJoin('me.Material m')
																->where($where2)->orderBy('m.nome asc')->groupBy('m.id')->execute();

										if($retEquipamento2->count()){
											?>
												<div class="form_row">
													<label>Peças Trocadas:</label>
													<select name="material_id[]" id='material_id<?php echo $objEquipamento->Equipamento ?>' multiple style="width: 500px;" class="material">
														<?php
															foreach ($retEquipamento2 as $objEquipamento2) {
																?><option value="<?php echo $objEquipamento->Equipamento->id.'-'.$objEquipamento2->material_id ?>"><?php echo $objEquipamento2->Material->nome ?></option><?php
															}
														?>
													</select>
													<br><br>
												</div>
											<?php
										}
									?>
									<div class="clear"></div>
								<?php
							}
						}else if($res->tipo_ordem == 0){

							$resMan = Doctrine_Core::getTable('OrdemServManutencao')->findBy('id_ordem_servico', $_GET['id']);
							$whereAdd = array();
							foreach ($resMan as $objMan) {
								$whereAdd[] = "e.serial = '".$objMan->serial."'";
							}
							$where = implode(' or ', $whereAdd);

							// echo $where;
			
							// Buscas (Geral e Paginada)
							$retEquipamento	= Doctrine_Query::create()->select()->from("Equipamento e")
													->leftJoin("e.EquipamentoModelo em")->leftJoin("em.Marca m")
													->where($where)->execute();
			
							foreach ($retEquipamento as $key => $objEquipamento) {
								?>
									<div class="form_row">
										<label><?php echo $objEquipamento->EquipamentoModelo->Marca->nome.' - '.$objEquipamento->EquipamentoModelo->nome.' ('.$objEquipamento->serial.')'; ?>:</label>
										<input name="IdEquip[]" id="IdEquip[]" value="<?php echo $objEquipamento->id ?>" type="hidden">
										<textarea name="descricaoEquip[]" id="descricaoEquip[]" class="textarea" maxlength='65' style="width: 500px; text-transform: uppercase;" rows="2" ></textarea>
									</div>

									<?php 

										// $where2 = "m.tipo = 4";
										$where2 = "(m.tipo = 4 or m.cobranca = 1) and me.equipamento_id = '".$objEquipamento->EquipamentoModelo->id."'";
										$retEquipamento2	= Doctrine_Query::create()->select()->from('MaterialEquipamento me')
																->leftJoin('me.Material m')
																->where($where2)->orderBy('m.nome asc')->groupBy('m.id')->execute();

										if($retEquipamento2->count()){
											?>
												<div class="form_row">
													<label>Peças Trocadas:</label>
													<select name="material_id[]" id='material_id<?php echo $objEquipamento->id ?>' multiple style="width: 500px;" class="material">														<?php
															foreach ($retEquipamento2 as $objEquipamento2) {
																?><option value="<?php echo $objEquipamento->id.'-'.$objEquipamento2->material_id ?>"><?php echo $objEquipamento2->Material->nome ?></option><?php
															}
														?>
													</select>
													<br><br>
												</div>
											<?php
										}
									?>
									<div class="clear"></div>
								<?php
							}

						}else if($res->tipo_ordem == 8){

							$resMan = Doctrine_Core::getTable('OrdemServAcessoremoto')->findBy('id_ordem_servico', $_GET['id']);
							$whereAdd = array();
							foreach ($resMan as $objMan) {
								$whereAdd[] = "e.serial = '".$objMan->serial."'";
							}
							$where = implode(' or ', $whereAdd);
			
							// Buscas (Geral e Paginada)
							$retEquipamento	= Doctrine_Query::create()->select()->from("Equipamento e")
													->leftJoin("e.EquipamentoModelo em")->leftJoin("em.Marca m")
													->where($where)->execute();
			
							foreach ($retEquipamento as $key => $objEquipamento) {
								?>
									<div class="form_row">
										<label><?php echo $objEquipamento->EquipamentoModelo->Marca->nome.' - '.$objEquipamento->EquipamentoModelo->nome.' ('.$objEquipamento->serial.')'; ?>:</label>
										<input name="IdEquip[]" id="IdEquip[]" value="<?php echo $objEquipamento->id ?>" type="hidden">
										<textarea name="descricaoEquip[]" id="descricaoEquip[]" class="textarea" maxlength='65' style="width: 500px; text-transform: uppercase;" rows="2" ></textarea>
									</div>
									<div class="clear"></div>
								<?php
							}

						}
					} 
				?>

				<div class="form_row">
					<input type="hidden" name="id" value="<?php echo $res->id; ?>" />
					<input type="hidden" name="id_cliente" value="<?php echo $res->Cliente->id; ?>" />
					<input type="submit" class="submit" value="Finalizar" />
				</div>
			</form>
			<?php
			} catch ( Exception $e ) {
				echo 'Ocorreu um erro!' . $e;
			}
			
			unset ( $res );
			
			?>
		</div>
	</div>
	<!-- Block End -->
</div>
<!-- Body Wrapper End -->

<!-- DIALOG MASK LOAD -->
<div style="display: none;">
	<div id="dialog-modal" title="<?php echo TITLE_DEFAULT; ?>">
		<p>Verificando e carregando informações...</p>
	</div>
</div>

<script type="text/javascript">
	$('.material').multiselect().multiselectfilter();
</script>
<script>
	
	$(document).ready(function(){
	    $("#form").submit(function(e){
	        e.preventDefault();

			if (confirm('Você é realmente <?php echo $_SESSION['sess_usuario_nome'] ?>?')){
				$("#form").unbind().submit();
				return true;
			} else {
				location.href = URL_ADMIN+"logout/";
				return false;
			}

	    });
    });

</script>