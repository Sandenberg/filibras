$(document).ready(function(){
	
	//Mascara Valor
	$("#valor").maskMoney({showSymbol: false, decimal: ",", thousands:"."});
	$('#minimo').mask('9?9999')
	
});