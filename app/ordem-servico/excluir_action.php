<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Delete
	$objOrdemServico = Doctrine_Core::getTable('OrdemServico')->find($_GET['id']);	

    $tipo = $objOrdemServico->tipo_ordem;
    $tipo = $tipo==0?'Manutenção no Equipamento':$tipo;
    $tipo = $tipo==1?'Troca de Cilindro/Toner':$tipo;
    $tipo = $tipo==2?'Leitura de Numerador':$tipo;                  
    $tipo = $tipo==3?'Instalação de Equipamento':$tipo;
    $tipo = $tipo==4?'Troca de Equipamento':$tipo;
    $tipo = $tipo==5?'Retirada de Equipamento':$tipo;
    $tipo = $tipo==6?'Manutenção Preventiva':$tipo;
    $tipo = $tipo==7?'Serviços de Informática':$tipo;
    $tipo = $tipo==8?'Acesso Remoto':$tipo;

    Util::regLog('Ordem de Serviço', $objOrdemServico->id, 'excluiu', $objOrdemServico->Cliente->nome_completo, $tipo);

	$objSaida = Doctrine_Core::getTable('Saida')->findOneByOrdemServicoId($_GET['id']);	

	if(isset($objSaida->SaidaMaterial[0]->id) &&  $objSaida->SaidaMaterial[0]->id!=''){

		foreach ($objSaida->SaidaMaterial as $objSaidaMaterial) {

			$objMaterial = Doctrine_Core::getTable('Material')->find($objSaidaMaterial->material_id);
			$objMaterial->estoque += $objSaidaMaterial->quantidade;
			$objMaterial->save();
		}

		$objSaida->delete();

	}
    
	$objOrdemServico->delete();
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e;
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');