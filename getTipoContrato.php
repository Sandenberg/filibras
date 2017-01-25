<?php

require('lib/Config.php');

if (isset($_GET['equipamento_id'])){

	try {

		// Array de retorno
		$returnArray = array();

		$where = 'equipamento_id = '.$_GET['equipamento_id'];

		// Busca
		$ret =	Doctrine_Query::create()->select()->from('ContratoEquipamento ce')->leftJoin('ce.Contrato c')
				->where($where)->orderBy('c.tipo asc')->execute();

		// Tratamento dos dados
		if ($ret->count() > 0){
			// Transforma os dados em Array
			$res = $ret->toArray();

			foreach ($res as $value){
				// Retorno
				$value['tipo'] = $value['Contrato']['tipo'];
				$returnArray[] = $value;
			}
		}

		echo json_encode($returnArray);

	} catch(Exception $e){

		echo json_encode($returnArray);

	}

}else if (isset($_GET['cliente_id'])){

	try {

		// Array de retorno
		$returnArray = array();

		$where = 'cliente_id = '.$_GET['cliente_id'];

		// Busca
		$ret =	Doctrine_Query::create()->select()->from('Contrato c')
				->where($where)->orderBy('tipo asc')->execute();

		// Tratamento dos dados
		if ($ret->count() > 0){
			// Transforma os dados em Array
			$res = $ret->toArray();

			foreach ($res as $value){
				// Retorno
				// $value['tipo'] = $value['Contrato']['tipo'];
				$returnArray[] = $value;
			}
		}

		echo json_encode($returnArray);

	} catch(Exception $e){

		echo json_encode($returnArray);

	}

}