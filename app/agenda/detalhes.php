<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<?php
		try {
				
			// Seleciona os dados do usuário
			$res = Doctrine_Core::getTable('Agenda')->find($_GET['id']);
				
		} catch (Exception $e){
		
		}
		
	
		
		
		?>
		<div class="titlebar">
			<h3>Cliente - <?php echo $res->nome_completo; ?> - Detalhes</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php 

			try {
				
				// Seleciona os dados do usuário
				$res = Doctrine_Core::getTable('Agenda')->find($_GET['id']);
            	$res->telefone_principal = strlen($res->telefone_principal)==10?Util::mask('(##)####-####', $res->telefone_principal):Util::mask('(##)#####-####', $res->telefone_principal);  
            	$res->telefone_alternativo = strlen($res->telefone_alternativo)==10?Util::mask('(##)####-####', $res->telefone_alternativo):Util::mask('(##)#####-####', $res->telefone_alternativo);  
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				<h4>Dados</h4>
				<hr />
				
				<div class="form_row">
					<label><b>TIPO DE PESSOA:</b></label>
					<div style="width: 270px;"><?php echo $res->tipo_pessoa==0?'Física':'Jurídica'; ?></div>
				</div>
				
				<div class="clear"></div>
							
				<div class="form_row">
					<label><b>NOME COMPLETO:</b></label>
					<div style="width: 600px;"><?php echo $res->nome_completo; ?></div>
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label><b><?php echo $res->tipo_pessoa==0?'CPF':'CNPJ'; ?>:</b></label>
					<?php 
						$cpf 	= $res->cpf!=''?Util::mask('###.###.###-##', $res->cpf):'-';
						$cnpj 	= $res->cnpj!=''?Util::mask('##.###.###/####-##', $res->cnpj):'-';
					?>
					<div style="width: 270px;"><?php echo $res->tipo_pessoa==0?$cpf:$cnpj; ?></div>
				</div>
				

				<div class="clear"></div>
				
				<div class="form_row">
					<label><b>EMAIL:</b></label>
					<div style="width: 270px;"><?php echo $res->email!=''?$res->email:'-'; ?></div>
				</div>
				
				<div class="form_row">
					<label><b>TELEFONE PRINCIPAL:</b></label>
					<div style="width: 270px;"><?php echo $res->telefone_principal; ?></div>
				</div>
				
				<div class="form_row">
					<label><b>TELEFONE ALTERNATIVO:</b></label>
					<div style="width: 270px;"><?php echo $res->telefone_alternativo; ?></div>
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label><b>LOGRADOURO:</b></label>
					<div style="width: 270px;"><?php echo $res->logradouro; ?></div>
				</div>
				
				<div class="form_row">
					<label><b>NÚMERO:</b></label>
					<div style="width: 270px;"><?php echo $res->numero!=''?number_format($res->numero, 0, '.', '.'):'S/N'; ?></div>
				</div>
				
				<div class="form_row">
					<label><b>COMPLEMENTO:</b></label>
					<div style="width: 270px;"><?php echo $res->complemento!=''?$res->complemento:'-'; ?></div>
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label><b>BAIRRO:</b></label>
					<div style="width: 270px;"><?php echo $res->bairro; ?></div>
				</div>
				
				<div class="form_row">
					<label><b>REFERÊNCIA:</b></label>
					<div style="width: 270px;"><?php echo $res->referencia!=''?$res->referencia:'-'; ?></div>
				</div>
				
				<div class="form_row">
					<label><b>CEP:</b></label>
					<div style="width: 270px;"><?php echo Util::mask('#####-###', $res->cep); ?></div>
				</div>

				<div class="clear"></div>
				
				<div class="form_row">
					<label><b>CIDADE:</b></label>
					<div style="width: 270px;"><?php echo $res->Cidade->nome!=''?$res->Cidade->nome:'-'; ?></div>
				</div>
				
				<div class="form_row">
					<label><b>ESTADO:</b></label>
					<div style="width: 270px;"><?php echo $res->Cidade->Uf->nome!=''?$res->Cidade->Uf->nome:'-'; ?></div>
				</div>
				
				<div class="clear"></div>
				

				
				<div class="clear"></div>
				
				<div class="form_row">
					<label><b>OBSERVAÇÕES:</b></label>
					<div style="width: 270px;"><?php echo $res->obs!=''?$res->obs:'-'; ?></div>
				</div>
			

			
				<div class="clear"></div><br />
				
			</form>
			<?php 
			
			} catch (Exception $e){
				echo "Ocorreu um erro!.'$e'";
			}
			
			unset($res);
			
			?>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->