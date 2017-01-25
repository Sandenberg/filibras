$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": URL_ADMIN+"action.php?model=log&action=listar",
        "iDisplayLength": 25,
        "aLengthMenu": [10, 25, 50, 100, 200, 500, 1000],
        "aaSorting" : [[0, 'DESC']],
        "aoColumns": [
        	{ "mDataProp": "data_alteracao", "type": "date", "sName": "l.data_alteracao" },
                { "mDataProp": "codigo", "sName": "codigo" },
                { "mDataProp": "modulo", "sName": "modulo" },
                { "mDataProp": "acao", "sName": "acao" },
        	{ "mDataProp": "usuario", "sName": "usuario", "bSearchable": false  }
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