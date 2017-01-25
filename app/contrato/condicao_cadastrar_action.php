<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Trata o action
	$action = explode('_', $_GET['action']);
	$action = $action[0];
	
	// Tratamento de dados
	$_POST['servico_id']		= $_POST['servico_id']!=''?$_POST['servico_id']:null;
	$_POST['data_verificacao']	= Util::dateConvert($_POST['data_verificacao']).' '.$_POST['hora_verificacao'];
	
	// Insert
	$objCondicao					= new EquipamentoCondicao();
	$objCondicao->data_verificacao	= $_POST['data_verificacao'];
	$objCondicao->condicao_id		= $_POST['condicao_id'];
	$objCondicao->servico_id		= $_POST['servico_id'];
	$objCondicao->equipamento_id	= $_POST['equipamento_id'];
	$objCondicao->save();
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
		
	
	
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/'.$action.'_listar/'.$_POST['equipamento_id'].'/');