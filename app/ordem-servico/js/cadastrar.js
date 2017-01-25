$(document).ready(function(){
	
	// Mascaras
	$("#data_nascimento").mask("99/99/9999");
	$("#telefone_principal").mask("(99)9999-9999");
	$("#telefone_alternativo").mask("(99)9999-9999");
	$("#cpf").mask("999.999.999-99");
	$("#cnpj").mask("99.999.999/9999-99");
	$("#cep").mask("99999-999");
	$("#numero").maskMoney({showSymbol: false, precision: 0, thousands:"."});
	
	
	// Click Tipo Pessoa Fisica
	$( "#tipo_ordemserv0" ).click(function() {
		
		//Mostra o formulario cadastro pessoa fisica
		$(".fisica").css("display","inline");
		$(".juridica").css("display","none");

		// Reseta os valores dos campos CNPJ
		$("#cnpj").val("");
		$("#inscricao_estadual").val("");
		$("#inscricao_municipal").val("");
		
	});
	
	
	// Click Tipo Pessoa Juridica
	$( "#tipo_ordemserv1" ).click(function() {
		
		//Mostra o formulario cadastro pessoa fisica
		$('.juridica').css('display','inline');
		$('.fisica').css('display','none');
		
		// Reseta os valores dos campos CPF 
		$("#cpf").val("");
		$("#rg").val("");
		
	});
	
	
	$( "#tipo_ordemserv2" ).click(function() {
			
			//Mostra o formulario cadastro pessoa fisica
			$('.juridica').css('display','inline');
			$('.fisica').css('display','none');
			
			// Reseta os valores dos campos CPF 
			$("#cpf").val("");
			$("#rg").val("");
			
		});
	
	
	$( "#tipo_ordemserv3" ).click(function() {
		
		//Mostra o formulario cadastro pessoa fisica
		$('.juridica').css('display','inline');
		$('.fisica').css('display','none');
		
		// Reseta os valores dos campos CPF 
		$("#cpf").val("");
		$("#rg").val("");
		
	});

	var vr;


	// Abre a lista de cidade de acordo com o estado
	$(function(){
		$("#cliente_id").change(function(event) {
			$("#equipamento_id").html("<option value=''>Selecione um Cliente</option>");
			$("#addinput").html("");
		});
		$('#btnBuscar').click(function(){

				
			if($("#cliente_id option:selected").val()){
				$.getJSON(URL_ADMIN+"getTipoContrato.php",{cliente_id: $("#cliente_id option:selected").val()}, function(j){
					if(j[0].tipo == 1){
						$('#tipo_cliente0').prop('checked', false);
						$('#tipo_cliente1').prop('checked', true);
						$('#tipo_cliente3').prop('checked', false);
						$('#tipo_cliente4').prop('checked', false);

					}else if(j[0].tipo == 2){

					}else if(j[0].tipo == 3){
						$('#tipo_cliente0').prop('checked', false);
						$('#tipo_cliente1').prop('checked', false);
						$('#tipo_cliente3').prop('checked', true);
						$('#tipo_cliente4').prop('checked', false);
					}else if(j[0].tipo == 4){
						$('#tipo_cliente0').prop('checked', false);
						$('#tipo_cliente1').prop('checked', false);
						$('#tipo_cliente3').prop('checked', false);
						$('#tipo_cliente4').prop('checked', true);

						// $('select[name=cilindro_id]').html('<option value="">Carregando...</option>');
						// $.getJSON(URL_ADMIN+"getMaterial.php?tipo=2", function(j){
						// 	var options = '<option value="">Selecione</option>';	
						// 	var vlocal = "";
						// 	for (var i = 0; i < j.length; i++){
						// 		options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						// 	}	

						// 	$('select[name=cilindro_id]').html(options).show();
						// 	$('#quan_c').val(0);
						// });

						// $('select[name=toner_id]').html('<option value="">Carregando...</option>');
						// $.getJSON(URL_ADMIN+"getMaterial.php?tipo=3", function(j){
						// 	var options = '<option value="">Selecione</option>';	
						// 	var vlocal = "";
						// 	for (var i = 0; i < j.length; i++){
						// 		options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						// 	}	
						// 	$('select[name=toner_id]').html(options).show();
						// 	$('#quant_t').val(0);

						// });
					}else{
						$('#tipo_cliente0').prop('checked', true);
						$('#tipo_cliente1').prop('checked', false);
						$('#tipo_cliente3').prop('checked', false);
						$('#tipo_cliente4').prop('checked', false);
					}

				});

				
			} else {
				
			}

			if($("#cliente_id option:selected").val()){
				if($("#cliente_id option:selected").attr('restricao')==1){
					alert('Cliente com pendência financeira. Consulte a diretoria!');
				}
				if(vr){
					vr.abort();
				}
				$('select[name=equipamento_id]').html('<option value="">Carregando...</option>');
				vr = $.getJSON(URL_ADMIN+"getEquipamento.php",{cliente_id: $("#cliente_id option:selected").val()}, function(j){
					var options = '<option value="">Selecione</option>';	
					var vlocal = "";
					for (var i = 0; i < j.length; i++){
						if(!j[i].localizacao)
							j[i].localizacao = '';

						if($('#tipo_ordemserv2').is(':checked')&&j[i].tipo==0||$('#tipo_ordemserv2').is(':checked')===false)
							options += '<option value="' + j[i].equipamento_id + '" nome="' + j[i].nome + '" modelo="'+ j[i].modelo_id +'">' + j[i].nome + ' - ' + j[i].localizacao + ' (' + j[i].serial + ')</option>';

						
					}	
					$('select[name=equipamento_id]').html(options).show();
					console.log($('input[name^=tipo_ordemserv]:checked').val());
					if($('input[name^=tipo_ordemserv]:checked').val()==2){
						$('.submitform').attr("disabled", true);
						$('#addinput').html('');
    					var addDiv = $('#addinput');

						$('#equipamento_id option').each(function(){
							
				            var equipamento = $(this).text();
				            var equipamento_nome = $(this).attr('nome');
				            var equipamento_id = $(this).val();
				            if(equipamento_id!=''){
					            var serial = "";
					            var localizacao = "";
					            var numerador = "";

					            $.getJSON(URL_ADMIN+"getLocalizacao.php",{equip_id: equipamento_id}, function(j){
									localizacao = j[0].local;

					                $.getJSON(URL_ADMIN+"getSerial.php",{equip_id: equipamento_id}, function(j){
					                    serial = j[0].serial;

							            // alert(equipamento);

							            $('<p><span id="IL_AD1" class="IL_AD"><b>Equipamento:</b>  <input type="hidden" name="equipamento_id_array[]" id="equipamento_id_array[]" value="'+ equipamento_id +'"> <input type ="text" name ="equipamento_aray[]" id="'+ equipamento_id +'" value="'+ equipamento_nome +'"><b>Localização:</b> <input type ="text" name="localizacao_array[]" id="localizacao_array" value="'+localizacao+'"><b>Serial:</b> <input type ="text" name="serial_array[]" id="serial_array" value="'+serial+'"><b> <b>Numerador:</b> <input type ="text" name="numerador_array[]" id="numerador_array" value="'+numerador+'"><b> <!--<a href="#" src="" id="remNew">Remove</a>--> </span> </p>').appendTo(addDiv);

							          	console.log('<p><span id="IL_AD1" class="IL_AD"><b>Equipamento:</b>  <input type="hidden" name="equipamento_id_array[]" id="equipamento_id_array[]" value="'+ equipamento_id +'"> <input type ="text" name ="equipamento_aray[]" id="'+ equipamento_id +'" value="'+ equipamento_nome +'"><b>Localização:</b> <input type ="text" name="localizacao_array[]" id="localizacao_array" value="'+localizacao+'"><b>Serial:</b> <input type ="text" name="serial_array[]" id="serial_array" value="'+serial+'"><b> <b>Numerador:</b> <input type ="text" name="numerador_array[]" id="numerador_array" value="'+numerador+'"><b> <a href="#" src="" id="remNew">Remove</a> </span> </p>');

					                }).done(function(){
					                	$('.submitform').attr("disabled", false);
					                });
								});


							}
						});

						$('#numequip').val(1);	
						

					}
				});
			} else {
				console.log("entrou3");
				$('select[name=equipamento_id]').html('<option value="">Selecione um Cliente</option>');				
				
			}
		});

		// $('select[name=cliente_id]').change(function(){
		// 	if($(this).val()&&$('#tipo_ordemserv2').is(':checked')===false){

		// 			console.log("entrou1");
		// 			if($("#cliente_id option:selected").attr('restricao')==1){
		// 				alert('Cliente com pendência financeira. Consulte a diretoria!');
		// 			}

		// 			$('select[name=equipamento_id]').html('<option value="">Carregando...</option>');
		// 			$.getJSON(URL_ADMIN+"getEquipamento.php",{cliente_id: $('select[name=cliente_id]').val()}, function(j){
		// 				var options = '<option value="">Selecione</option>';	
		// 				var vlocal = "";
		// 				for (var i = 0; i < j.length; i++){
		// 					if(!j[i].localizacao)
		// 						j[i].localizacao = '';

		// 					options += '<option value="' + j[i].equipamento_id + '" nome="' + j[i].nome + '" modelo="'+ j[i].modelo_id +'">' + j[i].nome + ' - ' + j[i].localizacao + ' (' + j[i].serial + ')</option>';

							
		// 				}	
		// 				$('select[name=equipamento_id]').html(options).show();
		// 				console.log($('input[name^=tipo_ordemserv]:checked').val());
		// 				if($('input[name^=tipo_ordemserv]:checked').val()==2){
		// 					$('.submitform').attr("disabled", true);
		// 					$('#addinput').html('');
	 //    					var addDiv = $('#addinput');

		// 					$('#equipamento_id option').each(function(){
								
		// 			            var equipamento = $(this).text();
		// 			            var equipamento_nome = $(this).attr('nome');
		// 			            var equipamento_id = $(this).val();
		// 			            if(equipamento_id!=''){
		// 				            var serial = "";
		// 				            var localizacao = "";
		// 				            var numerador = "";

		// 				            var jqxhr = $.getJSON(URL_ADMIN+"getLocalizacao.php",{equip_id: equipamento_id}, function(j){
		// 								localizacao = j[0].local;

		// 				                var jqxhr2 = $.getJSON(URL_ADMIN+"getSerial.php",{equip_id: equipamento_id}, function(j){
		// 				                    serial = j[0].serial;

		// 						            // alert(equipamento);

		// 						            $('<p><span id="IL_AD1" class="IL_AD"><b>Equipamento:</b>  <input type="hidden" name="equipamento_id_array[]" id="equipamento_id_array[]" value="'+ equipamento_id +'"> <input type ="text" name ="equipamento_aray[]" id="'+ equipamento_id +'" value="'+ equipamento_nome +'"><b>Localização:</b> <input type ="text" name="localizacao_array[]" id="localizacao_array" value="'+localizacao+'"><b>Serial:</b> <input type ="text" name="serial_array[]" id="serial_array" value="'+serial+'"><b> <b>Numerador:</b> <input type ="text" name="numerador_array[]" id="numerador_array" value="'+numerador+'"><b> <!--<a href="#" src="" id="remNew">Remove</a>--> </span> </p>').appendTo(addDiv);

		// 						          	console.log('<p><span id="IL_AD1" class="IL_AD"><b>Equipamento:</b>  <input type="hidden" name="equipamento_id_array[]" id="equipamento_id_array[]" value="'+ equipamento_id +'"> <input type ="text" name ="equipamento_aray[]" id="'+ equipamento_id +'" value="'+ equipamento_nome +'"><b>Localização:</b> <input type ="text" name="localizacao_array[]" id="localizacao_array" value="'+localizacao+'"><b>Serial:</b> <input type ="text" name="serial_array[]" id="serial_array" value="'+serial+'"><b> <b>Numerador:</b> <input type ="text" name="numerador_array[]" id="numerador_array" value="'+numerador+'"><b> <a href="#" src="" id="remNew">Remove</a> </span> </p>');

		// 				                }).done(function(){
		// 				                	$('.submitform').attr("disabled", false);
		// 				                });
		// 							});


		// 						}
		// 					});

		// 					$('#numequip').val(1);	
							

		// 				}
		// 			});

		// 	} else {
		// 			console.log("entrou3");
		// 		$('select[name=equipamento_id]').html('<option value="">Selecione um Cliente</option>');				
				
		// 	}
		// });
	});

	$(function(){
		$('select[name=equipamento_id]').change(function(){
			if($(this).val()){
				$('select[name=cilindro_id]').html('<option value="">Carregando...</option>');
				$.getJSON(URL_ADMIN+"getMaterial.php?tipo=2&equipamento_id="+jQuery(this).find('option:selected').attr('modelo'), function(j){
					var options = '<option value="">Selecione</option>';	
					var vlocal = "";
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
					}	

					$('select[name=cilindro_id]').html(options).show();
					$('#quan_c').val(0);


				});
			} else {
				$('select[name=cilindro_id]').html('<option value="">Selecione um Equipamento</option>');				
				
			}
		});
	});

	$(function(){
		$('select[name=equipamento_id]').change(function(){
			if($(this).val()){
				$('select[name=toner_id]').html('<option value="">Carregando...</option>');
				$.getJSON(URL_ADMIN+"getMaterial.php?tipo=3&equipamento_id="+jQuery(this).find('option:selected').attr('modelo'), function(j){
					var options = '<option value="">Selecione</option>';	
					var vlocal = "";
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
					}	
					$('select[name=toner_id]').html(options).show();
					$('#quant_t').val(0);

				});
			} else {
				$('select[name=toner_id]').html('<option value="">Selecione um Equipamento</option>');				
				
			}
		});
	});

	// Abre a lista de cidade de acordo com o estado
	// $(function(){
	// 	$('select[name=cliente_id]').change(function(){
	// 		if($(this).val()){
	// 			$.getJSON(URL_ADMIN+"getTipoContrato.php",{cliente_id: jQuery(this).val()}, function(j){
	// 				if(j[0].tipo == 1){
	// 					$('#tipo_cliente0').prop('checked', false);
	// 					$('#tipo_cliente1').prop('checked', true);
	// 					$('#tipo_cliente3').prop('checked', false);
	// 					$('#tipo_cliente4').prop('checked', false);

	// 				}else if(j[0].tipo == 2){

	// 				}else if(j[0].tipo == 3){
	// 					$('#tipo_cliente0').prop('checked', false);
	// 					$('#tipo_cliente1').prop('checked', false);
	// 					$('#tipo_cliente3').prop('checked', true);
	// 					$('#tipo_cliente4').prop('checked', false);
	// 				}else if(j[0].tipo == 4){
	// 					$('#tipo_cliente0').prop('checked', false);
	// 					$('#tipo_cliente1').prop('checked', false);
	// 					$('#tipo_cliente3').prop('checked', false);
	// 					$('#tipo_cliente4').prop('checked', true);

	// 					$('select[name=cilindro_id]').html('<option value="">Carregando...</option>');
	// 					$.getJSON(URL_ADMIN+"getMaterial.php?tipo=2", function(j){
	// 						var options = '<option value="">Selecione</option>';	
	// 						var vlocal = "";
	// 						for (var i = 0; i < j.length; i++){
	// 							options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
	// 						}	

	// 						$('select[name=cilindro_id]').html(options).show();
	// 						$('#quan_c').val(0);
	// 					});

	// 					$('select[name=toner_id]').html('<option value="">Carregando...</option>');
	// 					$.getJSON(URL_ADMIN+"getMaterial.php?tipo=3", function(j){
	// 						var options = '<option value="">Selecione</option>';	
	// 						var vlocal = "";
	// 						for (var i = 0; i < j.length; i++){
	// 							options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
	// 						}	
	// 						$('select[name=toner_id]').html(options).show();
	// 						$('#quant_t').val(0);

	// 					});
	// 				}else{
	// 					$('#tipo_cliente0').prop('checked', true);
	// 					$('#tipo_cliente1').prop('checked', false);
	// 					$('#tipo_cliente3').prop('checked', false);
	// 					$('#tipo_cliente4').prop('checked', false);
	// 				}

	// 			});

				
	// 		} else {
				
	// 		}
	// 	});
	// });


	// Abre a lista de cidade de acordo com o estado
	$(function(){
		$('select[name=equipamento_id]').change(function(){
			if($(this).val()){
				$.getJSON(URL_ADMIN+"getTipoContrato.php",{equipamento_id: jQuery(this).val()}, function(j){
					if(j[0].tipo == 1){
						$('#tipo_cliente0').prop('checked', false);
						$('#tipo_cliente1').prop('checked', true);
						$('#tipo_cliente3').prop('checked', false);
						$('#tipo_cliente4').prop('checked', false);
					}else if(j[0].tipo == 3){
						$('#tipo_cliente0').prop('checked', false);
						$('#tipo_cliente1').prop('checked', false);
						$('#tipo_cliente3').prop('checked', true);
						$('#tipo_cliente4').prop('checked', false);
					}else if(j[0].tipo == 4){
						$('#tipo_cliente0').prop('checked', false);
						$('#tipo_cliente1').prop('checked', false);
						$('#tipo_cliente3').prop('checked', false);
						$('#tipo_cliente4').prop('checked', true);

						
						// $('select[name=cilindro_id]').html('<option value="">Carregando...</option>');
						// $.getJSON(URL_ADMIN+"getMaterial.php?tipo=2", function(j){
						// 	var options = '<option value="">Selecione</option>';	
						// 	var vlocal = "";
						// 	for (var i = 0; i < j.length; i++){
						// 		options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						// 	}	

						// 	$('select[name=cilindro_id]').html(options).show();
						// 	$('#quan_c').val(0);
						// });

						// $('select[name=toner_id]').html('<option value="">Carregando...</option>');
						// $.getJSON(URL_ADMIN+"getMaterial.php?tipo=3", function(j){
						// 	var options = '<option value="">Selecione</option>';	
						// 	var vlocal = "";
						// 	for (var i = 0; i < j.length; i++){
						// 		options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						// 	}	
						// 	$('select[name=toner_id]').html(options).show();
						// 	$('#quant_t').val(0);

						// });
					}else{
						$('#tipo_cliente0').prop('checked', true);
						$('#tipo_cliente1').prop('checked', false);
						$('#tipo_cliente3').prop('checked', false);
						$('#tipo_cliente4').prop('checked', false);
					}

				});
			} else {
				
			}
		});
	});

    $('.defeito').css('display','none');
    $('.troca').css('display','none');
    $('.numerador').css('display','none');
    $('.diversos').css('display','none');
    $('.informatica').css('display','none');
    // $('#btnBuscar').css('display','none');
    $('.avulso').css('display', 'none');
	
	
	// Click Tipo Pessoa Juridica
	$( "#tipo_ordemserv0" ).click(function() {
		
		//Mostra o formulario cadastro pessoa fisica
		$('.defeito').css('display','inline');
		$('.troca').css('display','none');
		$('.numerador').css('display','inline');
        $('.diversos').css('display','none');
        $('.informatica').css('display','none');
        $('.avulso').css('display', 'none');
		$('#addmanutecao').css('display','inline');
		$('#addnumerador').css('display','none');
        $('.equipamento').css('display','block');
        $('#btnBuscar').css('display','block');
	});
	
	$( "#tipo_ordemserv1" ).click(function() {
		
		//Mostra o formulario cadastro pessoa fisica
		$('.troca').css('display','inline');
		$('.defeito').css('display','none');
		$('.numerador').css('display','none');
        $('.diversos').css('display','none');
        $('.avulso').css('display', 'none');
        $('.informatica').css('display','none');
		$('#addmanutecao').css('display','none');
		$('#addnumerador').css('display','none');
        $('.equipamento').css('display','block');
        $('#btnBuscar').css('display','block');

		
	});
	
    $( "#tipo_ordemserv2" ).click(function() {
		
		//Mostra o formulario cadastro pessoa fisica
		$('.troca').css('display','none');
		$('.defeito').css('display','none');
        $('.diversos').css('display','none');
        $('.equipamento').css('display','none');
        $('.avulso').css('display', 'none');
		$('.numerador').css('display','none');
		$('.informatica').css('display','none');
		
		$('#addmanutecao').css('display','none');
		// $('#addnumerador').css('display','inline');

        $('#btnBuscar').css('display','block');
		
	});
    
    $( "#tipo_ordemserv3").click(function() {

        //Mostra o formulario cadastro pessoa fisica
        $('.troca').css('display','none');
        $('.defeito').css('display','none');
        $('.numerador').css('display','none');
        $('.diversos').css('display','inline');
        $('.informatica').css('display','none');
		$('#addmanutecao').css('display','none');
        $('.avulso').css('display', 'none');
		$('#addnumerador').css('display','none');
        $('.equipamento').css('display','block');
        $('#btnBuscar').css('display','block');


    });

    $( "#tipo_ordemserv4" ).click(function() {

        //Mostra o formulario cadastro pessoa fisica
        $('.troca').css('display','none');
        $('.defeito').css('display','none');
        $('.numerador').css('display','none');
        $('.diversos').css('display','inline');
        $('.informatica').css('display','none');
        $('.avulso').css('display', 'none');
		$('#addmanutecao').css('display','none');
		$('#addnumerador').css('display','none');

        $('#btnBuscar').css('display','block');

    });
    $( "#tipo_ordemserv5" ).click(function() {

        //Mostra o formulario cadastro pessoa fisica
        $('.troca').css('display','none');
        $('.defeito').css('display','none');
        $('.avulso').css('display', 'none');
        $('.numerador').css('display','none');
        $('.diversos').css('display','inline');
        $('.informatica').css('display','none');
		$('#addmanutecao').css('display','none');
		$('#addnumerador').css('display','none');
        $('.equipamento').css('display','block');
        $('#btnBuscar').css('display','block');

    });

    $( "#tipo_ordemserv6" ).click(function() {

        //Mostra o formulario cadastro pessoa fisica
        $('.troca').css('display','none');
        $('.defeito').css('display','none');
        $('.avulso').css('display', 'none');
        $('.numerador').css('display','none');
        $('.diversos').css('display','none');
        $('.equipamento').css('display','none');
        $('.informatica').css('display','none');
		$('#addmanutecao').css('display','none');
		$('#addnumerador').css('display','none');
        $('#btnBuscar').css('display','block');


    });

    $( "#tipo_ordemserv7" ).click(function() {

        //Mostra o formulario cadastro pessoa fisica
        $('.troca').css('display','none');
        $('.defeito').css('display','none');
        $('.numerador').css('display','none');
        $('.diversos').css('display','none');
        $('.avulso').css('display', 'none');
        $('.equipamento').css('display','none');
        $('.informatica').css('display','inline');
		$('#addmanutecao').css('display','none');
		$('#addnumerador').css('display','none');
        $('#btnBuscar').css('display','none');


    });
    $( "#tipo_ordemserv8" ).click(function() {
		
		//Mostra o formulario cadastro pessoa fisica
		$('.defeito').css('display','inline');
		$('.troca').css('display','none');
		$('.numerador').css('display','inline');
        $('.avulso').css('display', 'none');
        $('.diversos').css('display','none');
        $('.informatica').css('display','none');
		$('#addmanutecao').css('display','inline');
		$('#addnumerador').css('display','none');
        $('.equipamento').css('display','block');
        $('#btnBuscar').css('display','block');

	});

    $( "#tipo_ordemserv9" ).click(function() {

        //Mostra o formulario cadastro pessoa fisica
        $('.troca').css('display','none');
        $('.defeito').css('display','none');
        $('.numerador').css('display','none');
        $('.diversos').css('display','none');
        $('.equipamento').css('display','none');
        $('.informatica').css('display','none');
        $('.avulso').css('display', 'block');
		$('#addmanutecao').css('display','none');
		$('#addnumerador').css('display','none');
        $('#btnBuscar').css('display','block');
        $('#tipo_cliente3').prop('checked', true);

    });
	
	// Abre a lista de cidade de acordo com o estado
	$(function(){
		//$('input[name=loc]').val('Teste1').show();
		$('select[name=equipamento_id]').change(function(){
			
			if($(this).val()){	
				$.getJSON(URL_ADMIN+"getLocalizacao.php",{equip_id: jQuery(this).val()}, function(j){
					for (var i = 0; i < j.length; i++){
					  	$('input[name=loc]').val(j[i].local).show();
					}
				});
			} else {
				//$('input[name=loc]').val('Teste2').show();
			}
		});
	});



    $(function(){
        //$('input[name=loc]').val('Teste1').show();
        $('select[name=equipamento_id]').change(function(){
        	$('#adddiversos').attr('disabled', true).css('opacity', '0.7');
        	$('.loading').html('Carregando..');
            if($(this).val()){
                $.getJSON(URL_ADMIN+"getSerial.php",{equip_id: jQuery(this).val()}, function(j){
                    for (var i = 0; i < j.length; i++){
                        $('input[name=serial]').val(j[i].serial).show();
                    }
        			$('#adddiversos').attr('disabled', false).css('opacity', '1');
        			$('.loading').html('');

                });
            } else {
        		$('#adddiversos').attr('disabled', false).css('opacity', '1');
        		$('.loading').html('');
                //$('input[name=loc]').val('Teste2').show();
            }
        });
    });
	
	// $('#tipo_cliente4').change(function(){
	// 	$('select[name=cilindro_id]').html('<option value="">Carregando...</option>');
	// 	$.getJSON(URL_ADMIN+"getMaterial.php?tipo=2", function(j){
	// 		var options = '<option value="">Selecione</option>';	
	// 		var vlocal = "";
	// 		for (var i = 0; i < j.length; i++){
	// 			options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
	// 		}	

	// 		$('select[name=cilindro_id]').html(options).show();
	// 		$('#quan_c').val(0);
	// 	});

	// 	$('select[name=toner_id]').html('<option value="">Carregando...</option>');
	// 	$.getJSON(URL_ADMIN+"getMaterial.php?tipo=3", function(j){
	// 		var options = '<option value="">Selecione</option>';	
	// 		var vlocal = "";
	// 		for (var i = 0; i < j.length; i++){
	// 			options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
	// 		}	
	// 		$('select[name=toner_id]').html(options).show();
	// 		$('#quant_t').val(0);

	// 	});
	// })
	
	$('input[name=tipo_ordemserv]').change(function(){
		// alert($(this).val());
		if($(this).val()!=6&&$(this).val()!=7){
			$('#numequip').val(0);
		}else{
			$('#numequip').val(1);
		}
		$("#addinput").html('');
	});

	$('.submitform').click(function(e){
		

		if($('input[name=tipo_ordemserv]:checked').val()){
			if($('#numequip').val()==0&&$('input[name=tipo_ordemserv]:checked').val()!='9'){
				alert("Adicione um equipamento/numerador!");
			}else{
				$('.form').submit();
			}
		}else{
			alert("Selecione um tipo de Ordem de Serviço!");
		}

	});

});