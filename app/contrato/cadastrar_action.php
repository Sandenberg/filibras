<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de valores
	$_POST['valor_monocromatica'] 		= isset($_POST['valor_monocromatica'])?preg_replace('/[.]/', '', $_POST['valor_monocromatica']):null;
	$_POST['valor_monocromatica'] 		= isset($_POST['valor_monocromatica'])?preg_replace('/[,]/', '.', $_POST['valor_monocromatica']):null;
	$_POST['valor_colorida'] 			= isset($_POST['valor_colorida'])?preg_replace('/[.]/', '', $_POST['valor_colorida']):null;
	$_POST['valor_colorida'] 			= isset($_POST['valor_colorida'])?preg_replace('/[,]/', '.', $_POST['valor_colorida']):null;
	$_POST['adicional_monocromatica'] 	= isset($_POST['adicional_monocromatica'])?preg_replace('/[.]/', '', $_POST['adicional_monocromatica']):null;
	$_POST['adicional_monocromatica'] 	= isset($_POST['adicional_monocromatica'])?preg_replace('/[,]/', '.', $_POST['adicional_monocromatica']):null;
	$_POST['adicional_colorida'] 		= isset($_POST['adicional_colorida'])?preg_replace('/[.]/', '', $_POST['adicional_colorida']):null;
	$_POST['adicional_colorida'] 		= isset($_POST['adicional_colorida'])?preg_replace('/[,]/', '.', $_POST['adicional_colorida']):null;
	$_POST['valor'] 		            = isset($_POST['valor'])?preg_replace('/[,]/', '.', $_POST['valor']):null;
		
	// Tratamento de dados
	$_POST['numero'] 					= isset($_POST['numero'])?$_POST['numero']:null;
	$_POST['data_inicio']				= isset($_POST['data_inicio'])&&$_POST['data_inicio']!=''?Util::dateConvert($_POST['data_inicio']):null;
	$_POST['data_fim']					= isset($_POST['data_fim'])&&$_POST['data_fim']!=''?Util::dateConvert($_POST['data_fim']):null;
	$_POST['inicio_garantia']			= isset($_POST['inicio_garantia'])&&$_POST['inicio_garantia']!=''?Util::dateConvert($_POST['inicio_garantia']):null;
	$_POST['fim_garantia']				= isset($_POST['fim_garantia'])&&$_POST['fim_garantia']!=''?Util::dateConvert($_POST['fim_garantia']):null;
	$_POST['dia_leitura']				= isset($_POST['dia_leitura'])&&$_POST['dia_leitura']!=''?$_POST['dia_leitura']:null;
	$_POST['franquia_monocromatica']	= isset($_POST['franquia_monocromatica'])&&$_POST['franquia_monocromatica']!=''?Util::getNumbers($_POST['franquia_monocromatica']):null;
	$_POST['franquia_colorida']			= isset($_POST['franquia_colorida'])&&$_POST['franquia_colorida']!=''?Util::getNumbers($_POST['franquia_colorida']):null;
	$_POST['valor_monocromatica']		= isset($_POST['valor_monocromatica'])&&doubleval($_POST['valor_monocromatica'])>0?doubleval($_POST['valor_monocromatica']):null;
	$_POST['valor_colorida']			= isset($_POST['valor_colorida'])&&doubleval($_POST['valor_colorida'])>0?doubleval($_POST['valor_colorida']):null;
	$_POST['adicional_monocromatica']	= isset($_POST['adicional_monocromatica'])&&doubleval($_POST['adicional_monocromatica'])>0?doubleval($_POST['adicional_monocromatica']):null;
	$_POST['adicional_colorida']		= isset($_POST['adicional_colorida'])&&doubleval($_POST['adicional_colorida'])>0?doubleval($_POST['adicional_colorida']):null;
	$_POST['valor']             		= isset($_POST['valor'])&&doubleval($_POST['valor'])>0?doubleval($_POST['valor']):null;
	$_POST['identificacao']        		= isset($_POST['identificacao'])&&$_POST['identificacao']!=''?$_POST['identificacao']:null;

	
	
	$garantia = null;
	if (isset($_POST['ativo']))
	{
		$garantia = $_POST['ativo'];
	}
	
	
	
	
	// Insert
	$objContrato							= new Contrato();
	$objContrato->tipo 						= $_POST['tipo'];
	$objContrato->numero 					= $_POST['numero'];
	$objContrato->data_inicio 				= $_POST['data_inicio'];
	$objContrato->data_fim 					= $_POST['data_fim'];
	$objContrato->data_inclusao				= date('Y-m-d H:i:s');
	$objContrato->garantia 					= $garantia;
	$objContrato->identificacao 			= $_POST['identificacao'];
	$objContrato->inicio_garantia 			= $_POST['inicio_garantia'];
	$objContrato->fim_garantia 				= $_POST['fim_garantia'];
	$objContrato->dia_leitura 				= $_POST['dia_leitura'];
	$objContrato->renovacao 				= $_POST['renovacao'];
	$objContrato->franquia_monocromatica 	= $_POST['franquia_monocromatica'];
	$objContrato->franquia_colorida 		= $_POST['franquia_colorida'];
	$objContrato->valor_monocromatica 		= $_POST['valor_monocromatica'];
	$objContrato->valor_colorida 			= $_POST['valor_colorida'];
	$objContrato->adicional_monocromatica 	= $_POST['adicional_monocromatica'];
	$objContrato->adicional_colorida 		= $_POST['adicional_colorida'];
	$objContrato->cliente_id 				= $_POST['cliente_id'];
	$objContrato->valor                     =$_POST['valor'];
	$objContrato->save();
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
		

	Util::regLog('Contrato', $objContrato->id, 'cadastrou', $objContrato->Cliente->nome_completo);
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= "$e";
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');