<?php 
    ini_set('memory_limit', -1); // defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); 

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
                <h4>ESTOQUE CRÍTICO </h4>
                <hr />
                <div class="clear"></div>
                <table>
                    

                    <tr>
                        <th width="40px">
                            <label><b>Nº:</b></label>
                        </th>
                        <th width="250px">
                            <label><b>Material:</b></label>
                        </th>
                        <th width="80px">
                            <label><b>Valor:</b></label>
                        </th>
                        <th width="80px">
                            <label><b>Mínimo:</b></label>
                        </th>
                        <th width="80px">
                            <label><b>Estoque:</b></label>
                        </th>
                    </tr>
                <?php

                $where = '1=1';
                // $where = 'minimo >= estoque';

                $retAll     =   Doctrine_Query::create()->select()->from('Material')
                                    ->orderBy("nome asc")
                                    ->where($where)->execute();

                $x = 0;
                foreach ($retAll as $objMaterial) {
                    $x++;

                    ?>

                        <tr>
                            <td>
                                <div style="width: 30px;"><?php echo $x ?></div>
                            </td>
                            <td>
                                <div style="width: 240px;"><?php echo $objMaterial->nome; ?></div>
                            </td>
                            <td>
                                <div style="width: 70px;">R$<?php echo number_format($objMaterial->valor, 2, ',', '.'); ?></div>
                            </td>
                            <td>
                                <div style="width: 70px;"><?php echo $objMaterial->minimo; ?></div>
                            </td>
                            <td>
                                <div style="width: 70px;"><?php echo $objMaterial->estoque; ?></div>
                            </td>
                        </tr>
                        
                    <?php

                }

                ?>
                </table>


                <div class="clear"></div><br />



                <div class="form_row"><input type="button" class="submit" onclick="window.print();" id="print" value="Imprimir"  /></div>

            </form>
            <?php


            ?>
        </div>
    </div><!-- Block End -->
</div><!-- Body Wrapper End -->