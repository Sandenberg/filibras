$(document).ready(function(){
	
	// Gatilho para o evento change em todos os checkboxes de permissão
	$(".chkp").change(function(){
		
		// Pega o atributo checked
		var status = $(this).attr("checked")=="checked"?true:false;
		
		// Altera a marcação dos filhos
		if (status){
			// Checked
			$(this).parent().next("ul").find("input[type=checkbox]").attr("checked", true);
		} else {
			// Unchecked
			$(this).parent().next("ul").find("input[type=checkbox]").removeAttr("checked");
		}
		
		// Verifica o atributo checked para definição da função
		if (status){
			
			// Parent do elemento atual
			var parent = $(this).attr("parent");
			
			// Repetição para marcação
			while (parent > 0) {
				
				// Seleciona o próximo elemento com o parent do elemento atual
				var chk = $("input[value="+parent+"]");

				// Marca o elemento
				$(chk).attr("checked", true);
				
				// Seleciona o próximo parent
				parent = $(chk).attr("parent");
				
			}
			
		} else {
			
			// Parent do elemento atual
			var parent = $(this).attr("parent");
			
			// Repetição para marcação
			while (parent > 0){

				// Seleciona o próximo elemento com o parent do elemento atual
				var chk = $("input[value="+parent+"]");

				// Marca o elemento se o mesmo não possui irmãos marcados
				if ($("input[parent="+parent+"]:checked").length <= 0){
					$(chk).removeAttr("checked");
				}
				
				// Seleciona o próximo parent
				parent = $(chk).attr("parent");
									
			}
			
		}
		
	});

});