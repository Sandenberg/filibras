$(document).ready(function() {
	$('#loginbox').hide().fadeIn(1000); /* LOGIN FADE */
	
	$("#loginform form, .form").validate(); /* LOGIN VALIDATE */
	
	$('.toggle').click(function() { /* BLOCK TOGGLE */
		$(this).toggleClass('show');
		$(this).parent().parent().children('.block_cont').slideToggle(300);
		$(this).parent().toggleClass('show');
	});
	
	$('.hide_btn').click(function() { /* ALERT HIDE */
		$(this).parent().fadeOut(300);
	});	
	
	$('.gallery_item .actionbar .delete').click(function() { /* GALLERY DELETE */
		$(this).parent().parent().fadeOut(300);
	});
	
	$("a.fancy").fancybox(); /* FANCYBOX CLASS */
		
	$('.table').wrap('<div class="table-wrap" />'); /* NORMAL TABLE */
	$('.table tr:even').addClass('even'); /* ODD/EVEN TABLEROW CLASS */
	
	$('.form').validationEngine(); /* VALIDATION ENGINE */
	
	$('.tipTop').tipsy({gravity: 's', fade: true}); /* TOOLTIP CLASS */
	$('.tipBot').tipsy({gravity: 'n', fade: true}); /* TOOLTIP CLASS */
	$('.tipLeft').tipsy({gravity: 'e', fade: true}); /* TOOLTIP CLASS */
	$('.tipRight').tipsy({gravity: 'w', fade: true}); /* TOOLTIP CLASS */



	$('input[name^=telefone]').focusout(function(){
	    var phone, element;
	    element = $(this);
	    element.unmask();
	    phone = element.val().replace(/\D/g, '');
	    if(phone.length > 10) {
	        element.mask("(99) 99999-999?9");
	    } else {
	        element.mask("(99) 9999-9999?9");
	    }
	}).trigger('focusout');
	
	
	$('.ie #userbar').corner('top 5px'); /* IE BORDER-RADIUS FIX */
	$('.ie .titlebar').corner('top 5px'); /* IE BORDER-RADIUS FIX */
	$('.ie .block_cont').corner('bottom 5px'); /* IE BORDER-RADIUS FIX */
	$('.ie .error, .ie .warning, .ie .success, .ie .information').corner('5px'); /* IE BORDER-RADIUS FIX */
});

