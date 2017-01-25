<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Array de retorno
	$returnArray = array();
	
	// Campos
	$fields = explode(',', $_GET['sColumns']);
	
	// Parâmetro de ordenação
	$orderby = $fields[$_GET['iSortCol_0']].' '.strtoupper($_GET['sSortDir_0']);
	
	// Parâmetro de Limite
	$limit = $_GET['iDisplayStart'].','.$_GET['iDisplayLength'];
	
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
	
	// Adição do ID do contrato
	$where .= ' AND contrato_id = '.$_GET['contrato_id'];
	
	// Buscas (Geral e Paginada)
	$retAll		= 	Doctrine_Query::create()->select()->from('ContratoEquipamento ec')
					->leftJoin('ec.Equipamento e')->leftJoin('e.Marca m')
					->leftJoin('e.EquipamentoTipo et')->leftJoin('e.EquipamentoModelo em')
					->where($where);
	$retLimit	= 	Doctrine_Query::create()->select()->from('ContratoEquipamento ec')
					->leftJoin('ec.Equipamento e')->leftJoin('e.Marca m')
					->leftJoin('e.EquipamentoTipo et')->leftJoin('e.EquipamentoModelo em')
					->where($where)
					->offset($_GET['iDisplayStart'])->limit($_GET['iDisplayLength'])
					->execute();
	
	// Tratamento dos dados
	if ($retLimit->count() > 0){
		// Transforma os dados em Array
		$resLimit = $retLimit->toArray();
		
		foreach ($resLimit as $value){
			// Trata as permissões
			$objPermissao = new UsuarioPermissao();
			$retPermissao = $objPermissao->getPermissao($_GET['model'],array(5,6),$_GET['action']);
			
			// Seleção de permissões nível 2
			if ($retPermissao){
				$action = '<div class="actionbar">';
				foreach ($retPermissao as $resPermissao){
					$tipo	= $resPermissao['tipo']==3||$resPermissao['tipo']==6?'action/':'';
					$acao	= $resPermissao['tipo']==3||$resPermissao['tipo']==6?'action3':'';
					$action .= '<a href="'.URL_ADMIN.$tipo.$resPermissao['model'].'/'.$resPermissao['action'].'/'.$value['equipamento_id'].'-'.$value['contrato_id'].'/" class="action '.$resPermissao['icone'].' '.$acao.'">';
					$action .= '<span>'.$resPermissao['titulo'].'</span></a>';
				}
				$action .= '</div>';
			} else {
				$action = '';
			}
			
			// Tratamento de dados
			$value['action'] =	'<div style="height: 3px;">&nbsp;</div>';
			$value['action'] .= $action;
			
			// Equipamento
			$value['equipamento'] = $value['Equipamento']['EquipamentoTipo']['nome'].' => '.$value['Equipamento']['Marca']['nome'].' => '.$value['Equipamento']['EquipamentoModelo']['nome'].' => '.$value['Equipamento']['serial'];
					
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
		'aaData'				=> array()
	);
	
	echo json_encode($returnJson);
	
}