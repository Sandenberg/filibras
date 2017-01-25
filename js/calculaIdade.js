/**
* jQuery CalculaIdade v1.0.0 - http://wborbajr.blogspot.com/jquery.CalculaIdade.php
*
* Copyright (c) 2008 Waldir Borba Junior (stilbuero.de)
* Dual licensed under the MIT and GPL licenses:
* http://www.opensource.org/licenses/mit-license.php
* http://www.gnu.org/licenses/gpl.html
*
* Usando calculaIdade().
*
* @exemplo
*
* $('#campos_formulario').val( $().calculaIdade( "dd/mm/yyyy" ) );
*
* $('#campos_formulario').val( $().calculaIdade( "dd/mm/yy" ) );
*
* @desc Calcula a idade de uma data informada e retorno no formato 99 a 99 m -
*            #ERR# - se a data informada  nao estiver correta
*
*/

$.fn.calculaIdade = function ( dataNascimento ) {
 var hoje = new Date();
 
 var arrayData = dataNascimento.split("/");
 
 var retorno = "#ERR#";
 
 if (arrayData.length == 3) {
  // Decompoem a data em array
  var ano = parseInt( arrayData[2] );
  var mes = parseInt( arrayData[1] );
  var dia = parseInt( arrayData[0] );
  
  // Valida a data informada
  if ( arrayData[0] > 31 || arrayData[1] > 12 ) {
   return retorno;
  }  
  
  ano = ( ano.length == 2 ) ? ano += 1900 : ano;

  // Subtrai os anos das duas datas
  var idade = ( hoje.getFullYear() ) - ano;

  // Subtrai os meses das duas datas
  var meses = ( hoje.getMonth() + 1 ) - mes;
  
  // Se meses for menor que 0 entao nao cumpriu anos. Se for maior sim ja cumpriu
  idade = ( meses < 0 ) ? idade - 1 : idade;    

  meses = ( meses < 0 ) ? meses + 12 : meses;      

  retorno = ( idade );  
 }   

 return retorno;
}; 