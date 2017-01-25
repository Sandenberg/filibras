$(document).ready(function(){
	
	// Máscaras
	$("#data_inicio").mask("99/99/9999");
	$("#data_fim").mask("99/99/9999");
	$("#inicio_garantia").mask("99/99/9999");
	$("#fim_garantia").mask("99/99/9999");
	$("#adicional_monocromatica").maskMoney({showSymbol: false, decimal: ",", thousands:".", precision: 4, allowZero: true});
	$("#adicional_colorida").maskMoney({showSymbol: false, decimal: ",", thousands:".", precision: 4, allowZero: true});
	$("#valor_monocromatica").maskMoney({showSymbol: false, decimal: ",", thousands:".", precision: 4, allowZero: true});
	$("#valor_colorida").maskMoney({showSymbol: false, decimal: ",", thousands:".", precision: 4, allowZero: true});
	$("#franquia_monocromatica").maskMoney({showSymbol: false, precision: 0, thousands:".", allowZero: true});
	$("#franquia_colorida").maskMoney({showSymbol: false, precision: 0, thousands:".", allowZero: true});
	$("#valor").maskMoney({showSymbol: false, decimal: ",", thousands:".", precision: 2, allowZero: true})
	
	// Validação de campos obrigatório de acordo com o tipo de contrato
	$("input[name=tipo]").change(function(){
		// Verifica o tipo de contrato
		if ($(this).val() == 0){
			
			// Locação
			//$("#numero").addClass("validate[required,maxSize[60]]").removeAttr("disabled");
			$("#data_inicio").addClass("validate[required,custom[dateBR]]").removeAttr("disabled");
			$("#valor_monocromatica").addClass("validate[required]").removeAttr("disabled");
			$("#valor_colorida").addClass("validate[required]").removeAttr("disabled");
			$("#adicional_monocromatica").addClass("validate[required]").removeAttr("disabled");
			$("#adicional_colorida").addClass("validate[required]").removeAttr("disabled");
			$("#franquia_monocromatica").addClass("validate[required]").removeAttr("disabled");
			$("#franquia_colorida").addClass("validate[required]").removeAttr("disabled");
			$("#dia_leitura").addClass("validate[required]").removeAttr("disabled");
			$("#venda_locacao").html("Início da Vigência:");
			$("input[name=garantia][value=0]").attr("checked", true);
			$("input[name=garantia]:checked").trigger("change");

			$("#data_fim").parent().css("display","inline-block");
			$("#dia_leitura").parent().css("display","inline-block");
			$("#franquia_monocromatica").parent().css("display","inline-block");
			$("#franquia_colorida").parent().css("display","inline-block");
			$("#renovacao").parent().css("display","inline-block");
			$("#valor_monocromatica").parent().css("display","inline-block");
			$("#valor_colorida").parent().css("display","inline-block");
			$("#adicional_monocromatica").parent().css("display","inline-block");
			$("#adicional_colorida").parent().css("display","inline-block");
			
			
			if($('#numero').val()=='SEM CONTRATO')
				$('#numero').val('');
		} else if ($(this).val() == 2){
			
			// Venda sem contrato
			//$("#numero").removeClass("validate[required,maxSize[60]]").attr("disabled", "disabled").val("");
			$("#data_inicio").removeClass("validate[required,custom[dateBR]]");
			$("#valor_monocromatica").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#valor_colorida").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#adicional_monocromatica").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#adicional_colorida").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#franquia_monocromatica").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#franquia_colorida").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#dia_leitura").addClass("validate[required]").removeAttr("disabled");
			// $("#dia_leitura").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#venda_locacao").html("Data da Venda:");
			$("#franquia_monocromatica").parent().css("display","inline-block");
			$("#franquia_colorida").parent().css("display","inline-block");
			$("#valor_monocromatica").parent().css("display","inline-block");
			$("#valor_colorida").parent().css("display","inline-block");
			$("#adicional_monocromatica").parent().css("display","inline-block");
			$("#adicional_colorida").parent().css("display","inline-block");
			$("#data_inicio").parent().css("display","inline-block");
			$("#valor").parent().css("display","inline-block");
			
			if($('#numero').val()=='SEM CONTRATO')
				$('#numero').val('');
		} else if ($(this).val() == 3){
			
			// Venda sem contrato
			//$("#numero").removeClass("validate[required,maxSize[60]]").attr("disabled", "disabled").val("");
			$("#data_inicio").removeClass("validate[required,custom[dateBR]]");
			$("#valor_monocromatica").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#valor_colorida").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#adicional_monocromatica").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#adicional_colorida").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#franquia_monocromatica").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#franquia_colorida").removeClass("validate[required]").attr("disabled", "disabled").val("");
			// $("#dia_leitura").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#dia_leitura").addClass("validate[required]").removeAttr("disabled");
			$("input[name=garantia][value=0]").attr("checked", true);
			$("input[name=garantia]:checked").trigger("change");
			$("#data_fim").parent().css("display","inline-block");
			$("#dia_leitura").parent().css("display","inline-block");
			$("#renovacao").parent().css("display","inline-block");
			$("#franquia_monocromatica").parent().css("display","none");
			$("#franquia_colorida").parent().css("display","none");
			$("#valor_monocromatica").parent().css("display","none");
			$("#valor_colorida").parent().css("display","none");
			$("#adicional_monocromatica").parent().css("display","none");
			$("#adicional_colorida").parent().css("display","none");
			$("#venda_locacao").html("Início da Vigência:");
			$("#data_inicio").parent().css("display","inline-block");
			$("#valor").parent().css("display","inline-block");

			if($('#numero').val()=='SEM CONTRATO')
				$('#numero').val('');
		}
		else  if($(this).val()==1) {
			
			// Venda
			//$("#numero").addClass("validate[required,maxSize[60]]").removeAttr("disabled");
			$("#data_inicio").removeClass("validate[required,custom[dateBR]]");
			$("#valor_monocromatica").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#valor_colorida").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#adicional_monocromatica").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#adicional_colorida").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#franquia_monocromatica").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#franquia_colorida").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#dia_leitura").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#venda_locacao").html("Data da Venda:");
			$('#garantia0').parent().css("display","inline-block");
			$("#data_fim").parent().css("display","none");
			$("#dia_leitura").parent().css("display","none");
			$("#franquia_monocromatica").parent().css("display","none");
			$("#franquia_colorida").parent().css("display","none");
			$("#renovacao").parent().css("display","none");
			$("#valor_monocromatica").parent().css("display","none");
			$("#valor_colorida").parent().css("display","none");
			$("#adicional_monocromatica").parent().css("display","none");
			$("#adicional_colorida").parent().css("display","none");
			$("#data_inicio").parent().css("display","inline-block");
			$("#valor").parent().css("display","inline-block");
			
			if($('#numero').val()=='SEM CONTRATO')
				$('#numero').val('');
		}
		else if($(this).val()==4){
			$('#numero').val('SEM CONTRATO');
			
			// Venda
			//$("#numero").addClass("validate[required,maxSize[60]]").removeAttr("disabled");
			$("#data_inicio").removeClass("validate[required,custom[dateBR]]");
			$("#valor_monocromatica").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#valor_colorida").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#adicional_monocromatica").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#adicional_colorida").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#franquia_monocromatica").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#franquia_colorida").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#dia_leitura").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#venda_locacao").html("Data da Venda:");
			$('#garantia0').parent().css("display","inline-block");
			$("#data_fim").parent().css("display","none");
			$("#dia_leitura").parent().css("display","none");
			$("#franquia_monocromatica").parent().css("display","none");
			$("#franquia_colorida").parent().css("display","none");
			$("#renovacao").parent().css("display","none");
			$("#valor_monocromatica").parent().css("display","none");
			$("#valor_colorida").parent().css("display","none");
			$("#adicional_monocromatica").parent().css("display","none");
			$("#adicional_colorida").parent().css("display","none");
			// $("#data_inicio").parent().css("display","none");
			// $("#valor").parent().css("display","none");
			$(".garantia").css("display","none");

			$("#venda_locacao").html("Data:");
		}
	});
	
	// Verifica se o contrato possui garantia
	$("input[name=garantia]").change(function(){
		// Verifica o tipo de contrato
		if ($(this).val() == 1){
			
			// Altera a propriedade do campo e label
			$("#inicio_garantia").addClass("validate[required]").removeAttr("disabled");
			$("#fim_garantia").addClass("validate[required]").removeAttr("disabled");
			$(".garantia").css("display","inline-block");
			
		} else {
			
			// Altera a propriedades do campo e label
			$("#inicio_garantia").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$("#fim_garantia").removeClass("validate[required]").attr("disabled", "disabled").val("");
			$(".garantia").css("display","none");
			
		}
	});
	
});