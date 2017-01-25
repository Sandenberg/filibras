$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": URL_ADMIN+"action.php?model=mensagem&action=listar",
        "aaSorting" : [[0, 'DESC']],
        "aoColumns": [
        	{ "mDataProp": "data_mensagem", "type": "date", "sName": "l.data_mensagem" },
                { "mDataProp": "enviada_por", "sName": "enviada_por" },
                { "mDataProp": "recebida_por", "sName": "recebida_por" },
                { "mDataProp": "titulo", "sName": "titulo" },
                { "mDataProp": "data_lida", "sName": "data_lida" },
                { "mDataProp": "data_ok", "sName": "data_ok" },
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
                  var id = aData.data_lida; // ID is returned by the server as part of the data
                  var $nRow = $(nRow); // cache the row wrapped up in jQuery
                  if (id == "-") {
                    $nRow.css({"font-weight":"700"})
                  }
                  return nRow
                }
	});

});