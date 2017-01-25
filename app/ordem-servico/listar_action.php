<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Array de retorno
	$returnArray = array();
	
	// Campos
	$fields = explode(',', $_GET['sColumns']);
	
	// Parâmetro de ordenação
	$orderby = $fields[$_GET['iSortCol_0']].' '.strtoupper($_GET['sSortDir_0']);
	
	// Parâmetro de Busca
	$where = '';

	if ($_GET['sSearch'] != ''){
		foreach ($fields as $key=>$value){
			if ($_GET['bSearchable_'.$key] == 'true'){
				if (isset($_GET[$value]) && $_GET[$value] == 'date'){
					$where .= 	$where==''?'DATE_FORMAT('.$value.',"%d/%m/%Y") LIKE "%'.$_GET['sSearch'].'%"':
					' OR DATE_FORMAT('.$value.',"%d/%m/%Y") LIKE "%'.$_GET['sSearch'].'%"';
				} else {
					$where .= 	$where==''?$value." LIKE '%".$_GET['sSearch']."%'":
					" OR ".$value." LIKE '%".$_GET['sSearch']."%'";
				}
			}
	    }
		$search = str_replace(".", "", $_GET['sSearch']);
		$where .= ' or u.nome like "%'.$search.'%"';
	}
	$where = $where==''?'1 = 1':$where;

	if(isset($_GET['sSearch_2'])&&$_GET['sSearch_2']!=''){

		$tipo_ordem = "";

        if($_GET['sSearch_2'] == "Manutenção no Equipamento"){
			$tipo_ordem=0;
		}elseif ($_GET['sSearch_2'] == 'Troca Cilindro/Toner'){
			$tipo_ordem=1;
		}elseif ($_GET['sSearch_2'] == 'Leitura de Numerador'){
			$tipo_ordem=2;
		}elseif ( $_GET['sSearch_2'] =='Instalação de Equipamento'){
			$tipo_ordem=3;
		}elseif ( $_GET['sSearch_2'] =='Troca de Equipamento'){
            $tipo_ordem=4;
        }elseif ( $_GET['sSearch_2'] =='Retirada de Equipamento'){
            $tipo_ordem=5;
        }elseif ( $_GET['sSearch_2'] =='Preventiva'){
            $tipo_ordem=6;
        }elseif ( $_GET['sSearch_2'] =='Serviços de Informática'){
            $tipo_ordem=7;
        }elseif ( $_GET['sSearch_2'] =='Acesso remoto'){
            $tipo_ordem=8;
        }elseif ( $_GET['sSearch_2'] =='Atendimento Avulso'){
            $tipo_ordem=9;
        }

        if ($tipo_ordem!=''||$tipo_ordem==0) {
        	$where = "(".$where.") and tipo_ordem = ".$tipo_ordem;
        }

	}

	if(isset($_GET['sSearchx'])&&$_GET['sSearchx']!=''&&$_GET['sEcho']==1){
		$_GET['sSearch_4'] = $_GET['sSearch_4']==''?$_GET['sSearchx']:$_GET['sSearch_4'];
	}
	$s = $_GET['sSearch_4'];
	// if(isset($_GET['sSearch_4'])&&$_GET['sSearch_4']!='Todos'){
		$status = 'Todos';
		$status = $_GET['sSearch_4']=='Em Andamento'?'0':$status;
		$status = $_GET['sSearch_4']=='Finalizado'?'1':$status;
		$status = $_GET['sSearch_4']=='Cancelado'?'2':$status;
		if($_GET['sEcho']>1){
			$_SESSION['OrdemServico']['sSearch_4'] = $_GET['sSearch_4'];
		}

		if($status!='Todos')
			$where = 	'('.$where.') AND status = "'.$status.'"';

	// Buscas (Geral e Paginada)
	$retAll		= 	Doctrine_Query::create()->select()->from('OrdemServico o')->innerJoin('o.Cliente c')->leftJoin('o.FinalizarOrdemServico fos')->leftJoin('fos.Usuario u')
					->where($where)->groupBy('o.id');
	
	$retLimit	= 	Doctrine_Query::create()->select()->from('OrdemServico o')->innerJoin('o.Cliente c')->leftJoin('o.FinalizarOrdemServico fos')->leftJoin('fos.Usuario u')
					->where($where)->offset($_GET['iDisplayStart'])
					->limit($_GET['iDisplayLength'])->orderBy($orderby)->groupBy('o.id')->execute();
	
	// Tratamento dos dados
	if ($retLimit->count() > 0){
		// Transforma os dados em Array
		$resLimit = $retLimit->toArray();
		
		foreach ($resLimit as $value){
			$usuario = "";
			// Trata as permissões
			$objPermissao = new UsuarioPermissao();
			$retPermissao = $objPermissao->getPermissao($_GET['model'],array(2,3));
			
			// Seleção de permissões nível 2
			if ($retPermissao){

				$action = '<div class="actionbar">';
				foreach ($retPermissao as $resPermissao){					
					$tipo	= $resPermissao['tipo']==3?'action/':'';
					$acao	= $resPermissao['tipo']==3?'action3':'';

					if($resPermissao['action']=='finalizar'&&$value['status']==1){
						$action .= '<a href="javascript:alert(\'Esta ordem já se encontra finalizada\')" class="action '.$resPermissao['icone'].' '.$acao.'">';
						$action .= '<span>'.$resPermissao['titulo'].'</span></a>';
					}else if($value['tipo_ordem']!='2'&&$resPermissao['action']=="rota"){
						$action .= '<a href="'.URL_ADMIN.$tipo.$resPermissao['model'].'/'.$resPermissao['action'].'/'.$value['id'].'/" class="action '.$resPermissao['icone'].' '.$acao.'">';
						$action .= '<span>'.$resPermissao['titulo'].'</span></a>';
					}else if($resPermissao['action']!="rota"){
						$action .= '<a href="'.URL_ADMIN.$tipo.$resPermissao['model'].'/'.$resPermissao['action'].'/'.$value['id'].'/" class="action '.$resPermissao['icone'].' '.$acao.'">';
						$action .= '<span>'.$resPermissao['titulo'].'</span></a>';
					}
				}
				$action .= '</div>';
			}else {
				$action = '';
			}

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


              }elseif($value['tipo_ordem']== 9){
                  foreach ($retFinaliza as $value_finaliza){

                      $where_usuario = "id = ".$value_finaliza['audit'];
                      $retUsuario	= 	Doctrine_Query::create()->select()->from('Usuario')->where($where_usuario)->execute();

                      $retUsuario = $retUsuario->toArray();
                      foreach ($retUsuario as $value_usuario){

                          $usuario = ' - '.$value_usuario['apelido'];
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
			
			// Tratamento de dados
			$value['action'] =	'<div style="height: 3px;">&nbsp;</div>';
			$value['action'] .= $action;
			
			// Status
			//$value['documento'] = $value['tipo_pessoa']==0?Util::mask('###.###.###-##', $value['cpf']):Util::mask('##.###.###/####-##', $value['cnpj']);
			

			$value['rota'] = isset($value['rota'])&&$value['rota']!=''?$value['rota']:"-";
			if($value['rota']!='-'){
				$objUsuario = Doctrine_Core::getTable('Usuario')->find($value['rota_usuario_id']);

				$value['rota'] = "<b>".$objUsuario->apelido." / ".$value['rota_turno']." - ".$value['rota_ordem']."</b>";
			}
			
			
			// Retorno
			$returnArray[] = $value;
			
			
			
		}
		
	}
	
	$returnJson = array(
		'sEcho'					=> intval($_GET['sEcho']),
		'iTotalRecords'			=> $retAll->count(),
		'iTotalDisplayRecords'	=> $retAll->count(),
		'aaData'				=> $returnArray,
		'sSearch_4'				=> $_GET['sSearch_4'],
		'sessao'				=> $_SESSION['OrdemServico']['sSearch_4'],
		'where'					=> $where,
		's'						=> $_GET['sSearch_2']
	);
	
	echo json_encode($returnJson);

} catch(Exception $e){

	$returnJson = array(
		'sEcho'					=> intval($_GET['sEcho']),
		'iTotalRecords'			=> 0,
		'iTotalDisplayRecords'	=> 0,
		'aaData'				=> array(),
		'error'					=> $e->getMessage()
	);
	
	echo json_encode($returnJson);
	
}

?> 