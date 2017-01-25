<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<?php
		try {

            $con = mysql_connect(DB_HOST, DB_USER, DB_PSWD);
            mysql_select_db(DB_NAME);

            $sql = "
            select  m.nome as marca, em.id as id_eq ,em.nome as modelo ,count(em.nome)as total from equipamento as e
            LEFT JOIN contrato_equipamento as ce on ce.equipamento_id = e.id
            LEFT JOIN contrato as c ON ce.contrato_id = c.id
            LEFT JOIN equipamento_modelo as em ON e.equipamento_modelo_id = em.id
            LEFT JOIN marca as m ON em.marca_id = m.id
            where
            ce.contrato_id = c.id
            AND ce.equipamento_id = e.id
            and e.status = 2
            GROUP BY em.nome
            ";
            /*
            where ce.contrato_id = c.id
            AND ce.equipamento_id = e.id
            AND c.tipo = 0*/

            $exe = mysql_query($sql) or die(mysql_error());


           ;



				
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
                <h4>TOTAL DE MAQUINAS DE EQUIPAMENTO DO CLIENTE POR MODELO </h4>
                <hr />
                <div class="clear"></div>

                <?php

                $total = 0;
                while ( $retTotal = mysql_fetch_assoc($exe)){


                    $total += $retTotal['total'];
                ?>
                    <div class="form_row" style="cursor: pointer; border: 1px #ccc solid; margin-right: 40px;" onclick="location.href= '<?php echo URL_ADMIN ?>relatorio-cliente-model/clientes?id=<?php echo $retTotal['id_eq'] ?>'">
                    <!-- <div class="form_row" style="border: 1px #ccc solid; margin-right: 40px;"> -->
                        <div class="form_row">
                            <label><b>Marca:</b></label>
                            <div style="width: 100px;"><?php echo $retTotal['marca']; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Modelo:</b></label>
                            <div style="width: 100px;"><?php echo $retTotal['modelo']; ?></div>
                        </div>

                        <div class="form_row" style="margin-right: 0px;">
                            <label><b>Total:</b></label>
                            <div style="width: 100px;"><?php echo $retTotal['total']; ?></div>
                        </div>
                    </div>
               <?php
                }

                ?>

                <h4>TOTAL DE MAQUINAS DE CLIENTE: <?php echo $total ?> </h4>
                <div class="clear"></div><br />



                <div class="form_row"><input type="button" class="submit" id="print" value="Imprimir"  /></div>
                <div class="form_row"><a href="<?php echo URL.'app/'.$_GET['model'].'/detalhes_pdf.php' ?>" class="submit" target="_blank">&nbsp;&nbsp;&nbsp;Exportar para PDF&nbsp;&nbsp;&nbsp;</a></div>

            </form>
            <?php


            ?>
        </div>
    </div><!-- Block End -->
</div><!-- Body Wrapper End -->