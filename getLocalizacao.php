<?php

require('lib/Config.php');

if (isset($_GET['equip_id'])){

	try {

		// Array de retorno
		$returnArray = array();
		$arrayModelo = array();
		
		$equipamento = $_GET['equip_id'];
          
          $where = "equipamento_id = $equipamento";
		// Busca
		$ret =	Doctrine_Query::create()->select()->from('ContratoEquipamento')
				->where($where)->execute();

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