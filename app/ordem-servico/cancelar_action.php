<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	// Delete
    $objOrdemServico 	= Doctrine_Core::getTable('OrdemServico')->find($_GET['id']);
	$objOrdemServico->status = 2;
	$objOrdemServico->save();
	
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

	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';

    Util::regLog('Ordem de Serviço', $objOrdemServico->id, 'cancelou', $objOrdemServico->Cliente->nome_completo, $tipo);
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');