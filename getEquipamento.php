<?php

require('lib/Config.php');

if (isset($_GET['cliente_id'])){

	try {
		// Array de retorno
		$returnArray = array();
		$arrayModelo = array();
		
		$cliente = $_GET['cliente_id'];

        // echo 'cliente';



        $con = mysql_connect(DB_HOST, DB_USER, DB_PSWD);
        mysql_select_db(DB_NAME);

	$sql = "SELECT cl.nome,
    c.id,
    ce.equipamento_id,
    ce.local,
    e.serial,
    e.id as equip_id,
    em.id as modelo_id,
    c.tipo as eq_tipo,
    em.nome
FROM contrato c
    LEFT JOIN cliente as cl on c.cliente_id = cl.id
    LEFT JOIN contrato_equipamento ce on c.id = ce.contrato_id
    LEFT JOIN equipamento e ON ce.equipamento_id = e.id
    LEFT JOIN equipamento_modelo em  on e.equipamento_modelo_id =  em.id
WHERE
 c.cliente_id = '$cliente' and e.id is not null";

        $exe = mysql_query($sql) or die(mysql_error());

				//echo $ret_modelo->count();

        while ( $ret_modelo = mysql_fetch_assoc($exe)){

            $where = "equipamento_id = ".$ret_modelo['equip_id'];
            $ret =  Doctrine_Query::create()->select()->from('ContratoEquipamento')->where($where)->execute();
            $ret->toArray();

            $ret_modelo['tipo'] = $ret_modelo['eq_tipo'];
            // print_r($ret);
            $ret_modelo['localizacao'] = $ret[0]['local'];
            // $ret_modelo['modelo'] = $ret['equipamento_modelo']['id'];


					$returnArray[] = $ret_modelo;




		}


       // echo print_r($returnArray);

        mysql_close($con);

		echo json_encode($returnArray);

	} catch(Exception $e){
             echo $e;
		echo json_encode($e);

	}

}