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
                <h4>TOTAL DE MAQUINAS POR MODELO POR CLIENTE </h4>
                <hr />
                <div class="clear"></div>
                <table>
                    

                    <tr>
                        <th width="30px">
                            <label><b>ID:</b></label>
                        </th>
                        <th width="80px">
                            <label><b>Cliente:</b></label>
                        </th><!-- 
                        <th width="80px">
                            <label><b>Telefone:</b></label>
                        </th><!-- 
                        <th width="80px">
                            <label><b>Contato:</b></label>
                        </th>
                        <th width="100px">
                            <label><b>Documento:</b></label>
                        </th> 
                        <th>
                            <label><b>E-mail:</b></label>
                        </th>-->
                        <th>
                            <label><b>Equipamento:</b></label>
                        </th>
                        <th>
                            <label><b>Série:</b></label>
                        </th>
                    </tr>
                <?php

                $where = 'c.tipo = 0 and e.status = 1';

                // Filtro de Cliente
                $where .= isset($_GET['id'])&&$_GET['id']!=''?" and m.id = '".$_GET['id']."'":'';

                $order = 'id desc';

                $retAll     =   Doctrine_Query::create()->select()->from('Equipamento e')
                                    ->leftJoin('e.ContratoEquipamento ce')->leftJoin('ce.Contrato c')
                                    ->leftJoin('e.EquipamentoModelo m')->leftJoin('m.Marca ma')->leftJoin('c.Cliente')
                                    ->orderBy($order)->where($where)->execute();

                $credito = 0;
                $debito = 0;
                $x = 0;
                foreach ($retAll as $objEquipamento) {
                    $x++;

                    $objEquipamento->ContratoEquipamento[0]->Contrato->Cliente->telefone_principal = ltrim($objEquipamento->ContratoEquipamento[0]->Contrato->Cliente->telefone_principal, '0');  
                    $telefone = strlen($objEquipamento->ContratoEquipamento[0]->Contrato->Cliente->telefone_principal)==10?Util::mask('(##)####-####', $objEquipamento->ContratoEquipamento[0]->Contrato->Cliente->telefone_principal):Util::mask('(##)#####-####', $objEquipamento->ContratoEquipamento[0]->Contrato->Cliente->telefone_principal);  
                                  
                    //     $retFornecedoResp = Doctrine_Query::create()->select()->from('ClienteResponsavel')
                    // ->where("cliente_id = ".$objEquipamento->ContratoEquipamento[0]->Contrato->Cliente->id)->execute();
                        
                    //     if ($retFornecedoResp->count() > 0){
                    // $resFornecedoResp = $retFornecedoResp->toArray();
                    //         foreach ($resFornecedoResp as $valueResp){
                    //     $objEquipamento->ContratoEquipamento[0]->Contrato->Cliente->contato = $valueResp['nome']; 
                    //         }}else{
                    //             $objEquipamento->ContratoEquipamento[0]->Contrato->Cliente->contato ='';
                    //         }
                    // $objEquipamento->ContratoEquipamento[0]->Contrato->Cliente->documento = $objEquipamento->ContratoEquipamento[0]->Contrato->Cliente->tipo_pessoa==0?Util::mask('###.###.###-##', $objEquipamento->ContratoEquipamento->Contrato->Cliente->cpf):Util::mask('##.###.###/####-##', $objEquipamento->ContratoEquipamento->Contrato->Cliente->cnpj);
                    

                    ?>

                        <tr>
                            <td>
                                <div style="width: 30px;"><?php echo $objEquipamento->ContratoEquipamento[0]->Contrato->Cliente->id ?></div>
                            </td>
                            <td>
                                <div style="width: 270px;"><?php echo $objEquipamento->ContratoEquipamento[0]->Contrato->Cliente->nome_completo; ?></div>
                            </td><!-- 
                            <td>
                                <div style="width: 120px;"><?php echo $telefone; ?></div>
                            </td>
                            <td>
                                <div style="width: 70px;"><?php //echo $objEquipamento->ContratoEquipamento[0]->Contrato->Cliente->contato; ?></div>
                            </td> -->
                            <!-- <td>
                                <div style="width: 100px;"><?php //echo $objEquipamento->ContratoEquipamento[0]->Contrato->Cliente->documento ?></div>
                            </td> 
                            <td>
                                <div style="width: 250px;"><?php echo $objEquipamento->ContratoEquipamento[0]->Contrato->Cliente->email; ?></div>
                            </td>-->
                            <td>
                                <div style="width: 250px;"><?php echo $objEquipamento->ContratoEquipamento[0]->Equipamento->EquipamentoModelo->Marca->nome.' - '.$objEquipamento->ContratoEquipamento[0]->Equipamento->EquipamentoModelo->nome; ?></div>
                            </td>
                            <td>
                                <div style="width: 250px;"><?php echo $objEquipamento->ContratoEquipamento[0]->Equipamento->serial; ?></div>
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
                <!-- <div class="form_row"><a href="<?php echo URL.'app/relatorio-lancamento/detalhes_pdf.php?'.$filtro ?>" class="submit" target="_blank">&nbsp;&nbsp;&nbsp;Exportar para PDF&nbsp;&nbsp;&nbsp;</a></div> -->

            </form>
            <?php


            ?>
        </div>
    </div><!-- Block End -->
</div><!-- Body Wrapper End -->