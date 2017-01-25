$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": URL_ADMIN+"action.php?model=relatorio-nota&action=listar",
        "iDisplayLength": 10,
                "aLengthMenu": [10, 25, 50, 100, 200],
        "aoColumns": [
            { "mDataProp": "fatura", "sName": "fatura" },
            { "mDataProp": "data_envio", "sName": "data_envio" },
          	{ "mDataProp": "nome_cliente", "sName": "cl.nome_completo" },
          	{ "mDataProp": "email1", "sName": "email1", "bSearchable": false },
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