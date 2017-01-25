<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<?php
		try {

            


           



				
		} catch (Exception $e){
		
		}

		?>

        <div class="titlebar">

            <a href="#" class="toggle">&nbsp;</a>
        </div>
        <div class="block_cont">

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
                        padding: 15px ;
                        font-size: 14px ;
                        line-height: 18px ;
                    }

                </style>
                <div class="form_row">
                    <div style="width: 100px;"><img src=<?php echo URL_ADMIN_IMAGES?>logomarca_filibras_pequena.png></div>
                </div>
                <!-- <h4>TOTAL DE MAQUINAS DE EQUIPAMENTO DO CLIENTE POR MODELO </h4> -->
                <hr />
                <div class="clear"></div>

                <table>
                    <tr>
                        <?php
                            $total = 0;

                            for($x=1;$x<=30;$x++){
                                ?><tr><td class='dia'><?php echo $x ?></td><?php

                                $con = mysql_connect(DB_HOST, DB_USER, DB_PSWD);
                                mysql_select_db(DB_NAME);

                                $sql = "
                                select cl.nome_completo from contrato as c
                                        LEFT JOIN cliente as cl on cl.id = c.cliente_id
                                    where
                                        dia_leitura = '".$x."' and
                                        (tipo = 0 or tipo = 3)
                                    group by cl.id
                                ";
                                /*
                                where ce.contrato_id = c.id
                                AND ce.equipamento_id = e.id
                                AND c.tipo = 0*/

                                $exe = mysql_query($sql) or die(mysql_error());
                                ?><td class='clientes'><?php
                                while ( $retTotal = mysql_fetch_assoc($exe)){
                                    ?>

                                        <div class="form_row" style="cursor: pointer; border: 1px #ccc solid;" onclick="//location.href= '<?php echo URL_ADMIN ?>'">
                                        <!-- <div class="form_row" style="border: 1px #ccc solid; margin-right: 40px;"> -->
                                            <div class="form_row">
                                                <div class='texto'><?php echo utf8_encode($retTotal['nome_completo']); ?></div>
                                                <!-- <div class='texto'><?php echo utf8_encode(utf8_decode(substr(utf8_encode($retTotal['nome_completo']), 0, 24))); ?></div>-->
                                            </div>
                                            <div class="form_row" style="cursor: pointer; border: 0px #ccc solid; float: right; margin-top: 20px; margin-right: 10px;" onclick="//location.href= '<?php echo URL_ADMIN ?>'">
                                                <input type="checkbox">
                                            </div>
                                        </div>
                                    <?php
                                    $total++;

                                }

                                ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan=2>
                                    <hr>
                                    </td>
                                </tr>
                                <?php
                            }

                        ?>
                    </tr>
                </table>

                <h4>TOTAL DE CLIENTES: <?php echo $total ?> </h4>
                <div class="clear"></div><br />



                <div class="form_row"><input type="button" class="submit" id="print" onclick="window.print();" value="Imprimir"  /></div>
                <!-- <div class="form_row"><a href="<?php echo URL.'app/'.$_GET['model'].'/detalhes_pdf.php' ?>" class="submit" target="_blank">&nbsp;&nbsp;&nbsp;Exportar para PDF&nbsp;&nbsp;&nbsp;</a></div> -->

            </form>
            <?php


            ?>
        </div>
    </div><!-- Block End -->
</div><!-- Body Wrapper End -->
<style type="text/css">
    @media print{
        a.submit{
            display: none !important;
        }
    }
    .dia{
        font-size: 20px;
        font-weight: 600;
        width: 40px;
    }
    .clientes{
        border: 1px solid #fff;
        margin-bottom: 10px;
    }
    .clientes .texto{
        width: 100px; 
        overflow: hidden;
        height: 50px; 
        font-size: 8px;
        padding: 4px;
        font-weight: 600
    }

</style>