<?php

require('lib/Config.php');

if (isset($_GET['id'])){

	try {

		// Array de retorno
		$returnArray = array();

		
		// Trata os códigos
		$ids = explode('-', $_GET['id']);
		
		// Condição de busca
		$where = 't.curso_id = '.$ids[1].' AND t.faculdade_id = '.$ids[0].' AND at.admissao_id = '.$ids[2];


		$ret =	Doctrine_Query::create()->select()->from('AdmissaoTurma at')->leftJoin('at.Turma t')->leftJoin('t.Curso c')
				->where($where)->groupBy('t.id')->orderBy('t.id ASC')->execute();

		// Tratamento dos dados
		if ($ret->count() > 0){
			// Transforma os dados em Array
			$res = $ret->toArray();

			foreach ($res as $value){
				$value['turno'] = $value['Turma']['turno']=='R'?'Regular':"Pós-laboral";
				// Display
				$value['display'] = $value['Turma']['Curso']['nome'];
				$value['id'] = $value['Turma']['Curso']['id'];
				
				// Retorno
				$returnArray[] = $value;
			}
		}

		echo json_encode($returnArray);

	} catch(Exception $e){

		echo json_encode($returnArray);

	}

}