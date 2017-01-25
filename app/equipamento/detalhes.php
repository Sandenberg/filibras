<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Equipamento - Editar</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php 

			try {
				
				// Seleciona os dados do usuário
				$res = Doctrine_Core::getTable('Equipamento')->find($_GET['id']);
				if(isset($res->formecedor_id)&&$res->formecedor_id>0)
					$resFornecedor = Doctrine_Core::getTable('Fornecedor')->find($res->formecedor_id);
				
			?>
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
				<?php 
					
					$t0 = $res->tipo_impressao==0?'Monocromática':"";
					$t0 = $res->tipo_impressao==1?'Colorida':$t0;
					$t0 = $res->tipo_impressao==2?'Não se aplica':$t0;
					
					?>
				<div class="form_row radioui">
					<label style='font-weight: 600'>Tipo Impressão:</label><br /> 
					<?php echo $t0 ?>
				</div>
				
				<hr>
				<div class="clear"></div>
				
				<div class="form_row">
					<label style='font-weight: 600'>Número de Série:</label> 
					<?php echo $res->serial; ?>
				</div>
				
				<div class="form_row" style='margin-left: 30px;'>
					<label style='font-weight: 600'>Patrimônio:</label> 
					<?php echo $res->patrimonio; ?>
				</div>
				
				<div class="clear"></div>
			
				<div class="form_row">
					<label style='font-weight: 600'>Marca:</label>
					<?php echo $res->Marca->nome ?>
				</div>
				
				<div class="form_row" style='margin-left: 30px;'>
					<label style='font-weight: 600'>Tipo de Equipamento:</label>
					<?php echo $res->EquipamentoTipo->nome ?>
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label style='font-weight: 600'>Modelo de Equipamento:</label>
					<?php echo $res->EquipamentoModelo->nome ?>
				</div>
				
				<div class="form_row" style='margin-left: 30px;'>
					<label style='font-weight: 600'>Situação do Equipamento:</label>
					<?php echo $res->EquipamentoSituacao->nome ?>
				</div>
				
				<div class="clear"></div>

				<?php if(isset($res->formecedor_id)&&$res->formecedor_id!=''){ ?>
				<div class="form_row">
					<label style='font-weight: 600'>Fornecedor:</label>
					<?php echo $resFornecedor->nome ?>
				</div>
				<?php } ?>
				
				<hr>
				<div class="form_row">
					<label style='font-weight: 600'>Data da Compra:</label> 
					<?php echo isset($res->data_compra)&&$res->data_compra!=''&&$res->data_compra!='0000-00-00'?date('d/m/Y', strtotime($res->data_compra)):''; ?>
				</div>
				<div class="form_row" style='margin-left: 30px;'>
					<label style='font-weight: 600'>NF da Compra:</label> 
					<?php echo $res->nf_compra; ?>
				</div>
				
				<div class="clear"></div>
								
				<div class="form_row">
					<label style='font-weight: 600'>Procedimento:</label> 
					<?php echo nl2br($res->procedimento); ?>
				</div>
			
				<div class="clear"></div>
				
				<div class="form_row radioui">
					<label style='font-weight: 600'>Status:</label>
					<div class="clear"></div>
					<?php 
					
						$s0 = $res->status==0?'Locação':'';
						$s0 = $res->status==1?'Vendido':$s0;
						$s0 = $res->status==2?'Equipamento do cliente':$s0;
						$s0 = $res->status==3?'Estoque':$s0;
						echo $s0;
					
					?>
					
				</div>
				
				<div class="clear"></div><br />
				
				<input type="hidden" name="id" value="<?php echo $res->id; ?>" />
				<button type="button" class='submit' onclick='history.go(-1)'>Voltar</button>
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