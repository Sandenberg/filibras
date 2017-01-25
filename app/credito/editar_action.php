<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['id'] 				= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;
	$_POST['cliente_id'] 		= isset($_POST['cliente_id'])&&$_POST['cliente_id']!=''?$_POST['cliente_id']:null;
	$_POST['fornecedor_id'] 	= isset($_POST['fornecedor_id'])&&$_POST['fornecedor_id']!=''?$_POST['fornecedor_id']:null;
	$_POST['beneficiario_id'] 	= isset($_POST['beneficiario_id'])&&$_POST['beneficiario_id']!=''?$_POST['beneficiario_id']:null;
	$_POST['vencimento'] 		= isset($_POST['vencimento'])&&$_POST['vencimento']!=''&&$_POST['vencimento']!='__/__/____'?Util::dateConvert($_POST['vencimento']):null;
	$_POST['lancamento'] 		= isset($_POST['lancamento'])&&$_POST['lancamento']!=''&&$_POST['lancamento']!='__/__/____'?Util::dateConvert($_POST['lancamento']):null;
	$_POST['valor'] 			= str_replace(",", ".", $_POST['valor']);
	$_POST['recibo'] 			= isset($_POST['recibo'])&&$_POST['recibo']!=''?$_POST['recibo']:null;
	$_POST['lancamento_nf'] 	= isset($_POST['lancamento_nf'])&&$_POST['lancamento_nf']!=''?$_POST['lancamento_nf']:null;
	$_POST['descricao'] 		= isset($_POST['descricao'])&&$_POST['descricao']!=''?$_POST['descricao']:null;
	$_POST['nf'] 				= isset($_POST['nf'])&&$_POST['nf']!=''?$_POST['nf']:null;
	$_POST['tipo_nf_id'] 		= isset($_POST['tipo_nf_id'])&&$_POST['tipo_nf_id']!=''?$_POST['tipo_nf_id']:null;
	$_POST['tipo']				= isset($_POST['tipo'])&&$_POST['tipo']!=''?$_POST['tipo']:null;
	$_POST['conta_id']			= isset($_POST['conta_id'])&&$_POST['conta_id']!=''?$_POST['conta_id']:null;
	$_POST['tipo_id']			= isset($_POST['tipo_id'])&&$_POST['tipo_id']!=''?$_POST['tipo_id']:null;
	$_POST['valor']				= isset($_POST['valor'])&&$_POST['valor']!=''?$_POST['valor']:null;
	// $_POST['lancamento_nf'] 	= ;
	
	if($_POST['tipo'] == 'credito'){
		$_POST['fornecedor_id'] = null;
		$_POST['beneficiario_id'] = null;
	} else {
		$_POST['cliente_id'] = null;
	}

	$objLancamento							= Doctrine_Core::getTable('Lancamento')->find($_POST['id']);
	$objLancamento->data_lancamento			= $_POST['lancamento'].' '.date('H:i:s');
	$objLancamento->recibo 					= $_POST['recibo'];
	$objLancamento->nf 						= $_POST['nf'];
	$objLancamento->data_lancamento_nf		= $_POST['lancamento_nf'];
	$objLancamento->tipo 					= $_POST['tipo'];
	$objLancamento->beneficiario_id 		= $_POST['beneficiario_id'];
	$objLancamento->fornecedor_id 			= $_POST['fornecedor_id'];
	$objLancamento->tipo_nf_id 				= $_POST['tipo_nf_id'];
	$objLancamento->cliente_id 				= $_POST['cliente_id'];
	$objLancamento->conta_id 				= $_POST['conta_id'];
	$objLancamento->lancamento_tipo_id 		= $_POST['tipo_id'];
	$objLancamento->descricao 				= $_POST['descricao'];
	$objLancamento->data_vencimento 		= $_POST['vencimento'];
	$objLancamento->valor_total				= str_replace(",", ".", $_POST['valor']);
	$objLancamento->valor_unitario			= str_replace(",", ".", $_POST['valor']);
	$objLancamento->save();

	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
	


	Util::regLog('Crédito', $objLancamento->id, 'editou', $objLancamento->Cliente->nome_completo);
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e;
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');