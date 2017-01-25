$(document).ready(function(){
        
    $('#vencimento').mask('99/99/9999');
    $('#lancamento').mask('99/99/9999');
        $('#lancamento_nf').mask('99/99/9999');

    $('.tipo').change(function(){
    	if($(this).val() == 'credito'){
    		$('#cliente_id').parent().css('display', 'inline-block');
    		// $('#fornecedor_id').parent().css('display', 'none');
    		$('#beneficiario').parent().css('display', 'none');
    	}else{
    		$('#cliente_id').parent().css('display', 'none');
    		// $('#fornecedor_id').parent().css('display', 'inline-block');
    		$('#beneficiario').parent().css('display', 'inline-block');
    	}
    });

    $("#tipo_nf_id").change(function(){
        if($(this).val() != ''){
            $('#nf').parent().css('display', 'inline-block');
            // $('#lancamento_nf').parent().css('display', 'inline-block');
        }else{
            $('#nf').parent().css('display', 'none');
            // $('#lancamento_nf').parent().css('display', 'none');
        }
    });
});