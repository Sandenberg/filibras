<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento de dados
	// $_POST['id'] 	= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;
	

	foreach ($_POST['data_baixa'] as $key => $value) {
		if($value != ''){
			
			$value = isset($value)&&$value!=''&&$value!='__/__/____'?Util::dateConvert($value):null;
			// echo $_POST['id'][$key].' - '.$value;
			$objLancamento							= Doctrine_Core::getTable('Lancamento')->find($_POST['id'][$key]);
			$objLancamento->data_baixa 				= $value;
			$objLancamento->save();	

			if($objLancamento->tipo == 'debito')
				Util::regLog('Débito', $objLancamento->id, 'confirmou', $objLancamento->Cliente->nome_completo);
			else
				Util::regLog('Crédito', $objLancamento->id, 'confirmou', $objLancamento->Cliente->nome_completo);
		}
	}



	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';
	


} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e;
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');