<?php
error_reporting(0);
defined('_ACTION') or exit('Direct access to the script is not allowed!');


//print_r($_POST);


$cliente = $_POST['cliente_id'];
$equipamento = $_POST['equipamento_aray'];
$id_equipamento = $_POST['equipamento_id_array'];
$localizacao = $_POST['localizacao_array'];
$serial      = $_POST['serial_array'];
$defeito     = $_POST['defeito_aray']!=''?$_POST['defeito_aray']:null;
$id_defeito = $_POST['defeito_id_array']!=''?$_POST['defeito_id_array']:null;
$quant_cilindro_array = $_POST['quant_cilindro_array']!=''?$_POST['quant_cilindro_array']:0;
$cilindro_id_array = $_POST['cilindro_id_array']!=''?$_POST['cilindro_id_array']:null;
$cilindro_array = $_POST['cilindro_array']!=''?$_POST['cilindro_id_array']:null;
$cilindro_array = $_POST['cilindro_array']!=''?$_POST['cilindro_array']:null;
$toner_array = $_POST['toner_array']!=''?$_POST['toner_array']:null;
$quant_toner_array = $_POST['quant_toner_array']!=''?$_POST['quant_toner_array']:0;
$toner_id_array = $_POST['toner_id_array']!=''?$_POST['toner_id_array']:null;
$numerador_array = $_POST['numerador_array']!=''?$_POST['numerador_array']:null;
$reserva_array = $_POST['reserva_array']!=''?$_POST['reserva_array']:null;
$tipo_cliente = $_POST['tipo_cliente'];
$problema = null;

