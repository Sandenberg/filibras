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
					if($value != 'cliente'){
						$where .= 	$where==''?$value.' LIKE "%'.$_GET['sSearch'].'%"':
						' OR '.$value.' LIKE "%'.$_GET['sSearch'].'%"';
					}else{
						$where .= ' or cl.nome_completo like "%'.$_GET['sSearch'].'%"';
					}
				}
			}
		}
		$where .= " or nf_compra like '%".$_GET['sSearch']."%'";
	}
	$where = $where==''?'1 = 1':$where;


	if(isset($_GET['sSearch_6'])&&$_GET['sSearch_6']!=''){

		$status = "";

        if($_GET['sSearch_6'] == "Vendido"){
			$status=0;
		}elseif ($_GET['sSearch_6'] == 'Locação'){
			$status=1;
		}elseif ($_GET['sSearch_6'] == 'Equipamento do Cliente'){
			$status=2;
		}elseif ( $_GET['sSearch_6'] =='Estoque'){
			$status=3;
		}

        if ($status!=''||$status==0) {
        	$where = "(".$where.") and status = ".$status;
        }

	}
	
	// Buscas (Geral e Paginada)
	$retAll		= 	Doctrine_Query::create()->select()->from('Equipamento e')->leftJoin('e.EquipamentoTipo et')
					->leftJoin('e.Marca m')->leftJoin('e.EquipamentoModelo em')
					->leftJoin('e.EquipamentoSituacao es')->leftJoin('e.ContratoEquipamento ce')
					->leftJoin('ce.Contrato c')->leftJoin('c.Cliente cl')->where($where);
	
	$retLimit	= 	Doctrine_Query::create()->select()->from('Equipamento e')->leftJoin('e.EquipamentoTipo et')
					->leftJoin('e.Marca m')->leftJoin('e.EquipamentoModelo em')
					->leftJoin('e.EquipamentoSituacao es')->leftJoin('e.ContratoEquipamento ce')
					->leftJoin('ce.Contrato c')->leftJoin('c.Cliente cl')
					->where($where)->offset($_GET['iDisplayStart'])
					->limit($_GET['iDisplayLength'])->orderBy($orderby)->execute();
	
	// Tratamento dos dados
	if ($retLimit->count() > 0){
		// Transforma os dados em Array
		$resLimit = $retLimit->toArray();
		
		foreach ($resLimit as $value){
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
			} else {
				$action = '';
			}
			
			// Tratamento de dados
			$value['action'] =	'<div style="height: 3px;">&nbsp;</div>';
			$value['action'] .= $action;
			
			// Cliente
			$value['cliente'] = isset($value['ContratoEquipamento'][0])?$value['ContratoEquipamento'][0]['Contrato']['Cliente']['nome_completo']:'-';

			$value['status'] = $value['status']==0?"Vendido":$value['status'];
			$value['status'] = $value['status']==1?"Locação":$value['status'];
			$value['status'] = $value['status']==2?"Equipamento do cliente":$value['status'];
			$value['status'] = $value['status']==3?"Estoque":$value['status'];


			
			// Retorno
			$returnArray[] = $value;
		}
	}
	
	$returnJson = array(
		'sEcho'					=> intval($_GET['sEcho']),
		'iTotalRecords'			=> $retAll->count(),
		'iTotalDisplayRecords'	=> $retAll->count(),
		'aaData'				=> $returnArray,
		'where'					=> $where
	);
	
	echo json_encode($returnJson);

} catch(Exception $e){
	
	$returnJson = array(
		'sEcho'					=> intval($_GET['sEcho']),
		'iTotalRecords'			=> 0,
		'iTotalDisplayRecords'	=> 0,
		'aaData'				=> array(),
		'where'					=> $where
	);
	
	echo json_encode($returnJson);
	
}