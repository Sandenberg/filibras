<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block small"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Meu cadastro</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont" style="height: 320px;">
			<?php 

			try {
				
				// Seleciona os dados do usuário
				$res = Doctrine_Core::getTable('Usuario')->find($_SESSION['sess_usuario_id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/cadastro/'; ?>" method="POST" id="formPerfil">
				<div class="form_row">
					<label>Nome:</label>
					<input type="text" name="nome" id="nome" class="input validate[required,maxSize[100]]" style="width: 380px;" value="<?php echo $res->nome; ?>" />
				</div>
				<div class="form_row">
					<label>Email:</label>
					<input type="text" name="email" id="email" class="input validate[required,custom[email],maxSize[100]]" style="width: 380px;" value="<?php echo $res->email; ?>" />
				</div>
				<div class="form_row">
					<label>Apelido:</label>
					<input type="text" name="apelido" id="apelido" class="input validate[required,maxSize[20]]" style="width: 258px;" value="<?php echo $res->apelido; ?>" />
				</div>
				<div class="form_row">
					<label>Data de Nascimento:</label>
					<input type="text" name="nascimento" id="nascimento" class="input validate[custom[dateBR]]" style="width: 105px;" value="<?php echo $res->nascimento!=''?date('d/m/Y',strtotime($res->nascimento)):''; ?>" />
				</div>
				<div class="form_row">
					<label>Sexo:</label>
					<select name="sexo" id="sexo" class="select" style="width: 225px;">
						<option value="">Selecione</option>
						<option value="1" <?php echo $res->sexo=='1'?' selected="selected"':''; ?>>Masculino</option>
						<option value="0" <?php echo $res->sexo=='0'?' selected="selected"':''; ?>>Feminino</option>
					</select>
				</div>
				<div class="form_row">
					<label>Login:</label>
					<input type="text" name="login" id="login" class="input validate[required,maxSize[30],custom[onlyLetterNumber]]" style="width: 150px;" value="<?php echo $res->login; ?>" />
				</div>
				
				<div class="clear"></div><br />
				<div class="clear"></div><br />
				
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
	<div class="block small"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Minha Foto</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont" style="height: 320px;">
			<?php

			try {
				
				// Seleciona os dados do usuário
				$res = Doctrine_Core::getTable('Usuario')->find($_SESSION['sess_usuario_id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/foto/'; ?>" method="POST" id="formAvatar" enctype="multipart/form-data">
				<?php 
				
				if ($res->avatar != ''){
					echo '<img src="'.URL_USUARIO.$res->avatar.'" width="48" height="48" title="Imagem atual" alt="Imagem atual" />';	
				} else {
					echo '<img src="'.URL_USUARIO.'default.png" width="48" height="48" title="Imagem padrão" alt="Imagem padrão" />';	
				}
				
				?>
				<div class="clear"></div><br />
				<div class="clear"></div><br />
				
				<div class="form_row">
					<label>Nova foto:</label>
					<input type="file" name="avatar" id="avatar" class="input validate[required]" style="width: 380px;" />
				</div>
				
				<div class="clear"></div><br />
				<div class="clear"></div><br />
				
				<p>Nesta ferramenta você deverá publicar uma foto ou imagem que será utilizada para representá-lo no sistema.</p>
				<div class="clear"></div><br />
				<p>Recomendamos o uso de imagens quadradas com dimensões iguais ou pouco superiores a 48 x 48 pixels, no formato JPG, PNG ou GIF.</p>
				
				<div class="clear"></div><br />
				<div class="clear"></div><br />
				
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
	<div class="block small"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Minha senha</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont" style="height: 320px;">
			<?php 

			try {
				
				// Seleciona os dados do usuário
				$res = Doctrine_Core::getTable('Usuario')->find($_SESSION['sess_usuario_id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/senha/'; ?>" method="POST" id="formSenha">
				<div class="form_row">
					<label>Senha atual:</label>
					<input type="password" name="senha_atual" id="senha_atual" class="input validate[required]" style="width: 380px;" />
				</div>
				<div class="form_row">
					<label>Nova senha:</label>
					<input type="password" name="senha_nova" id="senha_nova" class="input validate[required]" style="width: 380px;" />
				</div>
				<div class="form_row">
					<label>Confirmação da nova senha:</label>
					<input type="password" name="senha_confirmacao" id="senha_confirmacao" class="input validate[required,equals[senha_nova]]" style="width: 380px;" />
				</div>
				
				<p><b>Dicas para criar uma senha segura:</b><br />
				1. Misture letras, símbolos especiais e números.<br />
				2. Use letras maiúsculas e minúsculas.<br />
				3. Use uma quantidade superior a 8 caracteres.</p>
				
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