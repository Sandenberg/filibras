$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": URL_ADMIN+"action.php?model=agenda&action=listar",
        "iDisplayLength": 10,
        "aoColumns": [
        	{ "mDataProp": "nome_completo", "sName": "a.nome_completo" },
                { "mDataProp": "telefone", "sName": "telefone", "bSortable": false, "bSearchable": false },
        	{ "mDataProp": "documento", "sName": "documento", "bSortable": false, "bSearchable": false },
        	{ "mDataProp": "email", "sName": "a.email" },    
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