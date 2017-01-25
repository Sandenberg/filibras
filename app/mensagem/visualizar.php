<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Mensagem - Visualizar</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php 

			try {
				
				// Seleciona os dados
				$res = Doctrine_Core::getTable('Mensagem')->find($_GET['id']);
				if($res->lida==0&&$res->recebida_por==$_SESSION['sess_usuario_id']){
					$res->status 		= 1;
					$res->lida 			= 1;
					$res->data_lida		= date('Y-m-d H:i:s');
					$res->save();
				}
				$res2 = Doctrine_Core::getTable('Usuario')->find($res->enviada_por);
					
				?>
				<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
					<div class="form_row">
						<label>Enviada Por:</label>
						<input type="text" disabled name="titulo" id="titulo" class="input validate[required,maxSize[60]]" style="width: 200px;" value="<?php echo $res2->nome; ?>" />
					</div>
					<div class="form_row">
						<label>Titulo:</label>
						<input type="text" disabled name="titulo" id="titulo" class="input validate[required,maxSize[60]]" style="width: 350px;" value="<?php echo $res->titulo; ?>" />
					</div>
					<div class="clear"></div><br />
					
					<div class="form_row">
						<label>Mensagem:</label>
						<textarea type="text" disabled name="texto" cols="80" rows='6' style='height: 150px;' id="texto" class="input"><?php echo $res->texto; ?></textarea>
					</div>
					
					<div class="clear"></div><br />
					
					<input type="hidden" name="id" value="<?php echo $res->id; ?>" />
					<?php 
						if($res->status!=2){
							?>
								<div class="form_row"><input type="submit" class="submit" value="Finalizado" /></div>

								<script type="text/javascript">
									$('a').click(function(e){
										e.preventDefault();
										alert("Você deve finalizar esta mensagem!");
									})
								</script>
							<?php
						}else{
							?>
								<div class="form_row"><input type="button" onclick="history.go(-1)" class="submit" value="Voltar" /></div>
							<?php 
						}
					?>
					
					
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