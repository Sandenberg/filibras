<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['telefone_principal']	= $_POST['telefone_principal']!=''?Util::getNumbers($_POST['telefone_principal']):null;
	$_POST['telefone_alternativo']	= $_POST['telefone_alternativo']!=''?Util::getNumbers($_POST['telefone_alternativo']):null;
	$_POST['cpf']					= $_POST['cpf']!=''?Util::getNumbers($_POST['cpf']):null;
	$_POST['cnpj']					= $_POST['cnpj']!=''?Util::getNumbers($_POST['cnpj']):null;
	$_POST['cep']					= $_POST['cep']!=''?Util::getNumbers($_POST['cep']):null;
	$_POST['numero']				= $_POST['numero']!=''?Util::getNumbers($_POST['numero']):null;
	
	$filial = $_POST['filial_id'];
	$cnjp   = $_POST['cnpj'];
	$cpf    = $_POST['cpf'];


        
        
		
	$retFilial		= 	Doctrine_Query::create()->select()->from('Cliente')
	->where("filial_id  = '$filial' and (cpf = '$cpf' or cnpj = '$cnjp')")->execute();

	
	if ($retFilial->count() == 0){
	
		// Insert
		$objCliente 						= new Cliente();
		$objCliente->tipo_pessoa			= $_POST['tipo_pessoa'];
		$objCliente->nome_completo			= $_POST['nome_completo'];
		$objCliente->cpf					= $_POST['cpf'];
		$objCliente->cnpj					= $_POST['cnpj'];
		$objCliente->rg						= $_POST['rg']!=''?$_POST['rg']:null;
		$objCliente->inscricao_estadual		= $_POST['inscricao_estadual']!=''?$_POST['inscricao_estadual']:null;
		$objCliente->email					= $_POST['email']!=''?strtolower($_POST['email']):null; 
		$objCliente->telefone_principal		= $_POST['telefone_principal'];
		$objCliente->telefone_alternativo	= $_POST['telefone_alternativo'];
		$objCliente->logradouro				= $_POST['logradouro'];
		$objCliente->numero					= $_POST['numero'];
		$objCliente->complemento			= $_POST['complemento']!=''?$_POST['complemento']:null;
		$objCliente->referencia				= $_POST['referencia']!=''?$_POST['referencia']:null;
		$objCliente->bairro					= $_POST['bairro'];
		$objCliente->cidade_id				= $_POST['cidade_id'];
		$objCliente->cep					= $_POST['cep'];
		$objCliente->observacoes			= $_POST['observacoes']!=''?$_POST['observacoes']:null;
		$objCliente->data_cadastro			= date('Y-m-d H:i:s');
		$objCliente->filial_id              = $_POST['filial_id'];
		$objCliente->save();
		


		// Insert
		$objContato						= new ClienteResponsavel();
		$objContato->nome				= $_POST['nome_contato'];
		$objContato->email				= $_POST['email_contato']!=''?strtolower($_POST['email_contato']):null; 
		$objContato->tipo				= 0;
		$objContato->cliente_id			= $objCliente->id;
		$objContato->save();
		
		// Tratamento de retorno
		$_SESSION['return_type'] 	= 'success';
		$_SESSION['return_message']	= 'Executado com sucesso!';
		
		Util::regLog('Cliente', $objCliente->id, 'cadastrou', $objCliente->nome_completo);
	}else{
		
		$_SESSION['return_type'] 	= 'error';
		$_SESSION['return_message']	= 'Registro ja Cadastrado!';
	}
	
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= "$objCliente->getSQl()";
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');