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
			<h3>Ordem Serviço - <?php echo $res->id.' - Cliente - '.$res->Cliente->nome_completo; ?> - Detalhes</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<?php
			try {
				
				//Seleciona os dados do usuário
				$res = Doctrine_Core::getTable('OrdemServico')->find($_GET['id']);

                $telefone_principal = $res->Cliente->telefone_principal;  
                $telefone_principal = strlen($telefone_principal)==10?Util::mask('(##)####-####', $telefone_principal):Util::mask('(##)#####-####', $telefone_principal);  
    
				$telefone_alternativo = $res->Cliente->telefone_alternativo;  
                $telefone_alternativo = strlen($telefone_alternativo)==10?Util::mask('(##)####-####', $telefone_alternativo):Util::mask('(##)#####-####', $telefone_alternativo);  
    
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
                @media print{
                    .obstec{
                        display: none !important;
                    }
                    #main{
                        padding: 0px;
                    }
                    *{
                        line-height: 11px;
                    }
                    .printval{
                        page-break-inside: avoid;
                    }
                    input{
                        display: none;
                    }
                }

            </style>
            <div class="form_row">
                <div style="width: 100px;"><img src=<?php echo URL_ADMIN_IMAGES?>logomarca_filibras_pequena.png></div>
            </div>
            <h4>Dados do Cliente</h4>
            <hr />
            <div class="clear"></div>

				<div class="form_row">
					<label><b>Nº ORDEM DE SERVIÇO:</b></label>
					<div style="width: 200px;"><?php echo $res->id; ?></div>
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
                    $tipo = $tipo==6?'Manutenção Preventiva':$tipo;
                    $tipo = $tipo==7?'Serviços de Informática':$tipo;
                    $tipo = $tipo==8?'Acesso Remoto':$tipo;
                    $tipo = $tipo==9?'Atendimento Avulso':$tipo;
					?>
					<div style="width: 200px;"><?php echo $tipo; ?></div>
				</div>
            <div class="form_row">
                <label><b>DATA / HORA:</b></label>
                <div style="width: 200px;"><?php echo date('d/m/Y H:i:s',strtotime($res->data_atendimento)); ?></div>
            </div>
            <div class="form_row">
                <label><b>TIPO CONTRATO:</b></label>
                <?php
                $tipo = $res->tipo_cliente;
                $tipo = $tipo==0?'Locação':$tipo;
                $tipo = $tipo==1?'Venda':$tipo;
                $tipo = $tipo==3?'Contrato de Manutenção':$tipo;
                $tipo = $tipo==4?'Equipamento do Cliente':$tipo;
                ?>
                <div style="width: 200px;"><?php echo $tipo; ?></div>
            </div>
            <?php 

                if(isset($res->FinalizarOrdemServico[0]->audit)&&$res->FinalizarOrdemServico[0]->audit!=''){

                    $where_usuario = "id = ".$res->FinalizarOrdemServico[0]->audit;
                    $retUsuario   =   Doctrine_Query::create()->select()->from('Usuario')->where($where_usuario)->execute();
   
                    ?>
                        <div class="form_row">
                            <label><b>TÉCNICO:</b></label>
                            <div style="width: 200px;"><?php echo isset($retUsuario[0]->nome)?$retUsuario[0]->nome:""; ?></div>
                        </div>
                    <?php
                }
            ?>
            <hr />
				<div class="clear"></div>
			
				<div class="form_row">
					<label><b>CLIENTE:</b> <?php echo $res->Cliente->id; ?></label>
					<div style="width: 500px; line-height: 16px;"><?php echo $res->Cliente->nome_completo; ?></div>
				</div>



            <div class="form_row">
                <label><b>TELEFONE 1:</b></label>
                <div style="width: 150px;"><?php echo $res->Cliente->telefone_principal!=''?$telefone_principal:'-'; ?></div>
            </div>
            <?php if($res->Cliente->telefone_alternativo!=''){ ?>
                <div class="form_row">
                    <label><b>TELEFONE 2:</b></label>
                    <div style="width: 150px;"><?php echo $res->Cliente->telefone_alternativo!=''?$telefone_alternativo:'-'; ?></div>
                </div>
            <?php } ?>
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
                <label><b>NÚMERO:</b></label>
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
            <div class="form_row">
                <label><b>CIDADE:</b></label>
                <div style="width: 150px; text-transform: uppercase;"><?php echo $res->Cliente->Cidade->nome; ?></div>
            </div>
            <div class="form_row">
                <label><b>CEP:</b></label>
                <div style="width: 150px; text-transform: uppercase;"><?php echo $res->Cliente->cep; ?></div>
            </div>
            <hr />


            <?php if($res->tipo_ordem != 6&&$res->tipo_ordem != 9){ ?>
                <div class="form_row">
                    <div class="form_row">
                        <label><b>SOLICITANTE/OBSERVAÇÃO:</b></label>
                        <div style="width: 400px;"><?php echo $res->solicitante; ?></div>
                    </div>
                </div>
                <hr />
            <?php } ?>
            <?php if($res->tipo_ordem == 9){ ?>
                <div class="form_row">
                    <div class="form_row">
                        <label><b>LOCALIZAÇÃO:</b></label>
                        <div style="width: 400px;"><?php echo $res->observacao; ?></div>
                    </div>
                </div>
                <hr />
            <?php } ?>
            <?php if(isset($res->FinalizarOrdemServico[0]->id)&&$res->FinalizarOrdemServico[0]->id!=''){ ?>
                <div class="form_row">
                    <label><b>OBSERVAÇÃO:</b></label>
                    <div style="width: 400px; text-transform: uppercase;"><?php echo $res->FinalizarOrdemServico[0]->descricao; ?></div>
                </div>
                <hr />
            <?php } ?>


                <?php
                    /********************************************************************************/
                    /********************************************************************************/
                    /********************************************************************************/

                    $where = "ost.id_ordem_servico = ".$res->id." or osm.ordem_servico_id = ".$res->id;

                    $retMaterial = Doctrine_Query::create()->select()->from('OrdemServicoMaterial osm')->leftJoin('osm.Material m')->leftJoin('osm.OrdemServToner ost')->where($where)->execute();

                    if($retMaterial->count()>0){
                        ?>
                        <div style="background: #bbe2b3; padding: 10px;">
                            <h4>PEÇAS E MATERIAIS - SERVIÇOS EXECUTADOS</h4>
                            <?php 




                                $retMaterial = $retMaterial->toArray();

                                foreach ($retMaterial as $value){

                                    if(isset($value['equipamento_id'])&&$value['equipamento_id']!=''){
                                        $equipamento_id = $value['equipamento_id'];
                                    }else{
                                        $equipamento_id = $value['OrdemServToner']['equipamento_id'];
                                    }

                                    $resEquipamento = Doctrine_Core::getTable('Equipamento')->find($equipamento_id);

                                    $equipamento_form = $resEquipamento->EquipamentoModelo->nome;
                                    // $localizacao_form = $value['localizacao'];
                                    $serie_form = $resEquipamento->serial;

                                    if($value['tipo']==1){
                                        
                                        $value['tipo'] = 'Peça de Reposição';
                                    }else if($value['tipo'] == 0){
                                        
                                        // $value['tipo'] = 'Material de Consumo';
                                        
                                    }else if($value['tipo'] == 2){
                                        
                                        $value['tipo'] = 'Material de Consumo: Cilindro';
                                    }else if($value['tipo'] == 3){
                                        
                                        
                                        $value['tipo'] = 'Material de Consumo: Toner';
                                        
                                    }else if($value['tipo'] == 4){
                                        
                                        
                                        $value['tipo'] = 'Material de Cobrança';
                                        
                                    }

                                    if(isset($value['cobranca'])&&$value['tipo']!=4&&$value['cobranca']==1){
                                        $value['tipo'] .= $value['tipo']==""?"Material de Cobrança":" - Material de Cobrança";
                                    }
                                    

                                    ?>

                                        <div class="form_row">
                                            <label><b>Equipamento:</b></label>
                                            <div style="width: 150px;"><?php echo $equipamento_form; ?></div>
                                        </div>

                                        <div class="form_row">
                                            <label><b>Nº de Serie:</b></label>
                                            <div style="width: 150px;"><?php echo $serie_form; ?></div>
                                        </div>

                                        <div class="form_row">
                                            <label><b>Peça:</b></label>
                                            <div style="width: 200px;"><?php echo $value['Material']['nome'] ?></div>
                                        </div>

                                        <div class="form_row">
                                            <label><b>Quantidade:</b></label>
                                            <div style="width: 100px;"><?php echo $value['quantidade'] ?></div>
                                        </div>
                                        <div class="form_row">
                                            <label><b>Tipo:</b></label>
                                            <div style="width: 250px;"><?php echo $value['tipo'] ?></div>
                                        </div>

                                        <div class="clear"></div>
                                        <hr style="border: 0px; border-bottom: 1px solid #40a92a;">
                                    <?php
                                }

                                if(isset($res->FinalizarOrdemServico[0]->descricao)&&$res->FinalizarOrdemServico[0]->descricao!=''){
                                    ?><b style="line-height: 20px; ">OBSERVAÇÃO:</b><br><span style='text-transform: uppercase'><?php
                                    echo $res->FinalizarOrdemServico[0]->descricao."</span>";
                                }
                            ?>
                                

                        </div>

                        <?php

                    }

                    /********************************************************************************/
                    /********************************************************************************/
                    /********************************************************************************/
                ?>

				<?php

                if($res->tipo_ordem == 0){

                    ?>
                    <h4>DADOS DOS EQUIPAMENTOS</h4>
                    <hr />
                    <?php

                    $where = "id_ordem_servico = ".$res->id;

                    $retManutencao		= 	Doctrine_Query::create()->select()->from('OrdemServManutencao')->where($where)->execute();

                $retManutencao = $retManutencao->toArray();

                foreach ($retManutencao as $value){

                         $equipamento_form = $value['equipamento']!='undefined'?$value['equipamento']:"";
                         $localizacao_form = $value['localizacao'];
                         $serie_form = $value['serial'];
                         $defeito_id = $value['defeito'];
                         $numerador = $value['numerador'];

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
                        <div style="width: 350px;"><?php if(isset($resDefeito->nome)) echo $resDefeito->nome; else echo "&nbsp;" ?></div>
                    </div>
                    <div class="form_row">
                        <label><b>Numerador:</b></label>
                        <div style="width: 150px;"><?php echo $numerador ?></div>
                    </div>

                    <div class="clear"></div>
                    <hr />
                    <?php
                }
                
                ?>
                    <h4>Últimos Atendimentos</h4>
                    <?php

                    $where = "o.id <> ".$res->id." and id_cliente = ".$res->Cliente->id;



                    $whereEq = "serial = '".$serie_form."'";
                    $retEq =   Doctrine_Query::create()->select()->from('Equipamento')
                        ->where($whereEq)->limit(1)->execute();


                    $whereEq = "fo.id_ordem_servico < '".$res->id."' and equipamento_id = ".$retEq[0]->id;
                    $retFinalizarEquipamento =   Doctrine_Query::create()->select()->from('FinalizarEquipamento fe')
                            ->leftJoin("fe.FinalizarOrdemServico fo")->leftJoin('fo.OrdemServico o')
                            ->where($whereEq)->orderBy('id DESC')->limit(3)->execute();

                    // $retFinaliza    =   Doctrine_Query::create()->select()->from('FinalizarOrdemServico fo')->leftJoin('fo.OrdemServico o')->where($where)->orderBy('id desc limit 3')->execute();


                    // $retFinaliza = $retFinaliza->toArray();

                    $count = 0;


                foreach ($retFinalizarEquipamento as $value){

                    // if($value['OrdemServico']['tipo_ordem'] == 0 ){
                        if($count < 3){

                            $tipo = $value->FinalizarOrdemServico->OrdemServico->tipo_ordem;
                            $tipo = $tipo==0?'Manutenção no Equipamento':$tipo;
                            $tipo = $tipo==1?'Troca de Cilindro/Toner':$tipo;
                            $tipo = $tipo==2?'Leitura de Numerador':$tipo;                  
                            $tipo = $tipo==3?'Instalação de Equipamento':$tipo;
                            $tipo = $tipo==4?'Troca de Equipamento':$tipo;
                            $tipo = $tipo==5?'Retirada de Equipamento':$tipo;
                            $tipo = $tipo==6?'Manutenção Preventiva':$tipo;
                            $tipo = $tipo==7?'Serviços de Informática':$tipo;
                            $tipo = $tipo==8?'Acesso Remoto':$tipo;

                            $where_usuario = "id = ".$value->FinalizarOrdemServico->audit;
                            $retUsuario   =   Doctrine_Query::create()->select()->from('Usuario')->where($where_usuario)->execute();

                            ?>
                            <hr />
                            <div class="form_row" style='margin-right: 40px;'>
                                <label><b>Descrição:</b></label>
                                <div style="width: 270px; text-transform: uppercase"><?php echo strtoupper($value->descricao); ?></div>
                            </div>

                            <div class="form_row">
                                <label style="width: 200px;"><b>Tipo de Ordem de Serviço:</b></label>
                                <div style="width: 200px;"><?php echo $tipo; ?></div>
                            </div>

                            <div class="form_row">
                                <label><b>Data Finalizado:</b></label>
                                <div style="width: 150px;"><?php echo date("d/m/Y H:i:s", strtotime($value->FinalizarOrdemServico->data_final)); ?></div>
                            </div>


                            <div class="form_row">
                                <label style="width: 100px;"><b>Técnico:</b></label>
                                
                                <div style="width: 100px;"><?php echo isset($retUsuario[0]->nome)?$retUsuario[0]->nome:""; ?></div>
                            </div>

                            <div class="clear"></div>
                            <hr />

                        <?php
                        }
                    // }
                    $count++;
                }




                    $retFinaliza    =   Doctrine_Query::create()->select()->from('FinalizarOrdemServico fo')
                        ->leftJoin('fo.OrdemServico o')->where("o.id=".$_GET['id'])->orderBy('id desc limit 1')->execute();


                    $retFinaliza = $retFinaliza->toArray();

                    ?>
                    <div class="clear"></div>

                    <div class="form_row" style='width: 98%; background: #f1e990; padding: 10px 10px 15px;'>
                        <label><b>OBSERVAÇÃO TÉCNICA:</b></label>
                        <div style="width: 300px;"><textarea class="textarea" style="width: 700px;" rows="4" ><?php if(isset($retFinaliza[0]['descricao'])) echo strtoupper($retFinaliza[0]['descricao']) ?></textarea></imput></div>
                    </div>

                    <div class="clear"></div>
                <?php

                }



                if($res->tipo_ordem == 1){

                    ?>
                    <h4>DADOS DOS EQUIPAMENTOS</h4>
                    <hr />
                    <?php

                    // $res->status					= 1;
                    $res->save();

                    $where = "id_ordem_servico = ".$res->id;
                    $retToner		= 	Doctrine_Query::create()->select()->from('OrdemServToner')->where($where)->execute();


                    $retToner = $retToner->toArray();

                    foreach ($retToner as $value){

                        $equipamento_form = $value['equipamento']!='undefined'?$value['equipamento']:"&nbsp;";
                        $localizacao_form = $value['localizacao']!=''?$value['localizacao']:"&nbsp;";
                        $serie_form = $value['serial']!=''?$value['serial']:"&nbsp;";
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
                            <div style="width: 450px;"><?php echo $localizacao_form; ?></div>
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

                        ?>
                        <h4>DADOS DOS EQUIPAMENTOS</h4>
                        <hr />
                        <?php

                        // $res->status					= 1;
                        $res->save();

                        $where = "id_ordem_servico = ".$res->id;

                        $retNumerador		= 	Doctrine_Query::create()->select()->from('OrdemServNumerador')->where($where)->execute();


                        $retNumerador = $retNumerador->toArray();

                        foreach ($retNumerador as $value){

                            $equipamento_form = $value['equipamento'];
                            $localizacao_form = isset($value['localizacao'])&&$value['localizacao']!=''?$value['localizacao']:"&nbsp;";
                            $serie_form = $value['serial'];
                            $numerador = $value['numerador'];

                            $where2 = "serial = '".$value['serial']."'";
                            $retProcedimento       =   Doctrine_Query::create()->select()->from('Equipamento e')->leftJoin('e.EquipamentoModelo')->where($where2)->execute();
                            
                            $procedimento = isset($retProcedimento[0]->EquipamentoModelo->procedimento)&&$retProcedimento[0]->EquipamentoModelo->procedimento!=''?$retProcedimento[0]->EquipamentoModelo->procedimento:"&nbsp;";

                            ?>

                            <div class="form_row">
                                <label><b>Equipamento:</b></label>
                                <div style="width: 150px;"><?php echo $equipamento_form; ?></div>
                            </div>

                            <div class="form_row">
                                <label><b>Localização:</b></label>
                                <div style="width: 450px;"><?php echo $localizacao_form; ?></div>
                            </div>

                            <div class="form_row">
                                <label><b>Nº de Serie:</b></label>
                                <div style="width: 150px;"><?php echo $serie_form; ?></div>
                            </div>

                            <div class="form_row">
                                <label><b>Numerador:</b></label>
                                <div style="width: 150px;"><?php echo $numerador; ?></div>
                            </div>


                            <div class="form_row">
                                <label><b>Procedimento:</b></label>
                                <div style="width: 150px;"><?php echo nl2br($procedimento); ?></div>
                            </div>

                            <div class="clear"></div>
                            <hr />

                        <?php


                        }
                    }





                if($res->tipo_ordem == 3){

                    ?>
                    <h4>DADOS DOS EQUIPAMENTOS</h4>
                    <hr />
                    <?php

                    // $res->status					= 1;
                    // $res->save();

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
                            <div style="width: 450px;"><?php echo $localizacao_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Nº de Serie:</b></label>
                            <div style="width: 150px;"><?php echo $serie_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Cart R.:</b></label>
                            <div style="width: 80px;"><?php echo $cart_reserva_from; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Numerador:</b></label>
                            <div style="width: 150px;"></div>
                        </div>

                        <div class="clear"></div>
                        <hr />

                    <?php


                    }
                    ?>

                    <!-- <h4>Últimos Atendimentos</h4> -->
                    <?php

                    $where = "o.id <> ".$res->id." and id_cliente = ".$res->Cliente->id;

                    $retFinaliza    =   Doctrine_Query::create()->select()->from('FinalizarOrdemServico fo')->leftJoin('fo.OrdemServico o')->where($where)->orderBy('id desc limit 3')->execute();


                    $retFinaliza = $retFinaliza->toArray();

                    $count = 0;


                foreach ($retFinaliza as $value){

                    // if($value['OrdemServico']['tipo_ordem'] == 0 ){
                        if($count < 3){

                            $tipo = $value['OrdemServico']['tipo_ordem'];
                            $tipo = $tipo==0?'Manutenção no Equipamento':$tipo;
                            $tipo = $tipo==1?'Troca de Cilindro/Toner':$tipo;
                            $tipo = $tipo==2?'Leitura de Numerador':$tipo;                  
                            $tipo = $tipo==3?'Instalação de Equipamento':$tipo;
                            $tipo = $tipo==4?'Troca de Equipamento':$tipo;
                            $tipo = $tipo==5?'Retirada de Equipamento':$tipo;
                            $tipo = $tipo==6?'Manutenção Preventiva':$tipo;
                            $tipo = $tipo==7?'Serviços de Informática':$tipo;
                            $tipo = $tipo==8?'Acesso Remoto':$tipo;

                            ?>
                            <!-- <hr />
                            <div class="form_row">
                                <label><b>Descrição:</b></label>
                                <div style="width: 300px; text-transform: uppercase"><?php echo strtoupper($value['descricao']); ?></div>
                            </div>

                            <div class="form_row">
                                <label style="width: 200px;"><b>Tipo de Ordem de Serviço:</b></label>
                                <div style="width: 200px;"><?php echo $tipo; ?></div>
                            </div>

                            <div class="form_row">
                                <label><b>Data Finalizado:</b></label>
                                <div style="width: 150px;"><?php echo date("d/m/Y H:i:s", strtotime($value['data_final'])); ?></div>
                            </div>


                            <div class="clear"></div>
                            <hr /> -->

                        <?php
                        }
                    // }
                    $count++;
                }



                    $retFinaliza    =   Doctrine_Query::create()->select()->from('FinalizarOrdemServico fo')
                        ->leftJoin('fo.OrdemServico o')->where("o.id=".$_GET['id'])->orderBy('id desc limit 1')->execute();


                    $retFinaliza = $retFinaliza->toArray();

                    ?>
                    <div class="clear"></div>

                    <div class="form_row" style='width: 98%; background: #f1e990; padding: 10px 10px 15px;'>
                        <label><b>OBSERVAÇÃO TÉCNICA:</b></label>
                        <div style="width: 300px;"><textarea class="textarea" style="width: 700px;" rows="4" ><?php if(isset($retFinaliza[0]['descricao'])) echo strtoupper($retFinaliza[0]['descricao']) ?></textarea></imput></div>
                    </div>

                    <div class="clear"></div>
                    <?php 
                }

                if($res->tipo_ordem == 4){

                    ?>
                    <h4>DADOS DOS EQUIPAMENTOS</h4>
                    <hr />
                    <?php

                    $res->status					= 1;
                    $res->save();

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
                            <div style="width: 450px;"><?php echo $localizacao_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Nº de Serie:</b></label>
                            <div style="width: 150px;"><?php echo $serie_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Cart R.:</b></label>
                            <div style="width: 80px;"><?php echo $cart_reserva_from; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Numerador:</b></label>
                            <div style="width: 150px;"></div>
                        </div>

                        <div class="clear"></div>
                        <hr />

                    <?php


                    }
                    ?>
                    <div class="clear"></div>

                    <div class="form_row" style='width: 98%; background: #f1e990; padding: 10px 10px 15px;'>
                        <label><b>OBSERVAÇÃO TÉCNICA:</b></label>
                        <div style="width: 300px;"><textarea class="textarea" style="width: 700px;" rows="4" ></textarea></imput></div>
                    </div>

                    <div class="clear"></div>
                <?php
                }

                if($res->tipo_ordem == 5){

                    ?>
                    <h4>DADOS DOS EQUIPAMENTOS</h4>
                    <hr />
                    <?php

                    // $res->status					= 1;
                    // $res->save();

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
                            <div style="width: 450px;"><?php echo $localizacao_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Nº de Serie:</b></label>
                            <div style="width: 150px;"><?php echo $serie_form; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Cart R.:</b></label>
                            <div style="width: 80px;"><?php echo $cart_reserva_from; ?></div>
                        </div>

                        <div class="form_row">
                            <label><b>Numerador:</b></label>
                            <div style="width: 150px;"></div>
                        </div>

                        <div class="clear"></div>
                        <hr />

                    <?php


                    }
                    ?>

                    <!-- <h4>Últimos Atendimentos</h4> -->
                    <?php

                    $where = "o.id <> ".$res->id." and id_cliente = ".$res->Cliente->id;

                    $retFinaliza    =   Doctrine_Query::create()->select()->from('FinalizarOrdemServico fo')->leftJoin('fo.OrdemServico o')->where($where)->orderBy('id desc limit 3')->execute();


                    $retFinaliza = $retFinaliza->toArray();

                    $count = 0;


                foreach ($retFinaliza as $value){

                    // if($value['OrdemServico']['tipo_ordem'] == 0 ){
                        if($count < 3){

                            $tipo = $value['OrdemServico']['tipo_ordem'];
                            $tipo = $tipo==0?'Manutenção no Equipamento':$tipo;
                            $tipo = $tipo==1?'Troca de Cilindro/Toner':$tipo;
                            $tipo = $tipo==2?'Leitura de Numerador':$tipo;                  
                            $tipo = $tipo==3?'Instalação de Equipamento':$tipo;
                            $tipo = $tipo==4?'Troca de Equipamento':$tipo;
                            $tipo = $tipo==5?'Retirada de Equipamento':$tipo;
                            $tipo = $tipo==6?'Manutenção Preventiva':$tipo;
                            $tipo = $tipo==7?'Serviços de Informática':$tipo;
                            $tipo = $tipo==8?'Acesso Remoto':$tipo;

                            ?>
                            <!-- <hr />
                            <div class="form_row">
                                <label><b>Descrição:</b></label>
                                <div style="width: 300px; text-transform: uppercase"><?php echo strtoupper($value['descricao']); ?></div>
                            </div>

                            <div class="form_row">
                                <label style="width: 200px;"><b>Tipo de Ordem de Serviço:</b></label>
                                <div style="width: 200px;"><?php echo $tipo; ?></div>
                            </div>

                            <div class="form_row">
                                <label><b>Data Finalizado:</b></label>
                                <div style="width: 150px;"><?php echo date("d/m/Y H:i:s", strtotime($value['data_final'])); ?></div>
                            </div>


                            <div class="clear"></div>
                            <hr /> -->

                        <?php
                        }
                    // }
                    $count++;
                }



                    $retFinaliza    =   Doctrine_Query::create()->select()->from('FinalizarOrdemServico fo')
                        ->leftJoin('fo.OrdemServico o')->where("o.id=".$_GET['id'])->orderBy('id desc limit 1')->execute();


                    $retFinaliza = $retFinaliza->toArray();

                    ?>
                    <div class="clear"></div>

                    <div class="form_row" style='width: 98%; background: #f1e990; padding: 10px 10px 15px;'>
                        <label><b>OBSERVAÇÃO TÉCNICA:</b></label>
                        <div style="width: 300px;"><textarea class="textarea" style="width: 700px;" rows="4" ><?php if(isset($retFinaliza[0]['descricao'])) echo strtoupper($retFinaliza[0]['descricao']) ?></textarea></imput></div>
                    </div>


                    <div class="clear"></div>
                <?php
                }
                if($res->tipo_ordem == 6){

                    $retFinaliza    =   Doctrine_Query::create()->select()->from('FinalizarOrdemServico fo')
                        ->leftJoin('fo.OrdemServico o')->where("o.id=".$_GET['id'])->orderBy('id desc limit 1')->execute();
                    $id_finalizar = $retFinaliza[0]->id;

                    $retFinaliza = $retFinaliza->toArray();

                    ?>
                    <div class="clear"></div>

                    <div class="form_row obstec" style='width: 98%; background: #f1e990; padding: 10px 10px 15px;'>
                        <label><b>OBSERVAÇÃO TÉCNICA:</b></label>
                        <div style="width: 300px;"><textarea class="textarea" style="width: 700px;" rows="4" ><?php if(isset($retFinaliza[0]['descricao'])) echo strtoupper($retFinaliza[0]['descricao']) ?></textarea></imput></div>
                    </div>

                    <div class="clear"></div>
                    <?php 
                    
                    ?>
                    <h4>DADOS DOS EQUIPAMENTOS</h4>
                    <hr />
                    <?php

                    // $res->status					= 1;
                    // $res->save();



                    $where = "id_ordem_servico = ".$res->id;

                    $retNumerador		= 	Doctrine_Query::create()->select()->from('OrdemServPreventiva')->where($where)->execute();


                    $retNumerador = $retNumerador->toArray();

                    foreach ($retNumerador as $value){

                        $equipamento_form = $value['equipamento'];
                        $localizacao_form = $value['localizacao'];
                        $serie_form = $value['serial'];

                        ?>
                        <div class='printval'>
                            <div class="form_row">
                                <label><b>Equipamento:</b></label>
                                <div style="width: 150px;"><?php echo $equipamento_form; ?></div>
                            </div>

                            <div class="form_row">
                                <label><b>Localização:</b></label>
                                <div style="width: 430px;"><?php echo $localizacao_form; ?></div>
                            </div>

                            <div class="form_row">
                                <label><b>Nº de Serie:</b></label>
                                <div style="width: 150px;"><?php echo $serie_form; ?></div>
                            </div>

                            <div class="form_row">
                                <label><b>Numerador:</b></label>
                                <div style="width: 250px;">&nbsp;</div>
                            </div>

                            <div class="form_row">
                                <label><b>Verificado:</b></label>
                                <label>SIM</label> <input type="checkbox"  />
                            </div>
                            <div class="form_row">
                                <label>NÃO</label>  <input type="checkbox"  />
                            </div>
                            <div class="clear"></div>

                            <?php 

                                $whereEq = "serial = '".$serie_form."'";
                                $retEq =   Doctrine_Query::create()->select()->from('Equipamento')
                                    ->where($whereEq)->limit(1)->execute();

                                $whereEq = "f.id_ordem_servico < '".$res->id."' and equipamento_id = ".$retEq[0]->id;
                                $retFinalizarEquipamento =   Doctrine_Query::create()->select()->from('FinalizarEquipamento fe')->leftJoin("fe.FinalizarOrdemServico f")
                                    ->where($whereEq)->orderBy('id DESC')->execute();
                            ?>


                          <!--   <div class="form_row">
                                <label><b>Descrição:</b></label>
                                <div style="width: 250px;"><?php echo isset($retFinalizarEquipamento[0]->descricao)?strtoupper($retFinalizarEquipamento[0]->descricao):''; ?></div>
                            </div> -->

                        </div>


                        <div class="clear"></div>
                        <hr />
                      <?php
                   }

                }

                if($res->tipo_ordem == 7){
                    ?>
                    <div class="clear"></div>

                    <div class="form_row" style='width: 98%; background: #f1e990; padding: 10px 10px 15px;'>
                        <label><b>OBSERVAÇÃO TÉCNICA:</b></label>
                        <div style="width: 300px;"><textarea class="textarea" style="width: 800px;" rows="8" ></textarea></imput></div>
                    </div>

                    <div class="clear"></div>
                    <h4>Últimos Atendimentos</h4>
                    <?php

                    $where = "id_cliente = ".$res->Cliente->id;

                    $retFinaliza	= 	Doctrine_Query::create()->select()->from('FinalizarOrdemServico fo')->leftJoin('fo.OrdemServico o')->where($where)->orderBy('id desc limit 3')->execute();

                    $retFinaliza = $retFinaliza->toArray();
                    $count = 0;

                if($count < 3){
                    foreach ($retFinaliza as $value){

                        if($value['OrdemServico']['tipo_ordem'] == 7 ){

                            $where_usuario = "id = ".$value['audit'];
                            $retUsuario   =   Doctrine_Query::create()->select()->from('Usuario')->where($where_usuario)->execute();

                            $tipo = 'Serviços de Informática';

                            ?>
                            <hr />
                            <div class="form_row">
                                <label><b>Descrição:</b></label>
                                <div style="width: 300px;"><?php echo strtoupper($value['descricao']); ?></div>
                            </div>

                            <div class="form_row">
                                <label style="width: 200px;"><b>Tipo de Ordem de Serviço:</b></label>
                                <div style="width: 200px;"><?php echo $tipo; ?></div>
                            </div>

                            <div class="form_row">
                                <label><b>Data Finalizado:</b></label>
                                <div style="width: 150px;"><?php echo $value['data_final']; ?></div>
                            </div>


                            <div class="form_row">
                                <label><b>Técnico:</b></label>
                                <div style="width: 150px;"><?php echo $retUsuario->nome; ?></div>
                            </div>


                            <div class="clear"></div>
                            <hr />

                        <?php


                        }
                    }
                    $count++;

                }
                
                }


                if($res->tipo_ordem == 8){

                    ?>
                    <h4>DADOS DOS EQUIPAMENTOS</h4>
                    <hr />
                    <?php

                    $where = "id_ordem_servico = ".$res->id;

                    $retManutencao      =   Doctrine_Query::create()->select()->from('OrdemServAcessoremoto')->where($where)->execute();

                $retManutencao = $retManutencao->toArray();

                foreach ($retManutencao as $value){

                         $equipamento_form = $value['equipamento'];
                         $localizacao_form = $value['localizacao'];
                         $serie_form = $value['serial'];
                         $defeito_id = $value['defeito'];
                         $numerador = $value['numerador'];

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
                        <div style="width: 350px;"><?php if(isset($resDefeito->nome)) echo $resDefeito->nome; else echo "&nbsp;" ?></div>
                    </div>
                    <div class="form_row">
                        <label><b>Numerador:</b></label>
                        <div style="width: 150px;"><?php echo $numerador ?></div>
                    </div>




                    <div class="clear"></div>
                    <hr />
                    <?php
                }
                
                ?>
                    <h4>Últimos Atendimentos</h4>
                    <?php

                    $where = "o.id <> ".$res->id." and id_cliente = ".$res->Cliente->id;



                    $whereEq = "serial = '".$serie_form."'";
                    $retEq =   Doctrine_Query::create()->select()->from('Equipamento')
                        ->where($whereEq)->limit(1)->execute();

                    $whereEq = "fo.id_ordem_servico < '".$res->id."' and equipamento_id = ".$retEq[0]->id;
                    $retFinalizarEquipamento =   Doctrine_Query::create()->select()->from('FinalizarEquipamento fe')
                            ->leftJoin("fe.FinalizarOrdemServico fo")->leftJoin('fo.OrdemServico o')
                            ->where($whereEq)->orderBy('id DESC')->limit(3)->execute();

                    // $retFinaliza    =   Doctrine_Query::create()->select()->from('FinalizarOrdemServico fo')->leftJoin('fo.OrdemServico o')->where($where)->orderBy('id desc limit 3')->execute();


                    // $retFinaliza = $retFinaliza->toArray();

                    $count = 0;


                    foreach ($retFinalizarEquipamento as $value){

                        // if($value['OrdemServico']['tipo_ordem'] == 0 ){
                            if(isset( $value->FinalizarOrdemServico->OrdemServico->tipo_ordem)){

                                $tipo = $value->FinalizarOrdemServico->OrdemServico->tipo_ordem;
                                $tipo = $tipo==0?'Manutenção no Equipamento':$tipo;
                                $tipo = $tipo==1?'Troca de Cilindro/Toner':$tipo;
                                $tipo = $tipo==2?'Leitura de Numerador':$tipo;                  
                                $tipo = $tipo==3?'Instalação de Equipamento':$tipo;
                                $tipo = $tipo==4?'Troca de Equipamento':$tipo;
                                $tipo = $tipo==5?'Retirada de Equipamento':$tipo;
                                $tipo = $tipo==6?'Manutenção Preventiva':$tipo;
                                $tipo = $tipo==7?'Serviços de Informática':$tipo;
                                $tipo = $tipo==8?'Acesso Remoto':$tipo;


                                $where_usuario = "id = ".$value['audit'];
                                $retUsuario   =   Doctrine_Query::create()->select()->from('Usuario')->where($where_usuario)->execute();


                                ?>
                                <hr />
                                <div class="form_row">
                                    <label><b>Descrição:</b></label>
                                    <div style="width: 300px; text-transform: uppercase"><?php echo strtoupper($value->descricao); ?></div>
                                </div>

                                <div class="form_row">
                                    <label style="width: 200px;"><b>Tipo de Ordem de Serviço:</b></label>
                                    <div style="width: 200px;"><?php echo $tipo; ?></div>
                                </div>

                                <div class="form_row">
                                    <label><b>Data Finalizado:</b></label>
                                    <div style="width: 150px;"><?php echo date("d/m/Y H:i:s", strtotime($value->FinalizarOrdemServico->data_final)); ?></div>
                                </div>

                                <div class="form_row">
                                    <label><b>Técnico:</b></label>
                                    <div style="width: 150px;"><?php echo $retUsuario->nome; ?></div>
                                </div>

                                <div class="clear"></div>
                                <hr />

                            <?php
                            }
                        // }
                        $count++;
                    }




                    $retFinaliza    =   Doctrine_Query::create()->select()->from('FinalizarOrdemServico fo')
                        ->leftJoin('fo.OrdemServico o')->where("o.id=".$_GET['id'])->orderBy('id desc limit 1')->execute();


                    $retFinaliza = $retFinaliza->toArray();

                    ?>
                    <div class="clear"></div>

                    <div class="form_row" style='width: 98%; background: #f1e990; padding: 10px 10px 15px;'>
                        <label><b>OBSERVAÇÃO TÉCNICA:</b></label>
                        <div style="width: 300px;"><textarea class="textarea" style="width: 700px;" rows="4" ><?php if(isset($retFinaliza[0]['descricao'])) echo strtoupper($retFinaliza[0]['descricao']) ?></textarea></imput></div>
                    </div>

                    <div class="clear"></div>
                <?php

                }





                    ?>
                    <div class="clear"></div>


                <hr />

                <div class="clear"></div><br />


                    <div class="form_row" style="width: 200px">
                        <label><b>ASSINATURAS:</b></label>
                    </div>

                    <div class="form_row">
                        <label><b>Cliente:</b> ________________________________</label>
                        <div style="width: 300px;"></div>
                    </div>
                    <div class="form_row">
                        <label><b id='title-tecnico'>Técnico:</b></label>
                    </div>
                    <div class="form_row">
                        <input type="hidden" name="ordem_id" id='ordem_id' value="<?php echo $_GET['id'] ?>">
                        <select class="campo" id='usuario_id' id='usuario_id'>
                            <option value=""></option>
                            <?php
                                $where = "id <> 1";
                                // $where = "id <> '".$_SESSION['sess_usuario_id']."'";
                                $retUsuario = Doctrine_Query::create()->select()->from('Usuario u')->where($where)->execute();

                                foreach ($retUsuario as $objUsuario) {
                                    $selected = isset($res->tecnico)&&$res->tecnico!=''&&$res->tecnico==$objUsuario->id?"selected":"";
                                    ?><option value="<?php echo $objUsuario->id; ?>" <?php echo $selected ?>><?php echo $objUsuario->nome; ?></option><?php
                                }

                            ?>
                        </select>
                    </div>
			
				<div class="clear"></div><br />


                    <div class="form_row" style="margin-right: 200px;margin-left: 200px ">
                        <div style="width: 100px;"></div>
                    </div>

                    <div class="form_row" style="position: relative;">
                        <div id='ass-tecnico' style='width: 100px; position: absolute; top: -30px; left: 57px;'>_________________________________</div>
                    </div>

                <div class="clear"></div><br />
            <div class="form_row">
                <label><b>Data Atendimento:</b> _____/_____/______</label>
            </div>

                <h4>ATENÇÃO:</h4>
                <hr />


                <div class="form_row">

                    <!-- <b> É OBRIGATÓRIO O TÉCNICO ENTREGAR UMA CÓPIA DESTA ORDEM DE SERVIÇO PARA O CLIENTE.</b> -->
                    <b> Declaro que estou de acordo com os serviços executados no equipamento e descritos nesta Ordem de Serviço.</b>
                </div>


                <div class="clear"></div><br />



                <div class="form_row"><input type="button" class="submit" id="print" value="Imprimir"  /></div>

			</form>
            <script type="text/javascript">
                    var texto = $('.textarea').val();
                    var linhas = texto.replace(/<BR>/g,'\n');
                    $('.textarea').val(linhas);
            </script>
			<?php 
			
			} catch (Exception $e){
				echo 'Ocorreu um erro!'.$e;
			}
			
			unset($res);
			
			?>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->