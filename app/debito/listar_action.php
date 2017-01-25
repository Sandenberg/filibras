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
	$where = $where==''?"tipo = 'debito'":$where." and tipo = 'debito'";
	
	
	// Buscas (Geral e Paginada)
	$retAll		= 	Doctrine_Query::create()->select()->from('Lancamento l')
					->leftJoin("l.Beneficiario b")->leftJoin('l.LancamentoTipo lt')
					->where($where);
	$retLimit	= 	Doctrine_Query::create()->select()->from('Lancamento l')
					->leftJoin("l.Beneficiario b")->leftJoin('l.LancamentoTipo lt')
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
					if($resPermissao['action']=='confirmar'&&(isset($value['data_baixa']))&&$value['data_baixa']!='1969-12-31'&&$value['data_baixa']!='0000-00-00'){
						$action .= '<a href="javascript: void()" class="action">';
					}else{
						$action .= '<a href="'.URL_ADMIN.$tipo.$resPermissao['model'].'/'.$resPermissao['action'].'/'.$value['id'].'/" class="action '.$resPermissao['icone'].' '.$acao.'">';
						$action .= '<span>'.$resPermissao['titulo'].'</span></a>';
					}
				}
				$action .= '</div>';
			} else {
				$action = '';
			}
			
			// Tratamento de dados
			$value['action'] =	'<div style="height: 3px;">&nbsp;</div>';
			$value['action'] .= $action;
			
			$resx = Doctrine_Core::getTable('Conta')->find($value['conta_id']);
			$value['nome_conta'] = isset($resx->nome)&&$resx->nome!=''?$resx->nome:'-';


			
			$value['Beneficiario']['nome'] = isset($value['Beneficiario']['nome'])&&$value['Beneficiario']['nome']!=''?$value['Beneficiario']['nome']:'-';
			
			$value['Fornecedor']['nome_completo'] = isset($value['Fornecedor']['nome_completo'])&&$value['Fornecedor']['nome_completo']!=''?$value['Fornecedor']['nome_completo']:'-';

			$value['LancamentoTipo']['nome'] = isset($value['LancamentoTipo']['nome'])&&$value['LancamentoTipo']['nome']!=''?$value['LancamentoTipo']['nome']:'-';
			// $value['lancamento'] = isset($value['data_lancamento'])&&$value['data_lancamento']!=''&&$value['data_lancamento']!=''?date('d/m/Y', strtotime($value['data_lancamento'])):'-';

			$value['Conta']['nome'] = isset($value['Conta']['nome'])&&$value['Conta']['nome']!=''?$value['Conta']['nome']:'-';
			// $value['vencimento'] = isset($value['data_vencimento'])&&$value['data_vencimento']!=''&&$value['data_vencimento']!=''?date('d/m/Y', strtotime($value['data_vencimento'])):'-';

			$value['valor_total'] = is_numeric($value['valor_total'])?$value['valor_total']:0;
			$value['valor'] = "R$".number_format($value['valor_total'], 2, ',', '.');

			$value['nfrb'] = isset($value['nf'])&&$value['nf']!=''?$value['nf']:'-';
			$value['nfrb'] = isset($value['recibo'])&&$value['recibo']=='REC'?'REC':$value['nfrb'];

			$value['data_lancamento'] = isset($value['data_lancamento'])&&$value['data_lancamento']!='0000-00-00'&&$value['data_lancamento']!=''&&$value['data_lancamento']!='1969-12-31'?date("d/m/Y", strtotime($value['data_lancamento'])):'-';
			$value['data_vencimento'] = isset($value['data_vencimento'])&&$value['data_vencimento']!='0000-00-00'&&$value['data_vencimento']!=''&&$value['data_vencimento']!='1969-12-31'?date("d/m/Y", strtotime($value['data_vencimento'])):'-';
			$value['data_baixa'] = isset($value['data_baixa'])&&$value['data_baixa']!='0000-00-00'&&$value['data_baixa']!=''&&$value['data_baixa']!='1969-12-31'?date("d/m/Y", strtotime($value['data_baixa'])):'-';

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
		'error'					=> $e,
		'where' => $where

	);
	
	echo json_encode($returnJson);
	
}