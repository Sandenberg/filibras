$(document).ready(function(){
        
        $('.data-table').dataTable({
                "sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
                "bJQueryUI": true,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": URL_ADMIN+"action.php?model=lancamento&action=listar",
                "iDisplayLength": 10,
                "aoColumns": [
                { "mDataProp": "data_vencimento", "sName": "data_vencimento" },                    
                { "mDataProp": "tipo", "sName": "tipo" },                    
                { "mDataProp": "Cliente.nome_completo", "sName": "c.nome_completo" },                             
                { "mDataProp": "nome_beneficiario", "sName": "nome_beneficiario" },                             
                { "mDataProp": "data_baixa", "sName": "data_baixa" },                    
                { "mDataProp": "LancamentoTipo.nome", "sName": "lt.nome" },           
                { "mDataProp": "nome_conta", "sName": "nome_conta" },           
                { "mDataProp": "descricao", "sName": "descricao" },           
                { "mDataProp": "valor", "sName": "valor" },           
                { "mDataProp": "action", "bSortable": false, "bSearchable": false }
        ],
        "fnDrawCallback": function(oSettings, json) {
                $('.action3').click(function(){
                        // Seleciona a ação
                        var acao = $(this).children('span').html();
                        // Solicitação de confirmação
                        if (confirm('Deseja '+acao+' este registro?')){
                                return true;
                        } else {
                                return false;
                        }
                });
        }
        });

});