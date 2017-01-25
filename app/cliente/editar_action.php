<?php



defined('_ACTION') or exit('Direct access to the script is not allowed!');







try {

	

	// Tratamento de dados

	$_POST['id'] 					= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;

	$_POST['ativo'] 					= isset($_POST['ativo'])&&$_POST['ativo']!=''?$_POST['ativo']:0;

	$_POST['telefone_principal']	= $_POST['telefone_principal']!=''?Util::getNumbers($_POST['telefone_principal']):null;

	$_POST['telefone_alternativo']	= $_POST['telefone_alternativo']!=''?Util::getNumbers($_POST['telefone_alternativo']):null;

	$_POST['cep']					= Util::getNumbers($_POST['cep']);

	$_POST['cpf']					= $_POST['cpf']!=''?Util::getNumbers($_POST['cpf']):null;

	$_POST['cnpj']					= $_POST['cnpj']!=''?Util::getNumbers($_POST['cnpj']):null;

	$_POST['restricao']					= isset($_POST['restricao'])&&$_POST['restricao']!=''?$_POST['restricao']:null;

	$_POST['numero'] = $_POST['numero']!=''?Util::getNumbers($_POST['numero']):null;



	



	// Update

	$objCliente 						= Doctrine_Core::getTable('Cliente')->find($_POST['id']);

	$objCliente->tipo_pessoa			= $_POST['tipo_pessoa'];

	$objCliente->cnpj					= $_POST['cnpj'];

	$objCliente->cpf					= $_POST['cpf'];

	$objCliente->nome_completo			= $_POST['nome_completo'];

	$objCliente->inscricao_estadual		= $_POST['inscricao_estadual']!=''?$_POST['inscricao_estadual']:null;

	$objCliente->rg						= $_POST['rg']!=''?$_POST['rg']:null;

	$objCliente->email					= $_POST['email']!=''?strtolower($_POST['email']):null;

	$objCliente->telefone_principal		= $_POST['telefone_principal'];

	$objCliente->telefone_alternativo	= $_POST['telefone_alternativo'];

	$objCliente->logradouro				= $_POST['logradouro'];

	$objCliente->restricao				= $_POST['restricao'];

	$objCliente->numero					= $_POST['numero'];

	$objCliente->complemento			= $_POST['complemento']!=''?$_POST['complemento']:null;

	$objCliente->referencia				= $_POST['referencia']!=''?$_POST['referencia']:null;

	$objCliente->bairro					= $_POST['bairro'];

	$objCliente->cidade_id				= $_POST['cidade_id'];

	$objCliente->cep					= $_POST['cep'];

	$objCliente->observacoes			= $_POST['observacoes']!=''?$_POST['observacoes']:null;

	$objCliente->ativo                  = $_POST['ativo'];         

	$objCliente->filial_id				= $_POST['filial_id'];

	$objCliente->save();



	// echo $objCliente->telefone_principal;



	// Update

	$objContato						= Doctrine_Core::getTable('ClienteResponsavel')->find($_POST['id_contato']);

	$objContato->nome				= $_POST['nome_contato'];

	$objContato->email				= $_POST['email_contato']!=''?strtolower($_POST['email_contato']):null; 

	$objContato->tipo				= 0;

	$objContato->cliente_id			= $_POST['id'];

	$objContato->save();

	

	// Tratamento de retorno

	$_SESSION['return_type'] 	= 'success';

	$_SESSION['return_message']	= 'Executado com sucesso!';

		

	Util::regLog('Cliente', $objCliente->id, 'editou', $objCliente->nome_completo);



} catch(Exception $e){

	

	// Tratamento de retorno

	$_SESSION['return_type'] 	= 'error';

	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e;

	

}



// Redirecionamento para a página principal do módulo

header('Location: '.URL_ADMIN.$_GET['model'].'/');