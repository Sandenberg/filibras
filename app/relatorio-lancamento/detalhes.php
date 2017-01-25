<?php 
    ini_set('memory_limit', -1); // defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); 
    $_POST['tipo'] = isset($_GET['tipo'])&&$_GET['tipo']!=''?$_GET['tipo']:$_POST['tipo'];

?>
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
                <h4>TOTAL DE <?php echo strtoupper($_POST['tipo']) ?> </h4>
                <hr />
                <div class="clear"></div>
                <table>
                    

                    <tr>
                        <th width="30px">
                            <label><b>Nº:</b></label>
                        </th>
                        <?php if($_POST['tipo'] != 'debito'){ ?>
                        <th width="150px">
                            <label><b>Cliente:</b></label>
                        </th>
                        <?php } ?>
                        <?php if($_POST['tipo'] != 'credito'){ ?>
                        <th width="150px">
                            <label><b>Beneficiario:</b></label>
                        </th>
                        <?php } ?>
                        <th width="80px">
                            <label><b>Lançamento:</b></label>
                        </th>
                        <th width="80px">
                            <label><b>Vencimento:</b></label>
                        </th>
                        <th width="80px">
                            <label><b>Baixa:</b></label>
                        </th>
                        <th width="100px">
                            <label><b>Tipo:</b></label>
                        </th>
                        <th width="100px">
                            <label><b>Tipo/NF:</b></label>
                        </th>
                        <th width="100px">
                            <label><b>Conta:</b></label>
                        </th>
                        <!-- <th width="100px">
                            <label><b>Descrição:</b></label>
                        </th> -->
                        <th width="60px">
                            <label><b>Valor:</b></label>
                        </th>
                    </tr>
                <?php

                $where = '1 = 1';
                $filtro = "1=1";

                // Filtro de Tipo
                $where .= isset($_POST['tipo'])&&$_POST['tipo']!=''?" and tipo = '".$_POST['tipo']."'":'';
                $filtro .= isset($_POST['tipo'])&&$_POST['tipo']!=''?"&tipo=".$_POST['tipo']."":'';

                $where .= isset($_POST['nf'])&&$_POST['nf']!=''?" and nf = '".$_POST['nf']."' ":'';
                $filtro .= isset($_POST['nf'])&&$_POST['nf']!=''?"&nf=".$_POST['nf']."":'';


                if(isset($_POST['tipo_nf_id'])&&$_POST['tipo_nf_id']!=''){
                    if($_POST['tipo_nf_id'] == 'TNF')
                        $where .= " and nf <> ''";
                    else if($_POST['tipo_nf_id'] == 'REC')
                        $where .= " and recibo <> ''";
                    else if($_POST['tipo_nf_id'] == 'RECTNF')
                        $where .= " and (nf <> '' or recibo <> '')";
                    else
                        $where .= " and tipo_nf_id = '".$_POST['tipo_nf_id']."'";
                    $filtro .= isset($_POST['tipo_nf_id'])&&$_POST['tipo_nf_id']!=''?"&tipo_nf_id=".$_POST['tipo_nf_id']."":'';
                }

                // $where .= isset($_POST['tipo_nf_id'])&&$_POST['tipo_nf_id']!=''&&$_POST['tipo_nf_id']!='TNF'?" and tipo_nf_id = '".$_POST['tipo_nf_id']."' ":'';
                // $where .= isset($_POST['tipo_nf_id'])&&$_POST['tipo_nf_id']=='TNF'?" and nf <> ''":'';

                // $where .= isset($_POST['recibo'])&&$_POST['recibo']!=''?" and recibo <> '' ":'';

                // Filtro de Cliente
                $where .= isset($_POST['cliente_id'])&&$_POST['cliente_id']!=''?" and cliente_id = '".$_POST['cliente_id']."'":'';
                $filtro .= isset($_POST['cliente_id'])&&$_POST['cliente_id']!=''?"&cliente_id=".$_POST['cliente_id']."":'';

                // Filtro de Beneficiario
                $where .= isset($_POST['beneficiario_id'])&&$_POST['beneficiario_id']!=''?" and beneficiario_id = '".$_POST['beneficiario_id']."'":'';
                $filtro .= isset($_POST['beneficiario_id'])&&$_POST['beneficiario_id']!=''?"&beneficiario_id=".$_POST['beneficiario_id']."":'';

                // Filtro de Tipo de Lançamento
                $where .= isset($_POST['lancamento_tipo_id'])&&$_POST['lancamento_tipo_id']!=''?" and lancamento_tipo_id = '".$_POST['lancamento_tipo_id']."'":'';
                $filtro .= isset($_POST['lancamento_tipo_id'])&&$_POST['lancamento_tipo_id']!=''?"&lancamento_tipo_id=".$_POST['lancamento_tipo_id']."":'';

                // Filtro de Conta
                $where .= isset($_POST['conta_id'])&&$_POST['conta_id']!=''?" and conta_id = '".$_POST['conta_id']."'":'';
                $filtro .= isset($_POST['conta_id'])&&$_POST['conta_id']!=''?"&conta_id=".$_POST['conta_id']."":'';
                
                // Tratamento de dados
                $_POST['data_lancamento_I'] = isset($_POST['data_lancamento_I'])&&$_POST['data_lancamento_I']!=''?Util::dateConvert($_POST['data_lancamento_I']):null;
                $_POST['data_lancamento_F'] = isset($_POST['data_lancamento_F'])&&$_POST['data_lancamento_F']!=''?Util::dateConvert($_POST['data_lancamento_F']):null;
                            

                if ($_POST['data_lancamento_I'] != '' && $_POST['data_lancamento_F'] != ''){
                    $where .= ' and l.data_lancamento BETWEEN "'.$_POST['data_lancamento_I'].' 00:00:00" AND "'.$_POST['data_lancamento_F'].' 23:59:59"';
                    $filtro .= isset($_POST['data_lancamento_I'])&&$_POST['data_lancamento_I']!=''?"&data_lancamento_I=".$_POST['data_lancamento_I']."":'';
                    $filtro .= isset($_POST['data_lancamento_F'])&&$_POST['data_lancamento_F']!=''?"&data_lancamento_F=".$_POST['data_lancamento_F']."":'';
                }

                // Tratamento de dados
                $_POST['data_vencimento_I'] = isset($_POST['data_vencimento_I'])&&$_POST['data_vencimento_I']!=''?Util::dateConvert($_POST['data_vencimento_I']):null;
                $_POST['data_vencimento_F'] = isset($_POST['data_vencimento_F'])&&$_POST['data_vencimento_F']!=''?Util::dateConvert($_POST['data_vencimento_F']):null;
                            

                if ($_POST['data_vencimento_I'] != '' && $_POST['data_vencimento_F'] != ''){
                    $where .= ' and l.data_vencimento BETWEEN "'.$_POST['data_vencimento_I'].'" AND "'.$_POST['data_vencimento_F'].'"';
                    $filtro .= isset($_POST['data_vencimento_I'])&&$_POST['data_vencimento_I']!=''?"&data_vencimento_I=".$_POST['data_vencimento_I']."":'';
                    $filtro .= isset($_POST['data_vencimento_F'])&&$_POST['data_vencimento_F']!=''?"&data_vencimento_F=".$_POST['data_vencimento_F']."":'';
                }

                // Tratamento de dados
                $_POST['data_baixa_I'] = isset($_POST['data_baixa_I'])&&$_POST['data_baixa_I']!=''?Util::dateConvert($_POST['data_baixa_I']):null;
                $_POST['data_baixa_F'] = isset($_POST['data_baixa_F'])&&$_POST['data_baixa_F']!=''?Util::dateConvert($_POST['data_baixa_F']):null;
                            

                if ($_POST['data_baixa_I'] != '' && $_POST['data_baixa_F'] != ''){
                    $where .= ' and l.data_baixa BETWEEN "'.$_POST['data_baixa_I'].'" AND "'.$_POST['data_baixa_F'].'"';
                    $filtro .= isset($_POST['data_baixa_I'])&&$_POST['data_baixa_I']!=''?"&data_baixa_I=".$_POST['data_baixa_I']."":'';
                    $filtro .= isset($_POST['data_baixa_F'])&&$_POST['data_baixa_F']!=''?"&data_baixa_F=".$_POST['data_baixa_F']."":'';
                }

                $order = 'data_lancamento asc';

                if(isset($_POST['tipo_nf_id']))
                    $order = "nf asc";

                if(isset($_GET['tipo'])){
                    $order = 'data_vencimento asc';
                    $where = "tipo='".$_POST['tipo']."' and data_baixa is null";
                    
                }

                $retAll     =   Doctrine_Query::create()->select()->from('Lancamento l')
                                    ->leftJoin('l.LancamentoTipo lt')->leftJoin('l.TipoNf nf')
                                    ->orderBy($order)
                                    ->where($where)->execute();

                $credito = 0;
                $debito = 0;
                $x = 0;
                foreach ($retAll as $objLancamento) {
                    $x++;
                    if($objLancamento->beneficiario_id){
                        $res = Doctrine_Core::getTable('Beneficiario')->find($objLancamento->beneficiario_id);
                        $beneficiario = $res->nome;
                        $cliente = '-';
                        $debito += $objLancamento->valor_total;
                    }else{
                        $res = Doctrine_Core::getTable('Cliente')->find($objLancamento->cliente_id);
                        $cliente = isset($res->nome_completo)?$res->nome_completo:'';
                        $beneficiario = '-';
                        $credito += $objLancamento->valor_total;
                    }

                    if($objLancamento->conta_id){
                        $resConta = Doctrine_Core::getTable('Conta')->find($objLancamento->conta_id);
                        $conta = $resConta->nome;
                    }else{
                        $conta = '-';
                    }

                    $data_lancamento = isset($objLancamento->data_lancamento)&&$objLancamento->data_lancamento!='0000-00-00'&&$objLancamento->data_lancamento!=''?date('d/m/Y', strtotime($objLancamento->data_lancamento)):'-';
                    $data_vencimento = isset($objLancamento->data_vencimento)&&$objLancamento->data_vencimento!='0000-00-00'&&$objLancamento->data_vencimento!=''?date('d/m/Y', strtotime($objLancamento->data_vencimento)):'-';
                    $data_baixa = isset($objLancamento->data_baixa)&&$objLancamento->data_baixa!='0000-00-00'&&$objLancamento->data_baixa!=''?date('d/m/Y', strtotime($objLancamento->data_baixa)):'-';


                    $tipoNf = isset($objLancamento->TipoNf->nome)?$objLancamento->TipoNf->nome:'- ';
                    $nf = isset($objLancamento->nf)&&$objLancamento->nf!=''?$objLancamento->nf:' -';

                    $textoNf = $tipoNf."/".$nf;
                    if(isset($objLancamento->recibo)&&$objLancamento->recibo!='')
                        $textoNf = "RECIBO";
                    ?>

                        <tr>
                            <td>
                                <div style="width: 30px;"><?php echo $x ?></div>
                            </td>
                            <?php if($_POST['tipo'] != 'debito'){ ?>
                                <td>
                                    <div style="width: 230px;"><?php echo $cliente ?></div>
                                </td>
                            <?php } ?>
                            <?php if($_POST['tipo'] != 'credito'){ ?>
                                <td>
                                    <div style="width: 100px;"><?php echo $beneficiario; ?></div>
                                </td>
                            <?php } ?>
                            <td>
                                <div style="width: 70px;"><?php echo $data_lancamento; ?></div>
                            </td>
                            <td>
                                <div style="width: 70px;"><?php echo $data_vencimento; ?></div>
                            </td>
                            <td>
                                <div style="width: 70px;"><?php echo $data_baixa; ?></div>
                            </td>
                            <td>
                                <div style="width: 100px;"><?php echo isset($objLancamento->LancamentoTipo->nome)?$objLancamento->LancamentoTipo->nome:"-"; ?></div>
                            </td>
                            <td>
                                <div style="width: 100px;"><?php echo $textoNf; ?></div>
                            </td>
                            <td>
                                <div style="width: 100px;"><?php echo $conta; ?></div>
                            </td>
                            <!-- <td>
                                <div style="width: 100px;"><?php echo $objLancamento->descricao; ?></div>
                            </td> -->
                            <td>
                                <div style="width: 60px;">R$<?php echo is_numeric($objLancamento->valor_total)?number_format($objLancamento->valor_total, 2, ',', '.'):$objLancamento->valor_total; ?></div>
                            </td>
                        </tr>
                        
                    <?php

                }

                ?>
                    <tr>
                        <td colspan="8" align="right" style="background: none">
                            <?php if($credito > 0) { ?><b>Valor de Crédito: R$ <?php echo number_format($credito, 2, ',', '.') ?></b><br><?php } ?>
                            <?php if($debito > 0) { ?><b>Valor de Débito: R$ <?php echo number_format($debito, 2, ',', '.') ?></b><br><?php } ?>
                            <?php if(($debito != 0)&&($credito != 0)) { ?><b>Saldo: R$ <?php echo number_format($credito-$debito, 2, ',', '.') ?></b><?php } ?>
                        </td>
                    </tr>
                </table>


                <div class="clear"></div><br />



                <div class="form_row"><input type="button" class="submit" onclick="window.print();" id="print" value="Imprimir"  /></div>
                <div class="form_row"><a href="<?php echo URL.'app/relatorio-lancamento/detalhes_pdf.php?'.$filtro ?>" class="submit" target="_blank">&nbsp;&nbsp;&nbsp;Exportar para PDF&nbsp;&nbsp;&nbsp;</a></div>

            </form>
            <?php


            ?>
        </div>
    </div><!-- Block End -->
</div><!-- Body Wrapper End -->