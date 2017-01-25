$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search">><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": URL_ADMIN+"action.php?model=equipamento&action=condicao_listar",
        "aaSorting": [[0, "DESC"]],
        "aoColumns": [
          	{ "mDataProp": "Equipamento.serial", "sName": "e.serial" },
        	{ "mDataProp": "Condicao.nome", "sName": "c.nome" },
        	{ "mDataProp": "data_verificacao", "sName": "ec.data_verificacao" },
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
        "fnServerData": function(sSource, aoData, fnCallback){
        	aoData.push({ "name": "equipamento_id", "value": $("input[name=equipamento_id]").val() });
        	$.getJSON( sSource, aoData, function(json){
        		fnCallback(json);
            });
        }
	});

});