$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": URL_ADMIN+"action.php?model=equipamento-modelo&action=listar",
        // "iDisplayLength": 100,
        "aoColumns": [
        	{ "mDataProp": "nome", "sName": "em.nome" },
                { "mDataProp": "Marca.nome", "sName": "m.nome" },
                { "mDataProp": "EquipamentoTipo.nome", "sName": "et.nome" },
        	{ "mDataProp": "numerador", "sName": "numerador", "bSortable": false, "bSearchable": false },
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