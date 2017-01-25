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
		$where .= 	$where==''?'DATE_FORMAT(data_mensagem ,"%d/%m/%Y") LIKE "%'.$_GET['sSearch'].'%"':
					' OR DATE_FORMAT(data_mensagem ,"%d/%m/%Y") LIKE "%'.$_GET['sSearch'].'%"';
	}
	$where = $where==''?'1 = 1':$where;

	$where = $_SESSION['sess_usuario_grupo_id']!=1?"(".$where.") and recebida_por = '".$_SESSION['sess_usuario_id']."'":$where;
	// if($_SESSION['sess_usuario_grupo_id']==4){

	// 	$retUsuario	= Doctrine_Core::getTable('Usuario')->findByUsuarioGrupoId(4);

	// 	foreach ($retUsuario as $objUsuario) {
	// 		$recebida_por[] = "recebida_por = '".$objUsuario->id."'";
	// 	}

	// 	$where = "(".$where.") and (".implode(" or ", $recebida_por).")";

	// }
	
	// Buscas (Geral e Paginada)
	$retAll		= 	Doctrine_Query::create()->select()->from('Mensagem l')
					->where($where);
	$retLimit	= 	Doctrine_Query::create()->select()->from('Mensagem l')
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
					if($value['recebida_por']==$_SESSION['sess_usuario_id']&&$_SESSION['sess_usuario_grupo_id']==4||$_SESSION['sess_usuario_grupo_id']!=4){
						$action .= '<a href="'.URL_ADMIN.$tipo.$resPermissao['model'].'/'.$resPermissao['action'].'/'.$value['id'].'/" class="action '.$resPermissao['icone'].' '.$acao.'">';
						$action .= '<span>'.$resPermissao['titulo'].'</span></a>';
					}
				}
				$action .= '</div>';
			} else {
				$action = '';
			}

			$objUsuario1	= Doctrine_Core::getTable('Usuario')->find($value['enviada_por']);
			if ($value['enviada_por'] <> '' or $value['enviada_por'] <> null ){			
				$value['enviada_por'] = $objUsuario1->nome;
			}

			$objUsuario2	= Doctrine_Core::getTable('Usuario')->find($value['recebida_por']);
			$value['recebida_por'] = $objUsuario2->nome;
			
			// Tratamento de dados
			$value['action'] =	'<div style="height: 3px;">&nbsp;</div>';
			$value['action'] .= $action;
			
			$value['data_mensagem'] = date('d/m/Y H:i:s', strtotime($value['data_mensagem']));
			$value['data_lida'] = $value['lida']==1?date('d/m/Y H:i:s', strtotime($value['data_lida'])):"-";
			$value['data_ok'] = $value['status']==2?date('d/m/Y H:i:s', strtotime($value['data_ok'])):"-";
			
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
		'aaData'				=> array(),
		'error'				=> $e->getMessage()
	);
	
	echo json_encode($returnJson);
	
}