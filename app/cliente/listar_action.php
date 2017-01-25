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
		$search = str_replace("-", "", $search);
		$search = str_replace("/", "", $search);

		$where .= ' or cpf like "%'.$search.'%"';
		$where .= ' or cnpj like "%'.$search.'%"';
		$where .= ' or logradouro like "%'.$search.'%"';
		$where .= ' or bairro like "%'.$search.'%"';
	}
	$where = $where==''?'1 = 1':$where;
	
	// Buscas (Geral e Paginada)
	$retAll		= 	Doctrine_Query::create()->select()->from('Cliente c')->innerJoin('c.Filial f')
					->where($where);
	
	$retLimit	= 	Doctrine_Query::create()->select()->from('Cliente c')->innerJoin('c.Filial f')
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
					$resPermissao['titulo'] = $resPermissao['titulo']=='Restrição'&&$value['restricao']==1?"Retirar Restrição":$resPermissao['titulo'];
					$action .= '<span>'.$resPermissao['titulo'].'</span></a>';
				}
				$action .= '</div>';
			} else {
				$action = '';
			}
			
			// Tratamento de dados
			$value['action'] =	'<div style="height: 3px;">&nbsp;</div>';
			$value['action'] .= $action;
			
			// Status
            $value['telefone_principal'] = ltrim($value['telefone_principal'], '0');  
            $value['telefone'] = strlen($value['telefone_principal'])==10?Util::mask('(##)####-####', $value['telefone_principal']):Util::mask('(##)#####-####', $value['telefone_principal']);  
                          
                        $retFornecedoResp = Doctrine_Query::create()->select()->from('ClienteResponsavel')
					->where("cliente_id = ".$value['id'])->execute();
                        
                        if ($retFornecedoResp->count() > 0){
		            $resFornecedoResp = $retFornecedoResp->toArray();
                            foreach ($resFornecedoResp as $valueResp){
                        $value['contato'] = $valueResp['nome']; 
                            }}else{
                                $value['contato'] ='';
                            }
			$value['documento'] = $value['tipo_pessoa']==0?Util::mask('###.###.###-##', $value['cpf']):Util::mask('##.###.###/####-##', $value['cnpj']);
			
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
		'where'					=> $where,
		'error'					=> $e->getMessage()
	);
	
	echo json_encode($returnJson);
	
}

?>