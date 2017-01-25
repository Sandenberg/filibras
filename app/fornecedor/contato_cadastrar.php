<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<?php 
		
		try {
			
			// Seleciona o registro
			$obj = Doctrine_Core::getTable('Fornecedor')->find($_GET['id']);
			$res = 'Fornecedor - '.$obj->nome_completo.' - Contato - Cadastrar';
			
		} catch (Exception $e){
			
			$res = 	'Ocorreu um erro de sistema!';
			echo 	'<h1>Ocorreu um erro de sistema!</h1>';
			
		}
		
		?>
		<div class="titlebar">
			<h3><?php echo $res; ?></h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form">
			
				<div class="form_row">
					<label>Nome:</label>
					<input type="text" name="nome" id="nome" class="input validate[required,maxSize[60]]" style="width: 500px;" />
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>E-mail:</label>
					<input type="text" name="email" id="email" class="input validate[maxSize[100],custom[email]]" style="width: 270px;" />
				</div>
				
				<div class="form_row">
					<label>Telefone:</label>
					<input type="text" name="telefone" id="telefone" class="input" style="width: 130px;" />
				</div>
				
				<div class="form_row">
					<label>Ramal:</label>
					<input type="text" name="ramal" id="ramal" class="input validate[maxSize[4],custom[onlyNumberSp]]" style="width: 65px;" />
				</div>
				
				<div class="clear"></div><br />
				
				<input type="hidden" name="fornecedor_id" value="<?php echo $_GET['id']; ?>" />
				<div class="form_row"><input type="submit" class="submit" value="Salvar" /></div>
			</form>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->