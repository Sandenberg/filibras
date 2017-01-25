<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['parcelado'] 		= isset($_POST['parcelado'])&&$_POST['parcelado']!=''?$_POST['parcelado']:null;
	$_POST['nf'] 				= isset($_POST['nf'])&&$_POST['nf']!=''?$_POST['nf']:null;
	$_POST['lancamento_nf']		= isset($_POST['lancamento_nf'])&&$_POST['lancamento_nf']!=''?$_POST['lancamento_nf']:null;
	$_POST['descricao'] 		= isset($_POST['descricao'])&&$_POST['descricao']!=''?$_POST['descricao']:null;
	$_POST['tipo_nf_id'] 		= isset($_POST['tipo_nf_id'])&&$_POST['tipo_nf_id']!=''?$_POST['tipo_nf_id']:null;
	$_POST['recibo'] 			= isset($_POST['recibo'])&&$_POST['recibo']!=''?$_POST['recibo']:null;
	$_POST['cliente_id'] 		= isset($_POST['cliente_id'])&&$_POST['cliente_id']!=''?$_POST['cliente_id']:null;
	$_POST['fornecedor_id'] 	= isset($_POST['fornecedor_id'])&&$_POST['fornecedor_id']!=''?$_POST['fornecedor_id']:null;
	$_POST['beneficiario_id'] 	= isset($_POST['beneficiario_id'])&&$_POST['beneficiario_id']!=''?$_POST['beneficiario_id']:null;
	$_POST['vencimento'] 		= isset($_POST['vencimento'])&&$_POST['vencimento']!=''&&$_POST['vencimento']!='__/__/____'?Util::dateConvert($_POST['vencimento']):null;
	$_POST['lancamento']		= isset($_POST['lancamento'])&&$_POST['lancamento']!=''&&$_POST['lancamento']!='__/__/____'?Util::dateConvert($_POST['lancamento']):date("Y-m-d");
	$_POST['tipo']				= isset($_POST['tipo'])&&$_POST['tipo']!=''?$_POST['tipo']:null;
	$_POST['conta_id']			= isset($_POST['conta_id'])&&$_POST['conta_id']!=''?$_POST['conta_id']:null;
	$_POST['tipo_id']			= isset($_POST['tipo_id'])&&$_POST['tipo_id']!=''?$_POST['tipo_id']:null;
	$_POST['valor']				= isset($_POST['valor'])&&$_POST['valor']!=''?$_POST['valor']:null;
	$_POST['valor'] 			= str_replace(",", ".", $_POST['valor']);
	

	if($_POST['tipo'] == 'credito'){
		$_POST['fornecedor_id'] = null;
		$_POST['beneficiario_id'] = null;
	} else {
		$_POST['cliente_id'] = null;
	}

	if($_POST['parcelado'] == 'Sim'){

		for ($i=0; $i < $_POST['parcelas']; $i++) { 
			$_POST['vencimento_parc'][$i] = isset($_POST['vencimento_parc'][$i])&&$_POST['vencimento_parc'][$i]!=''&&$_POST['vencimento_parc'][$i]!='__/__/____'?Util::dateConvert($_POST['vencimento_parc'][$i]):null;
			
			// echo number_format($_POST['valor_parc'][$i], 2, '.','');
			// Insert
			$parcela = $i + 1;
			$objLancamento							= new Lancamento();
			$objLancamento->data_lancamento			= $_POST['lancamento'];
			$objLancamento->data_lancamento_nf		= $_POST['lancamento_nf'];
			$objLancamento->beneficiario_id 		= $_POST['beneficiario_id'];
			$objLancamento->qtd_parcelas			= $_POST['parcelas'];
			$objLancamento->numero_parcela			= $parcela;
			$objLancamento->tipo 					= $_POST['tipo'];
			$objLancamento->recibo 					= $_POST['recibo'];
			$objLancamento->tipo_nf_id 				= $_POST['tipo_nf_id'];
			$objLancamento->nf 						= $_POST['nf'];
			$objLancamento->fornecedor_id 			= $_POST['fornecedor_id'];
			$objLancamento->cliente_id 				= $_POST['cliente_id'];
			$objLancamento->conta_id 				= $_POST['conta_id'];
			$objLancamento->lancamento_tipo_id 		= $_POST['tipo_id'];
			$objLancamento->descricao 				= $_POST['descricao']." ".$parcela."/".$_POST['parcelas'];
			$objLancamento->data_vencimento 		= $_POST['vencimento_parc'][$i];
			$objLancamento->valor_total				= str_replace(",", ".", $_POST['valor_parc'][$i]);
			$objLancamento->quantidade				= 1;
			$objLancamento->valor_unitario			= str_replace(",", ".", $_POST['valor_parc'][$i]);
			$objLancamento->status 					= 0;
			$objLancamento->save();
		}

	}else{

		// Insert
		$objLancamento							= new Lancamento();
		$objLancamento->data_lancamento			= $_POST['lancamento'];
		$objLancamento->beneficiario_id 		= $_POST['beneficiario_id'];
		$objLancamento->data_lancamento_nf		= $_POST['lancamento_nf'];
		$objLancamento->tipo 					= $_POST['tipo'];
		$objLancamento->recibo 					= $_POST['recibo'];
		$objLancamento->tipo_nf_id 				= $_POST['tipo_nf_id'];
		$objLancamento->nf 						= $_POST['nf'];
		$objLancamento->fornecedor_id 			= $_POST['fornecedor_id'];
		$objLancamento->cliente_id 				= $_POST['cliente_id'];
		$objLancamento->conta_id 				= $_POST['conta_id'];
		$objLancamento->lancamento_tipo_id 		= $_POST['tipo_id'];
		$objLancamento->descricao 				= $_POST['descricao'];
		$objLancamento->data_vencimento 		= $_POST['vencimento'];
		$objLancamento->valor_total				= str_replace(",", ".", $_POST['valor']);
		$objLancamento->quantidade				= 1;
		$objLancamento->valor_unitario			= str_replace(",", ".", $_POST['valor']);
		$objLancamento->status 					= 0;
		$objLancamento->save();

	}

	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
	
	Util::regLog('Crédito', $objLancamento->id, 'cadastrou', $objLancamento->Cliente->nome_completo);
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e;

	echo $e;	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');