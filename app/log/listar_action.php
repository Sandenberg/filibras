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
		$where .= 	$where==''?'DATE_FORMAT(data_alteracao ,"%d/%m/%Y") LIKE "%'.$_GET['sSearch'].'%"':
					' OR DATE_FORMAT(data_alteracao ,"%d/%m/%Y") LIKE "%'.$_GET['sSearch'].'%"';
					
		$where .= 	' OR texto like "%'.$_GET['sSearch'].'%" or tipo like "%'.$_GET['sSearch'].'%"';

		$where .= 	' OR u.nome like "%'.$_GET['sSearch'].'%"';
	}
	$where = $where==''?'1 = 1':$where;
	
	// Buscas (Geral e Paginada)
	$retAll		= 	Doctrine_Query::create()->select()->from('Log l')->leftJoin('l.Usuario u')
					->where($where);
	$retLimit	= 	Doctrine_Query::create()->select()->from('Log l')->leftJoin('l.Usuario u')
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
			
			// Tipo
			$value['Usuario']['nome'] = isset($value['Usuario']['nome'])?$value['Usuario']['nome']:'-';
			
			$value['usuario'] = $value['Usuario']['nome'];
			$texto = "-";
			if($value['modulo']=='Cliente'){
				$res = Doctrine_Core::getTable('Cliente')->find($value['codigo']);
				if($res)
					$texto = $res->nome_completo;
			}else if($value['modulo']=='Contrato'){
				$res = Doctrine_Core::getTable('Contrato')->find($value['codigo']);
				if(isset($res->Cliente->nome_completo))
					$texto = $res->Cliente->nome_completo;
			}else if($value['modulo']=='Crédito'||$value['modulo']=='Lançamento'){
				$res = Doctrine_Core::getTable('Lancamento')->find($value['codigo']);
				if(isset($res->Cliente->nome_completo)&&$res->Cliente->nome_completo!='')
					$texto = $res->Cliente->nome_completo;

				// $texto = date('d/m/Y', strtotime($res->data_vencimento));
			}else if($value['modulo']=='Débito'){
				$res = Doctrine_Core::getTable('Lancamento')->find($value['codigo']);
				if(isset($res->Beneficiario->nome)&&$res->Beneficiario->nome!='')
					$texto = $res->Beneficiario->nome;

				// $texto = date('d/m/Y', strtotime($res->data_vencimento));
			}else if($value['modulo']=='Fornecedor'){
				$res = Doctrine_Core::getTable('Fornecedor')->find($value['codigo']);
				$texto = $res->nome_completo;
			}else if($value['modulo']=='Ordem de Serviço'){
				$res = Doctrine_Core::getTable('OrdemServico')->find($value['codigo']);
				// $texto = $res->Cliente->nome_completo;

				if($value['tipo']==""){
					if(isset($res->tipo_ordem)){
						$tipo = $res->tipo_ordem;
						$tipo = $tipo==0?'Manutenção no Equipamento':$tipo;
						$tipo = $tipo==1?'Troca de Cilindro/Toner':$tipo;
						$tipo = $tipo==2?'Leitura de Numerador':$tipo;					
						$tipo = $tipo==3?'Instalação de Equipamento':$tipo;
		                $tipo = $tipo==4?'Troca de Equipamento':$tipo;
		                $tipo = $tipo==5?'Retirada de Equipamento':$tipo;
		                $tipo = $tipo==6?'Manutenção Preventiva':$tipo;
		                $tipo = $tipo==7?'Serviços de Informática':$tipo;
		                $tipo = $tipo==8?'Acesso Remoto':$tipo;
						
						$value['modulo'] = $tipo;
					}
				}else{
					$value['modulo'] = $value['tipo'];
				}
				if(isset($res->Cliente->nome_completo))
					$texto = $res->Cliente->nome_completo;

			}
			$value['codigo'] = isset($value['texto'])&&$value['texto']!=''?$value['codigo']." / ".$value['texto']:$value['codigo']." / ".$texto;


			$value['acao'] = strtoupper($value['acao']);

			$value['data_alteracao'] = date('d/m/Y H:i:s', strtotime($value['data_alteracao']));
			
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