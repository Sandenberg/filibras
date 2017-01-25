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
	}
	$where = $where==''?'1 = 1':$where;
	//$where .= 'and c.ativo = 1 ';
	
	// Buscas (Geral e Paginada)
	$retAll		= 	Doctrine_Query::create()->select()->from('Contrato c')->innerJoin('c.Cliente cl')->innerJoin('cl.Filial f')
					->where($where);
	$retLimit	= 	Doctrine_Query::create()->select()->from('Contrato c')->innerJoin('c.Cliente cl')->innerJoin('cl.Filial f')
					->where($where)->offset($_GET['iDisplayStart'])
					->limit($_GET['iDisplayLength'])->orderBy($orderby)->execute();
	
	// Tratamento dos dados
	if ($retLimit->count() > 0){
		// Transforma os dados em Array
		$resLimit = $retLimit->toArray();
		
		foreach ($resLimit as $value){

			if($value['Cliente']['ativo'] != 1){
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
			
			// Datas Inicio Vigência e Fim Vigência
			$value['data_inicio']	= $value['data_inicio']==''?'':date('d/m/Y', strtotime($value['data_inicio']));
			$value['data_fim']		= $value['data_fim']==''?'INDETERMINADA':date('d/m/Y', strtotime($value['data_fim']));
			$value['data_fim']		= $value['tipo']==2?'':$value['data_fim'];	
			

            $value['renovacao'] = $value['renovacao']==1?'Automática':'Manual';
            $value['renovacao'] = $value['tipo']==1?'-':$value['renovacao'];
			// Tipo de Contrato
			$value['tipo'] = $value['tipo']==0?'Locação':$value['tipo'];
			$value['tipo'] = $value['tipo']==1?'Venda':$value['tipo'];
			$value['tipo'] = $value['tipo']==2?'Venda sem contrato':$value['tipo'];
			$value['tipo'] = $value['tipo']==3?'Contrato de manutenção':$value['tipo'];
			$value['tipo'] = $value['tipo']==4?'Equipamento do Cliente':$value['tipo'];

                        
            $value['filial'] = isset($value['Cliente'][0])?$value['Cliente'][0]['Cliente']['Filial']['nome']:$value['Cliente']['Filial']['nome'];
			
			// Retorno
			$returnArray[] = $value;
			
			}else if($value['Cliente']['ativo'] == 1) {
					
				$id_contrato = $value['id'];
				
				$objContrato= Doctrine_Query::create()
				->delete('ContratoEquipamento c')
				->where("c.contrato_id = $id_contrato")
				->execute();
			}		

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
		'where'					=> $where,
		'error'					=> $e->getMessage()
	);
	
	echo json_encode($returnJson);
	
}