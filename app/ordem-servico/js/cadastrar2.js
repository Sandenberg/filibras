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


	// Abre a lista de cidade de acordo com o estado
	$(function(){
		$('select[name=cliente_id]').change(function(){
			if($(this).val()){
				$('select[name=equipamento_id]').html('<option value="">Carregando...</option>');
				$.getJSON(URL_ADMIN+"getEquipamento.php",{cliente_id: jQuery(this).val()}, function(j){
					var options = '<option value="">Selecione</option>';	
					var vlocal = "";
					for (var i = 0; i < j.length; i++){
						if(!j[i].localizacao)
							j[i].localizacao = '';

						options += '<option value="' + j[i].equipamento_id + '" nome="' + j[i].nome + '">' + j[i].nome + ' - ' + j[i].localizacao + ' (' + j[i].serial + ')</option>';

						
					}	
					$('select[name=equipamento_id]').html(options).show();

				});
			} else {
				$('select[name=equipamento_id]').html('<option value="">Selecione um Cliente</option>');				
				
			}
		});
	});

	// Abre a lista de cidade de acordo com o estado
	$(function(){
		$('select[name=cliente_id]').change(function(){
			if($(this).val()){
				$.getJSON(URL_ADMIN+"getTipoContrato.php",{cliente_id: jQuery(this).val()}, function(j){
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
	
	
	// Click Tipo Pessoa Juridica
	$( "#tipo_ordemserv0" ).click(function() {
		
		//Mostra o formulario cadastro pessoa fisica
		$('.defeito').css('display','inline');
		$('.troca').css('display','none');
		$('.numerador').css('display','inline');
        $('.diversos').css('display','none');
        $('.informatica').css('display','none');
		$('#addmanutecao').css('display','inline');
		$('#addnumerador').css('display','none');
	});
	
	$( "#tipo_ordemserv1" ).click(function() {
		
		//Mostra o formulario cadastro pessoa fisica
		$('.troca').css('display','inline');
		$('.defeito').css('display','none');
		$('.numerador').css('display','none');
        $('.diversos').css('display','none');
        $('.informatica').css('display','none');
		$('#addmanutecao').css('display','none');
		$('#addnumerador').css('display','none');

		
	});
	
    $( "#tipo_ordemserv2" ).click(function() {
		
		//Mostra o formulario cadastro pessoa fisica
		$('.troca').css('display','none');
		$('.defeito').css('display','none');
        $('.diversos').css('display','none');
		$('.numerador').css('display','inline');
		$('#addmanutecao').css('display','none');
		$('#addnumerador').css('display','inline');

		
	});
    
    $( "#tipo_ordemserv3").click(function() {

        //Mostra o formulario cadastro pessoa fisica
        $('.troca').css('display','none');
        $('.defeito').css('display','none');
        $('.numerador').css('display','none');
        $('.diversos').css('display','inline');
        $('.informatica').css('display','none');
		$('#addmanutecao').css('display','none');
		$('#addnumerador').css('display','none');


    });

    $( "#tipo_ordemserv4" ).click(function() {

        //Mostra o formulario cadastro pessoa fisica
        $('.troca').css('display','none');
        $('.defeito').css('display','none');
        $('.numerador').css('display','none');
        $('.diversos').css('display','inline');
        $('.informatica').css('display','none');
		$('#addmanutecao').css('display','none');
		$('#addnumerador').css('display','none');


    });
    $( "#tipo_ordemserv5" ).click(function() {

        //Mostra o formulario cadastro pessoa fisica
        $('.troca').css('display','none');
        $('.defeito').css('display','none');
        $('.numerador').css('display','none');
        $('.diversos').css('display','inline');
        $('.informatica').css('display','none');
		$('#addmanutecao').css('display','none');
		$('#addnumerador').css('display','none');

    });

    $( "#tipo_ordemserv6" ).click(function() {

        //Mostra o formulario cadastro pessoa fisica
        $('.troca').css('display','none');
        $('.defeito').css('display','none');
        $('.numerador').css('display','none');
        $('.diversos').css('display','none');
        $('.equipamento').css('display','none');
        $('.informatica').css('display','none');
		$('#addmanutecao').css('display','none');
		$('#addnumerador').css('display','none');


    });

    $( "#tipo_ordemserv7" ).click(function() {

        //Mostra o formulario cadastro pessoa fisica
        $('.troca').css('display','none');
        $('.defeito').css('display','none');
        $('.numerador').css('display','none');
        $('.diversos').css('display','none');
        $('.equipamento').css('display','none');
        $('.informatica').css('display','inline');
		$('#addmanutecao').css('display','none');
		$('#addnumerador').css('display','none');


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

            if($(this).val()){
                $.getJSON(URL_ADMIN+"getSerial.php",{equip_id: jQuery(this).val()}, function(j){
                    for (var i = 0; i < j.length; i++){
                        $('input[name=serial]').val(j[i].serial).show();
                    }
                });
            } else {
                //$('input[name=loc]').val('Teste2').show();
            }
        });
    });
	
	
	
	

});