<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>

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

                    #formPerfil a{

                    	text-decoration: none;

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
    





    
				                    

					<?php

						$where	 	= 	"'".date("Y-m-d", strtotime(date("Y-m-d")."+35 days"))."' > data_fim and tipo <> 1";

						$retAll		= 	Doctrine_Query::create()->select()->from('Contrato c')

													->innerJoin('c.Cliente cl')->innerJoin('cl.Filial f')

													->where($where)->orderBy('data_fim asc')->execute();

					?>



                    <tr>

                        <th>

                            <label><b>Cliente:</b></label>

                        </th>

                        <th>

                            <label><b>Tipo:</b></label>

                        </th>

                        <th>

                            <label><b>Contrato:</b></label>

                        </th>

                        <th>

                            <label><b>Início Vigência:</b></label>

                        </th>

                        <th>

                            <label><b>Fim Vigência:</b></label>

                        </th>

                        <!-- <th>

                            <label><b>Filial:</b></label>

                        </th> -->

                        <th>

                            <label><b>Renovação:</b></label>

                        </th>

                    </tr>

                    <?php

                    	foreach ($retAll as $objContrato) {

							// Validação de datas

							$objContrato->data_inicio	= $objContrato->data_inicio==''?'':date('d/m/Y', strtotime($objContrato->data_inicio));

							$data_fim            		= $objContrato->data_fim==''?'INDETERMINADA':date('d/m/Y', strtotime($objContrato->data_fim));

                            $data_fim                   = $data_fim=="2015-12-12"?"12/12/2015":$data_fim;



							// Exibie o tipo correto

							$objContrato->tipo = $objContrato->tipo==0?'Locação':$objContrato->tipo;

							$objContrato->tipo = $objContrato->tipo==1?'Venda':$objContrato->tipo;

							$objContrato->tipo = $objContrato->tipo==2?'Venda sem contrato':$objContrato->tipo;

							$objContrato->tipo = $objContrato->tipo==3?'Contrato de manutenção':$objContrato->tipo;

                            $objContrato->tipo = $objContrato->tipo==4?'Diversos':$objContrato->tipo;

							

                            $objContrato->renovacao = $objContrato->renovacao==1?'Automática':'Manual';

            				

            				// Busca a filial

            				$filial = isset($objContrato->Cliente[0])?$objContrato->Cliente[0]->Filial->nome:$objContrato->Cliente->Filial->nome;

                    		?>

                    			<tr>

                    				<td><a href="<?php echo URL_ADMIN."contrato/editar/".$objContrato->id."/"; ?>" target='_blank'><?php echo $objContrato->Cliente->nome_completo ?></a></td>

                    				<td><?php echo $objContrato->tipo ?></td>

                    				<td><?php echo $objContrato->numero ?></td>

                    				<td><?php echo $objContrato->data_inicio ?></td>

                    				<td><?php echo $data_fim ?></td>

                                    <!-- <td><?php echo $filial ?></td> -->

                    				<td><?php echo $objContrato->renovacao ?></td>

                    			</tr>

                    		<?php

                    	}

                    ?>

                    <tr>

                        <td colspan="8" align="right" style="background: none">

                            <b>Total de registros: <?php echo $retAll->count() ?></b>

                        </td>

                    </tr>

                </table>





                <div class="clear"></div><br />







                <div class="form_row"><input type="button" class="submit" onclick="window.print();" id="print" value="Imprimir"  /></div>



            </form>

            <?php





            ?>

        </div>

    </div><!-- Block End -->

</div><!-- Body Wrapper End -->