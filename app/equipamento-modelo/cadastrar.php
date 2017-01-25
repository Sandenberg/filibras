<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Modelo do Equipamento - Cadastrar</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form">
				<div class="form_row">
					<label>Modelo do Equipamento:</label>
					<input type="text" name="nome" id="nome" class="input validate[required,maxSize[60]]" style="width: 300px;" />
				</div>
								
				<div class="clear"></div>

				<div class="form_row">
					<label>Marca:</label>
					<select name="marca_id" id="marca_id" class="select validate[required]" style="width: 457px;">
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
								echo '<option value="">Nenhum registro encontrado.</option>';
							}
						
						} catch (Exception $e){
							echo '<option value="">Ocorreu um erro de sistema</option>';
						}
						
						
						?>
					</select>
				</div>	

				<div class="clear"></div>

				<div class="form_row">
					<label>Tipo:</label>
					<select name="equipamento_tipo_id" id="equipamento_tipo_id" class="select" style="width: 457px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resMarca = Doctrine_Query::create()->select()->from('EquipamentoTipo')->orderBy('nome ASC')->execute();
							
							if ($resMarca->count() > 0){
								$resMarca->toArray();
								
								foreach ($resMarca as $value){
									echo '<option value="'.$value['id'].'">'.$value['nome'].'</option>';
								}
								
							} else {
								echo '<option value="">Nenhum registro encontrado.</option>';
							}
						
						} catch (Exception $e){
							echo '<option value="">Ocorreu um erro de sistema</option>';
						}
						
						
						?>
					</select>
				</div>
				
				<div class="clear"></div>
								
				<div class="form_row">
					<label>Procedimento Numerador:</label> 
					<textarea name="procedimento" id="procedimento" class="input" style="width: 457px; height: 100px" rows=5></textarea>
				</div>
			
				
				<div class="clear"></div><br />
				
				<div class="form_row"><input type="submit" class="submit" value="Salvar" /></div>
			</form>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->