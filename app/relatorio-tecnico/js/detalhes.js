$(document).ready(function(){
        
        $('#data_vencimento_I').mask('99/99/9999');
        $('#data_vencimento_F').mask('99/99/9999');

        $('.tipo').change(function(){
                if($(this).val() == 'credito'){
                        $('#cliente_id').parent().css('display', 'inline-block');
                        $('#beneficiario_id').parent().css('display', 'none');
                }else if($(this).val() == 'debito'){
                        $('#cliente_id').parent().css('display', 'none');
                        $('#beneficiario_id').parent().css('display', 'inline-block');
                }else{
                        $('#cliente_id').parent().css('display', 'none');
                        $('#beneficiario_id').parent().css('display', 'none');
                }
        });

});