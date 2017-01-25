<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Array de retorno
	$returnArray = array();
	
	// Campos
	$fields = explode(',', $_GET['sColumns']);
	
	// Parâmetro de ordenação
	$orderby = $fields[$_GET['iSortCol_0']].' '.strtoupper($_GET['sSortDir_0']);
	$where = "";
	// Parâmetro de Busca
	if ($_GET['sSearch'] != ''){
		$where .= '(';
		foreach ($fields as $key=>$value){
			if ($_GET['bSearchable_'.$key] == 'true'){
				if (isset($_GET[$value]) && $_GET[$value] == 'date'){
					$where .= 	$where=='('?'DATE_FORMAT('.$value.',"%d/%m/%Y") LIKE "%'.$_GET['sSearch'].'%"':
					' OR DATE_FORMAT('.$value.',"%d/%m/%Y") LIKE "%'.$_GET['sSearch'].'%"';
				} else {
					$where .= 	$where=='('?$value.' LIKE "%'.$_GET['sSearch'].'%"':
					' OR '.$value.' LIKE "%'.$_GET['sSearch'].'%"';
				}
			}
		}
		$where .= ')';
	}
	$where = $where==''?"1=1":$where;

	$where = isset($_GET['cliente_id'])&&$_GET['cliente_id']!=''?"(".$where.") and os.cliente_id = '".$_GET['cliente_id']."' or oss.cliente_id = '".$_GET['cliente_id']."'":$where;
	$where = isset($_GET['fechamento'])&&$_GET['fechamento']!=''?"(".$where.") and osm.data_cadastro between '".date('Y-m-d H:i:s', strtotime($_GET['fechamento']." - 30 days"))."' and '".date('Y-m-d H:i:s', strtotime($_GET['fechamento']))."'":$where;
	
	// Buscas (Geral e Paginada)
	$retAll		= 	Doctrine_Query::create()->select()->from('OrdemServicoMaterial osm')->leftJoin('osm.Material m')
					->leftJoin('osm.OrdemServico os')->leftJoin('osm.OrdemServToner ost')->leftJoin('ost.OrdemServico oss')
					->where($where);
	$retLimit	= 	Doctrine_Query::create()->select()->from('OrdemServicoMaterial osm')->leftJoin('osm.Material m')
					->leftJoin('osm.OrdemServico os')->leftJoin('osm.OrdemServToner ost')->leftJoin('ost.OrdemServico oss')
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

			$value['valor_unidade'] = "R$".number_format($value['valor_unidade'], 2, ',', '.');
			$value['valor_total'] = "R$".number_format($value['valor_total'], 2, ',', '.');
			
			$value['data_cadastro'] = date('Y-m-d H:i:s', strtotime($value['data_cadastro']));

			if($value['tipo']==1){
				$value['tipo'] = 'Peça de Reposição';
			}else if($value['tipo'] == 2){	
				$value['tipo'] = 'Material de Consumo: Cilindro';
			}else if($value['tipo'] == 3){
				$value['tipo'] = 'Material de Consumo: Toner';
			}else if($value['tipo'] == 4){
				$value['tipo'] = 'Peça de Reposição';
			}
			// $resx = Doctrine_Core::getTable('Conta')->find($value['conta_id']);
			// $value['nome_conta'] = isset($resx->nome)&&$resx->nome!=''?$resx->nome:'-';

			// Retorno
			$returnArray[] = $value;
		}
	}
	
	$returnJson = array(
		'sEcho'					=> intval($_GET['sEcho']),
		'iTotalRecords'			=> $retAll->count(),
		'iTotalDisplayRecords'	=> $retAll->count(),
		'aaData'				=> $returnArray,
		'where' => $where
	);
	
	echo json_encode($returnJson);

} catch(Exception $e){
	
	$returnJson = array(
		'sEcho'					=> intval($_GET['sEcho']),
		'iTotalRecords'			=> 0,
		'iTotalDisplayRecords'	=> 0,
		'aaData'				=> array(),
		'error'					=> $e->getMessage(),
		'where' => $where
	);
	
	echo json_encode($returnJson);
	
}