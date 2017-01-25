<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big">
		<!-- Block Begin -->
		<div class="titlebar">
			<h3>Funcionario - Cadastrar</h3>
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
					<label>Ativo:</label><br /> 
					<input type="checkbox" id="ativo" name="ativo" value="1"  /><label for="ativo">Inativo</label>
				
				</div>
				<div class="clear"></div>
						
				<div class="form_row">
					<label><span class="fisica">Nome Completo:</span><span class="juridica">Razão Social:</span></label> 
					<input type="text" name="nome_completo" id="nome_completo" class="input " style="width: 400px;" />
				</div>
				
				<div class="form_row">
					<label>E-mail:</label> 
					<input type="text" name="email" id="email" class="input validate[maxSize[100],custom[email]]" style="width: 313px;" />
				</div>

				<div class="clear"></div>
				
			
					<div class="form_row">
						<label>CPF:</label> 
						<input type="text" name="cpf" id="cpf" class="input " style="width: 177px;" />
					</div>
					
				
				
				<div class="form_row">
					<label>Tel Principal:</label> 
					<input type="text" name="telefone_principal"	id="telefone_principal" class="input" style="width: 155px;" />
				</div>

				<div class="form_row">
					<label>Tel Alternativo:</label>
					<input type="text" name="telefone_alternativo" id="telefone_alternativo" class="input" style="width: 155px;" />
				</div>
				
				<div class="form_row">
					<label>CEP:</label>
					<input type="text" name="cep" id="cep" class="input" style="width: 155px;" />
				</div>
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Logradouro:</label>
					<input type="text" name="logradouro" id="logradouro" class="input validate[maxSize[150]]" style="width: 270px;" />
				</div>
				
				<div class="form_row">
					<label>Número:</label>
					<input type="text" name="numero" id="numero" class="input" style="width: 60px;" />
				</div>

				<div class="form_row">
					<label>Complemento:</label>
					<input type="text" name="complemento" id="complemento" class="input validate[maxSize[30]]" style="width: 133px;" />
				</div>
				
				<div class="form_row">
					<label>Referência:</label>
					<input type="text" name="referencia" id="referencia" class="input validate[maxSize[100]]" style="width: 220px;" />
				</div>				

				<div class="clear"></div>
				
				<div class="form_row">
					<label>Bairro:</label>
					<input type="text" name="bairro" id="bairro" class="input validate[maxSize[150]]" style="width: 260px;" />
				</div>
				
				<div class="form_row">
					<label>Estado:</label>
					<select name="uf_id" id="uf_id" class="select validate[required]" style="width: 80px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resUF = Doctrine_Query::create()->select()->from('Uf')->orderBy('sigla ASC')->execute();
							
							if ($resUF->count() > 0){
								$resUF->toArray();
								
								foreach ($resUF as $value){
									echo '<option value="'.$value['id'].'">'.$value['sigla'].'</option>';
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
					<label>Cidade:</label>
					<select name="cidade_id" id="cidade_id" class="select validate[required]" style="width: 300px;">
						<option value="">Selecione um estado</option>
					</select>
				</div>
				
		
				
				<div class="clear"></div>
				
				<div class="form_row">
					<label>Observações Gerais:</label>
					<textarea name="observacoes" id="observacoes" class="textarea" style="width: 730px;" rows="6" ></textarea>
				</div>
				
				<div class="clear"></div><br />

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
	$("#cep").change(function(){
      // Se o campo CEP não estiver vazio
        if($.trim($("#cep").val()) != ""){
          /* 
              Para conectar no serviço e executar o json, precisamos usar a função
              getScript do jQuery, o getScript e o dataType:"jsonp" conseguem fazer o cross-domain, os outros
              dataTypes não possibilitam esta interação entre domínios diferentes
              Estou chamando a url do serviço passando o parâmetro "formato=javascript" e o CEP digitado no formulário
              http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val()
          */
          $.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val(), function(){
              // o getScript dá um eval no script, então é só ler!
              //Se o resultado for igual a 1
                if(resultadoCEP["resultado"]){

                    $("#carregando").css('display', '');

                    var uf = resultadoCEP["uf"];
                    uf = uf.replace(' ', '');

                    var cidade = unescape(resultadoCEP["cidade"]);
                    console.log(cidade);
                  // troca o valor dos elementos
                  // ID do campo da rua
                  $("#logradouro").val(unescape(resultadoCEP["tipo_logradouro"])+" "+unescape(resultadoCEP["logradouro"]));
                  // ID do campo do bairro
                  $("#bairro").val(unescape(resultadoCEP["bairro"]));
                  // ID do campo do estado
                  // $('#estado').find('option[text="'+uf+'"]').attr('selected', 'selected');
                  // console.log("'"+uf+"'");
                    $('#uf_id option:contains(' + uf + ')').each(function(){
                        if ($(this).text() == uf) {
                            $(this).attr('selected', 'selected');
                            uf_id = $(this).val();
                            // return false;
                        }
                        // return true;
                        $("#uf_id").val(uf_id);
                    });
                    // $("#uf_id").selectpicker('refresh');

                    $("select[name=cidade_id]").html('<option value="">Carregando...</option>');

                    $.when( $.getJSON("<?php echo URL_ADMIN ?>getCidades.php",{uf_id: uf_id}, function(j){
                        var options = '<option value="">Selecione</option>';    
                        for (var i = 0; i < j.length; i++){

                            options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
                            
                        }   
                        $("#cidade_id").html(options);
                    })).done(function() {
                        $('#cidade_id option:contains(' + cidade + ')').each(function(){
                            if ($(this).text() == cidade) {
                                $(this).attr('selected', 'selected');
                                cidade_id = $(this).val();
                                // return false;
                            }
                            // return true;
                        });


                        

                        $("#carregando").css('display', 'none');
                    });
                    
                    // alert("ae");
                    

                    $('#numero').focus();
                    
                  // ID do campo da Cidade
                  // $("#cidade").val(unescape(resultadoCEP["cidade"]));
              }else{
                  alert("Endereço não encontrado");
              }
          });                
      }               
    });
</script>