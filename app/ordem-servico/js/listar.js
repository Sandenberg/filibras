$(document).ready(function(){
	
	$('.data-table').dataTable({
		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',
		"bJQueryUI": true,
		"bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": URL_ADMIN+"action.php?model=ordem-servico&action=listar",
        // "iDisplayLength": 10,
        "aaSorting": [[0, 'DESC']],
                // "aLengthMenu": [25, 50, 100, 200],
        "aoColumns": [
        	{ "mDataProp": "id", "sName": "o.id" },
        	{ "mDataProp": "Cliente.nome_completo", "sName": "c.nome_completo" },
        	{ "mDataProp": "ordem", "sName": "ordem", "bSortable": false, "bSearchable": false },
        	{ "mDataProp": "data_atendimento", "sName": "o.data_atendimento" },
            { "mDataProp": "status", "sName": "status", "bSortable": false, "bSearchable": false },
        	{ "mDataProp": "rota", "sName": "rota", "bSortable": false, "bSearchable": false },
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
        "fnInitComplete": function() {
            if($('#filtro').val()=="Em Andamento")
                $('#filtro').val("Em%20Andamento");
            $('.select_filter[rel=4] option[value="'+$('#filtro').val()+'"]').attr('selected', true).trigger('change');
            
            $('.confirm').click(function(e){
                e.preventDefault();
                if (confirm('Você é realmente '+$('#usuario_nome').val()+'?')){
                    location.href = $(this).prop('href');
                    return true;
                } else {
                    location.href = URL_ADMIN+"logout/";
                    return false;
                }
            });
        },
        "fnServerData": function(sSource, aoData, fnCallback){
            aoData.push({ "name": "sSearchx", "value": $("#filtro").val() });
            $.getJSON( sSource, aoData, function(json){
                fnCallback(json);
            });
        }
	}).columnFilter({
        aoColumns: [ 
                null,
                null,
                { type: "select", values: [ 
                    'Instalação de Equipamento', 
                    'Leitura de Numerador', 
                    'Troca Cilindro/Toner', 
                    'Preventiva', 
                    'Manutenção no Equipamento', 
                    'Instalação de Equipamento', 
                    'Retirada de Equipamento', 
                    'Serviços de Informática', 
                    'Acesso remoto'
                ]  },
                null,
                { type: "select", values: [ 
                    'Em Andamento', 
                    'Cancelado', 
                    'Finalizado'
                ]  },
                null
            ]

    });

});