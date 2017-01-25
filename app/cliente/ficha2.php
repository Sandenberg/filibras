<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
<div class="block big"><!-- Block Begin -->
<?php

$res = Doctrine_Core::getTable('Cliente')->find($_GET['id']);
$con = mysql_connect(DB_HOST, DB_USER, DB_PSWD);
mysql_select_db(DB_NAME);

$sqlContrato = "SELECT
    c.numero,
    c.data_fim,
    c.tipo,
    c.dia_leitura
    FROM contrato c
    WHERE
    c.cliente_id = '$res->id'";

 $exeContrato = mysql_query($sqlContrato) or die(mysql_error());
 $retContrato = mysql_fetch_assoc($exeContrato);

if(($retContrato['tipo']==0)||($retContrato['tipo']==4)){

    if($retContrato['tipo']==0){

        $tipo = 'Locação';
    }else{
        $tipo = 'Diversos';
    }

    $numero = $retContrato['numero'];
    $leitura = $retContrato['dia_leitura'];
    $validade = date('d/m/Y',strtotime($retContrato['data_fim']));
    $cabeçalho = "Ficha Cliente &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  Tipo: $tipo &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Nº $numero &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp VD: $validade &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Leitura Numerador: $leitura" ;

}elseif($retContrato['tipo']==1){

    $cabeçalho = "Ficha Cliente &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Tipo: Venda";
}elseif($retContrato['tipo']==3){

    $cabeçalho = "Ficha Cliente &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Tipo: Contrato de manutenção";
}elseif($retContrato['tipo']==4){

    $cabeçalho = "Ficha Cliente &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Tipo: Diversos";
}
// echo $retContrato['tipo'];

    // Seleciona os dados do usuário

?>
<div class="titlebar">
    <h3>Ficha - <?php echo $res->id.' - Cliente - '.$res->nome_completo; ?> - Detalhes</h3>
    <a href="#" class="toggle">&nbsp;</a>
