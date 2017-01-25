<?php // defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		
        <div class="titlebar">

            <a href="#" class="toggle">&nbsp;</a>
        </div>
        <div class="block_cont">

            <form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="post" id="formPerfil">
                <style type="text/css">
                    #formPerfil table td {
                        /* height: 40px; */
                        border-bottom: 1px #ccc solid;
                        padding: 10px;
                        vertical-align: middle;
                    }
                    #formPerfil table tr:nth-child(2n+3) {
                        background: #eee;
                    }
                    #formPerfil table th {
                        background: #ccc;
                        text-align: left;
                        padding: 10px;
                    }


                </style>
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
                    body{
                        background: none;
                    }

                    #formPerfil {
                        background-color: white;
                        height: 100% ;
                        width: 100% ;
                        position: absolute;
                        top: 0 ;
                        left: 0 ;
                        margin: 0 ;
                        padding: 15px ;
                        font-size: 10px ;
                        line-height: 18px ;
                    }

                </style>
                <div class="form_row">
                    <div style="width: 100px;"><img src=<?php echo URL_ADMIN_IMAGES?>logomarca_filibras_pequena.png></div>
                </div>
                <h4></h4>
                <hr />
                <div class="clear"></div>
                <table>
                    

                    <tr>
                        <th>
                            <label><b>Nº:</b></label>
                        </th>
                        <th>
                            <label><b>Cliente:</b></label>
                        </th>
                        <th>
                            <label><b>Usuário:</b></label>
                        </th>
                        <th>
                            <label><b>Tipo:</b></label>
                        </th>
                        <th>
                            <label><b>Data/Hora:</b></label>
                        </th>
                    </tr>
                <?php

                $where = '1 = 1';

                $tipo = $_POST['tipo'];
                // Filtro de Tipo
                if($tipo == "ordem")
                    $where .= isset($_POST['ordem'])&&$_POST['ordem']!=''?" and os.tipo_ordem = '".$_POST['ordem']."'":'';

                if($tipo == "tecnico")
                    // $where .= isset($_POST['usuario_id'])&&$_POST['usuario_id']!=''?" and fo.id is not null and fo.audit = '".$_POST['usuario_id']."'":'';
                    $where .= isset($_POST['usuario_id'])&&$_POST['usuario_id']!=''?" and fo.audit = '".$_POST['usuario_id']."'":'';

                if($tipo == "cliente")
                    $where .= isset($_POST['cliente_id'])&&$_POST['cliente_id']!=''?" and os.cliente_id = '".$_POST['cliente_id']."' ":'';

                // Tratamento de dados
                $_POST['data_periodo_I'] = isset($_POST['data_periodo_I'])&&$_POST['data_periodo_I']!=''?Util::dateConvert($_POST['data_periodo_I']):null;
                $_POST['data_periodo_F'] = isset($_POST['data_periodo_F'])&&$_POST['data_periodo_F']!=''?Util::dateConvert($_POST['data_periodo_F']):null;
                            

                if ($_POST['data_periodo_I'] != '' && $_POST['data_periodo_F'] != ''){
                    $where .= ' and os.data_atendimento BETWEEN "'.$_POST['data_periodo_I'].'  00:00:00" AND "'.$_POST['data_periodo_F'].' 23:59:59"';
                }

                // echo $where;

                $retAll     =   Doctrine_Query::create()->select()->from('OrdemServico os')->leftJoin('os.FinalizarOrdemServico fo')
                                    ->leftJoin('os.Cliente c')->orderBy('os.data_atendimento desc')
                                    ->where($where)->execute();

                $credito = 0;
                $debito = 0;

                $i = 0;
                foreach ($retAll as $objLancamento) {

                    switch ($objLancamento->tipo_ordem) {
                        
                        case "0":
                            $tipo_ordem = "Manutenção no Equipamento";
                            break;

                        case "1":
                            $tipo_ordem = "Troca de Cilindro/Toner";
                            break;

                        case "2":
                            $tipo_ordem = "Leitura de Numerador";
                            break;

                        case "3":
                            $tipo_ordem = "Instalação de Equipamento";
                            break;

                        case "5":
                            $tipo_ordem = "Retirada de Equipamento";
                            break;

                        case "6":
                            $tipo_ordem = "Manutenção Preventiva";
                            break;

                        case "7":
                            $tipo_ordem = "Serviços de Informática";
                            break;

                        case "8":
                            $tipo_ordem = "Acesso Remoto";
                            break;

                
                        default:
                            # code...
                            break;
                    }
                    $usunome="-";
                    // $objLancamento->FinalizarOrdemServico->data_final = isset($objLancamento->FinalizarOrdemServico->data_final)&&$objLancamento->FinalizarOrdemServico->data_final!='0000-00-00'&&$objLancamento->FinalizarOrdemServico->data_final!=''?date('d/m/Y', strtotime($objLancamento->FinalizarOrdemServico->data_final)):'-';
                    $objLancamento->data_atendimento = isset($objLancamento->data_atendimento)&&$objLancamento->data_atendimento!='0000-00-00'&&$objLancamento->data_atendimento!=''?date('d/m/Y', strtotime($objLancamento->data_atendimento)):'-';
                    if(isset($objLancamento->FinalizarOrdemServico[0]->audit)&&$objLancamento->FinalizarOrdemServico[0]->audit!=''){
                        $resUsuario = Doctrine_Core::getTable('Usuario')->find($objLancamento->FinalizarOrdemServico[0]->audit);
                        $usunome = isset($resUsuario->nome)&&$resUsuario->nome!=''?$resUsuario->nome:'-';
                    }
                    // }else{

                    // if($usunome=='-'){
                        // $resUsuario = Doctrine_Core::getTable('Usuario')->find($objLancamento->audt);
                        // $usunome = isset($resUsuario->nome)&&$resUsuario->nome!=''?$resUsuario->nome:'-';
                    // }

                    ?>

                        <tr>
                            <td>
                                <div style="width: 60px;"><?php echo $objLancamento->id ?></div>
                            </td>
                            <td>
                                <div style="width: 450px;"><?php echo $objLancamento->Cliente->nome_completo ?></div>
                            </td>
                            <td>
                                <div style="width: 100px;"><?php echo $usunome; ?></div>
                            </td>
                            <td>
                                <div style="width: 200px;"><?php echo $tipo_ordem; ?></div>
                            </td>
                            <td>
                                <div style="width: 130px;"><?php echo $objLancamento->data_atendimento; ?></div>
                            </td>
                        </tr>
                        
                    <?php
                    $i++;
                }

                ?>
                    <tr>
                        <td colspan="8" align="right" style="background: none">
                            <?php if($i > 0) { ?><b>Total de registros: <?php echo $i ?></b><br><?php } ?>
                            <?php if($debito > 0) { ?><b>Valor de Débito: R$ <?php echo number_format($debito, 2, ',', '.') ?></b><br><?php } ?>
                            <?php if(($debito != 0)&&($credito != 0)) { ?><b>Saldo: R$ <?php echo number_format($credito-$debito, 2, ',', '.') ?></b><?php } ?>
                        </td>
                    </tr>
                </table>


                <div class="clear"></div><br />



                <div class="form_row"><input type="button" class="submit" onclick="window.print();" id="print" value="Imprimir"  /></div>
                <div class="form_row"><input type="button" class="submit" onclick="history.back();" id="voltar" value="Voltar"  /></div>

            </form>
            <?php


            ?>
        </div>
    </div><!-- Block End -->
</div><!-- Body Wrapper End -->