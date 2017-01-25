<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>

<div id="body">

	<div class="block big"><!-- Block Begin -->

		<div class="titlebar">

			<h3>Entrada no Estoque - Cadastrar</h3>

			<a href="#" class="toggle">&nbsp;</a>

		</div>

		<div class="block_cont">

			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form">

				<div class="form_row">

					<label>Descricao:</label>

					<input type="text" name="descricao" id="descricao" value='ENTRADA DE PRODUTO' class="input validate[required,maxSize[60]]" style="width: 380px; font-weight: bold" />

				</div>

				<div class="form_row">

					<label>NF:</label>

					<input type="text" name="nf" id="nf" value='' class="input validate[]" style="width: 100px; font-weight: bold" />

				</div>

							

				<div class="clear"></div>

				<h1>Materiais</h1>

				<div class="clear"></div>

				<?php 



					$where = "1=1";

					// $where2 = "(m.tipo = 4 or m.cobranca = 1) and me.equipamento_id = '".$objEquipamento->EquipamentoModelo->id."'";

					$retMaterial	= Doctrine_Query::create()->select()->from('Material m')

											->where($where)->orderBy('m.nome asc')->groupBy('m.id')->execute();



					if($retMaterial->count()){

						?>

							<div class="form_row">

								<label>Material:</label>

								<select name="material" id='material' style="width: 250px;" class="select">														

									<option value=""></option>

									<?php

										foreach ($retMaterial as $objMaterial) {

											?><option value="<?php echo $objMaterial->id ?>"><?php echo $objMaterial->nome ?></option><?php

										}

									?>

								</select>

							</div>

						<?php

					}

				?>
				<div class="clear"></div>

				
			

				<div class="form_row">

					<label>Quantidade:</label>

					<input type="text" name="qtd" id="qtd" class="input validate[required,maxSize[60]]" style="width: 80px;" value="0" />

				</div>

				<div class="form_row">

					<label>Valor:</label>

					<input type="text" name="val" id="val" class="input validate[required,maxSize[60]]" style="width: 80px;" value="0" />

				</div>

				<div class="form_row"><input type="button" class="submit" id='addMaterial' value="Adicionar" /></div>

				<div class="clear"></div><br />

						

                <div id="addinput">



                    <p>



                    </p>



                </div>
                <h1>Fornecedor</h1>

				<div class="clear"></div>

				<?php 



					$where = "1=1";

					// $where2 = "(m.tipo = 4 or m.cobranca = 1) and me.equipamento_id = '".$objEquipamento->EquipamentoModelo->id."'";

					$retFornecedor	= Doctrine_Query::create()->select()->from('Fornecedor f')

											->where($where)->orderBy('f.nome_completo asc')->groupBy('f.id')->execute();



					if($retFornecedor->count()){

						?>

							<div class="form_row">

								<label>Fornecedor:</label>

								<select name="fornecedor" id='fornecedor' style="width: 250px;" class="select">														

									<option value=""></option>

									<?php

										foreach ($retFornecedor as $objFornecedor) {

											?><option value="<?php echo $objFornecedor->id ?>"><?php echo $objFornecedor->nome_completo ?></option><?php

										}

									?>

								</select>

							</div>

						<?php

					}

				?>


				<div class="clear"></div><br />

				<input type="hidden" name="numMaterial" id="numMaterial" value="0">

				

				<div class="form_row"><input type="submit" class="submit" value="Salvar" /></div>

			</form>

		</div>

	</div><!-- Block End -->

</div><!-- Body Wrapper End -->

<script type="text/javascript">

	

		$("#val").maskMoney({showSymbol: false, decimal: ".", thousands:"", precision: 2, allowZero: true});

        var addDiv = $('#addinput');

        var i = 0;

        $('#addMaterial').live('click', function() {

        	if($('#material').val()==''||$('#material').val()=='undefined'){

				alert("Adicione um equipamento!");

        	}

        	else{

	            var material = $('#material option:selected').text();

	            var material_id = $('#material option:selected').val();

	            var quantidade = $('#qtd').val();

	            var valor = $('#val').val();



	            // alert(equipamento);



	            $('<p><span id="IL_AD1" class="IL_AD"><b>Material:</b>  <input type="hidden" name="material_id[]" id="material_id[]" value="'+ material_id +'"> <input type ="text" name ="material[]" id="'+ material +'" value="'+ material +'"><b>Quantidade:</b> <input type ="text" name="quantidade[]" id="quantidade" value="'+quantidade+'"><b>Valor:</b> <input type ="text" name="valor[]" id="valor" value="'+valor+'"><b> <a href="#" src="" class="remNew">Remove</a> </span> </p>').appendTo(addDiv);



	            i++;

				$('#numMaterial').val(1);



				$("#material").val('');

				$("#qtd").val('0');

				$("#val").val('0.00');



		        $('.remNew').click(function(){

		        	$(this).parent().parent().parent().remove();

		        });



	            return false;

	        }

        });





        $('.form').submit(function(e){

        	e.preventDefault();

        	if($('#numMaterial').val()==0){

        		alert('Adicione um material!');

        	}else{

        		if($('.form').validationEngine('validate')){

        			$(this).unbind().submit();

        		}

        	}

        })

</script>