</div>
<div class="block_cont">
<?php
try {
    //Seleciona os dados do usuário
    $res = Doctrine_Core::getTable('Cliente')->find($_GET['id']);
    ?>
    <form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
    <style type="text/css" media="print">
        #userbar{
            display: none;
        }
        #header{
            display: none;
        }
        #print{
            display: none;
        }
        #formPerfil {
            background-color: white;
            height: 100% ;
            width: 100% ;
            position: absolute;
            top: 0 ;
            left: 0 ;
            margin: 0 ;
            padding: 10px ;
            font-size: 14px ;
            line-height: 10px ;
        }
        @media print{
            *{
                line-height: 16px;
            }
        }
    </style>
    <style type="text/css">
        .form_row div {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }

        hr {
            margin: 3px 0px;
        }
    </style>
        <h6><?php echo $cabeçalho ?></h6>
        <hr />
        <div class="clear"></div>
        <div class="form_row">
            <div style="width: 500px;"><b>CLIENTE: </b><?php echo $res->nome_completo; ?></div>
        </div>
        <div class="form_row">
         <div style="width: 200px;"><b>TELEFONE: </b><?php echo $res->telefone_principal!=''?Util::mask('(##)####-####', $res->telefone_principal):'-'; ?></div>
    </div>
    <div class="form_row">
        <?php
        $cpf 	= $res->cpf!=''?Util::mask('###.###.###-##', $res->cpf):'-';
        $cnpj 	= $res->cnpj!=''?Util::mask('##.###.###/####-##', $res->cnpj):'-';
        ?>
        <div style="width: 200px;"><b><?php echo $res->tipo_pessoa==0?'CPF':'CNPJ'; ?>: </b><?php echo $res->tipo_pessoa==0?$cpf:$cnpj; ?></div>
    </div>
    <hr />
    <div class="clear"></div>
    <div class="form_row">
        <div style="width: 300px;"><b>ENDEREÇO: </b><?php echo $res->logradouro; ?></div>
    </div>
    <div class="form_row">
        <div style="width: 120px;"><b>NÚMERO: </b><?php echo $res->numero; ?></div>
    </div>
    <div class="form_row">
        <div style="width: 300px;"><b>COMPL: </b><?php echo $res->complemento; ?></div>
    </div>
    <div class="clear"></div>
    <div class="form_row">
        <div style="width: 200px;"><b>BAIRRO: </b><?php echo $res->bairro; ?></div>
    </div>
    <div class="form_row">
        <div style="width: 200px;"><b>CIDADE: </b><?php echo $res->Cidade->nome; ?></div>
    </div>
    <div class="form_row">
        <div style="width: 150px;"><b>CEP: </b><?php echo $res->cep; ?></div>
    </div><br>
    <div class="form_row">
        <div style="width: 350px; text-transform: lowercase"><b style=' text-transform: uppercase'>EMAIL: </b><?php echo $res->email; ?></div>
    </div><br>
        <?php
            $ret = Doctrine_Core::getTable('ClienteResponsavel')->findBy("cliente_id", $_GET['id']);
            $ret = $ret->toArray();
        ?>
        <div class="form_row">
            <div style="width: 350px;"><b>CONTATO: </b><?php echo $ret[0]['nome']; ?></div>
        </div>
       <!--  <div class="form_row">
            <div style="width: 300px;"><b>EMAIL: </b><?php echo $ret[0]['email']; ?></div>
        </div>
        <div class="form_row">
            <div style="width: 150px;"><b>TELEFONE: </b><?php echo $ret[0]['telefone']; ?></div>
        </div>
        <div class="form_row">
            <div style="width: 150px;"><b>RAMAL: </b><?php echo $ret[0]['ramal']; ?></div>
        </div> -->
    <hr />
    <h6>Dados dos Equipamentos</h6>
    <hr />
    <?php
    $sql = "SELECT cl.nome as cliente,
    c.id,
    ce.equipamento_id,
    ce.local,
    e.serial,
    em.nome as equipamento,
    c.valor_monocromatica,
    c.franquia_monocromatica,
    c.valor_colorida,
    c.franquia_colorida,
    c.adicional_monocromatica,
    c.adicional_colorida
FROM contrato c
    LEFT JOIN cliente as cl on c.cliente_id = cl.id
    LEFT JOIN contrato_equipamento as  ce on c.id = ce.contrato_id
    LEFT JOIN equipamento as  e ON ce.equipamento_id = e.id
    LEFT JOIN equipamento_modelo as em  on e.equipamento_modelo_id =  em.id

WHERE
 c.cliente_id = '$res->id'";

    $exe = mysql_query($sql) or die(mysql_error());
    while ( $retEquipamento = mysql_fetch_assoc($exe)){
            ?>
            <div class="form_row">
                <div style="width: 250px;"><b>Equipamento: </b><?php echo $retEquipamento['equipamento']; ?></div>
            </div>

            <div class="form_row">
                <div style="width: 200px;"><b>Nº de Serie: </b><?php echo$retEquipamento['serial']; ?></div>
            </div>

            <div class="clear"></div>
        <?
        }
    $sql_franquia = "SELECT cl.nome as cliente,
    c.id,
    ce.equipamento_id,
    ce.local,
    e.serial,
    em.nome as equipamento,
    c.valor,
    c.valor_monocromatica,
    c.franquia_monocromatica,
    c.valor_colorida,
    c.franquia_colorida,
    c.adicional_monocromatica,
    c.adicional_colorida
FROM contrato c
    LEFT JOIN cliente as cl on c.cliente_id = cl.id
    LEFT JOIN contrato_equipamento as  ce on c.id = ce.contrato_id
    LEFT JOIN equipamento as  e ON ce.equipamento_id = e.id
    LEFT JOIN equipamento_modelo as em  on e.equipamento_modelo_id =  em.id

