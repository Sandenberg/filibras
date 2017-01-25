$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": URL_ADMIN+"action.php?model=contrato&action=vencido_listar",
        "iDisplayLength": 10,
                "aLengthMenu": [10, 25, 50, 100, 200],
        "aoColumns": [
          	{ "mDataProp": "Cliente.nome_completo", "sName": "cl.nome_completo" },
          	{ "mDataProp": "tipo", "sName": "c.tipo", "bSearchable": false },
          	{ "mDataProp": "numero", "sName": "c.numero", "bSortable": false, "bSearchable": false },
          	{ "mDataProp": "data_inicio", "sName": "c.data_inicio" },
        	{ "mDataProp": "data_fim", "sName": "c.data_fim" },
        	{ "mDataProp": "dia_leitura", "sName": "c.dia_leitura" },
                { "mDataProp": "filial", "sName": "filial","bSortable": false, "bSearchable": false },                
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