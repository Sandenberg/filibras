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
					$where .= 	$where==''?$value.' LIKE "%'.$_GET['sSearch'].'%"':
					' OR '.$value.' LIKE "%'.$_GET['sSearch'].'%"';
				}
			}
	    }
	}
	$where = $where==''?'1 = 1':$where;

	
	// Buscas (Geral e Paginada)
	$retAll		= 	Doctrine_Query::create()->select()->from('OrdemServico o')->innerJoin('o.Cliente c')
					->where($where);
	
	$retLimit	= 	Doctrine_Query::create()->select()->from('OrdemServico o')->innerJoin('o.Cliente c')
					->where($where)->offset($_GET['iDisplayStart'])
					->limit($_GET['iDisplayLength'])->orderBy('o.data_atendimento DESC ')->execute();
	
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
					$action .= '<a href="'.URL_ADMIN.$tipo.$resPermissao['model'].'/'.$resPermissao['action'].'/'.$value['id'].'/" class="action '.$resPermissao['icone'].' '.$acao.'">';
					$action .= '<span>'.$resPermissao['titulo'].'</span></a>';
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

                          $usuario = ' - '.$value_usuario['nome'];
                      }
                  }
                }elseif($value['tipo_ordem']== 3){
                  foreach ($retFinaliza as $value_finaliza){

                      $where_usuario = "id = ".$value_finaliza['audit'];
                      $retUsuario	= 	Doctrine_Query::create()->select()->from('Usuario')->where($where_usuario)->execute();

                      $retUsuario = $retUsuario->toArray();
                      foreach ($retUsuario as $value_usuario){

                          $usuario = ' - '.$value_usuario['nome'];
                      }
                  }
                } elseif($value['tipo_ordem']== 5){
                  foreach ($retFinaliza as $value_finaliza){

                      $where_usuario = "id = ".$value_finaliza['audit'];
                      $retUsuario	= 	Doctrine_Query::create()->select()->from('Usuario')->where($where_usuario)->execute();

                      $retUsuario = $retUsuario->toArray();
                      foreach ($retUsuario as $value_usuario){

                          $usuario = ' - '.$value_usuario['nome'];
                      }
                  }
                } elseif($value['tipo_ordem']== 7){
                  foreach ($retFinaliza as $value_finaliza){

                      $where_usuario = "id = ".$value_finaliza['audit'];
                      $retUsuario	= 	Doctrine_Query::create()->select()->from('Usuario')->where($where_usuario)->execute();

                      $retUsuario = $retUsuario->toArray();
                      foreach ($retUsuario as $value_usuario){

                          $usuario = '-'.$value_usuario['nome'];
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
			

			
			
			// Retorno
			$returnArray[] = $value;
			
			
			
		}
		
	}
	
	$returnJson = array(
		'sEcho'					=> intval($_GET['sEcho']),
		'iTotalRecords'			=> $retAll->count(),
		'iTotalDisplayRecords'	=> $retAll->count(),
		'aaData'				=> $returnArray
	);
	
	echo json_encode($returnJson);

} catch(Exception $e){

	$returnJson = array(
		'sEcho'					=> intval($_GET['sEcho']),
		'iTotalRecords'			=> 0,
		'iTotalDisplayRecords'	=> 0,
		'aaData'				=> array($e)
	);
	
	echo json_encode($returnJson);
	
}

?>