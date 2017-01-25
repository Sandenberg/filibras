$(document).ready(function(){
	
	// Mascaras
	$("#data_nascimento").mask("99/99/9999");
	$("#telefone_principal").mask("(99)9999-9999");
	$("#telefone_alternativo").mask("(99)9999-9999");
	$("#cpf").mask("999.999.999-99");
	$("#cnpj").mask("99.999.999/9999-99");
	$("#cep").mask("99999-999");
	$("#numero").maskMoney({showSymbol: false, precision: 0, thousands:"."});
	
	// Verifica tipo de pessoa se fisica/juridica
	if( $( "#tipo_pessoa" ).val() == 0 ) {
		
		//Mostra o formulario cadastro pessoa fisica
		$(".fisica").css("display","inline");
		$(".juridica").css("display","none");

		// Reseta os valores dos campos CNPJ
		$("#cnpj").val("");
		$("#inscricao_estadual").val("");
		$("#inscricao_municipal").val("");

	}else{
		
		//Mostra o formulario cadastro pessoa fisica
		$('.juridica').css('display','inline');
		$('.fisica').css('display','none');
		
		// Reseta os valores dos campos CPF 
		$("#cpf").val("");
		$("#rg").val("");
		
	}
	
	// Abre a lista de cidade de acordo com o estado
	$(function(){
		$('select[name=uf_id]').change(function(){
			if($(this).val()){
				$('select[name=cidade_id]').html('<option value="">Carregando...</option>');
				$.getJSON(URL_ADMIN+"getCidades.php",{uf_id: jQuery(this).val()}, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						
					}	
					$('select[name=cidade_id]').html(options).show();
				});
			} else {
				$('select[name=cidade_id]').html('<option value="">Selecione um estado</option>');
			}
		});
	});

	// Abre a lista de cidade de acordo com o estado
	$(function(){
		$('select[name=cliente_id]').change(function(){
			if($(this).val()){
				$('select[name=equipamento_id]').html('<option value="">Carregando...</option>');
				$.getJSON(URL_ADMIN+"getEquipamento.php",{cliente_id: jQuery(this).val()}, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						
						options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						
					}	
					$('select[name=equipamento_id]').html(options).show();
				});
			} else {
				$('select[name=equipamento_id]').html('<option value="">Selecione um Cliente</option>');				
				
			}
		});
	});
	
	
	
	// Click Tipo Pessoa Juridica
	$( "#tipo_ordemserv0" ).click(function() {
		
		//Mostra o formulario cadastro pessoa fisica
		$('.defeito').css('display','inline');
		$('.troca').css('display','none');
		$('.numerador').css('display','none');
		

	});
	
	$( "#tipo_ordemserv1" ).click(function() {
		
		//Mostra o formulario cadastro pessoa fisica
		$('.troca').css('display','inline');
		$('.defeito').css('display','none');
		$('.numerador').css('display','none');

		
	});
	
    $( "#tipo_ordemserv2" ).click(function() {
		
		//Mostra o formulario cadastro pessoa fisica
		$('.troca').css('display','none');
		$('.defeito').css('display','none');
		$('.numerador').css('display','inline');

		
	});
    
    $( "#tipo_ordemserv3" ).click(function() {
		
		//Mostra o formulario cadastro pessoa fisica
		$('.troca').css('display','none');
		$('.defeito').css('display','inline');
		$('.numerador').css('display','none');

		
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

});