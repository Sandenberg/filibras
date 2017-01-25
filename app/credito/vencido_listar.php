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
                        $where      =   "'".date("Y-m-d")."' > data_vencimento and data_baixa is null";
						$retAll		= 	Doctrine_Query::create()->select()->from('Lancamento l')
                                                    ->leftJoin("l.Cliente cl")->leftJoin('l.LancamentoTipo lt')->innerJoin('cl.Filial f')
													->where($where)->orderBy('data_lancamento asc')->execute();
                        // echo $retAll->count();
					?>

                    <tr>
                        <th width="80">Lançamento</th>
                        <th class='cliente'>Cliente</th>
                        <th width="80">Vencimento</th>
                        <th width="50">NF/REC</th>
                        <th width="100">Tipo</th>
                        <!-- <th width="150">Descrição</th> -->
                        <th width="60">Valor</th>
                    </tr>
                    <?php
                        $soma = 0;
                    	foreach ($retAll as $objLancamento) {
							// Validação de datas
							$data_lancamento	        = $objLancamento->data_lancamento==''?'':date('d/m/Y', strtotime($objLancamento->data_lancamento));
							$data_vencimento		    = $objLancamento->data_vencimento==''?'':date('d/m/Y', strtotime($objLancamento->data_vencimento));
							
                            
                            $nfrb = isset($objLancamento->nf)&&$objLancamento->nf!=''?$objLancamento->nf:'-';
                            $nfrb = isset($objLancamento->recibo)&&$objLancamento->recibo=='REC'?'REC':$nfrb;

                            $objLancamento->LancamentoTipo->nome = isset($objLancamento->LancamentoTipo->nome)&&$objLancamento->LancamentoTipo->nome!=''?$objLancamento->LancamentoTipo->nome:'-';
            				
            				// Busca a filial
            				$filial = isset($objLancamento->Cliente[0])?$objLancamento->Cliente[0]->Filial->nome:$objLancamento->Cliente->Filial->nome;
                    		?>
                    			<tr>
                    				<td><?php echo $data_lancamento ?></td>
                                    <td><a href="<?php echo URL_ADMIN."credito/editar/".$objLancamento->id."/"; ?>" target='_blank'><?php echo $objLancamento->Cliente->nome_completo ?></a></td>
                                    <td><?php echo $data_vencimento ?></td>
                    				<td><?php echo $nfrb ?></td>
                    				<td><?php echo $objLancamento->LancamentoTipo->nome ?></td>
                                    <!-- <td><?php echo $filial ?></td> -->
                    				<td>R$ <?php echo number_format($objLancamento->valor_total, 2, ',', '.') ?></td>
                    			</tr>
                    		<?php
                            $soma+=$objLancamento->valor_total;
                    	}
                    ?>
                    <tr>
                        <td colspan="8" align="right" style="background: none">
                            <b>Total de registros: <?php echo $retAll->count() ?></b><br><br>
                            <b>Valor Total: R$<?php echo number_format($soma, 2, ',', '.'); ?></b>
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