<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Peça e Material - Editar</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
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
		<div class="block_cont">
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('Material')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				
				<div class="form_row radioui">
					<label>Tipo de Material:</label>
					<div class="clear"></div>
					<?php 
					
					$s0 = $res->tipo==0?'checked="checked"':'';
					$s1 = $res->tipo==1?'checked="checked"':'';
					$s2 = $res->tipo==2?'checked="checked"':'';
					$s3 = $res->tipo==3?'checked="checked"':'';
					$s4 = $res->cobranca==1?'checked="checked"':'';
					
					?>
					<input type="radio" id="tipo1" name="tipo" value="1" class="input" <?php echo $s1; ?>><label for="tipo1">Peça de Reposição</label>
					<!-- <input type="radio" id="tipo0" name="tipo" value="0" class="input"  <?php echo $s0; ?>><label for="tipo0">Material de Consumo</label> -->
					<input type="radio" id="tipo2" name="tipo" value="2" class="input"  <?php echo $s2; ?>><label for="tipo0">Cilindro</label>
					<input type="radio" id="tipo3" name="tipo" value="3" class="input"  <?php echo $s3; ?>><label for="tipo0">Toner</label>
					<input type="checkbox" id="cobranca" name="cobranca" value="1" class="input"  <?php echo $s4; ?>><label for="cobranca">Cobrança</label>
				</div>
				
				<div class="form_row">
					<label>Valor:</label>
					<input type="text" name="valor" id="valor" class="input validate[maxSize[10,2]]" style="width: 120px;" value="<?php echo $res->valor!=''?number_format($res->valor,2,',','.'):0; ?>" />
				</div>
				<?php if($_SESSION['sess_usuario_grupo_id']==1){ ?>
				<div class="form_row"><input type="button" class="submit" value="Desmarcar opções" id='decheck' /></div>
				<?php } ?>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Peça e Material:</label>
					<input type="text" name="nome" id="nome" class="input validate[required,maxSize[60]]" style="width: 385px;" value="<?php echo $res->nome; ?>" />
				</div>
				
				<div class="form_row">
					<label>Estoque Mínimo:</label>
					<input type="text" name="minimo" id="minimo" class="input validate[required,maxSize[60]]" style="width: 185px;" value="<?php echo $res->minimo; ?>" />
				</div>

				<div class="form_row">
					<label>Estoque:</label>
					<input type="text" name="estoque" id="estoque" class="input validate[required,maxSize[60]]" style="width: 185px;" value="<?php echo $res->estoque; ?>" />
				</div>
				
				<div class="clear"></div>

				
				<div class="form_row">

					<label>Localização:</label>

					<input type="text" name="localizacao" id="localizacao" class="input" style="width: 612px;" value="<?php echo $res->localizacao; ?>" >

				
					<label>Equipamento:</label>
					<select name="equipamento_id[]" id="equipamento_id" class="select2 validate[required]" style="width: 612px;" multiple="multiple">
						<?php 
						
						try {
							$equipamentos = array();
							$resMaterial = Doctrine_Query::create()->select()->from('MaterialEquipamento')->where('material_id = '.$_GET['id'])->execute();
							if ($resMaterial->count() > 0){
								foreach ($resMaterial as $value) {
									$equipamentos[] = $value->equipamento_id;
								}
							}

							$resEquipamento =	Doctrine_Query::create()->select()->from('EquipamentoModelo em')
												->leftJoin('em.Marca m')->orderBy('m.nome ASC, em.nome ASC')->execute();
							
							if ($resEquipamento->count() > 0){
								$resEquipamento->toArray();
								
								foreach ($resEquipamento as $value){
									$selected = in_array($value['id'], $equipamentos)?' selected="selected"':'';
									echo '<option value="'.$value['id'].'" '.$selected.'>'.$value->Marca->nome.' => '.$value->nome.'</option>';
								}
								
							} else {
								echo '<option value="">Nenhum modelo disponível</option>';
							}
						
						} catch (Exception $e){
							echo $e->getMessage();
							echo '<option value="">Ocorreu um erro de sistema</option>';
						}
						
						
						?>
					</select>
				
				
				<div class="clear"></div>
				<br />
				
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
			<script type="text/javascript">
				$('#equipamento_id').multiselect().multiselectfilter();
				$("#decheck").click(function(){
					$('input[name^=tipo]').each(function(){
						$(this).attr('checked', false);
					});
				});
			</script>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->