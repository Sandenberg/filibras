<?php



defined('_ACTION') or exit('Direct access to the script is not allowed!');



try {

	

	// Tratamento de dados

	// print_r($_POST);



	// Insert

	$objEntrada					= new Entrada();

	$objEntrada->data_cadastro	= date('Y-m-d H:i:s');

	$objEntrada->descricao 		= $_POST['descricao'];

	$objEntrada->nf 			= $_POST['nf'];

	$objEntrada->usuario_id		= $_SESSION['sess_usuario_id'];

	$objEntrada->save();


	$objEntradaFornecedor				 = new EntradaFornecedor();

	$objEntradaFornecedor->id_entrada	 = $objEntrada->id;

	$objEntradaFornecedor->id_fornecedor = $_POST['fornecedor'];



	$objEntradaFornecedor->save();



	foreach ($_POST['material_id'] as $key => $value) {

		$objEntradaMaterial = new EntradaMaterial();

		$objEntradaMaterial->material_id = $_POST['material_id'][$key];

		$objEntradaMaterial->quantidade = $_POST['quantidade'][$key];

		$objEntradaMaterial->valor = (float) $_POST['valor'][$key];

		$objEntradaMaterial->entrada_id = $objEntrada->id;

		$objEntradaMaterial->save();



		$objMaterial = Doctrine_Core::getTable('Material')->find($_POST['material_id'][$key]);

		$objMaterial->estoque 	+= $_POST['quantidade'][$key];

		$objMaterial->valor 	= (float) $_POST['valor'][$key];

		$objMaterial->save();


	

	}



	// Tratamento de retorno

	$_SESSION['return_type'] 	= 'success';

	$_SESSION['return_message']	= 'Executado com sucesso!';

	

    Util::regLog('Entrada no Estoque', $objEntrada->id, 'cadastrou', $objEntrada->id." / ".substr($objEntrada->descricao, 0, 50));





} catch(Exception $e){

	

	// Tratamento de retorno

	$_SESSION['return_type'] 	= 'error';

	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';

	

}



// Redirecionamento para a página principal do módulo

header('Location: '.URL_ADMIN.$_GET['model'].'/');