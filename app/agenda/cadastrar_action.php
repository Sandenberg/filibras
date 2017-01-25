<?php ob_start();
 
defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	$_POST['telefone_principal']	= $_POST['telefone_principal']!=''?Util::getNumbers($_POST['telefone_principal']):null;
	$_POST['telefone_alternativo']	= $_POST['telefone_alternativo']!=''?Util::getNumbers($_POST['telefone_alternativo']):null;
	$_POST['cpf']					= $_POST['cpf']!=''?Util::getNumbers($_POST['cpf']):null;
	$_POST['cnpj']					= $_POST['cnpj']!=''?Util::getNumbers($_POST['cnpj']):null;
	$_POST['cep']					= $_POST['cep']!=''?Util::getNumbers($_POST['cep']):null;
	$_POST['numero']				= $_POST['numero']!=''?Util::getNumbers($_POST['numero']):null;
	

	$cnjp   = $_POST['cnpj'];
	$cpf    = $_POST['cpf'];
        
        
		

	
	// Insert
	$objAgenda 						    = new Agenda();
	$objAgenda->tipo_pessoa			    = $_POST['tipo_pessoa'];
	$objAgenda->nome_completo			= $_POST['nome_completo'];
	$objAgenda->cpf					    = $_POST['cpf'];
	$objAgenda->cnpj					= $_POST['cnpj'];
	$objAgenda->email					= $_POST['email']!=''?$_POST['email']:null;
	$objAgenda->telefone_principal		= $_POST['telefone_principal'];
	$objAgenda->telefone_alternativo	= $_POST['telefone_alternativo'];
	$objAgenda->logradouro				= $_POST['logradouro'];
	$objAgenda->numero					= $_POST['numero'];
	$objAgenda->complemento			    = $_POST['complemento']!=''?$_POST['complemento']:null;
	$objAgenda->referencia				= $_POST['referencia']!=''?$_POST['referencia']:null;
	$objAgenda->bairro					= $_POST['bairro'];
	$objAgenda->cidade_id				= $_POST['cidade_id'];
	$objAgenda->cep					    = $_POST['cep'];	
	$objAgenda->data_cadastro			= date('Y-m-d H:i:s');
	$objAgenda->obs                     = $_POST['obs'];
	$objAgenda->nome_contato			= $_POST['nome_contato'];
	$objAgenda->email_contato			= $_POST['email_contato'];
	$objAgenda->save();
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
	
	
	Util::regLog('Agenda', $objAgenda->id, 'cadastrou', $_POST['nome_completo']);
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= "$objAgenda->getSQl()";
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');