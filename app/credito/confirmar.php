<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Lançamento - Crédito - Confirmar</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('Lancamento')->find($_GET['id']);
				$res->data_vencimento = isset($res->data_vencimento)&&$res->data_vencimento!='1969-12-31'&&$res->data_vencimento!='0000-00-00'?date("d/m/Y", strtotime($res->data_vencimento)):null;

				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				
				<div class="form_row">
					<label>Baixa:</label>
					<input type="text" name="baixa" id="baixa" class="input validate[required,maxSize[60],custom[dateBR]]" style="width: 102px;" value="<?php echo date('d/m/Y'); ?>" />
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