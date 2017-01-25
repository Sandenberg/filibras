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
		if(strlen($_GET['sSearch'])==10&&substr_count($_GET['sSearch'], '/')==2)
			$where .= ' or data_cadastro between "'.Util::dateConvert($_GET['sSearch']).' 00:00:00" and "'.Util::dateConvert($_GET['sSearch']).' 23:59:59"';
	}
	$where = $where==''?'1 = 1':$where;
	
	// Buscas (Geral e Paginada)
	$retAll		= 	Doctrine_Query::create()->select()->from('Saida e')->leftJoin('e.Usuario u')
					->leftJoin('e.SaidaMaterial sm')->leftJoin('sm.Material m')
					->leftJoin('e.OrdemServico os')->leftJoin('os.Cliente c')
					->where($where)->groupBy('e.id');
	$retLimit	= 	Doctrine_Query::create()->select()->from('Saida e')->leftJoin('e.Usuario u')
					->leftJoin('e.SaidaMaterial sm')->leftJoin('sm.Material m')
					->leftJoin('e.OrdemServico os')->leftJoin('os.Cliente c')
					->where($where)->groupBy('e.id')->offset($_GET['iDisplayStart'])
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

				if(isset($value['ordem_servico_id'])&&$value['ordem_servico_id']!=''){
					$action .= '<a target="_blank" href="'.URL_ADMIN.'ordem-servico/detalhes/'.$value['ordem_servico_id'].'" class="action informacao">';
					$action .= '<span>Detalhes OS</span></a>';
				}else{
					$action .= '<a target="_blank" href="javascript: void(0)" class="action view" style="border: 0px; background: transparent; cursor: pointer">';
				}
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

			$value['nome_cliente'] = isset($value['OrdemServico']['Cliente']['nome_completo'])&&$value['OrdemServico']['Cliente']['nome_completo']!=''?$value['OrdemServico']['Cliente']['nome_completo']:"-";

			$value['materiais'] = "";

			$retMaterial = Doctrine_Core::getTable('SaidaMaterial')->findBySaidaId($value['id']);
			foreach ($retMaterial as $objMaterial) {
				$value['materiais'] .= $value['materiais']==""?"":", ";
				$value['materiais'] .= $objMaterial->Material->nome." <b>(".$objMaterial->quantidade.")</b>";
			}

						
			$value['data_cadastro'] = date('d/m/Y H:i:s', strtotime($value['data_cadastro']));

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
		'aaData'				=> array()
	);
	
	echo json_encode($returnJson);
	
}