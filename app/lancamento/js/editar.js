$(document).ready(function(){
        
    $('#vencimento').mask('99/99/9999');

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

});