$(document).ready(function(){
	$("#data_compra").mask("99/99/9999");
		
	// Abre a lista de cidade de acordo com o estado
	$(function(){
		$('select[name=marca_id]').change(function(){
			if($(this).val()){
				$('select[name=equipamento_modelo_id]').html('<option value="">Carregando...</option>');
				$.getJSON(URL_ADMIN+"getModelos.php",{marca_id: jQuery(this).val()}, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						
					}	
					$('select[name=equipamento_modelo_id]').html(options).show();
				});
			} else {
				$('select[name=equipamento_modelo_id]').html('<option value="">Selecione um estado</option>');
			}
		});
	});

});