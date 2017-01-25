<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Tratamento do valor
	$_POST['valor'] = preg_replace('/[.]/', '', $_POST['valor']);
	$_POST['valor'] = preg_replace('/[,]/', '.', $_POST['valor']);
	$_POST['valor']	= isset($_POST['valor'])&&doubleval($_POST['valor'])>0?doubleval($_POST['valor']):null;
	
	// Tratamento de dados
	$_POST['id'] 	= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;
	$_POST['minimo'] 	= isset($_POST['minimo'])&&$_POST['minimo']!=''?str_replace("_", "", $_POST['minimo']):0;
	$_POST['estoque'] 	= isset($_POST['estoque'])&&$_POST['estoque']!=''?str_replace("_", "", $_POST['estoque']):0;
	$_POST['dns']	= Util::getCleanUrl($_POST['nome']);
	
	// Verifica se existe outro registro com os dados informados
	$retMaterial =	Doctrine_Query::create()->select()->from('EquipamentoSituacao')
					->where('dns LIKE "'.$_POST['dns'].'" AND id <> "'.$_POST['id'].'"')
					->execute();
	
	if ($retMaterial->count() > 0){
	
		// Tratamento de retorno
		$_SESSION['return_type']	= 'error';
		$_SESSION['return_message'] = 'Já existe um registro com os dados informados.';
	
	} else {
	
		// Update
		$objMaterial			= Doctrine_Core::getTable('Material')->find($_POST['id']);
		$objMaterial->nome 		= $_POST['nome'];
		$objMaterial->minimo 	= $_POST['minimo'];
		$objMaterial->estoque 	= $_POST['estoque'];
		$objMaterial->localizacao 	= $_POST['localizacao'];
		$objMaterial->dns		= $_POST['dns'];
		$objMaterial->valor		= $_POST['valor'];
		$objMaterial->tipo		= isset($_POST['tipo'])?$_POST['tipo']:null;
		$objMaterial->cobranca	= isset($_POST['cobranca'])?$_POST['cobranca']:null;
		$objMaterial->save();

		// Remove as ligações atuais
		$objMaterial->MaterialEquipamento->delete();
		// Verifica se existem produtoras para realizar as ligações
		if(isset($_POST['equipamento_id'])){
			if (count($_POST['equipamento_id']) > 0){
				foreach ($_POST['equipamento_id'] as $equipamento_id){
					// Insert
					$objMaterialEquipamento					= new MaterialEquipamento();
					$objMaterialEquipamento->material_id	= $objMaterial->id;
					$objMaterialEquipamento->equipamento_id	= $equipamento_id;
					$objMaterialEquipamento->save();
				}
			}
		}

		// Tratamento de retorno
		$_SESSION['return_type'] 	= 'success';
		$_SESSION['return_message']	= 'Executado com sucesso!';
		
	}

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e;
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');