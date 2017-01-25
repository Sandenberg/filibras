<?php

require('lib/Config.php');

if (isset($_GET['tipo'])){

    try {

        // Array de retorno
        $returnArray = array();
        $arrayModelo = array();

        $equipamento = isset($_GET['equipamento_id'])?$_GET['equipamento_id']:null;
        $tipo = $_GET['tipo'];
        if(isset($_GET['equipamento_id'])&&$_GET['equipamento_id']!='')
            $where = "me.equipamento_id = $equipamento and tipo = $tipo";
        else
            $where = "tipo = $tipo";
        // Busca
        $ret =	Doctrine_Query::create()->select()->from('MaterialEquipamento me')
            ->leftJoin('me.Material m')
            ->where($where)->groupBy('m.id')->execute();

        // Tratamento dos dados
        if ($ret->count() > 0){
            // Transforma os dados em Array
            $res = $ret->toArray();
            foreach ($res as $value){

                $value['nome'] = $value['Material']['nome'];
                $value['id'] = $value['Material']['id'];

                // Retorno
                $returnArray[] = $value;




            }
        }

        echo json_encode($returnArray);

    } catch(Exception $e){

        echo json_encode($returnArray);

    }

}