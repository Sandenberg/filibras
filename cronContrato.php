<?php

require('lib/Config.php');


try {
	    
	// $data = "2017-07-30";
	// $data = "2015-12-12";
	$data = date('Y-m-d');

    $where = "data_fim = '".$data."' and renovacao = 1 and c.tipo = 0";
	$ret =	Doctrine_Query::create()->select()->from('Contrato c')->leftJoin('c.Cliente cli')
			->where($where)->execute();

	// Tratamento dos dados
	if ($ret->count() > 0){
		foreach ($ret as $objContrato) {

			$d1 = $objContrato->data_inicio;
			$d2 = $objContrato->data_fim;
						
			$ts1 = strtotime($d1);
			$ts2 = strtotime($d2);

			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);

			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);

			$diff = (($year2 - $year1) * 12) + ($month2 - $month1);
			
			echo $data_fim = date('Y-m-d', strtotime(date('Y-m-d')." +".$diff." months"));

			$res = Doctrine_Core::getTable('Contrato')->find($objContrato->id);
			$res->data_inicio = date('Y-m-d');
			$res->data_fim = $data_fim;
			$res->save();


			Util::regLog('Contrato', $objContrato->Cliente->id, 'Renovado', $objContrato->Cliente->nome_completo);

		}
	}
	// echo "a";
	echo "certo!";
} catch(Exception $e){
	echo $e;
}

