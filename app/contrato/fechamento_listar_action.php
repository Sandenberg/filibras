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
	
	// Adição do ID do equipamento
	$where .= ' AND contrato_id = '.$_GET['contrato_id'];
	
	// Buscas (Geral e Paginada)
	$retAll		= 	Doctrine_Query::create()->select()->from('Fechamento f')
					->where($where);
	$retLimit	= 	Doctrine_Query::create()->select()->from('Fechamento f')
					->where($where)
					->offset($_GET['iDisplayStart'])->limit($_GET['iDisplayLength'])
					->orderBy($orderby)->execute();
	
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
					$action .= '<a href="'.URL_ADMIN.$tipo.$resPermissao['model'].'/'.$resPermissao['action'].'/'.$value['contrato_id'].'-'.$value['condicao_id'].'/" class="action '.$resPermissao['icone'].' '.$acao.'">';
					$action .= '<span>'.$resPermissao['titulo'].'</span></a>';
				}
				$action .= '</div>';
			} else {
				$action = '';
			}
			
			// Tratamento de dados
			$value['action'] =	'<div style="height: 3px;">&nbsp;</div>';
			$value['action'] .= $action;
			
			$value['lucro'] = $value['valor']-$value['custo'];

			$value['valor'] = "R$".number_format($value['valor'], 2, ',', '.');
			$value['custo'] = "<a href='".URL_ADMIN."lancamento-material/?cliente_id=".$value['cliente_id']."&fechamento=".$value['data_fechamento']."'>R$".number_format($value['custo'], 2, ',', '.')."</a>";
			$value['lucro'] = "R$".number_format($value['lucro'], 2, ',', '.');

			// Datas nascimento
			$value['data_fechamento']	= date('d/m/Y H:i', strtotime($value['data_fechamento']))." a ".date('d/m/Y H:i', strtotime($value['data_fechamento']." - 30 days"));
			
			// Retorno
			$returnArray[] = $value;
		}
	}
	
	$returnJson = array(
		'sEcho'					=> intval($_GET['sEcho']),
		'iTotalRecords'			=> $retAll->count(),
		'iTotalDisplayRecords'	=> $retLimit->count(),
		'aaData'				=> $returnArray
	);
	
	echo json_encode($returnJson);

} catch(Exception $e){
	
	$returnJson = array(
		'sEcho'					=> intval($_GET['sEcho']),
		'iTotalRecords'			=> 0,
		'iTotalDisplayRecords'	=> 0,
		'aaData'				=> array(),
		'er'					=> $e->getMessage()
	);
	
	echo json_encode($returnJson);
	
}