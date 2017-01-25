<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Entrada no Estoque - Detalhes</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('Entrada')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				<div class="form_row">
					<label>Descrição:</label>
					<input type="text" name="descricao" disabled id="descricao" class="input validate[required,maxSize[60]]" style="width: 380px;" value="<?php echo $res->descricao; ?>" />
				</div>
				<div class="form_row">
					<label>NF:</label>
					<input type="text" name="nf" disabled id="nf" class="input validate[]" style="width: 100px;" value="<?php echo $res->nf; ?>" />
				</div>

				<?php
					foreach ($res->EntradaMaterial as $objEntradaMaterial) {
						?>
		            		<p><span id="IL_AD1" class="IL_AD"><b>Material:</b>  <input type ="text" name ="material[]" value="<?php echo $objEntradaMaterial->Material->nome ?>"><b>Quantidade:</b> <input type ="text" name="quantidade[]" id="quantidade" value="<?php echo $objEntradaMaterial->quantidade ?>"><b><b>Valor:</b> <input type ="text" name="valor[]" id="valor" value="<?php echo $objEntradaMaterial->valor ?>"><b></span> </p>

						<?php
					}

				?>
				
				<div class="clear"></div><br />
				
				<input type="hidden" name="id" value="<?php echo $res->id; ?>" />
				<div class="form_row"><input type="button" onclick="history.go(-1)" class="submit" value="Voltar" /></div>
				
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