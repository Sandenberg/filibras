$(document).ready(function(){
	
	/**
	 * Primeira opção
	 */
	
	// Abre a lista de cidade de acordo com o estado
	$(function(){
		$('select[name=uf_id1]').change(function(){
			if($(this).val()){
				$('select[name=cidade_id1]').html('<option value="">Carregando...</option>');
				$.getJSON(URL+"getCidadesAdmissao.php",{uf_id: jQuery(this).val(), cidades: $("#cidades").val() }, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						
					}	
					$('select[name=cidade_id1]').html(options).show();
				});
			} else {
				$('select[name=cidade_id1]').html('<option value="">Selecione uma província.</option>');
			}
		});
	});
	
	// Abre a lista de cidade de acordo o município
	$(function(){
		$('select[name=cidade_id1]').change(function(){
			if($(this).val()){
				$('select[name=polo_id1]').html('<option value="">Carregando...</option>');
				$.getJSON(URL+"getPoloAdmissao.php",{cidade_id: jQuery(this).val(), polos: $("#polos").val() }, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						
					}	
					$('select[name=polo_id1]').html(options).show();
				});
			} else {
				$('select[name=polo_id1]').html('<option value="">Selecione um município.</option>');
			}
		});
	});
	
	// Abre a lista de cidade de acordo o polo
	$(function(){
		$('select[name=polo_id1]').change(function(){
			if($(this).val()){
				$('select[name=faculdade_id1]').html('<option value="">Carregando...</option>');
				$.getJSON(URL+"getFaculdadeAdmissao.php",{polo_id: jQuery(this).val(), faculdades: $("#faculdades").val() }, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						
					}	
					$('select[name=faculdade_id1]').html(options).show();
				});
			} else {
				$('select[name=faculdade_id1]').html('<option value="">Selecione um polo.</option>');
			}
		});
	});
	
	// Abre a lista de turmas/cursos de acordo com a faculdade
	$(function(){
		$('select[name=faculdade_id1]').change(function(){
			if($(this).val()){
				$('select[id=Sturma_id1]').html('<option value="">Carregando...</option>');
				$.getJSON(URL+"getTurmaAdmissao.php",{faculdade_id: jQuery(this).val(), turmas: $("#turmas").val() }, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].display + '</option>';
						
					}	
					$('select[id=Sturma_id1]').html(options).show();
				});
			} else {
				$('select[id=Sturma_id1]').html('<option value="">Selecione uma faculdade.</option>');
			}
		});
	});
	
	// Abre a lista de turmas/cursos de acordo com a faculdade
	$(function(){
		$('select[name=Sturma_id1]').change(function(){
			if($(this).val()){
				$('select[id=Speriodo1]').html('<option value="">Carregando...</option>');
				$.getJSON(URL+"getPeriodoAdmissao.php",{turma_id: jQuery(this).val() }, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].display + '</option>';
						
					}	
					$('select[id=Speriodo1]').html(options).show();
				});
			} else {
				$('select[id=Speriodo1]').html('<option value="">Selecione um curso.</option>');
			}
		});
	});
	
	/**
	 * Segunda Opção
	 */
	
	// Abre a lista de cidade de acordo com o estado
	$(function(){
		$('select[name=uf_id2]').change(function(){
			if($(this).val()){
				$('select[name=cidade_id2]').html('<option value="">Carregando...</option>');
				$.getJSON(URL+"getCidadesAdmissao.php",{uf_id: jQuery(this).val(), cidades: $("#cidades").val() }, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						
					}	
					$('select[name=cidade_id2]').html(options).show();
				});
			} else {
				$('select[name=cidade_id2]').html('<option value="">Selecione uma província.</option>');
			}
		});
	});
	
	// Abre a lista de cidade de acordo o município
	$(function(){
		$('select[name=cidade_id2]').change(function(){
			if($(this).val()){
				$('select[name=polo_id2]').html('<option value="">Carregando...</option>');
				$.getJSON(URL+"getPoloAdmissao.php",{cidade_id: jQuery(this).val(), polos: $("#polos").val() }, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						
					}	
					$('select[name=polo_id2]').html(options).show();
				});
			} else {
				$('select[name=polo_id2]').html('<option value="">Selecione um município.</option>');
			}
		});
	});
	
	// Abre a lista de cidade de acordo o polo
	$(function(){
		$('select[name=polo_id2]').change(function(){
			if($(this).val()){
				$('select[name=faculdade_id2]').html('<option value="">Carregando...</option>');
				$.getJSON(URL+"getFaculdadeAdmissao.php",{polo_id: jQuery(this).val(), faculdades: $("#faculdades").val() }, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						
					}	
					$('select[name=faculdade_id2]').html(options).show();
				});
			} else {
				$('select[name=faculdade_id2]').html('<option value="">Selecione um polo.</option>');
			}
		});
	});
	
	// Abre a lista de turmas/cursos de acordo com a faculdade
	$(function(){
		$('select[name=faculdade_id2]').change(function(){
			if($(this).val()){
				$('select[id=Sturma_id2]').html('<option value="">Carregando...</option>');
				$.getJSON(URL+"getTurmaAdmissao.php",{faculdade_id: jQuery(this).val(), turmas: $("#turmas").val() }, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].display + '</option>';
						
					}	
					$('select[id=Sturma_id2]').html(options).show();
				});
			} else {
				$('select[id=Sturma_id2]').html('<option value="">Selecione uma faculdade.</option>');
			}
		});
	});
	
	// Abre a lista de turmas/cursos de acordo com a faculdade
	$(function(){
		$('select[name=Sturma_id2]').change(function(){
			if($(this).val()){
				$('select[id=Speriodo2]').html('<option value="">Carregando...</option>');
				$.getJSON(URL+"getPeriodoAdmissao.php",{turma_id: jQuery(this).val() }, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].display + '</option>';
						
					}	
					$('select[id=Speriodo2]').html(options).show();
				});
			} else {
				$('select[id=Speriodo2]').html('<option value="">Selecione um curso.</option>');
			}
		});
	});
	
	/**
	 * Terceira Opção
	 */
	
	// Abre a lista de cidade de acordo com o estado
	$(function(){
		$('select[name=uf_id3]').change(function(){
			if($(this).val()){
				$('select[name=cidade_id3]').html('<option value="">Carregando...</option>');
				$.getJSON(URL+"getCidadesAdmissao.php",{uf_id: jQuery(this).val(), cidades: $("#cidades").val() }, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						
					}	
					$('select[name=cidade_id3]').html(options).show();
				});
			} else {
				$('select[name=cidade_id3]').html('<option value="">Selecione uma província.</option>');
			}
		});
	});
	
	// Abre a lista de cidade de acordo o município
	$(function(){
		$('select[name=cidade_id3]').change(function(){
			if($(this).val()){
				$('select[name=polo_id3]').html('<option value="">Carregando...</option>');
				$.getJSON(URL+"getPoloAdmissao.php",{cidade_id: jQuery(this).val(), polos: $("#polos").val() }, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						
					}	
					$('select[name=polo_id3]').html(options).show();
				});
			} else {
				$('select[name=polo_id3]').html('<option value="">Selecione um município.</option>');
			}
		});
	});
	
	// Abre a lista de cidade de acordo o polo
	$(function(){
		$('select[name=polo_id3]').change(function(){
			if($(this).val()){
				$('select[name=faculdade_id3]').html('<option value="">Carregando...</option>');
				$.getJSON(URL+"getFaculdadeAdmissao.php",{polo_id: jQuery(this).val(), faculdades: $("#faculdades").val() }, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						
					}	
					$('select[name=faculdade_id3]').html(options).show();
				});
			} else {
				$('select[name=faculdade_id3]').html('<option value="">Selecione um polo.</option>');
			}
		});
	});
	
	// Abre a lista de turmas/cursos de acordo com a faculdade
	$(function(){
		$('select[name=faculdade_id3]').change(function(){
			if($(this).val()){
				$('select[id=Sturma_id3]').html('<option value="">Carregando...</option>');
				$.getJSON(URL+"getTurmaAdmissao.php",{faculdade_id: jQuery(this).val(), turmas: $("#turmas").val() }, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].display + '</option>';
						
					}	
					$('select[id=Sturma_id3]').html(options).show();
				});
			} else {
				$('select[id=Sturma_id3]').html('<option value="">Selecione uma faculdade.</option>');
			}
		});
	});
	
	// Abre a lista de turmas/cursos de acordo com a faculdade
	$(function(){
		$('select[name=Sturma_id3]').change(function(){
			if($(this).val()){
				$('select[id=Speriodo3]').html('<option value="">Carregando...</option>');
				$.getJSON(URL+"getPeriodoAdmissao.php",{turma_id: jQuery(this).val() }, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].display + '</option>';
						
					}	
					$('select[id=Speriodo3]').html(options).show();
				});
			} else {
				$('select[id=Speriodo3]').html('<option value="">Selecione um curso.</option>');
			}
		});
	});
	
	// Mascaras
	$("#data_nascimento").mask("99/99/9999");
	$("#data_admissao").mask("99/99/9999");
	$("#telefone").mask("(999)999-999");
	$("#celular").mask("(999)999-999");
	$("input[name=doc_tipo]").change(function(){
		$("#doc_numero").val("");
	});
	$("#doc_numero").focus(function(){
			$("#doc_numero").mask("999999999aa999");
			
			if ($("input[name=doc_tipo]:checked").val() == 1){
				$("#doc_numero").unmask();
			}
	});
	
	// Abre a lista de cidade de acordo com o estado para NATURALIDADE
	$(function(){
		$('select[name=uf_id_naturalidade]').change(function(){
			if($(this).val()){
				$('select[name=cidade_id_naturalidade]').html('<option value="">Carregando...</option>');
				$.getJSON(URL+"getCidades.php",{uf_id: jQuery(this).val()}, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						
					}	
					$('select[name=cidade_id_naturalidade]').html(options).show();
				});
			} else {
				$('select[name=cidade_id_naturalidade]').html('<option value="">Selecione uma província.</option>');
			}
		});
	});
	
	// Abre a lista de cidade de acordo com o estado para ENDEREÇO
	$(function(){
		$('select[name=uf_id_endereco]').change(function(){
			if($(this).val()){
				$('select[name=cidade_id_endereco]').html('<option value="">Carregando...</option>');
				$.getJSON(URL+"getCidades.php",{uf_id: jQuery(this).val()}, function(j){
					var options = '<option value="">Selecione</option>';	
					for (var i = 0; i < j.length; i++){
						options += '<option value="' + j[i].id + '">' + j[i].nome + '</option>';
						
					}	
					$('select[name=cidade_id_endereco]').html(options).show();
				});
			} else {
				$('select[name=cidade_id_endereco]').html('<option value="">Selecione uma província.</option>');
			}
		});
	});
	
	// Carrega os dados da pessoa de acordo com o documento informado
	$(function(){
		$('#doc_numero').change(function(){
			if($(this).val()){
				
				// Mascara de carregamento 
				$("#dialog-modal").dialog({ 
					closeOnEscapeType: false, 
					height: 80, 
					modal: true,
					draggable: false,
					hide: "explode",
					resizable: false
				});
				
				// Realiza a requisição ao Banco de Dados
				$.getJSON(URL+"getPessoa.php",{documento: jQuery(this).val()}, function(j){
					// Atribui os dados a uma variável
					var data = j[0];
					
					// Verifica o retorno
					if (j.length <= 0){
						
						setTimeout(function(){
							$("#dialog-modal").dialog("close");
							$("#nome_completo").focus();
						}, 1000);
						
					} else if (data != undefined && data != 'underfined') {
						
						// Preenche os campo de acordo com os dados recebidos
						$("input[name=doc_tipo][value="+data.doc_tipo+"]").attr("checked", "checked");
						$("#nome_completo").val(data.nome_completo);
						$("input[name=sexo][value="+data.sexo+"]").attr("checked", "checked");
						$("#data_nascimento").val(data.data_nascimento);
						$('#estado_civil_id').val(data.estado_civil_id);
						$('#uf_id_naturalidade').val(data.Cidade.uf_id);
						$('#uf_id_naturalidade').trigger("change");
						$("#nome_pai").val(data.nome_pai);
						$("#nome_mae").val(data.nome_mae);
						$("#email").val(data.email);
						$("#telefone").val(data.telefone);
						$("#telefone").focus();
						$("#celular").val(data.celular);
						$("#celular").focus();
						$('#escola_id').val(data.escola_id);
						
						// Verifica se o usuário possui endereço cadastrado
						if (data.PessoaEndereco.length > 0){
							// Preenche os campos de endereço
							$("#logradouro").val(data.PessoaEndereco[0].Endereco.logradouro);							
							$("#numero").val(data.PessoaEndereco[0].Endereco.numero);
							$("#complemento").val(data.PessoaEndereco[0].Endereco.complemento);
							$("#referencia").val(data.PessoaEndereco[0].Endereco.referencia);
							$("#cep").val(data.PessoaEndereco[0].Endereco.cep);
							$("#bairro").val(data.PessoaEndereco[0].Endereco.bairro);
							$('#uf_id_endereco').val(data.PessoaEndereco[0].Endereco.Cidade.uf_id);
							$('#uf_id_endereco').trigger("change");
						}
						
						// Verifica se existem formações e marca as existentes
						if (data.PessoaFormacao.length > 0){
							for (var i = 0; i < data.PessoaFormacao.length; i++){
								$("input[name='formacao_id[]'][value="+data.PessoaFormacao[i].formacao_id+"]").attr("checked", "checked");
							}
						}
						
						// Verifica se existem idiomas e marca os existentes
						if (data.PessoaIdioma.length > 0){
							for (var i = 0; i < data.PessoaIdioma.length; i++){
								$("input[name='idioma_id[]'][value="+data.PessoaIdioma[i].idioma_id+"]").attr("checked", "checked");
							}
						}
						
						// Carrega a cidade
						setTimeout(function(){
							$('#cidade_id_naturalidade').val(data.cidade_id);
							// Verifica se havia um endereço cadastrado
							if (data.PessoaEndereco.length > 0){
								$('#cidade_id_endereco').val(data.PessoaEndereco[0].Endereco.cidade_id);
							}
							$("#dialog-modal").dialog("close");
						}, 3000);
						
					}
					
				});
				
			} else {
				
				$("#dialog-modal").dialog("close");
				
			}
			
		});
		
	});
	
	// Validação de idade mínima
	$('#data_nascimento').change(function(){
		if ($.fn.calculaIdade($("#data_nascimento").val()) < 15){
			alert("O processo de admissão só pode realizado por candidatos com idade igual ou superior a 15 anos.");
			$(this).val("");
			$(this).trigger("blur");
		}
	});
	
});