<?php

require('lib/Config.php');

if (isset($_GET['uf_id'])){

	try {

		// Array de retorno
		$returnArray = array();

		$where = 'uf_id = '.$_GET['uf_id'];

		// Busca
		$ret =	Doctrine_Query::create()->select()->from('Cidade')
				->where($where)->orderBy('
				CASE WHEN 
						nome = "Belo Horizonte" || nome = "Rio Branco" || nome = "Maceió"
						|| nome = "Macapá" || nome = "Manaus" || nome = "Salvador" || nome = "Fortaleza"
						|| nome = "Brasília" || nome = "Vitória" || nome = "Goiânia"
						|| nome = "São Luís" || nome = "Cuiabá" || nome = "Campo Grande"
						|| nome = "João Pessoa" || nome = "Belém"  || nome = "Curitiba" || nome = "Recife"
						|| nome = "Teresina" || nome = "Rio de Janeiro" || nome = "Natal"
						|| nome = "Porto Alegre" || nome = "Porto Velho" || nome = "Boa Vista"
						|| nome = "Florianópolis" || nome = "São Paulo" || nome = "Aracaju" || nome = "Palmas"
				THEN 1 ELSE 2 END, nome ASC')->execute();

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