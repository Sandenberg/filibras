$(document).ready(function(){
	
	$("#data_compra").mask("99/99/9999");
	
	// Abre a lista de modelo de acordo com a marca
	$(function(){
		$('select[name=marca_id]').change(function(){
			if($(this).val()&&$("#equipamento_tipo_id").val()){
				$('select[name=equipamento_modelo_id]').html('<option value="">Carregando...</option>');
				$.getJSON(URL_ADMIN+"getModelos2.php",{marca_id: jQuery(this).val(), equipamento_tipo_id: $("#equipamento_tipo_id").val()}, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						if(j[i].equipamento_tipo_id==null)
							j[i].equipamento_tipo_id="";
						options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						
					}	
					$('select[name=equipamento_modelo_id]').html(options).show();
				});
			} else {
				$('select[name=equipamento_modelo_id]').html('<option value="">Selecione uma Marca e Tipo</option>');
			}
		});

		$('select[name=equipamento_tipo_id]').change(function(){
			if($(this).val()&&$("#marca_id").val()){
				$('select[name=equipamento_modelo_id]').html('<option value="">Carregando...</option>');
				$.getJSON(URL_ADMIN+"getModelos2.php",{equipamento_tipo_id: jQuery(this).val(), marca_id: $("#marca_id").val()}, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						if(j[i].equipamento_tipo_id==null)
							j[i].equipamento_tipo_id="";
						options += '<option value="' + j[i].id + '" tipo="' + j[i].equipamento_tipo_id + '">' + j[i].nome + '</option>';
						
					}	
					$('select[name=equipamento_modelo_id]').html(options).show();
				});
			} else {
				$('select[name=equipamento_modelo_id]').html('<option value="">Selecione uma Marca e Tipo</option>');
			}
		});

	});

});