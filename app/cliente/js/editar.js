$(document).ready(function(){
	
	// Mascaras
	$("#data_nascimento").mask("99/99/9999");

	$('#telefone_principal').focusout(function(){
	    var phone, element;
	    element = $(this);
	    element.unmask();
	    phone = element.val().replace(/\D/g, '');
	    if(phone.length > 10) {
	        element.mask("(99) 99999-999?9");
	    } else {
	        element.mask("(99) 9999-9999?9");
	    }
	}).trigger('focusout');


	$('#telefone_alternativo').focusout(function(){
	    var phone, element;
	    element = $(this);
	    element.unmask();
	    phone = element.val().replace(/\D/g, '');
	    if(phone.length > 10) {
	        element.mask("(99) 99999-999?9");
	    } else {
	        element.mask("(99) 9999-9999?9");
	    }
	}).trigger('focusout');

	$("#cpf").mask("999.999.999-99");
	$("#cnpj").mask("99.999.999/9999-99");
	$("#cep").mask("99999-999");
	$("#numero").maskMoney({showSymbol: false, precision: 0, thousands:"."});
	
	// Verifica tipo de pessoa se fisica/juridica
	if( $( "#tipo_pessoa_ex" ).val() == 0 ) {
		
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
	
	// Click Tipo Pessoa Fisica
	$( "#tipo_pessoa0" ).click(function() {
		
		//Mostra o formulario cadastro pessoa fisica
		$(".fisica").css("display","inline");
		$(".juridica").css("display","none");

		// Reseta os valores dos campos CNPJ
		$("#cnpj").val("");
		$("#inscricao_estadual").val("");
		$("#inscricao_municipal").val("");
		
	});

	// Click Tipo Pessoa Juridica
	$( "#tipo_pessoa1" ).click(function() {
		
		//Mostra o formulario cadastro pessoa fisica
		$('.juridica').css('display','inline');
		$('.fisica').css('display','none');
		
		// Reseta os valores dos campos CPF 
		$("#cpf").val("");
		$("#rg").val("");
	});
	$('.input').change(function(){
	    this.value = this.value.toUpperCase();
	});

	$('#email').unbind('change');
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


});