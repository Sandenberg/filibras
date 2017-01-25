$(document).ready(function(){

	

	$('.data-table').dataTable({

		"sDom": '<"data-table-top"<"data-table-entries"l><"data-table-search"f>><"clear"><"table-wrap"rt><"clear"><"data-table-bottom"<"float_left"i><"float_right"p>><"clear">',

		"bJQueryUI": true,

		"bProcessing": true,

        "bServerSide": true,

        "sAjaxSource": URL_ADMIN+"action.php?model=material&action=listar",
        "iDisplayLength": 25,

        "aLengthMenu": [25, 50, 100, 200, 300, 400, 500],

        // "iDisplayLength": 100,

        "aoColumns": [

          	{ "mDataProp": "tipo", "sName": "tipo", "bSearchable": false },

        	{ "mDataProp": "nome", "sName": "nome" },

            { "mDataProp": "localizacao", "sName": "localizacao" },
            { "mDataProp": "valor", "sName": "valor", "bSearchable": false },

        	{ "mDataProp": "estoque", "sName": "estoque", "bSearchable": false },
            { "mDataProp": "minimo", "sName": "minimo", "bSearchable": false },

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
          var id = aData.localizacao; // ID is returned by the server as part of the data
          var estoque = aData.estoque;
          var minimo = aData.minimo;
          var $nRow = $(nRow); // cache the row wrapped up in jQuery
          if (id == "NÃO TEM") {
            $nRow.css({"background-color":"#f5d2d2", 'font-weight':'600'})
          }else if(parseInt(minimo) > 0 && parseInt(estoque) < parseInt(minimo)){
            $nRow.css({'font-weight':'600'})
          }
          return nRow
        }

	});



});