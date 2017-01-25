<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<?php
		try {
            $con = mysql_connect(DB_HOST, DB_USER, DB_PSWD);
            mysql_select_db(DB_NAME);

            $sql = "select COUNT(e.id)as total, m.nome from equipamento as e
            LEFT JOIN contrato_equipamento as ce on ce.equipamento_id = e.id
            LEFT JOIN contrato as c ON ce.contrato_id = c.id
            LEFT JOIN equipamento_modelo as em ON e.equipamento_modelo_id = em.id
            LEFT JOIN marca as m ON em.marca_id = m.id
            where ce.contrato_id = c.id
            AND ce.equipamento_id = e.id
            AND c.tipo = 0";

            $exe = mysql_query($sql) or die(mysql_error());


            $retTotal = mysql_fetch_assoc($exe);


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
            <h4>TOTAL DE MAQUINAS ALUGADAS</h4>
            <hr />
            <div class="clear"></div>

				<div class="form_row">
					<label><b>Total de Maquinas:</b></label>
                    <h4><?php echo $retTotal['total']; ?></h4>
				</div>


                <div class="clear"></div><br />



                <div class="form_row"><input type="button" class="submit" id="print" value="Imprimir"  /></div>

			</form>
			<?php


			?>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->