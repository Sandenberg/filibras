<?php

require('lib/Config.php');

if (isset($_GET['nf'])){

	try {

		// Array de retorno
		$returnArray = array();

		$where = 'nf = '.$_GET['nf'];
		$where .= isset($_GET['tipo_nf_id'])&&$_GET['tipo_nf_id']!=''?' and tipo_nf_id = '.$_GET['tipo_nf_id']:"";

		// Busca
		$ret =	Doctrine_Query::create()->select()->from('Lancamento l')->leftJoin('l.Cliente c')
				->where($where)->orderBy('id ASC')->execute();
				
		$returnArray['total'] = $ret->count();
		$returnArray['cliente'] = $ret[0]->Cliente->nome_completo;

		echo json_encode($returnArray);

	} catch(Exception $e){

		echo json_encode($returnArray);

	}

}