$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": URL_ADMIN+"action.php?model=estoque-saida&action=listar",
        "aaSorting": [[0, 'desc']],
        // "iDisplayLength": 10,
        "aoColumns": [
        	{ "mDataProp": "data_cadastro", "sName": "data_cadastro", "bSearchable": false },
                { "mDataProp": "descricao", "sName": "descricao"},
                { "mDataProp": "materiais", "sName": "m.nome", "bSortable": false },
                { "mDataProp": "nome_cliente", "sName": "c.nome_completo"},
                { "mDataProp": "Usuario.nome", "sName": "u.nome"},
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