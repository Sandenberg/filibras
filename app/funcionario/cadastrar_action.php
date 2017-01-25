<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['telefone_principal']	= $_POST['telefone_principal']!=''?Util::getNumbers($_POST['telefone_principal']):null;
	$_POST['telefone_alternativo']	= $_POST['telefone_alternativo']!=''?Util::getNumbers($_POST['telefone_alternativo']):null;
	$_POST['cidade_id']				= isset($_POST['cidade_id'])&&$_POST['cidade_id']!=''?Util::getNumbers($_POST['cidade_id']):null;	
	$_POST['cpf']					= $_POST['cpf']!=''?Util::getNumbers($_POST['cpf']):null;	
	$_POST['cep']					= $_POST['cep']!=''?Util::getNumbers($_POST['cep']):null;
	$_POST['numero']				= $_POST['numero']!=''?Util::getNumbers($_POST['numero']):null;

	$cpf    = $_POST['cpf'];
	$ativo = null;
	if (isset($_POST['ativo']))
	{
		$ativo = $_POST['ativo'];
	}
	
        
		
	$retFilial	= 	Doctrine_Query::create()->select()->from('Funcionario')
	->where("cpf = '$cpf'")->execute();
	
	if ($retFilial->count() == 0){
	
	// Insert
	$objFuncionario 						= new Funcionario();
	$objFuncionario->nome_completo			= $_POST['nome_completo'];
	$objFuncionario->cpf					= $_POST['cpf'];		
	$objFuncionario->email					= $_POST['email']!=''?$_POST['email']:null;
	$objFuncionario->telefone_principal		= $_POST['telefone_principal'];
	$objFuncionario->telefone_alternativo	= $_POST['telefone_alternativo'];
	$objFuncionario->cep				= $_POST['cep'];
	$objFuncionario->logradouro				= $_POST['logradouro'];
	$objFuncionario->numero					= $_POST['numero'];
	$objFuncionario->complemento			= $_POST['complemento']!=''?$_POST['complemento']:null;
	$objFuncionario->referencia				= $_POST['referencia']!=''?$_POST['referencia']:null;
	$objFuncionario->bairro					= $_POST['bairro'];
	$objFuncionario->cidade_id				= $_POST['cidade_id'];
	$objFuncionario->observacoes			= $_POST['observacoes']!=''?$_POST['observacoes']:null;
	$objFuncionario->data_cadastro			= date('Y-m-d H:i:s');
	$objFuncionario->ativo                  = $ativo;
	$objFuncionario->save();
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
	
	}else{
		
		$_SESSION['return_type'] 	= 'error';
		$_SESSION['return_message']	= 'Registro ja Cadastrado!';
	}
	
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= "$e";
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');