$(document).ready(function(){
		
	// Abre a lista de cursos de acordo com a faculdade
	$(function(){
		$('select[name=faculdade_id]').change(function(){
			if($(this).val()){
				$('select[name=curso_id]').html('<option value="">Carregando...</option>');
				$.getJSON(URL_ADMIN+"getCursoFaculdade.php",{faculdade_id: jQuery(this).val()}, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].Curso.id + '">' + j[i].Curso.nome + '</option>';
						
					}	
					$('select[name=curso_id]').html(options).show();
				});
			} else {
				$('select[name=curso_id]').html('<option value="">Selecione uma faculdade.</option>');
			}
		});
	});
	
});