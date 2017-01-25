$(document).ready(function(){
        
        $('.data-table').dataTable({
                "sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
                "bJQueryUI": true,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": URL_ADMIN+"action.php?model=credito&action=listar",
                // "iDisplayLength": 10,
                "aaSorting": [[0, 'DESC']],
                // "aLengthMenu": [10, 25, 50, 100, 200],
                "aoColumns": [
                        { "mDataProp": "data_lancamento", "sName": "data_lancamento", "bSearchable": false },                    
                        { "mDataProp": "Cliente.nome_completo", "sName": "c.nome_completo" },                          
                        { "mDataProp": "data_vencimento", "sName": "data_vencimento", "bSearchable": false },                    
                        { "mDataProp": "nfrb", "sName": "nf", "bSortable": false },                    
                        { "mDataProp": "data_baixa", "sName": "data_baixa", "bSearchable": false },                    
                        { "mDataProp": "LancamentoTipo.nome", "sName": "lt.nome" },           
                        { "mDataProp": "nome_conta", "sName": "nome_conta", "bSearchable": false },           
                        // { "mDataProp": "descricao", "sName": "descricao" },           
                        { "mDataProp": "valor", "sName": "valor", "bSearchable": false },           
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
                },
                "fnRowCallback": function( nRow, aData ) {
                  var id = aData.data_baixa; // ID is returned by the server as part of the data
                  var $nRow = $(nRow); // cache the row wrapped up in jQuery
                  if (id != "-") {
                    $nRow.css({"background-color":"#090", 'color':'#fff'})
                  }
                  return nRow
                }
        });

});