<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['id'] 					= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;
	$_POST['telefone_principal']	= $_POST['telefone_principal']!=''?Util::getNumbers($_POST['telefone_principal']):null;
	$_POST['telefone_alternativo']	= $_POST['telefone_alternativo']!=''?Util::getNumbers($_POST['telefone_alternativo']):null;
	$_POST['cep']					= Util::getNumbers($_POST['cep']);
	$_POST['cpf']					= $_POST['cpf']!=''?Util::getNumbers($_POST['cpf']):null;
	$_POST['cnpj']					= $_POST['cnpj']!=''?Util::getNumbers($_POST['cnpj']):null;
	$_POST['numero']				= $_POST['numero']!=''?Util::getNumbers($_POST['numero']):null;
	
	$tipo_fornecimento              = implode(',', $_POST['tipo_fornecimento']);
	
	// Update
	$objFornecedor 							= Doctrine_Core::getTable('Fornecedor')->find($_POST['id']);
	$objFornecedor->tipo_fornecimento		= $tipo_fornecimento;
	$objFornecedor->cnpj					= $_POST['cnpj'];
	$objFornecedor->cpf						= $_POST['cpf'];
	$objFornecedor->nome_completo			= $_POST['nome_completo'];
	$objFornecedor->inscricao_estadual		= $_POST['inscricao_estadual']!=''?$_POST['inscricao_estadual']:null;
	$objFornecedor->rg						= $_POST['rg']!=''?$_POST['rg']:null;
	$objFornecedor->email					= $_POST['email']!=''?$_POST['email']:null;
	$objFornecedor->telefone_principal		= $_POST['telefone_principal'];
	$objFornecedor->telefone_alternativo	= $_POST['telefone_alternativo'];
	$objFornecedor->logradouro				= $_POST['logradouro'];
	$objFornecedor->numero					= $_POST['numero'];
	$objFornecedor->complemento				= $_POST['complemento']!=''?$_POST['complemento']:null;
	$objFornecedor->referencia				= $_POST['referencia']!=''?$_POST['referencia']:null;
	$objFornecedor->bairro					= $_POST['bairro'];
	$objFornecedor->cidade_id				= $_POST['cidade_id'];
	$objFornecedor->cep						= $_POST['cep'];
	$objFornecedor->observacoes				= $_POST['observacoes']!=''?$_POST['observacoes']:null;
	$objFornecedor->save();



	// Update
	$objContato						= Doctrine_Core::getTable('FornecedorResponsavel')->find($_POST['id_contato']);
	$objContato->nome				= $_POST['nome_contato'];
	$objContato->email				= $_POST['email_contato'];
	$objContato->tipo				= 0;
	$objContato->save();
		
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';

	Util::regLog('Fornecedor', $objFornecedor->id, 'editou');
} catch(Exception $e){
		
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');