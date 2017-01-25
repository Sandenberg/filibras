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
                <h4>LANÇAMENTOS </h4>
                <hr />
                <div class="clear"></div>
                <table>
                    

                    <tr>
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
                            <label><b>Vencimento:</b></label>
                        </th>
                        <th width="80px">
                            <label><b>Baixa:</b></label>
                        </th>
                        <th width="100px">
                            <label><b>Tipo:</b></label>
                        </th>
                        <th width="100px">
                            <label><b>Conta:</b></label>
                        </th>
                        <th width="100px">
                            <label><b>Descrição:</b></label>
                        </th>
                        <th width="60px">
                            <label><b>Valor:</b></label>
                        </th>
                    </tr>
                <?php

                $where = 'data_baixa is null';

                // Filtro de Tipo
                $where .= isset($_POST['tipo'])&&$_POST['tipo']!=''?" and tipo = '".$_POST['tipo']."'":'';

                // Filtro de Cliente
                $where .= isset($_POST['cliente_id'])&&$_POST['cliente_id']!=''?" and cliente_id = '".$_POST['cliente_id']."'":'';

                // Filtro de Beneficiario
                $where .= isset($_POST['beneficiario_id'])&&$_POST['beneficiario_id']!=''?" and beneficiario_id = '".$_POST['beneficiario_id']."'":'';

                // Filtro de Tipo de Lançamento
                $where .= isset($_POST['lancamento_tipo_id'])&&$_POST['lancamento_tipo_id']!=''?" and lancamento_tipo_id = '".$_POST['lancamento_tipo_id']."'":'';

                // Filtro de Conta
                $where .= isset($_POST['conta_id'])&&$_POST['conta_id']!=''?" and conta_id = '".$_POST['conta_id']."'":'';

                // Tratamento de dados
                $_POST['data_vencimento_I'] = isset($_POST['data_vencimento_I'])&&$_POST['data_vencimento_I']!=''?Util::dateConvert($_POST['data_vencimento_I']):null;
                $_POST['data_vencimento_F'] = isset($_POST['data_vencimento_F'])&&$_POST['data_vencimento_F']!=''?Util::dateConvert($_POST['data_vencimento_F']):null;
                            

                if ($_POST['data_vencimento_I'] != '' && $_POST['data_vencimento_F'] != ''){
                    $where .= ' and l.data_vencimento BETWEEN "'.$_POST['data_vencimento_I'].'" AND "'.$_POST['data_vencimento_F'].'"';
                }

                // Tratamento de dados
                $_POST['data_baixa_I'] = isset($_POST['data_baixa_I'])&&$_POST['data_baixa_I']!=''?Util::dateConvert($_POST['data_baixa_I']):null;
                $_POST['data_baixa_F'] = isset($_POST['data_baixa_F'])&&$_POST['data_baixa_F']!=''?Util::dateConvert($_POST['data_baixa_F']):null;
                            

                if ($_POST['data_baixa_I'] != '' && $_POST['data_baixa_F'] != ''){
                    $where .= ' and l.data_baixa BETWEEN "'.$_POST['data_baixa_I'].'" AND "'.$_POST['data_baixa_F'].'"';
                }

                $retAll     =   Doctrine_Query::create()->select()->from('Lancamento l')
                                    ->leftJoin('l.LancamentoTipo lt')->orderBy('data_vencimento asc')
                                    ->where($where)->execute();

                $credito = 0;
                $debito = 0;
                $x=0;

                foreach ($retAll as $objLancamento) {
                    
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

                    $data_vencimento = isset($objLancamento->data_vencimento)&&$objLancamento->data_vencimento!='0000-00-00'&&$objLancamento->data_vencimento!=''?date('d/m/Y', strtotime($objLancamento->data_vencimento)):'-';
                    $objLancamento->data_baixa = isset($objLancamento->data_baixa)&&$objLancamento->data_baixa!='0000-00-00'&&$objLancamento->data_baixa!=''?date('d/m/Y', strtotime($objLancamento->data_baixa)):'-';
                    $objLancamento->valor_total = isset($objLancamento->valor_total)&&is_numeric($objLancamento->valor_total)?$objLancamento->valor_total:0;
                    ?>

                        <tr>
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
                                <div style="width: 70px;"><?php echo $data_vencimento; ?></div>
                            </td>
                            <td>
                                <!-- <div style="width: 70px;"><?php echo $objLancamento->data_baixa; ?></div> -->
                                <input type="hidden" name="id[]" value="<?php echo $objLancamento->id ?>">
                                <input type="text" class='data_baixa <?php if($x == 0) echo "pdata_baixa" ?> input' style="width: 70px;" name="data_baixa[]" value="">
                            </td>
                            <td>
                                <div style="width: 100px;"><?php echo isset($objLancamento->LancamentoTipo->nome)?$objLancamento->LancamentoTipo->nome:'-'; ?></div>
                            </td>
                            <td>
                                <div style="width: 100px;"><?php echo $conta; ?></div>
                            </td>
                            <td>
                                <div style="width: 100px;"><?php echo $objLancamento->descricao; ?></div>
                            </td>
                            <td>
                                <div style="width: 60px;">R$<?php echo number_format($objLancamento->valor_total, 2, ',', '.'); ?></div>
                            </td>
                        </tr>
                        
                    <?php
                    $x++;
                }

                ?>
                    <!-- <tr>
                        <td colspan="8" align="right" style="background: none">
                            <?php if($credito > 0) { ?><b>Valor de Crédito: R$ <?php echo number_format($credito, 2, ',', '.') ?></b><br><?php } ?>
                            <?php if($debito > 0) { ?><b>Valor de Débito: R$ <?php echo number_format($debito, 2, ',', '.') ?></b><br><?php } ?>
                            <?php if(($debito != 0)&&($credito != 0)) { ?><b>Saldo: R$ <?php echo number_format($credito-$debito, 2, ',', '.') ?></b><?php } ?>
                        </td>
                    </tr> -->
                </table>


                <div class="clear"></div><br />



                <div class="form_row"><input type="submit" class="submit" value="Atualizar"  /></div>

            </form>
            <?php


            ?>
        </div>
    </div><!-- Block End -->
</div><!-- Body Wrapper End -->

        <script type="text/javascript">
            $('.data_baixa').mask('99/99/9999');
            $('.pdata_baixa').change(function(){
                $('.data_baixa').val($(this).val());
            })
        </script>