WHERE
 c.cliente_id = '$res->id'";

    $exe_faquia = mysql_query($sql_franquia) or die(mysql_error());

    $retFranquia = mysql_fetch_assoc($exe_faquia);
    if($retContrato['tipo']!=1){
        if(($retFranquia['valor']!=0)&&($retFranquia['valor']!='')){
               $valor = number_format($retFranquia['valor'], 4, ',', '.');
               $franquia =" R$: $valor";
            ?>
            <hr />
            <div class="form_row">
                <div style="width: 800px;"><b>Franquia: </b><?php echo $franquia; ?></div>
            </div>
            <hr />
            <div class="clear"></div>
            <?php
        }else if($retFranquia['franquia_colorida'] == 0){
            $copia = $retFranquia['franquia_monocromatica'];
               if($copia == 0){
                   $valor = number_format($retFranquia['valor_monocromatica'], 4, ',', '.');
                   $franquia =" R$: $valor CENTAVOS";
                } else {
                   $valor = number_format($retFranquia['valor_monocromatica'], 4, ',', '.');
                   $excedente = number_format($retFranquia['adicional_monocromatica'], 4, ',', '.');
                   $franquia ="P&B: ".number_format($copia, 0, '', '.')." COP/IMP POR R$: $valor - EXCEDENTES POR R$: $excedente CENTAVOS";
                   
                   // $franquia ="P&B: R$: $valor";
               }
               $franquia_c = "";
               if($retFranquia['franquia_colorida']==0&&$retFranquia['valor_colorida']>0){
                    $valor_c = number_format($retFranquia['valor_colorida'],4,',','.');
                    $franquia_c ="Colorida: R$:$valor_c CENTAVOS";
                }
            ?>
            <hr />
            <div class="form_row">
                <div style="width: 800px;"><b>Franquia: </b><?php echo $franquia; ?></div>
                <?php if($franquia_c != ''){ ?>
                    <div style="width: 800px;"><b>Franquia: </b><?php echo $franquia_c; ?></div>
                <?php } ?>
            </div>
            <hr />
            <div class="clear"></div>
        <?php
        }else{
            $copia_m = $retFranquia['franquia_monocromatica'];
            $valor_m = number_format($retFranquia['valor_monocromatica'], 4, ',', '.');;
            $excedente_m = number_format($retFranquia['adicional_monocromatica'], 4, ',', '.');;
            $copia_c = $retFranquia['franquia_colorida'];
            $valor_c = number_format($retFranquia['valor_colorida'],4,',','.');
            $excedente_c = number_format($retFranquia['adicional_colorida'],4,',','.');
            // $franquia_m ="P&B: R$:$valor_m CENTAVOS ";
                if($copia_m == 0){
                    if($retFranquia['valor_monocromatica'] > 0)
                        $franquia_m ="P&B: R$:$valor_m CENTAVOS ";
               }else{
                    $franquia_m ="P&B: ".number_format($copia_m, 0, '', '.')." COP/IMP POR R$:$valor_m - EXCEDENTES POR R$:$excedente_m CENTAVOS ";
               }
            $franquia_c ="Colorida: ".number_format($copia_c, 0, '', '.')." COP/IMP POR R$:$valor_c - EXCEDENTES POR R$:$excedente_c CENTAVOS ";
            ?>
            <hr />
            <div class="form_row">

                <div style="width: 800px;"><b>Franquia: </b><?php echo $franquia_m; ?></div><br>
                <div style="width: 800px;"><b>Franquia: </b><?php echo $franquia_c; ?></div>
            </div>
            <hr />
            <div class="clear"></div>
        <?php
        }
     }
        ?>
    <div class="form_row"><input type="button" class="submit" id="print" value="Imprimir"  /></div>

    </form>
<?php

} catch (Exception $e){
    echo 'Ocorreu um erro!'.$e;
}

unset($res);

?>
</div>
</div><!-- Block End -->
</div><!-- Body Wrapper End -->