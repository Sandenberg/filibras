<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ini_set('memory_limit', -1) ?>
<?php $_SESSION['OrdemServico']['sSearch_4'] = isset($_SESSION['OrdemServico']['sSearch_4'])?$_SESSION['OrdemServico']['sSearch_4']:""; ?>
<div id="body">
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Ordem de Serviço</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">

			<style type="text/css">
                #formPerfil  td {
                    /* height: 40px; */
                    border-bottom: 1px #ccc solid;
                    padding: 10px;
                    vertical-align: middle;
                }
                #formPerfil  tr:nth-child(2n+3) {
                    background: #eee;
                }
                #formPerfil  th {
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
                <div><img src=<?php echo URL_ADMIN_IMAGES?>logomarca_filibras_pequena.png></div>
            </div>
            <div class="form_row" style="width: 50px;">
            </div>
            <div class="form_row">
                <h2 style="margin: 0px 0px; float: left; margin-top: -30px; width: 810px;">
                	<?php 
                		$titulo = "";
                		if(isset($_GET['usuario'])&&$_GET['usuario']!=''){
                			$objUsuario = Doctrine_Core::getTable('Usuario')->find($_GET['usuario']);
                			$titulo .= $objUsuario->nome;
                		}
                		if(isset($_GET['cliente_id'])&&$_GET['cliente_id']!=''){
                			$objCliente = Doctrine_Core::getTable('Cliente')->find($_GET['cliente_id']);
                			$titulo .= $titulo!=''?" - ".$objCliente->nome_completo:$objCliente->nome_completo;
                		}
						if(isset($_GET['data_periodo_I'])&&$_GET['data_periodo_I']!=''&&isset($_GET['data_periodo_F'])&&$_GET['data_periodo_F']!=''){
                			$titulo .= " - ".$_GET['data_periodo_I']." até ".$_GET['data_periodo_F'];
                		}
                		echo $titulo;
                	?>
                </h2>
            </div>
            <h4></h4>
            <hr />
            <div class="clear"></div>
            <?php 
            	if(!isset($_GET['usuario'])&&$_SESSION['sess_usuario_grupo_id']==1&&!isset($_GET['filtro'])){
            		?>
						<form class="form" method="GET" id="form">
            				<input type="hidden" name="filtro" value="1">
							<div class="form_row">
								<label>Cliente:</label>
								<select name="cliente_id" id="cliente_id" class="select" style="width: 615px;">
									<option value="">Selecione</option>
									<?php 
									try {
										$resCliente = Doctrine_Query::create()->select()->from('Cliente')->orderBy('nome_completo ASC')->execute();
										
										if ($resCliente->count() > 0){
											$resCliente->toArray();
											
											foreach ($resCliente as $value){
			                                                                    $resFilial = Doctrine_Core::getTable('Filial')->find($value['filial_id']);
			                                                                    $filial = "";
			                                                                    if($resFilial->nome != "Sem Filial")
			                                                                    	$filial = "- ".$resFilial->nome;

			                                                                    $id = $value['id'];
			                                                                    $nome = $value['nome_completo'];
			                                                                    $restricao = $value['restricao']==1?"style='color:#a00'":"";

												echo "<option value='$id' restricao='".$value['restricao']."' ".$restricao.">$nome $filial</option>";
											}
											
										} else {
											echo '<option value="">Ocorreu um erro de sistema</option>';
										}
									
									} catch (Exception $e){
										echo '<option value="">Ocorreu um erro de sistema</option>';
									}
									
									?>
								</select>
							</div>
				

							<div class="form_row">
								<label>Ordem de serviço:</label>
								<select name="ordem" id="ordem" class="select" style="width: 230px;">
			                        <option value="">Todos</option>
			                        <option value="0">Manutenção no Equipamento</option>
			                        <option value="1">Troca de Cilindro/Toner</option>
			                        <option value="2">Leitura de Numerador</option>
			                        <option value="3">Instalação de Equipamento</option>
			                        <option value="5">Retirada de Equipamento</option>
			                        <option value="6">Manutenção Preventiva</option>
			                        <option value="7">Serviços de Informática</option>
			                        <option value="8">Acesso Remoto</option>
								</select>
							</div>
							<div class="clear"></div>
							
							<div class="form_row">
								<label>Usuario:</label>
								<select name="usuario" id="usuario" class="select" style="width: 230px;">
									<option value="">Todos</option>
									<?php 
									
									try {
									
										$resStatus = Doctrine_Query::create()->select()->from('Usuario')->where('id <> 1 and status = 1 and id <> 9')->orderBy('nome ASC')->execute();
										
										if ($resStatus->count() > 0){
											$resStatus->toArray();
											
											foreach ($resStatus as $value){
												echo '<option value="'.$value['id'].'">'.$value['nome'].'</option>';
											}
											
										} else {
											echo '<option value="">Nenhum registro encontrado.</option>';
										}
									
									} catch (Exception $e){
										echo '<option value="">Ocorreu um erro de sistema</option>';
									}
									
									
									?>
								</select>
							</div>
			                
			                <div class="form_row">
			                    <label>Data do Periodo:</label>
			                    <input type="text" name="data_periodo_I" id="data_periodo_I" class="input data validate[custom[dateBR]]" style="width: 70px;" /> a
			                    <input type="text" name="data_periodo_F" id="data_periodo_F" class="input data validate[custom[dateBR]]" style="width: 70px;" />
			                </div>

			                
			                <div class="form_row">
			                    <label><input type="checkbox" name="resumo" id="resumo" value=1 class="input" /> Resumo Mensal</label>
			                </div>

							<div class="clear"></div><br />
							
							<div class="form_row"><input type="submit" class="submit" value="Gerar o relatório" /></div>
            			</form>
            		<?php
            	}else{
            		if(isset($_GET['resumo'])&&$_GET['resumo']!=''){
            			?>
						<table id='formPerfil'><!-- Table Wrapper Begin -->
							<thead>
								<tr>
									<th width="100"><label><b>Mês</b></label></th>
									<th width="100"><label><b>Total</b></label></th>
									<th width="200"><label><b>Tipo da Ordem</b></label></th>
								</tr>
							</thead>
							<?php 
								$meses = array(
								    1 => 'Janeiro',
								    'Fevereiro',
								    'Março',
								    'Abril',
								    'Maio',
								    'Junho',
								    'Julho',
								    'Agosto',
								    'Setembro',
								    'Outubro',
								    'Novembro',
								    'Dezembro'
								);
								$data_inicio = Util::dateConvert($_GET['data_periodo_I']);
								$data_final = Util::dateConvert($_GET['data_periodo_F']);

								$start    = (new DateTime($data_inicio))->modify('first day of this month');
								$end      = (new DateTime($data_final))->modify('first day of next month');
								$interval = DateInterval::createFromDateString('1 month');
								$period   = new DatePeriod($start, $interval, $end);
								$x = 0;
								foreach ($period as $dt) {

									$where = "o.status = 1";

									// if(isset($_GET['data_periodo_I'])&&$_GET['data_periodo_I']!=''&&isset($_GET['data_periodo_F'])&&$_GET['data_periodo_F']!=''){
									// 	$where .= " and fos.data_final between '".Util::dateConvert($_GET['data_periodo_I'])." 00:00:00' and '".Util::dateConvert($_GET['data_periodo_F'])." 00:00:00'";
									// }else{
									// 	$where .= " and fos.data_final between '".date('Y-m-01 00:00:00')."' and '".date('Y-m-t 23:59:59')."'";
									// }

									$where .= isset($_GET['ordem'])&&$_GET['ordem']!=''?" and tipo_ordem = '".$_GET['ordem']."'":"";
									$where .= isset($_GET['cliente_id'])&&$_GET['cliente_id']!=''?" and cliente_id = '".$_GET['cliente_id']."'":"";

									$where .= isset($_GET['usuario'])&&$_GET['usuario']!=''?" and audit = '".$_GET['usuario']."'":"";

									$retAll		= 	Doctrine_Query::create()->select('count() as total, tipo_ordem')->from('OrdemServico o')->leftJoin('o.FinalizarOrdemServico fos')->innerJoin('o.Cliente c')->leftJoin('fos.Usuario u')
													->where($where)
													->addWhere('DATE_FORMAT(fos.data_final, "%m%Y") = ?', $dt->format("mY"))
													->groupBy('o.id');

									if($retAll->count()>0){

							            if($_GET['ordem']==''){
											$value['ordem'] = 'Todos';
							            }elseif($_GET['ordem']==0){
											$value['ordem'] = 'Manutenção no Equipamento';
										}elseif ($_GET['ordem']==1){
											$value['ordem'] = 'Troca Cilindro/Toner';
										}elseif ($_GET['ordem']==2){
											$value['ordem'] = 'Leitura de Numerador';
										}elseif ( $_GET['ordem']==3){
											$value['ordem'] ='Instalação de Equipamento';
										}elseif ( $_GET['ordem']==4){
							                $value['ordem'] ='Troca de Equipamento';
							            }elseif ( $_GET['ordem']==5){
							                $value['ordem'] ='Retirada de Equipamento';
							            }elseif ( $_GET['ordem']==6){
							                $value['ordem'] ='Preventiva';
							            }elseif ( $_GET['ordem']==7){
							                $value['ordem'] ='Serviços de Informática';
							            }elseif ( $_GET['ordem']==8){
							                $value['ordem'] ='Acesso Remoto';
							            }elseif ( $_GET['ordem']==9){
							                $value['ordem'] ='Atendimento Avulso';
							            }
										?>
											<tr>
												<td><?php echo $meses[str_replace(0, "", $dt->format("m"))] ?></td>
												<td><?php echo $retAll->count() ?></td>
												<td><?php echo $value['ordem'] ?></td>
											</tr>
										<?php
									}
									$x+=$retAll->count();
								}

							?>
							<tr>
								<td colspan="4" align="right" style="text-align: right; font-weight: 600">Total de Registros: <?php echo $x ?></td>
							</tr>
						</table><!-- Table Wrapper End -->
						<br>
						<form class="form">
			            	<div class="form_row"><input type="button" class="submit" onclick="window.print();" id="print" value="Imprimir"  /></div>
			            	<div class="form_row"><input type="button" class="submit" onclick="history.go(-1);" id="print" value="Voltar"  /></div>
			            </form>
            			<?php
            		}else{
			            ?>
						<table id='formPerfil'><!-- Table Wrapper Begin -->
							<thead>
								<tr>
									<th width="100"><label><b>Numero</b></label></th>
									<th width="300"><label><b>Cliente</b></label></th>
									<th width="200"><label><b>Tipo</b></label></th>
									<th width="100"><label><b>Data</b></label></th>
								</tr>
							</thead>
							<?php 
								$x = 0;
								$where = "o.status = 1";

								if(isset($_GET['data_periodo_I'])&&$_GET['data_periodo_I']!=''&&isset($_GET['data_periodo_F'])&&$_GET['data_periodo_F']!=''){
									$where .= " and fos.data_final between '".Util::dateConvert($_GET['data_periodo_I'])." 00:00:00' and '".Util::dateConvert($_GET['data_periodo_F'])." 00:00:00'";
								}else{
									$where .= " and fos.data_final between '".date('Y-m-01 00:00:00')."' and '".date('Y-m-t 23:59:59')."'";
								}

								$where .= isset($_GET['ordem'])&&$_GET['ordem']!=''?" and tipo_ordem = '".$_GET['ordem']."'":"";
								$where .= isset($_GET['cliente_id'])&&$_GET['cliente_id']!=''?" and o.cliente_id = '".$_GET['cliente_id']."'":"";

								$where .= isset($_GET['usuario'])&&$_GET['usuario']!=''?" and audit = '".$_GET['usuario']."'":"";

								$retAll		= 	Doctrine_Query::create()->select()->from('OrdemServico o')->leftJoin('o.FinalizarOrdemServico fos')->innerJoin('o.Cliente c')->leftJoin('fos.Usuario u')
												->where($where)->groupBy('o.id')->execute();


								// Tratamento dos dados
								if ($retAll->count() > 0){
									// Transforma os dados em Array
									$resLimit = $retAll->toArray();
									
									foreach ($resLimit as $value){
										$usuario = "";

							            if($value['tipo_ordem']==0){
											$value['ordem'] = 'Manutenção no Equipamento';
										}elseif ($value['tipo_ordem']==1){
											$value['ordem'] = 'Troca Cilindro/Toner';
										}elseif ($value['tipo_ordem']==2){
											$value['ordem'] = 'Leitura de Numerador';
										}elseif ( $value['tipo_ordem']==3){
											$value['ordem'] ='Instalação de Equipamento';
										}elseif ( $value['tipo_ordem']==4){
							                $value['ordem'] ='Troca de Equipamento';
							            }elseif ( $value['tipo_ordem']==5){
							                $value['ordem'] ='Retirada de Equipamento';
							            }elseif ( $value['tipo_ordem']==6){
							                $value['ordem'] ='Preventiva';
							            }elseif ( $value['tipo_ordem']==7){
							                $value['ordem'] ='Serviços de Informática';
							            }elseif ( $value['tipo_ordem']==8){
							                $value['ordem'] ='Acesso Remoto';
							            }elseif ( $value['tipo_ordem']==9){
							                $value['ordem'] ='Atendimento Avulso';
							            }

							          try{
							              $where_finaliza = "id_ordem_servico = ".$value['id'];
							              $retFinaliza	= 	Doctrine_Query::create()->select()->from('FinalizarOrdemServico fo')->leftJoin('fo.OrdemServico o')->where($where_finaliza)->execute();

							              $retFinaliza = $retFinaliza->toArray();

							              if($value['tipo_ordem']== 0){
							                  foreach ($retFinaliza as $value_finaliza){

							                      $where_usuario = "id = ".$value_finaliza['audit'];
							                      $retUsuario	= 	Doctrine_Query::create()->select()->from('Usuario')->where($where_usuario)->execute();

							                      $retUsuario = $retUsuario->toArray();
							                      foreach ($retUsuario as $value_usuario){

							                          $usuario = ' - '.$value_usuario['apelido'];
							                      }
							                  }
							                }elseif($value['tipo_ordem']== 1){
							                  foreach ($retFinaliza as $value_finaliza){

							                      $where_usuario = "id = ".$value_finaliza['audit'];
							                      $retUsuario	= 	Doctrine_Query::create()->select()->from('Usuario')->where($where_usuario)->execute();

							                      $retUsuario = $retUsuario->toArray();
							                      foreach ($retUsuario as $value_usuario){

							                          $usuario = ' - '.$value_usuario['apelido'];
							                      }
							                  }
							                } elseif($value['tipo_ordem']== 2){
							                  foreach ($retFinaliza as $value_finaliza){

							                      $where_usuario = "id = ".$value_finaliza['audit'];
							                      $retUsuario	= 	Doctrine_Query::create()->select()->from('Usuario')->where($where_usuario)->execute();

							                      $retUsuario = $retUsuario->toArray();
							                      foreach ($retUsuario as $value_usuario){

							                          $usuario = ' - '.$value_usuario['apelido'];
							                      }
							                  }
							                } elseif($value['tipo_ordem']== 3){
							                  foreach ($retFinaliza as $value_finaliza){

							                      $where_usuario = "id = ".$value_finaliza['audit'];
							                      $retUsuario	= 	Doctrine_Query::create()->select()->from('Usuario')->where($where_usuario)->execute();

							                      $retUsuario = $retUsuario->toArray();
							                      foreach ($retUsuario as $value_usuario){

							                          $usuario = ' - '.$value_usuario['apelido'];
							                      }
							                  }
							                } elseif($value['tipo_ordem']== 5){
							                  foreach ($retFinaliza as $value_finaliza){

							                      $where_usuario = "id = ".$value_finaliza['audit'];
							                      $retUsuario	= 	Doctrine_Query::create()->select()->from('Usuario')->where($where_usuario)->execute();

							                      $retUsuario = $retUsuario->toArray();
							                      foreach ($retUsuario as $value_usuario){

							                          $usuario = ' - '.$value_usuario['apelido'];
							                      }
							                  }
							                } elseif($value['tipo_ordem']== 6){
							                  foreach ($retFinaliza as $value_finaliza){

							                      $where_usuario = "id = ".$value_finaliza['audit'];
							                      $retUsuario	= 	Doctrine_Query::create()->select()->from('Usuario')->where($where_usuario)->execute();

							                      $retUsuario = $retUsuario->toArray();
							                      foreach ($retUsuario as $value_usuario){

							                          $usuario = ' - '.$value_usuario['apelido'];
							                      }
							                  }
							                } elseif($value['tipo_ordem']== 7){
							                  foreach ($retFinaliza as $value_finaliza){

							                      $where_usuario = "id = ".$value_finaliza['audit'];
							                      $retUsuario	= 	Doctrine_Query::create()->select()->from('Usuario')->where($where_usuario)->execute();

							                      $retUsuario = $retUsuario->toArray();
							                      foreach ($retUsuario as $value_usuario){

							                          $usuario = '-'.$value_usuario['apelido'];
							                      }
							                  }


							              }else{

							                  $usuario = '';

							              }


							          }catch(Exception $e){

							             echo $e;

							              }


							            if($value['status']==0){
											$value['status'] = "<font color='#FF9900'>Em Andamento</font>";
										}elseif ($value['status']==1){
											$value['status'] = "<font color='green' >Finalizado </font><font color='#8B4513' >$usuario</font>";
										}elseif ($value['status']==2){
											$value['status'] = "<font color='red' >Cancelado</font>";
										}

										$date = $value['data_atendimento'];
										$value['data_atendimento'] = date("d-m-Y", strtotime($date));
										
										
										?>
											<tr>
												<td><?php echo $value['id'] ?></td>
												<td><?php echo $value['Cliente']['nome_completo'] ?></td>
												<td><?php echo $value['ordem'] ?></td>
												<td><?php echo date("d/m/Y H:i:s", strtotime($value['FinalizarOrdemServico'][0]['data_final'])); ?></td>
											</tr>
										<?php
										$x++;
									}
									
								}
							?>
							<tr>
								<td colspan="4" align="right" style="text-align: right; font-weight: 600">Total de Registros: <?php echo $x ?></td>
							</tr>
						</table><!-- Table Wrapper End -->
						<br>
						<form class="form">
			            	<div class="form_row"><input type="button" class="submit" onclick="window.print();" id="print" value="Imprimir"  /></div>
			            	<div class="form_row"><input type="button" class="submit" onclick="history.go(-1);" id="print" value="Voltar"  /></div>
			            </form>
				        <?php
				    }
			    }
		    ?>
		</div>

	</div><!-- Block End -->
</div><!-- Body Wrapper End -->
<script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.9/filtering/row-based/TableTools.ShowSelectedOnly.js"></script>
<input id='filtro' type='hidden' name="filtro" value="<?php echo $_SESSION['OrdemServico']['sSearch_4'] ?>">

<style type="text/css">
	.data-table th{
		color: #fff;
	}
</style>