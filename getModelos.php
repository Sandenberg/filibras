<?php

require('lib/Config.php');

if (isset($_GET['marca_id'])){

	try {

		// Array de retorno
		$returnArray = array();

		$where = 'marca_id = '.$_GET['marca_id'];

		// Busca
		$ret =	Doctrine_Query::create()->select()->from('EquipamentoModelo')
				->where($where)->orderBy('nome ASC')->execute();

		// Tratamento dos dados
		if ($ret->count() > 0){
			// Transforma os dados em Array
			$res = $ret->toArray();

			foreach ($res as $value){
				// Retorno
				$returnArray[] = $value;
			}
		}

		echo json_encode($returnArray);

	} catch(Exception $e){

		echo json_encode($returnArray);

	}

}