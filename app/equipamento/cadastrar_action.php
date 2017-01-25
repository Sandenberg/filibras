<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	$_POST['data_compra']				= isset($_POST['data_compra'])&&$_POST['data_compra']!=''?Util::dateConvert($_POST['data_compra']):null;
	$_POST['nf_compra']					= isset($_POST['nf_compra'])&&$_POST['nf_compra']!=''?$_POST['nf_compra']:null;
	$_POST['fornecedor_id']					= isset($_POST['fornecedor_id'])&&$_POST['fornecedor_id']!=''?$_POST['fornecedor_id']:null;
	
	// Insert
	$objEquipamento								= new Equipamento();
	$objEquipamento->serial 					= $_POST['serial'];
	$objEquipamento->patrimonio 				= md5(date('YmdHis').rand(0, 180000000));
	$objEquipamento->tipo_impressao				= $_POST['tipo_impressao'];
	$objEquipamento->data_cadastro				= date('Y-m-d H:i:s');
	$objEquipamento->equipamento_tipo_id		= $_POST['equipamento_tipo_id'];
	$objEquipamento->fornecedor_id				= $_POST['fornecedor_id'];
	$objEquipamento->data_compra				= $_POST['data_compra'];
	$objEquipamento->nf_compra					= $_POST['nf_compra'];
	$objEquipamento->marca_id					= $_POST['marca_id'];
	$objEquipamento->equipamento_modelo_id		= $_POST['equipamento_modelo_id'];
	$objEquipamento->equipamento_situacao_id	= $_POST['equipamento_situacao_id'];
	// $objEquipamento->procedimento				= $_POST['procedimento'];
	$objEquipamento->status						= $_POST['status'];
	$objEquipamento->save();
	
	// Gera o número de patrimônio
	$objEquipamento->patrimonio	= str_pad($objEquipamento->id, 6, '0', STR_PAD_LEFT);
	$objEquipamento->save();

	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');