try {
    if($_POST['tipo_ordemserv'] == 0){

        $solicitante = $_POST['solicitantedef'];
    }elseif($_POST['tipo_ordemserv'] == 1){

        $solicitante = $_POST['solicitantetoner'];

    }elseif(($_POST['tipo_ordemserv'] == 3) ||($_POST['tipo_ordemserv'] == 4)||($_POST['tipo_ordemserv'] == 5)){

        $solicitante = $_POST['solicitantediver'];

    }elseif($_POST['tipo_ordemserv'] == 7){

        $solicitante = $_POST['solicitanteinfo'];
        $problema = $_POST['problemainfo'];

    }


    $tipo = $_POST['tipo_ordemserv'];
    $tipo = $tipo==0?'Manutenção no Equipamento':$tipo;
    $tipo = $tipo==1?'Troca de Cilindro/Toner':$tipo;
    $tipo = $tipo==2?'Leitura de Numerador':$tipo;                  
    $tipo = $tipo==3?'Instalação de Equipamento':$tipo;
    $tipo = $tipo==4?'Troca de Equipamento':$tipo;
    $tipo = $tipo==5?'Retirada de Equipamento':$tipo;
    $tipo = $tipo==6?'Manutenção Preventiva':$tipo;
    $tipo = $tipo==7?'Serviços de Informática':$tipo;
    $tipo = $tipo==8?'Acesso Remoto':$tipo;

    // Insert
	$objOrdemservico 						= new OrdemServico();
	$objOrdemservico->tipo_ordem	        = $_POST['tipo_ordemserv'];
	$objOrdemservico->data_atendimento		= date('Y-m-d H:i:s');
    $objOrdemservico->solicitante           = $solicitante;
	$objOrdemservico->problema			    = $problema;
	$objOrdemservico->observacao    		= $_POST['observacoes']!=''?$_POST['observacoes']:null;
    $objOrdemservico->cliente_id            = $cliente;
    $objOrdemservico->tipo_cliente          = $tipo_cliente;
    $objOrdemservico->audt                  = $_SESSION['sess_usuario_id'];
	$objOrdemservico->status                = 0;

	$objOrdemservico->save();

    $id_ordem_serv = $objOrdemservico->getIncremented();

if($_POST['tipo_ordemserv'] == 0){
    for($i=0;$i<count($equipamento);$i++){

        $equipamento_manu = $equipamento[$i];
        $localizacao_manu = $localizacao[$i];
        $serial_manu = $serial[$i];
        $numerador_manu = $numerador_array[$i];
        $defeito_manu =  $id_defeito[$i];

        $objOrdemManutencao		       		   = new OrdemServManutencao();
        $objOrdemManutencao->equipamento       = $equipamento_manu;
        $objOrdemManutencao->localizacao       = $localizacao_manu;
        $objOrdemManutencao->serial            = $serial_manu;
        $objOrdemManutencao->defeito           = $defeito_manu;
        $objOrdemManutencao->numerador         = $numerador_manu;
        $objOrdemManutencao->id_ordem_servico  = $id_ordem_serv;
        $objOrdemManutencao->save();

    }
}elseif($_POST['tipo_ordemserv']==1){

    for($i=0;$i<count($equipamento);$i++){

        $equipamento_toner = $equipamento[$i];
        $equipamento_id_toner = $id_equipamento[$i];
        $localizacao_toner = $localizacao[$i];
        $serial_toner = $serial[$i];
        $quant_cilindro =  $quant_cilindro_array[$i];
        $cilindro_array_toener = $cilindro_array[$i];
        $cilindro_id_array_toner = $cilindro_id_array[$i];
        $quant_toner = $quant_toner_array[$i];
        $toner_array_toner =$toner_array[$i];
        $toner_id_array_toner = $toner_id_array[$i];

        $objOrdemToner	       		   = new OrdemServToner();
        $objOrdemToner->equipamento       = $equipamento_toner;
        $objOrdemToner->equipamento_id    = $equipamento_id_toner;
        $objOrdemToner->localizacao       = str_replace("º", "&ordm;", $localizacao_toner);
        $objOrdemToner->serial            = $serial_toner;
        $objOrdemToner->quant_cilindro    = $quant_cilindro;
        $objOrdemToner->cilindro_id       = isset($cilindro_id_array_toner)&&$cilindro_id_array_toner!=''?$cilindro_id_array_toner:null;
        $objOrdemToner->cilindro          = $cilindro_array_toener;
        $objOrdemToner->quant_toner       = $quant_toner;
        $objOrdemToner->toner             = $toner_array_toner;
        $objOrdemToner->toner_id          = $toner_id_array_toner;
        $objOrdemToner->toner_id          = isset($toner_id_array_toner)&&$toner_id_array_toner!=''?$toner_id_array_toner:null;
        $objOrdemToner->id_ordem_servico  = $id_ordem_serv;
        $objOrdemToner->save();

    }

}elseif($_POST['tipo_ordemserv']==2){

    for($i=0;$i<count($equipamento);$i++){

        $equipamento_numerador = $equipamento[$i];
        $localizacao_numerador = $localizacao[$i];
        $serial_numerador = $serial[$i];
        $numerador = $numerador_array[$i];


        $objOrdemNumerador       		      = new OrdemServNumerador();
        $objOrdemNumerador->equipamento       = $equipamento_numerador;
        $objOrdemNumerador->localizacao       = str_replace("º", "&ordm;", $localizacao_numerador);
        $objOrdemNumerador->serial            = $serial_numerador;
        $objOrdemNumerador->numerador         = $numerador;
        $objOrdemNumerador->id_ordem_servico  = $id_ordem_serv;
        $objOrdemNumerador->save();

    }

}elseif($_POST['tipo_ordemserv']==3){

    for($i=0;$i<count($equipamento);$i++){

        $equipamento_instalacoa = $equipamento[$i];
        $localizacao_instacao = $localizacao[$i];
        $serial_instalacao= $serial[$i];
        $reserva = $reserva_array[$i];


        $objOrdemInstalacao       		   = new OrdemServInstalacao();
        $objOrdemInstalacao->equipamento       = $equipamento_instalacoa;
        $objOrdemInstalacao->localizacao       = str_replace("º", "&ordm;", $localizacao_instacao);
        $objOrdemInstalacao->serial            = $serial_instalacao;
        $objOrdemInstalacao->cart_reserva      = $reserva;
        $objOrdemInstalacao->id_ordem_servico  = $id_ordem_serv;
        $objOrdemInstalacao->save();

    }


}elseif($_POST['tipo_ordemserv']==4){

    for($i=0;$i<count($equipamento);$i++){

        $equipamento_troca = $equipamento[$i];
        $localizacao_troca = $localizacao[$i];
        $serial_troca= $serial[$i];
        $reserva = $reserva_array[$i];


        $objOrdemTroca       		   = new OrdemServTroca();
        $objOrdemTroca->equipamento       = $equipamento_troca;
        $objOrdemTroca->localizacao       = str_replace("º", "&ordm;", $localizacao_troca);
        $objOrdemTroca->serial            = $serial_troca;
        $objOrdemTroca->cart_reserva      = $reserva;
        $objOrdemTroca->id_ordem_servico  = $id_ordem_serv;
        $objOrdemTroca->save();

    }


}elseif($_POST['tipo_ordemserv']==5){

    for($i=0;$i<count($equipamento);$i++){


        $equipamento_retirada = $equipamento[$i];
        $localizacao_retirada = $localizacao[$i];
        $serial_retirada= $serial[$i];
        $reserva = $reserva_array[$i];


        $objOrdemRetirada       		   = new OrdemServRetirada();
        $objOrdemRetirada->equipamento       = $equipamento_retirada;
        $objOrdemRetirada->localizacao       = str_replace("º", "&ordm;", $localizacao_retirada);
        $objOrdemRetirada->serial            = $serial_retirada;
        $objOrdemRetirada->cart_reserva      = $reserva;
        $objOrdemRetirada->id_ordem_servico  = $id_ordem_serv;
        $objOrdemRetirada->save();

    }

}elseif($_POST['tipo_ordemserv']==6){




        $con = mysql_connect(DB_HOST, DB_USER, DB_PSWD);
        mysql_select_db(DB_NAME);

        $sql = "SELECT cl.nome,
        c.id,
        ce.equipamento_id,
        ce.local,
        e.serial,
        em.nome
    FROM contrato c
        LEFT JOIN cliente as cl on c.cliente_id = cl.id
        LEFT JOIN contrato_equipamento ce on c.id = ce.contrato_id
        LEFT JOIN equipamento e ON ce.equipamento_id = e.id
        LEFT JOIN equipamento_modelo em  on e.equipamento_modelo_id =  em.id
    WHERE
     c.cliente_id = '$cliente' and c.tipo = '".$_POST['tipo_cliente']."'";

        $exe = mysql_query($sql) or die(mysql_error());

        //echo $ret_modelo->count();


        while ( $ret_modelo = mysql_fetch_assoc($exe)){

            $objOrdemRetirada       		   = new OrdemServPreventiva();
            $objOrdemRetirada->equipamento       = $ret_modelo['nome'];
            $objOrdemRetirada->localizacao       = utf8_encode($ret_modelo['local']);
            $objOrdemRetirada->serial            = $ret_modelo['serial'];
            $objOrdemRetirada->id_ordem_servico  = $id_ordem_serv;
            $objOrdemRetirada->save();


        }


        // echo print_r($returnArray);

        mysql_close($con);






}elseif($_POST['tipo_ordemserv'] == 8){
    for($i=0;$i<count($equipamento);$i++){

        $equipamento_manu = $equipamento[$i];
        $localizacao_manu = $localizacao[$i];
        $serial_manu = $serial[$i];
        $numerador_manu = $numerador_array[$i];
        $defeito_manu =  $id_defeito[$i];

        $objOrdemManutencao                    = new OrdemServAcessoremoto();
        $objOrdemManutencao->equipamento       = $equipamento_manu;
        $objOrdemManutencao->localizacao       = $localizacao_manu;
        $objOrdemManutencao->serial            = $serial_manu;
        $objOrdemManutencao->defeito           = $defeito_manu;
        $objOrdemManutencao->numerador         = $numerador_manu;
        $objOrdemManutencao->id_ordem_servico  = $id_ordem_serv;
        $objOrdemManutencao->save();

    }
}



	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';	

	
    Util::regLog('Ordem de Serviço', $objOrdemservico->id, 'cadastrou', $objOrdemservico->Cliente->nome_completo, $tipo);
} catch(Exception $e){ 
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= "$e";
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');