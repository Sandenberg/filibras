$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": URL_ADMIN+"action.php?model=equipamento&action=listar",
        // "iDisplayLength": 10,
                // "aLengthMenu": [10, 25, 50, 100, 200],
        "aoColumns": [
          	{ "mDataProp": "EquipamentoTipo.nome", "sName": "et.nome" },
        	{ "mDataProp": "serial", "sName": "e.serial" },
        	{ "mDataProp": "Marca.nome", "sName": "m.nome" },
        	{ "mDataProp": "EquipamentoModelo.nome", "sName": "em.nome" },
        	{ "mDataProp": "EquipamentoSituacao.nome", "sName": "es.nome" },
            { "mDataProp": "cliente", "sName": "cliente", "bSearchable": true },
            { "mDataProp": "status", "sName": "status", "bSearchable": true },
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
	}).columnFilter({
        aoColumns: [ 
                null,
                null,
                null,
                null,
                null,
                null,
                { type: "select", values: [ 
                    'Locação', 
                    'Vendido', 
                    'Equipamento do Cliente',
                    'Estoque'
                ]  },
                null
            ]

    });
;

});