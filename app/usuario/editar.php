<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Usuário - Editar</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php 

			try {
				
				// Seleciona os dados do usuário
				$res = Doctrine_Core::getTable('Usuario')->find($_GET['id']);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				<div class="form_row">
					<label>Grupo de Usuário:</label>
					<select name="usuario_grupo_id" id="usuario_grupo_id" class="select validate[required]" style="width: 628px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resGrupo = Doctrine_Query::create()->select()->from('UsuarioGrupo')->orderBy('nome ASC')->execute();
							
							if ($resGrupo->count() > 0){
								$resGrupo->toArray();
								
								foreach ($resGrupo as $value){
									$selected = $value['id']==$res->usuario_grupo_id?' selected="selected"':'';
									echo '<option value="'.$value['id'].'"'.$selected.'>'.$value['nome'].'</option>';
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
				
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Nome:</label>
					<input type="text" name="nome" id="nome" class="input validate[required,maxSize[100]]" style="width: 300px;" value="<?php echo $res->nome; ?>" />
				</div>
				<!-- 
				<div class="form_row">
					<label>E-mail:</label>
					<input type="text" name="email" id="email" class="input validate[required,custom[email],maxSize[100]]" style="width: 300px;" value="<?php echo $res->email; ?>" />
				</div>
				 -->
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Nome de Exibição:</label>
					<input type="text" name="apelido" id="apelido" class="input validate[required,maxSize[20]]" style="width: 300px;" value="<?php echo $res->apelido; ?>" />
				</div>
				
				<div class="form_row">
					<label>Login:</label>
					<input type="text" name="login" id="login" class="input validate[required,maxSize[20],custom[onlyLetterNumber]]" style="width: 300px;" value="<?php echo $res->login; ?>" />
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Senha (Deixe em branco se não quiser alterar):</label>
					<input type="password" name="senha" id="senha" class="input validate[minSize[4]]" style="width: 300px;" />
				</div>
				
				<div class="form_row radioui">
					<label>Status:</label>
					<div class="clear"></div>
					<?php 
					
					$s0 = $res->status==0?'checked="checked"':'';
					$s1 = $res->status==1?'checked="checked"':'';
					
					?>
					<input type="radio" id="status1" name="status" value="1" class="input validate[required]" <?php echo $s1; ?>><label for="status1">Ativo</label>
					<input type="radio" id="status0" name="status" value="0" class="input validate[required]"  <?php echo $s0; ?>><label for="status0">Inativo</label>
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