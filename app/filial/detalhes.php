<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<?php
		try {
				
			// Seleciona os dados do usuário
			$res = Doctrine_Core::getTable('OrdemServico')->find($_GET['id']);
				
		} catch (Exception $e){
		
		}
		?>
		<div class="titlebar">
			<h3>Contrato - <?php echo $res->id.' - Cliente - '.$res->Cliente->nome_completo; ?> - Detalhes</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php 

			try {
				
				//Seleciona os dados do usuário
				$res = Doctrine_Core::getTable('OrdemServico')->find($_GET['id']);
				
			?>
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
                    padding: 10px ;
                    font-size: 14px ;
                    line-height: 10px ;
                }

            </style>
            <div class="form_row">
                <div style="width: 100px;"><img src=<?php echo URL_ADMIN_IMAGES?>logomarca_filibras_pequena.png></div>
            </div>
            <h4>Dados do Cliente</h4>
            <hr />
            <div class="clear"></div>

				<div class="form_row">
					<label><b>NÚMERO DA ORDEM DE SERVIÇO:</b></label>
					<div style="width: 400px;"><?php echo $res->id; ?></div>
				</div>

				<div class="form_row">
					<label><b>TIPO:</b></label>
					<?php
					$tipo = $res->tipo_ordem;
					$tipo = $tipo==0?'Manutenção no Equipamento':$tipo;
					$tipo = $tipo==1?'Troca de Cilindro/Toner':$tipo;
					$tipo = $tipo==2?'Leitura de Numerador':$tipo;					
					$tipo = $tipo==3?'Instalação de Equipamento':$tipo;
                    $tipo = $tipo==4?'Troca de Equipamento':$tipo;
                    $tipo = $tipo==5?'Retirada de Equipamento':$tipo;
                    $tipo = $tipo==6?'Retirada de Equipamento':$tipo;
					?>
					<div style="width: 200px;"><?php echo $tipo; ?></div>
				</div>
            <hr />
				<div class="clear"></div>
			
				<div class="form_row">
					<label><b>CLIENTE:</b></label>
					<div style="width: 500px;"><?php echo $res->Cliente->nome_completo; ?></div>
				</div>
            <div class="form_row">
                <label><b><?php echo $res->Cliente->tipo_pessoa==0?'CPF':'CNPJ'; ?>:</b></label>
                <?php
                $cpf 	= $res->Cliente->cpf!=''?Util::mask('###.###.###-##', $res->Cliente->cpf):'-';
                $cnpj 	= $res->Cliente->cnpj!=''?Util::mask('##.###.###/####-##', $res->Cliente->cnpj):'-';
                ?>
                <div style="width: 270px;"><?php echo $res->Cliente->tipo_pessoa==0?$cpf:$cnpj; ?></div>
            </div>
            <hr />
            <div class="clear"></div>

            <div class="form_row">
                <label><b>ENDEREÇO:</b></label>
                <div style="width: 300px;"><?php echo $res->Cliente->logradouro; ?></div>
            </div>
            <div class="form_row">
                <label><b>NUMERO:</b></label>
                <div style="width: 100px;"><?php echo $res->Cliente->numero; ?></div>
            </div>
            <div class="form_row">
                <label><b>COMPL:</b></label>
                <div style="width: 150px;"><?php echo $res->Cliente->complemento; ?></div>
            </div>
            <div class="form_row">
                <label><b>BAIRRO:</b></label>
                <div style="width: 150px;"><?php echo $res->Cliente->bairro; ?></div>
            </div>
            <hr />
            <div class="form_row">

                <div class="form_row">
                    <label><b>SOLICITANTE/CONTATO:</b></label>
                    <div style="width: 400px;"><?php echo $res->solicitante; ?></div>
                </div>
            <div class="form_row">
                <label><b>OBSERVAÇÃO SOLICITANTE/CONTATO:</b></label>
                <div style="width: 300px;"><textarea class="textarea" style="width: 400px;" rows="2" ></textarea></imput></div>
            </div>


            </div>

            <hr />
            <h4>DADOS DOS EQUIPAMENTOS</h4>
            <hr />
				<?php

                if($res->tipo_ordem == 0){

                    $where = "id_ordem_servico = ".$res->id;

                    $retManutencao		= 	Doctrine_Query::create()->select()->from('OrdemServManutencao')->where($where)->execute();

                $retManutencao = $retManutencao->toArray();

                foreach ($retManutencao as $value){

                         $equipamento_form = $value['equipamento'];
                         $localizacao_form = $value['localizacao'];
                         $serie_form = $value['serial'];
                         $defeito_id = $value['defeito'];

                    $resDefeito = Doctrine_Core::getTable('Condicao')->find($defeito_id);
            ?>

                    <div class="form_row">
                        <label><b>Equipamento:</b></label>
                        <div style="width: 150px;"><?php echo $equipamento_form; ?></div>
                    </div>

                    <div class="form_row">
                        <label><b>Localização:</b></label>
                        <div style="width: 350px;"><?php echo $localizacao_form; ?></div>
                    </div>

                    <div class="form_row">
                        <label><b>Nº de Serie:</b></label>
                        <div style="width: 150px;"><?php echo $serie_form; ?></div>
                    </div>

                    <div class="form_row">
                        <label><b>Defeito:</b></label>
                        <div style="width: 150px;"><?php echo $resDefeito->nome; ?></div>
                    </div>

                    <div class="clear"></div>
                    <hr />
                <?php



                }
                }



                if($res->tipo_ordem == 1){

                    $where = "id_ordem_servico = ".$res->id;
                    $retToner		= 	Doctrine_Query::create()->select()->from('OrdemServToner')->where($where)->execute();


                    $retToner = $retToner->toArray();

                    foreach ($retToner as $value){

                        $equipamento_form = $value['equipamento'];
                        $localizacao_form = $value['localizacao'];
                        $serie_form = $value['serial'];
                        $quant_cilindro_form = $value['quant_cilindro'];
                        $quant_toner_form = $value['quant_toner'];
                        $cilindro_form = $value['cilindro'];
                        $toner_form = $value['toner'];



                        ?>

                        <div class="form_row">
                            <label><b>Equipamento:</b></label>
                            <div style="width: 150px;"><?php echo $equipamento_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Localização:</b></label>
                            <div style="width: 350px;"><?php echo $localizacao_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Nº de Serie:</b></label>
                            <div style="width: 150px;"><?php echo $serie_form; ?></div>
                        </div>
                        <?php
                        if($toner_form != 'Selecione'){
                        ?>
                        <div class="form_row">
                            <label><b>Quantidade Toner:</b></label>
                            <div style="width: 150px;"><?php echo $quant_toner_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Toner:</b></label>
                            <div style="width: 150px;"><?php echo $toner_form; ?></div>
                        </div>
                        <?php
                        }
                        ?>

                        <?php
                        if($cilindro_form != 'Selecione'){
                            ?>

                        <div class="form_row">
                            <label><b>Quantidade Cilindro:</b></label>
                            <div style="width: 150px;"><?php echo $quant_cilindro_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Cilindro:</b></label>
                            <div style="width: 150px;"><?php echo $cilindro_form; ?></div>
                        </div>
                        <?php
                        }
                        ?>

                        <div class="clear"></div>
                        <hr />

                    <?php

                    }
                }


                    if($res->tipo_ordem == 2){

                        $where = "id_ordem_servico = ".$res->id;

                        $retNumerador		= 	Doctrine_Query::create()->select()->from('OrdemServNumerador')->where($where)->execute();


                        $retNumerador = $retNumerador->toArray();

                        foreach ($retNumerador as $value){

                            $equipamento_form = $value['equipamento'];
                            $localizacao_form = $value['localizacao'];
                            $serie_form = $value['serial'];
                            $numerador = $value['numerador'];

                            ?>

                            <div class="form_row">
                                <label><b>Equipamento:</b></label>
                                <div style="width: 150px;"><?php echo $equipamento_form; ?></div>
                            </div>

                            <div class="form_row">
                                <label><b>Localização:</b></label>
                                <div style="width: 350px;"><?php echo $localizacao_form; ?></div>
                            </div>

                            <div class="form_row">
                                <label><b>Nº de Serie:</b></label>
                                <div style="width: 150px;"><?php echo $serie_form; ?></div>
                            </div>

                            <div class="form_row">
                                <label><b>Numerador:</b></label>
                                <div style="width: 150px;"><?php echo $numerador; ?></div>
                            </div>

                            <div class="clear"></div>
                            <hr />

                        <?php


                        }
                    }





                if($res->tipo_ordem == 3){

                    $where = "id_ordem_servico = ".$res->id;

                    $retNumerador		= 	Doctrine_Query::create()->select()->from('OrdemServInstalacao')->where($where)->execute();


                    $retNumerador = $retNumerador->toArray();

                    foreach ($retNumerador as $value){

                        $equipamento_form = $value['equipamento'];
                        $localizacao_form = $value['localizacao'];
                        $serie_form = $value['serial'];
                        $cart_reserva_from = $value['cart_reserva'];

                        ?>

                        <div class="form_row">

                            <label><b>Equipamento:</b></label>
                            <div style="width: 150px;"><?php echo $equipamento_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Localização:</b></label>
                            <div style="width: 350px;"><?php echo $localizacao_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Nº de Serie:</b></label>
                            <div style="width: 150px;"><?php echo $serie_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Cartucho Reserva:</b></label>
                            <div style="width: 150px;"><?php echo $cart_reserva_from; ?></div>
                        </div>

                        <div class="clear"></div>
                        <hr />

                    <?php


                    }
                }

                if($res->tipo_ordem == 4){

                    $where = "id_ordem_servico = ".$res->id;

                    $retNumerador		= 	Doctrine_Query::create()->select()->from('OrdemServTroca')->where($where)->execute();


                    $retNumerador = $retNumerador->toArray();

                    foreach ($retNumerador as $value){

                        $equipamento_form = $value['equipamento'];
                        $localizacao_form = $value['localizacao'];
                        $serie_form = $value['serial'];
                        $cart_reserva_from = $value['cart_reserva'];

                        ?>

                        <div class="form_row">
                            <label><b>Equipamento:</b></label>
                            <div style="width: 150px;"><?php echo $equipamento_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Localização:</b></label>
                            <div style="width: 350px;"><?php echo $localizacao_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Nº de Serie:</b></label>
                            <div style="width: 150px;"><?php echo $serie_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Cartucho Reserva:</b></label>
                            <div style="width: 150px;"><?php echo $cart_reserva_from; ?></div>
                        </div>

                        <div class="clear"></div>
                        <hr />

                    <?php


                    }
                }

                if($res->tipo_ordem == 5){

                    $where = "id_ordem_servico = ".$res->id;

                    $retNumerador		= 	Doctrine_Query::create()->select()->from('OrdemServRetirada')->where($where)->execute();


                    $retNumerador = $retNumerador->toArray();

                    foreach ($retNumerador as $value){

                        $equipamento_form = $value['equipamento'];
                        $localizacao_form = $value['localizacao'];
                        $serie_form = $value['serial'];
                        $cart_reserva_from = $value['cart_reserva'];

                        ?>

                        <div class="form_row">
                            <label><b>Equipamento:</b></label>
                            <div style="width: 150px;"><?php echo $equipamento_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Localização:</b></label>
                            <div style="width: 350px;"><?php echo $localizacao_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Nº de Serie:</b></label>
                            <div style="width: 150px;"><?php echo $serie_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Cartucho Reserva:</b></label>
                            <div style="width: 150px;"><?php echo $cart_reserva_from; ?></div>
                        </div>

                        <div class="clear"></div>
                        <hr />

                    <?php


                    }
                }
                if($res->tipo_ordem == 6){

                    $where = "id_ordem_servico = ".$res->id;

                    $retNumerador		= 	Doctrine_Query::create()->select()->from('OrdemServPreventiva')->where($where)->execute();


                    $retNumerador = $retNumerador->toArray();

                    foreach ($retNumerador as $value){

                        $equipamento_form = $value['equipamento'];
                        $localizacao_form = $value['localizacao'];
                        $serie_form = $value['serial'];

                        ?>

                        <div class="form_row">
                            <label><b>Equipamento:</b></label>
                            <div style="width: 150px;"><?php echo $equipamento_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Localização:</b></label>
                            <div style="width: 350px;"><?php echo $localizacao_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Nº de Serie:</b></label>
                            <div style="width: 150px;"><?php echo $serie_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Verificado:</b></label>
                            <label>SIM</label> <input type="checkbox"  />
                        </div>
                        <div class="form_row">
                            <label>NÃO</label>  <input type="checkbox"  />
                        </div>



                        <div class="clear"></div>
                        <hr />

                    <?php


                    }
                }


				
				?>



				<div class="clear"></div>
					
					<div class="form_row">
						<label><b>OBSERVAÇÃO:</b></label>
                        <div style="width: 300px;"><textarea class="textarea" style="width: 700px;" rows="4" ></textarea></imput></div>
					</div>
					
				<div class="clear"></div>


                <hr />
                <h4>Últimos Atendimentos</h4>
                <?php

                $where = "id_cliente = ".$res->Cliente->id;

                $retNumerador		= 	Doctrine_Query::create()->select()->from('FinalizarOrdemServico')->where($where)->execute();


                $retNumerador = $retNumerador->toArray();
                $count = 0;
                if($count < 5){
                    foreach ($retNumerador as $value){

                        $res = Doctrine_Core::getTable('OrdemServico')->find($value['id_ordem_servico']);

                        $tipo = $res->tipo_ordem;
                        $tipo = $tipo==0?'Manutenção no Equipamento':$tipo;
                        $tipo = $tipo==1?'Troca de Cilindro/Toner':$tipo;
                        $tipo = $tipo==2?'Leitura de Numerador':$tipo;
                        $tipo = $tipo==3?'Instalação de Equipamento':$tipo;
                        $tipo = $tipo==4?'Troca de Equipamento':$tipo;
                        $tipo = $tipo==5?'Retirada de Equipamento':$tipo;
                        $tipo = $tipo==6?'Retirada de Equipamento':$tipo;
                        ?>
                        <hr />
                        <div class="form_row">
                            <label><b>Descrição:</b></label>
                            <div style="width: 300px;"><?php echo $value['descricao']; ?></div>
                        </div>

                        <div class="form_row">
                            <label style="width: 200px;"><b>Tipo de Ordem de Serviço:</b></label>
                            <div style="width: 200px;"><?php echo $tipo; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Data Finalizado:</b></label>
                            <div style="width: 150px;"><?php echo $value['data_final']; ?></div>
                        </div>


                        <div class="clear"></div>
                        <hr />

                    <?php




                    }
                    $count++;
                }

                ?>
                <div class="clear"></div><br />


                    <div class="form_row">
                        <label><b>ASSINATURAS:</b></label>
                    </div>
                    <div class="clear"></div><br />

                    <div class="form_row">
                        <label><b>Cliente:</b></label>
                        <div style="width: 300px;"></div>
                    </div>
                    <div class="form_row">
                        <label><b>Técnico:</b></label>
                    </div>
			
				<div class="clear"></div><br />

                    <div class="form_row" style="margin-right: 200px ">
                        <div style="width: 100px;">________________________________</div>
                    </div>

                    <div class="form_row">
                        <div style="width: 100px;">_________________________________</div>
                    </div>

                <div class="clear"></div><br />
            <div class="form_row">
                <label><b>Data Atendimento:</b></label></br>
                <div style="width: 100px;">_____/_____/______</div>
            </div>

                <h4>ATENÇÃO:</h4>
                <hr />


                <div class="form_row">

                    <b> É OBRIGATÓRIO O TÉCNICO ENTREGAR UMA CÓPIA DESTA ORDEM DE SERVIÇO PARA O CLIENTE.</b>
                </div>


                <div class="clear"></div><br />



                <div class="form_row"><input type="button" class="submit" id="print" value="Imprimir"  /></div>

			</form>
			<?php 
			
			} catch (Exception $e){
				echo 'Ocorreu um erro!'.$e;
			}
			
			unset($res);
			
			?>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->