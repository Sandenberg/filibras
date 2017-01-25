<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Delete
	$objLancamento = Doctrine_Core::getTable('Lancamento')->find($_GET['id']);
	if(isset($objLancamento->nf)&&$objLancamento->nf>0){
		$where = 'nf = "'.$objLancamento->nf.'"';
		$where .= isset($objLancamento->tipo_nf_id)&&$objLancamento->tipo_nf_id!=''?' and tipo_nf_id = "'.$objLancamento->tipo_nf_id.'"':"";

		$retAll	= Doctrine_Query::create()->select()->from('Lancamento')->where($where)->execute();
		foreach ($retAll as $objLancamento2) {
			$objLancamento = Doctrine_Core::getTable('Lancamento')->find($objLancamento2->id);
			$objLancamento->delete();
		}

	}else{
		$objLancamento->delete();
	}

	Util::regLog('Débito', $objLancamento->id, 'excluiu', $objLancamento->Cliente->nome_completo);

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