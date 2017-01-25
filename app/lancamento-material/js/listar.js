$(document).ready(function(){
        
        $('.data-table').dataTable({
                "sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
                "bJQueryUI": true,
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": URL_ADMIN+"action.php?model=lancamento-material&action=listar",
                "iDisplayLength": 100,
                "aaSorting": [[0, 'DESC']],
                "aLengthMenu": [100, 250, 500, 1000],
                "aoColumns": [
                        { "mDataProp": "data_cadastro", "sName": "data_cadastro", "bSearchable": false },                    
                        { "mDataProp": "Material.nome", "sName": "m.nome" },                          
                        { "mDataProp": "quantidade", "sName": "quantidade", "bSearchable": false },                    
                        { "mDataProp": "valor_unidade", "sName": "valor_unidade", "bSortable": false },                    
                        { "mDataProp": "valor_total", "sName": "valor_total", "bSearchable": false },                    
                        { "mDataProp": "tipo", "sName": "tipo", "bSearchable": false }
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
                    // $nRow.css({"background-color":"#090", 'color':'#fff'})
                  }
                  return nRow
                },
                "fnServerData": function(sSource, aoData, fnCallback){
                    aoData.push({ "name": "cliente_id", "value": $("input[name=cliente_id]").val() },{ "name": "fechamento", "value": $("input[name=fechamento]").val() });
                    $.getJSON( sSource, aoData, function(json){
                        fnCallback(json);
                    });
                }
        });

});