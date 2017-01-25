<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!');


?>
<div id="body">
	<div class="block big">
		<!-- Block Begin -->
		<div class="titlebar">
			<h3>Ordem de Serviço - Cadastrar</h3>
			<!-- Open Dialog Modal -->
			<div class="hide">
				<div id="dialog" title="Filibras"></div>
			</div>
			<!-- /Open Dialog Modal -->
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form">
				
				<div class="form_row radioui">
					<label>Tipo de Ordem de Serviço:</label><br /> 
					<input type="radio" id="tipo_ordemserv0" name="tipo_ordemserv" value="0" class="validate[required]" /><label for="tipo_ordemserv0">Manutenção no Equipamento</label>
					<input type="radio" id="tipo_ordemserv1" name="tipo_ordemserv" value="1" class="validate[required]" /><label for="tipo_ordemserv1">Troca de Cilindro/Toner</label>
					<input type="radio" id="tipo_ordemserv2" name="tipo_ordemserv" value="2" class="validate[required]" /><label for="tipo_ordemserv2">Leitura de Numerador</label>
					<input type="radio" id="tipo_ordemserv3" name="tipo_ordemserv" value="3" class="validate[required]" /><label for="tipo_ordemserv3">Instalação de Equipamento</label>
                    <input type="radio" id="tipo_ordemserv5" name="tipo_ordemserv" value="5" class="validate[required]" /><label for="tipo_ordemserv5">Retirada de Equipamento</label>
                    <input type="radio" id="tipo_ordemserv6" name="tipo_ordemserv" value="6" class="validate[required]" /><label for="tipo_ordemserv6">Manutenção Preventiva</label><br>
                    <input type="radio" id="tipo_ordemserv7" name="tipo_ordemserv" value="7" class="validate[required]" /><label for="tipo_ordemserv7">Serviços de Informática</label>
				</div>
				<div class="clear"></div>
				<div class="form_row">
					<label>Cliente:</label>
					<select name="cliente_id" id="cliente_id" class="select validate[required]" style="width: 615px;">
						<option value="">Selecione</option>
						<?php 
						try {
							$resCliente = Doctrine_Query::create()->select()->from('Cliente')->orderBy('nome_completo ASC')->execute();
							
							if ($resCliente->count() > 0){
								$resCliente->toArray();
								
								foreach ($resCliente as $value){
                                                                    $resFilial = Doctrine_Core::getTable('Filial')->find($value['filial_id']);
                                                                    $filial = "";
                                                                    if($resFilial->nome != "Sem Filial")
                                                                    	$filial = "- ".$resFilial->nome;

                                                                    $id = $value['id'];
                                                                    $nome = $value['nome_completo'];

									echo "<option value=$id>$nome $filial</option>";
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

                <div class="form_row radioui">
                    <input type="radio" id="tipo_cliente0" name="tipo_cliente" value="0" class="validate[required]"  /><label for="tipo_cliente0">Locação</label>
                    <input type="radio" id="tipo_cliente1" name="tipo_cliente" value="1" class="validate[required]" /><label for="tipo_cliente1">Venda</label>
					<input type="radio" id="tipo_cliente3" name="tipo_cliente" value="3" class="validate[required]" /><label for="tipo_cliente3">Contrato de Manutenção</label>
				    <input type="radio" id="tipo_cliente4" name="tipo_cliente" value="4" class="validate[required]" /><label for="tipo_cliente4">Diversos</label>  
				</div>
             <span class="equipamento">

				<div class="clear"></div>
				<div class="form_row">
					<label>Equipamento:</label>

					<select name="equipamento_id" id="equipamento_id" class="select " style="width: 600px;">
						<option value="">Selecione um Cliente</option>
					</select>
					
				</div>
				
				<div class="form_row">
					<!-- <label>Localização:</label> -->
					<input type="hidden" name="loc" id="loc" class="input " style="width: 177px;" />
				</div>


                <div class="form_row">
                    <!-- <label>Serial:</label> -->
                    <input type="hidden" name="serial" id="serial" class="input " style="width: 177px;" />
                </div>
		          <div class="clear"></div>
		          
		     </span>
		<span>
               <div class="clear"></div>
				<div class="form_row defeito">
					<label>Defeito:</label>
					<select name="defeito_id" id="defeito_id" class="select " style="width: 350px;">
						<option value="">Selecione um Defeito</option>
						<?php 
						
						try {
						
							$resUF = Doctrine_Query::create()->select()->from('Condicao')->orderBy('nome')->execute();
							
							if ($resUF->count() > 0){
								$resUF->toArray();
								
								foreach ($resUF as $value){
									echo '<option value="'.$value['id'].'">'.$value['nome'].'</option>';
								}
								
							} else {
								echo '<option value="">Nenhum registro encontrado</option>';
							}
						
						} catch (Exception $e){
							echo '<option value="">Ocorreu um erro de sistema</option>';
						}
						
						?>
					</select> 
				</div>
                      <div class="form_row">
                      </div>

                  <span class="numerador">
				   <div class="clear"></div>
					<div class="form_row">
                        <label>Numerador:</label>
                        <input type="text" name="numerador" id="numerador" class="input" style="width: 200px;" />
                    </div>
                     <div class="form_row">
                          <input type="button" id="addmanutecao" name="addmanutencao" class="submit" value="Adicionar" />
                          <input type="button" id="addnumerador" name="addnumerador" class="submit" value="Adicionar" />
                     </div>
				</span>

                    <div class="clear"></div>
					<div class="form_row defeito">
                        <label>Solicitante/Observação:</label>
                        <input type="text" name="solicitantedef" id="solicitante" class="input validate[required]" style="width: 500px;" />
                    </div>
        </span>


				
              
			<div class="clear"></div>
		       <span class="troca">
				<div class="form_row">
					<label>Quant Cilindro:</label> 
					<input type="text" name="quant_c" id="quan_c" class="input" value='0'style="width: 70px;" />
				</div>
				<div class="form_row">
					<label>Cilindro</label>
					<select name="cilindro_id" id="cilindro_id" class="select " style="width: 250px;">
						<option value="">Selecione</option>
						<?php 
						
						try {
						
							$resUF = Doctrine_Query::create()->select()->from('Material')->where('tipo = 2')->execute();
							
								if ($resUF->count() > 0){
									$resUF->toArray();
									
									foreach ($resUF as $value){
										echo '<option value="'.$value['id'].'">'.$value['nome'].'</option>';
									}
									
								} else {
									echo '<option value="">Nenhum registro encontrado</option>';
								}
						
						} catch (Exception $e){
							echo '<option value="">Ocorreu um erro de sistema</option>';
						}
						
						?>
					</select>
				</div>
				
					<div class="form_row">
					<label>Quant Toner:</label> 
					<input type="text" name="quant_t" id="quant_t" value="0" class="input" style="width: 70px;" />
				</div>
					
				<div class="form_row">
					<label>Toner</label>
					<select name="toner_id" id="toner_id" class="select " style="width: 250px;">
						<option value="">Selecione</option>
						<?php 
						
						try {
						
							$resUF = Doctrine_Query::create()->select()->from('Material')->where('tipo = 3')->execute();
							
								if ($resUF->count() > 0){
									$resUF->toArray();
									
									foreach ($resUF as $value){
										echo '<option value="'.$value['id'].'">'.$value['nome'].'</option>';
									}
									
								} else {
									echo '<option value="">Nenhum registro encontrado</option>';
								}
						
						} catch (Exception $e){
							echo '<option value="">Ocorreu um erro de sistema</option>';
						}
						
						?>
					</select> 
				</div>

                    <div class="form_row">
                        <input type="button" id="addtoner" name="addtoner" class="submit" value="Adicionar" />
                    </div>

                           <div class="clear"></div>
					<div class="form_row">
                        <label>Solicitante/Observação:</label>
                        <input type="text" name="solicitantetoner" id="solicitante" class="input validate[required]" style="width: 500px;" />
                    </div>
				
				</span>
				

                <span class="diversos">
				   <div class="clear"></div>
					<div class="form_row">
                        <label>Cartuchos Reservas:</label>
                        <input type="text" name="reserva" id="reserva" class="input" style="width: 200px;" />
                    </div>

                     <div class="form_row">
                         <input type="button" id="adddiversos" name="adddiversos" class="submit" value="Adicionar" />
                     </div>

                     <div class="clear"></div>
					<div class="form_row">
                        <label>Solicitante/Observação:</label>
                        <input type="text" name="solicitantediver" id="solicitante" class="input validate[required]" style="width: 500px;" />
                    </div>
				</span>

                <span class="informatica">
                  	<div class="clear"></div>
						<div class="form_row">
	                        <label>Solicitante/Observação:</label>
	                        <input type="text" name="solicitanteinfo" id="solicitante" class="input validate[required]" style="width: 500px;" />
	                    </div>
                     	<div class="clear"></div>
						<div class="form_row">
	                        <label>Problema:</label>
	                        <input type="text" name="problemainfo" id="problemainfo" class="input validate[required]" style="width: 500px;" />
	                    </div>

                    </span>
                <div id="addinput">

                    <p>

                    </p>

                </div>
			
				<div class="clear"></div>
				<div class="form_row">
					<input type="submit" class="submit" value="Salvar" />
				</div>
			</form>
		</div>
	</div>
	<!-- Block End -->
</div>
<!-- Body Wrapper End -->

<!-- DIALOG MASK LOAD -->
<div style="display: none;">
	<div id="dialog-modal" title="<?php echo TITLE_DEFAULT; ?>">
		<p>Verificando e carregando informações...</p>
	</div>
</div>



<script type="text/javascript">

    $(function() {
        var addDiv = $('#addinput');
        var i = $('#addinput p').size() + 1;

        $('#addmanutecao').live('click', function() {
            var equipamento = $('#equipamento_id option:selected').text();
            var equipamento_nome = $('#equipamento_id option:selected').attr('nome');
            var equipamento_id = $('#equipamento_id option:selected').val();
            var localizacao = $('#loc').val();
            var serial = $('#serial').val();
            var defeito =  $('#defeito_id option:selected').text();
            var defeito_id =  $('#defeito_id option:selected').val();
            var numerador = $('#numerador').val();

            // alert(equipamento);

            $('<p><span id="IL_AD1" class="IL_AD"><b>Equipamento:</b>  <input type="hidden" name="equipamento_id_array[]" id="equipamento_id_array[]" value="'+ equipamento_id +'"> <input type ="text" name ="equipamento_aray[]" id="'+ equipamento_id +'" value="'+ equipamento_nome +'"><b>Localização:</b> <input type ="text" name="localizacao_array[]" id="localizacao_array" value="'+localizacao+'"><b>Serial:</b> <input type ="text" name="serial_array[]" id="serial_array" value="'+serial+'"><b>  <b>Numerador:</b> <input type ="text" name="numerador_array[]" id="numerador_array" value="'+numerador+'"><b> <input type="hidden" name="defeito_id_array[]" id="defeito_id_array[]" value="'+defeito_id+'"> Defeito:</b><input type ="text" name ="defeito_aray[]" id="'+defeito_id +'" value="'+defeito+'">  <a href="#" src="" id="remNew">Remove</a> </span> </p>').appendTo(addDiv);

            i++;

            return false;
        });


        $('#addtoner').live('click', function() {

            var equipamento = $('#equipamento_id option:selected').text();
            var equipamento_nome = $('#equipamento_id option:selected').attr('nome');
            var equipamento_id = $('#equipamento_id option:selected').val();
            var localizacao = $('#loc').val();
            var serial = $('#serial').val();
            var quant_cilindro =  $('#quan_c').val();
            var cilindro =  $('#cilindro_id option:selected').text();
            var id_cilindro =  $('#cilindro_id option:selected').val();
            var quant_toner =  $('#quant_t').val();
            var toner =  $('#toner_id option:selected').text();
            var id_toner =  $('#toner_id option:selected').val();


            $('<p><span id="" class=""><b>Equipamento:</b>  <input type="hidden" name="equipamento_id_array[]" id="equipamento_id_array[]" value="'+ equipamento_id +'"> <input type ="text" name ="equipamento_aray[]" id="'+ equipamento_id +'" value="'+ equipamento_nome +'"><b>Localização:</b> <input type ="text" name="localizacao_array[]" id="localizacao_array" value="'+localizacao+'"><b>Serial:</b> <input type ="text" name="serial_array[]" id="serial_array" value="'+serial+'"> <b>Quant Cilindro:</b> <input type ="text" name="quant_cilindro_array[]" style="width: 70px;" id="quant_cilindro_array" value="'+quant_cilindro+'"><b> <input type="hidden" name="cilindro_id_array[]" id="cilindro_id_array[]" value="'+id_cilindro+'"> Cilindro:</b><input type ="text" name ="cilindro_array[]" id="'+id_cilindro +'" value="'+cilindro+'"> <b>Quant Toner:</b> <input type ="text" style="width: 70px;" name="quant_toner_array[]" id="quant_toner_array" value="'+quant_toner+'"><b> <input type="hidden" name="toner_id_array[]" id="toner_id_array[]" value="'+id_toner+'"> <b>Toner:</b><input type ="text" name ="toner_array[]" id="'+id_toner +'" value="'+toner+'"><a href="#" src="" id="remNew">Remove</a> </span> </p>').appendTo(addDiv);

            i++;

            return false;
        });



        $('#addnumerador').live('click', function() {
            var equipamento = $('#equipamento_id option:selected').text();
            var equipamento_nome = $('#equipamento_id option:selected').attr('nome');
            var equipamento_id = $('#equipamento_id option:selected').val();
            var serial = $('#serial').val();
            var localizacao = $('#loc').val();
            var numerador = $('#numerador').val();

            // alert(equipamento);

            $('<p><span id="IL_AD1" class="IL_AD"><b>Equipamento:</b>  <input type="hidden" name="equipamento_id_array[]" id="equipamento_id_array[]" value="'+ equipamento_id +'"> <input type ="text" name ="equipamento_aray[]" id="'+ equipamento_id +'" value="'+ equipamento_nome +'"><b>Localização:</b> <input type ="text" name="localizacao_array[]" id="localizacao_array" value="'+localizacao+'"><b>Serial:</b> <input type ="text" name="serial_array[]" id="serial_array" value="'+serial+'"><b> <b>Numerador:</b> <input type ="text" name="numerador_array[]" id="numerador_array" value="'+numerador+'"><b> <a href="#" src="" id="remNew">Remove</a> </span> </p>').appendTo(addDiv);

            i++;

            return false;
        });

        $('#adddiversos').live('click', function() {
            var equipamento = $('#equipamento_id option:selected').text();
            var equipamento_nome = $('#equipamento_id option:selected').attr('nome');
            var equipamento_id = $('#equipamento_id option:selected').val();
            var serial = $('#serial').val();
            var localizacao = $('#loc').val();
            var reserva = $('#reserva').val();

            // alert(equipamento);

            $('<p><span id="IL_AD1" class="IL_AD"><b>Equipamento:</b>  <input type="hidden" name="equipamento_id_array[]" id="equipamento_id_array[]" value="'+ equipamento_id +'"> <input type ="text" name ="equipamento_aray[]" id="'+ equipamento_id +'" value="'+ equipamento_nome +'"><b>Localização:</b> <input type ="text" name="localizacao_array[]" id="localizacao_array" value="'+localizacao+'"><b>Serial:</b> <input type ="text" name="serial_array[]" id="serial_array" value="'+serial+'"><b> <b>Cartuchos Reservas:</b> <input type ="text" name="reserva_array[]" id="reserva_array" value="'+reserva+'"><b> <a href="#" src="" id="remNew">Remove</a> </span> </p>').appendTo(addDiv);

            i++;

            return false;
        });




        $('#remNew').live('click', function() {
            if( i > 2 ) {
                $(this).parents('p').remove();
                i--;
            }
            return false;
        });
    });

</script>


