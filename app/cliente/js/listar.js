$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": URL_ADMIN+"action.php?model=cliente&action=listar",
                // "iDisplayLength": 10,
                "aaSorting": [[ 1, "ASC" ]],
                // "aLengthMenu": [10, 25, 50, 100, 200],
                "aoColumns": [
                        { "mDataProp": "id", "sName": "c.id" },
                	{ "mDataProp": "nome_completo", "sName": "c.nome_completo" },
                        { "mDataProp": "telefone", "sName": "telefone", "bSortable": false, "bSearchable": false },
                        { "mDataProp": "contato", "sName": "contato", "bSortable": false, "bSearchable": false },
                	{ "mDataProp": "documento", "sName": "documento", "bSortable": false, "bSearchable": false },
                	{ "mDataProp": "email", "sName": "c.email" },        	
                	{ "mDataProp": "Filial.nome", "sName": "f.nome" },
                	{ "mDataProp": "action", "bSortable": false, "bSearchable": false }
                ],
                "fnDrawCallback": function(oSettings, json) {
                	$('.action3').click(function(){
                		// Seleciona a ação
                		var acao = $(this).children('span').html();
                		// Solicitação de confirmação
                		if (confirm('Deseja '+acao+' para este cliente?')){
                			return true;
                		} else {
                			return false;
                		}
                	});
                },
                "fnRowCallback": function( nRow, aData ) {
                  var id = aData.restricao; // ID is returned by the server as part of the data
                  var $nRow = $(nRow); // cache the row wrapped up in jQuery
                  if (id == "1") {
                    $nRow.css({'color':'#a00'})
                  }
                  return nRow
                }
	});

});