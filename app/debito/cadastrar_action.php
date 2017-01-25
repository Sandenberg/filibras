<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['parcelado'] 		= isset($_POST['parcelado'])&&$_POST['parcelado']!=''?$_POST['parcelado']:null;
	$_POST['recibo'] 			= isset($_POST['recibo'])&&$_POST['recibo']!=''?$_POST['recibo']:null;
	$_POST['nf'] 				= isset($_POST['nf'])&&$_POST['nf']!=''?$_POST['nf']:null;
	$_POST['cliente_id'] 		= isset($_POST['cliente_id'])&&$_POST['cliente_id']!=''?$_POST['cliente_id']:null;
	$_POST['descricao'] 		= isset($_POST['descricao'])&&$_POST['descricao']!=''?$_POST['descricao']:null;
	$_POST['fornecedor_id'] 	= isset($_POST['fornecedor_id'])&&$_POST['fornecedor_id']!=''?$_POST['fornecedor_id']:null;
	$_POST['beneficiario_id'] 	= isset($_POST['beneficiario_id'])&&$_POST['beneficiario_id']!=''?$_POST['beneficiario_id']:null;
	$_POST['vencimento'] 		= isset($_POST['vencimento'])&&$_POST['vencimento']!=''&&$_POST['vencimento']!='__/__/____'?Util::dateConvert($_POST['vencimento']):null;
	$_POST['valor'] 			= str_replace(",", ".", $_POST['valor']);
	$_POST['tipo_nf_id'] 		= isset($_POST['tipo_nf_id'])&&$_POST['tipo_nf_id']!=''?$_POST['tipo_nf_id']:null;
	$_POST['lancamento_nf'] 	= isset($_POST['lancamento_nf'])&&$_POST['lancamento_nf']!=''&&$_POST['lancamento_nf']!='__/__/____'?Util::dateConvert($_POST['lancamento_nf']):null;
		

	if($_POST['tipo'] == 'credito'){
		$_POST['fornecedor_id'] = null;
		$_POST['beneficiario_id'] = null;
	} else {
		$_POST['cliente_id'] = null;
	}

	if($_POST['parcelado'] == 'Sim'){

		for ($i=0; $i < $_POST['parcelas']; $i++) { 
			$_POST['vencimento_parc'][$i] = isset($_POST['vencimento_parc'][$i])&&$_POST['vencimento_parc'][$i]!=''&&$_POST['vencimento_parc'][$i]!='__/__/____'?Util::dateConvert($_POST['vencimento_parc'][$i]):null;
			
			$_POST['valor_parc'][$i] 			= str_replace(",", ".", $_POST['valor_parc'][$i]);
			// echo number_format($_POST['valor_parc'][$i], 2, '.','');
			// Insert
			$parcela = $i + 1;
			$objLancamento							= new Lancamento();
			$objLancamento->data_lancamento			= date('Y-m-d H:i:s');
			$objLancamento->beneficiario_id 			= $_POST['beneficiario_id'];
			$objLancamento->data_lancamento_nf		= $_POST['lancamento_nf'];
			$objLancamento->qtd_parcelas			= $_POST['parcelas'];
			$objLancamento->numero_parcela			= $parcela;
			$objLancamento->tipo 					= $_POST['tipo'];
			$objLancamento->fornecedor_id 			= $_POST['fornecedor_id'];
			$objLancamento->recibo 					= $_POST['recibo'];
			$objLancamento->tipo_nf_id 				= $_POST['tipo_nf_id'];
			$objLancamento->nf 						= $_POST['nf'];
			$objLancamento->cliente_id 				= $_POST['cliente_id'];
			$objLancamento->conta_id 				= $_POST['conta_id'];
			$objLancamento->lancamento_tipo_id 		= $_POST['tipo_id'];
			$objLancamento->descricao 				= $_POST['descricao']." ".$parcela."/".$_POST['parcelas'];
			$objLancamento->data_vencimento 		= $_POST['vencimento_parc'][$i];
			$objLancamento->valor_total				= $_POST['valor_parc'][$i];
			$objLancamento->quantidade				= 1;
			$objLancamento->valor_unitario			= $_POST['valor_parc'][$i];
			$objLancamento->status 					= 0;
			$objLancamento->save();
		}

	}else{

		// Insert
		$objLancamento							= new Lancamento();
		$objLancamento->data_lancamento			= date('Y-m-d H:i:s');
		$objLancamento->beneficiario_id 			= $_POST['beneficiario_id'];
		$objLancamento->tipo 					= $_POST['tipo'];
		$objLancamento->recibo 					= $_POST['recibo'];
		$objLancamento->nf 						= $_POST['nf'];
		$objLancamento->data_lancamento_nf		= $_POST['lancamento_nf'];
		$objLancamento->fornecedor_id 			= $_POST['fornecedor_id'];
		$objLancamento->cliente_id 				= $_POST['cliente_id'];
		$objLancamento->conta_id 				= $_POST['conta_id'];
		$objLancamento->lancamento_tipo_id 		= $_POST['tipo_id'];
		$objLancamento->descricao 				= $_POST['descricao'];
		$objLancamento->tipo_nf_id 				= $_POST['tipo_nf_id'];
		$objLancamento->data_vencimento 		= $_POST['vencimento'];
		$objLancamento->valor_total				= $_POST['valor'];
		$objLancamento->quantidade				= 1;
		$objLancamento->valor_unitario			= $_POST['valor'];
		$objLancamento->status 					= 0;
		$objLancamento->save();

	}

	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
	
	Util::regLog('Débito', $objLancamento->id, 'cadastrou', $objLancamento->Cliente->nome_completo);
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e;

	echo $e;	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');