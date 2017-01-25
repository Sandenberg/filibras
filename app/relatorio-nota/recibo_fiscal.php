<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Contrato - Enviar recibo</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<?php 
			$res = Doctrine_Core::getTable('Nota')->find($_GET['id']); 

			$objConfiguracao = Doctrine_Core::getTable('Configuracao')->find(1); 
			
			
			
		?>
		<div class="block_cont">
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil" target='_blank' enctype="multipart/form-data">
				
				<div class="form_row">
					<label>Fatura de Locação:</label>
					<input type="text" name="fatura" id="fatura" class="input validate[required]" style="width: 139px;" value="<?php echo $res->fatura ?>" />
				</div>
				<div class="form_row">
					<label>Data:</label>
					<input type="text" name="data" id="data" class="input validate[required]" style="width: 139px;" value="<?php echo date('d/m/Y') ?>" />
				</div>
				<div class="form_row">
					<label>Email:</label>
					<input type="text" name="email" id="email" class="input validate[required]" style="width: 453px;" value="<?php echo $res->email1 ?>" />
				</div>
				<div class="form_row">
					<label>Email CC:</label>
					<input type="text" name="email2" id="email2" class="input" style="width: 453px;" value="<?php echo $res->email2 ?>" />
				</div>
				<div class="clear"></div>
				<div class="form_row">
					<label>Observacao:</label>
					<textarea name="observacao" id="observacao" class="input" style="width: 453px; height: 100px;" value="" /><?php echo $res->observacao ?></textarea>
				</div>
				<div class="clear"></div>

				<div class="form_row"><h4></h4></div>
				<div class="form_row"><input type="button" class="submit" id='item_add' name="acao" value="Adicionar Item" /></div>
				<div id='itens'>
					
					<?php foreach ($res->NotaItem as $objItem) { ?>
						<div class="form_row" style="margin-right: 10px;">
		                    <label>Descrição:</label>
		                    <input type="text" name="descricao[]" id="variacao_estoque" class="input" value="<?php echo $objItem->descricao ?>" />
		                </div>
		                <div class="form_row" style="margin-right: 10px;">
		                    <label>Quantidade:</label>
		                    <input type="text" name="quantidade[]" id="variacao_nome" style="width: 60px" class="input" value="<?php echo $objItem->quantidade ?>" />
		                </div>
		                <div class="form_row" style="margin-right: 10px;">
		                    <label>Valor:</label>
		                    <input type="text" name="valor[]" id="variacao_nome" style="width: 80px" class="input valor" value="<?php echo $objItem->valor ?>"/>
		                </div>
						<div class="clear"></div>
					<?php } ?>
				</div>
				<div class="clear"></div><br />
				
				<div class="form_row">
					<label>Boleto 1:</label>
					<input type="file" name="boleto1" id="boleto1" class="" style="width: 453px;" />
				</div>
				<div class="clear"></div>

				<div class="form_row">
					<label>Boleto 2:</label>
					<input type="file" name="boleto2" id="boleto2" class="" style="width: 453px;" />
				</div>
				<div class="clear"></div>

				<div class="form_row">
					<label>Boleto 3:</label>
					<input type="file" name="boleto3" id="boleto3" class="" style="width: 453px;" />
				</div>
				<div class="clear"></div><br />
				<input type="hidden" name="nota_id" value="<?php echo $res->id; ?>" />
				<input type="hidden" name="id" value="<?php echo $res->contrato_id; ?>" />
				<div class="form_row"><input type="submit" class="submit" name="acao" value="Enviar para o Cliente" id='salvar' /></div>
				<div class="form_row"><input type="submit" class="submit" name="acao" value="Salvar" id='salvar' /></div>
				<div class="form_row"><input type="submit" class="submit" name="acao" value="Visualizar" /></div>
				<div class="form_row"><input type="button" class="submit" name="acao" value="Voltar" onclick="history.go(-1);" /></div>
				
			</form>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->
<script type="text/javascript">
	
        $('#item_add').click(function(){

            $('#itens').append(''+
                '<div class="row">'+
                // '<div class="form_row" style="margin-right: 20px;">'+
                // '    <label>Codigo:</label>'+
                // '    <input type="text" name="codigo[]" id="variacao_nome" style="width: 80px" class="input"/>'+
                // '</div>'+
                '<div class="form_row" style="margin-right: 10px;">'+
                '    <label>Descrição:</label>'+
                '    <input type="text" name="descricao[]" id="variacao_estoque" class="input"/>'+
                '</div>'+
                // '<div class="form_row" style="margin-right: 10px;">'+
                // '    <label>Unidade:</label>'+
                // '    <input type="text" name="unidade[]" id="variacao_nome" style="width: 40px" class="input"/>'+
                // '</div>'+
                '<div class="form_row" style="margin-right: 10px;">'+
                '    <label>Quantidade:</label>'+
                '    <input type="text" name="quantidade[]" id="variacao_nome" style="width: 60px" class="input"/>'+
                '</div>'+
                '<div class="form_row" style="margin-right: 10px;">'+
                '    <label>Valor:</label>'+
                '    <input type="text" name="valor[]" id="variacao_nome" style="width: 80px" class="input valor"/>'+
                '</div>'
                // '<div class="form_row">'+
                // '    <label>Valor Total:</label>'+
                // '    <input type="text" name="valor_total[]" id="variacao_valor" style="width: 80px" class="input valor"/>'+
                // '</div></div>'
            );

            // $('.variacao_estoque').mask('9?99999');
            // $(".valor").unbind().maskMoney({showSymbol: false, decimal: ".", thousands:"", precision: 2, allowZero: true});
        });

</script>