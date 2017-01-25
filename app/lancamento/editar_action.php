<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['id'] 				= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;
	$_POST['cliente_id'] 		= isset($_POST['cliente_id'])&&$_POST['cliente_id']!=''?$_POST['cliente_id']:null;
	$_POST['fornecedor_id'] 	= isset($_POST['fornecedor_id'])&&$_POST['fornecedor_id']!=''?$_POST['fornecedor_id']:null;
	$_POST['beneficiario_id'] 	= isset($_POST['beneficiario_id'])&&$_POST['beneficiario_id']!=''?$_POST['beneficiario_id']:null;
	$_POST['vencimento'] 		= isset($_POST['vencimento'])&&$_POST['vencimento']!=''&&$_POST['vencimento']!='__/__/____'?Util::dateConvert($_POST['vencimento']):null;
	
	if($_POST['tipo'] == 'credito'){
		$_POST['fornecedor_id'] = null;
		$_POST['beneficiario_id'] = null;
	} else {
		$_POST['cliente_id'] = null;
	}

	$objLancamento							= Doctrine_Core::getTable('Lancamento')->find($_POST['id']);
	$objLancamento->data_lancamento			= date('Y-m-d H:i:s');
	$objLancamento->tipo 					= $_POST['tipo'];
	$objLancamento->beneficiario_id 		= $_POST['beneficiario_id'];
	$objLancamento->fornecedor_id 			= $_POST['fornecedor_id'];
	$objLancamento->cliente_id 				= $_POST['cliente_id'];
	$objLancamento->conta_id 				= $_POST['conta_id'];
	$objLancamento->lancamento_tipo_id 		= $_POST['tipo_id'];
	$objLancamento->descricao 				= $_POST['descricao'];
	$objLancamento->data_vencimento 		= $_POST['vencimento'];
	$objLancamento->valor_total				= number_format($_POST['valor'], 2, '.', '');
	$objLancamento->valor_unitario			= number_format($_POST['valor'], 2, '.', '');
	$objLancamento->save();

	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
	


} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e;
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');