<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');


$ativo = null;

if (isset($_POST['ativo']))
{
	$ativo = $_POST['truc']; 
}

try {

	function geraSaidaEstoque($ordem_servico_id, $material_id, $quantidade){

		// Baixa no Estoque
		$objSaida					= new Saida();
		$objSaida->data_cadastro	= date('Y-m-d H:i:s');
		$objSaida->ordem_servico_id = $ordem_servico_id;
		$objSaida->descricao 		= "Ordem de Serviço Nº ".$ordem_servico_id;
		$objSaida->usuario_id		= $_SESSION['sess_usuario_id'];
		$objSaida->save();
		
		$objSaidaMaterial = new SaidaMaterial();
		$objSaidaMaterial->material_id = $material_id;
		$objSaidaMaterial->quantidade = $quantidade;
		$objSaidaMaterial->saida_id = $objSaida->id;
		$objSaidaMaterial->save();

		$objMaterial = Doctrine_Core::getTable('Material')->find($material_id);
		$objMaterial->estoque -= $quantidade;
		$objMaterial->save();

	}
	
	// Tratamento de dados
	$_POST['id'] 					= isset($_POST['id'])&&$_POST['id']!=''?$_POST['id']:0;


	$objOrdemServico						= Doctrine_Core::getTable('OrdemServico')->find($_POST['id']);

	// Update
	$objOrdemservicoFinalizar 						= new FinalizarOrdemServico();
	$objOrdemservicoFinalizar->id_ordem_servico 	= $_POST['id'];
	$objOrdemservicoFinalizar->id_cliente           = $_POST['id_cliente'];
    $objOrdemservicoFinalizar->entregue           	= isset($_POST['entregue'])&&$_POST['entregue']!=''?$_POST['entregue']:null;
    $objOrdemservicoFinalizar->data_final           = date('Y-m-d H:i:s');
    $objOrdemservicoFinalizar->audit                  = $_SESSION['sess_usuario_id'];
	$objOrdemservicoFinalizar->save();
	$descricao = array();

	if($objOrdemServico->tipo_ordem==1){
		
		if(isset($_POST['idToner'])&&count($_POST['idToner'])>0&&$objOrdemServico->status==0){
			foreach ($_POST['idToner'] as $key => $value) {

				$objEquipamento	= Doctrine_Core::getTable('OrdemServToner')->find($value);
				$objEquipamento->quant_final_cilindro = $_POST['quant_c'][$key];
				$objEquipamento->quant_final_toner = $_POST['quant_t'][$key];
				$objEquipamento->save();

				if($_POST['quant_t'][$key] > 0){
					
					$objMaterial	= Doctrine_Core::getTable('Material')->find($objEquipamento->toner_id);

					$objOrdemServicoMaterial 						= new OrdemServicoMaterial();
					$objOrdemServicoMaterial->data_cadastro			= date('Y-m-d H:i:s');
					$objOrdemServicoMaterial->ordem_serv_toner_id	= $objEquipamento->id;
					$objOrdemServicoMaterial->material_id			= $objMaterial->id;
					$objOrdemServicoMaterial->quantidade			= $_POST['quant_t'][$key];
					$objOrdemServicoMaterial->valor_unidade			= (float) $objMaterial->valor;
					$objOrdemServicoMaterial->valor_total			= (float) $_POST['quant_t'][$key]*$objMaterial->valor;
					$objOrdemServicoMaterial->tipo 					= $objMaterial->tipo;
					$objOrdemServicoMaterial->save();

					geraSaidaEstoque($objOrdemServico->id, $objMaterial->id, $_POST['quant_t'][$key]);

				}

				if($_POST['quant_c'][$key] > 0){
					
					$objMaterial	= Doctrine_Core::getTable('Material')->find($objEquipamento->cilindro_id);

					$objOrdemServicoMaterial 						= new OrdemServicoMaterial();
					$objOrdemServicoMaterial->data_cadastro			= date('Y-m-d H:i:s');
					$objOrdemServicoMaterial->ordem_serv_toner_id	= $objEquipamento->id;
					$objOrdemServicoMaterial->material_id			= $objMaterial->id;
					$objOrdemServicoMaterial->quantidade			= $_POST['quant_c'][$key];
					$objOrdemServicoMaterial->valor_unidade			= (float) $objMaterial->valor;
					$objOrdemServicoMaterial->valor_total			= (float) $_POST['quant_c'][$key]*$objMaterial->valor;
					$objOrdemServicoMaterial->tipo 					= $objMaterial->tipo;
					$objOrdemServicoMaterial->save();

					geraSaidaEstoque($objOrdemServico->id, $objMaterial->id, $_POST['quant_c'][$key]);

				}
			}
		}
	} else if($objOrdemServico->tipo_ordem==0||$objOrdemServico->tipo_ordem==6){

		if(isset($_POST['material_id'])&&count($_POST['material_id'])>0&&$objOrdemServico->status==0){
			foreach ($_POST['material_id'] as $key => $value) {
				$vetor = explode("-", $value);
				$equipamento_id = $vetor[0];
				$material_id = $vetor[1];


				$objMaterial	= Doctrine_Core::getTable('Material')->find($material_id);

				$objOrdemServicoMaterial 						= new OrdemServicoMaterial();
				$objOrdemServicoMaterial->data_cadastro			= date('Y-m-d H:i:s');
				$objOrdemServicoMaterial->equipamento_id		= $equipamento_id;
				$objOrdemServicoMaterial->ordem_servico_id		= $objOrdemServico->id;
				$objOrdemServicoMaterial->material_id			= $objMaterial->id;
				$objOrdemServicoMaterial->quantidade			= 1;
				$objOrdemServicoMaterial->valor_unidade			= (float) $objMaterial->valor;
				$objOrdemServicoMaterial->valor_total			= (float) 1*$objMaterial->valor;
				$objOrdemServicoMaterial->tipo 					= $objMaterial->tipo;
				$objOrdemServicoMaterial->save();

				geraSaidaEstoque($objOrdemServico->id, $objMaterial->id, 1);

			}
		}

	} else if($objOrdemServico->tipo_ordem==3){

		foreach ($_POST['material_id'] as $key => $value) {
			$vetor = explode("-", $value);
			$equipamento_id = $vetor[0];
			$material_id = $vetor[1];

			$objMaterial	= Doctrine_Core::getTable('Material')->find($material_id);

			$objOrdemServicoMaterial 						= new OrdemServicoMaterial();
			$objOrdemServicoMaterial->data_cadastro			= date('Y-m-d H:i:s');
			$objOrdemServicoMaterial->equipamento_id		= $equipamento_id;
			$objOrdemServicoMaterial->ordem_servico_id		= $objOrdemServico->id;
			$objOrdemServicoMaterial->material_id			= $material_id;
			$objOrdemServicoMaterial->quantidade			= $_POST['quantidade'][$key];
			$objOrdemServicoMaterial->valor_unidade			= (float) $objMaterial->valor;
			$objOrdemServicoMaterial->valor_total			= (float) $objMaterial->valor;
			$objOrdemServicoMaterial->save();

			geraSaidaEstoque($objOrdemServico->id, $objMaterial->id, $_POST['quantidade'][$key]);

		}

	}

	if(isset($_POST['IdEquip'])&&count($_POST['IdEquip'])>0){
		foreach ($_POST['IdEquip'] as $key => $value) {

			$objEquipamento	= Doctrine_Core::getTable('Equipamento')->find($value);

			$descricao[] = $objEquipamento->EquipamentoModelo->nome." (".$objEquipamento->serial.") - ".$_POST['descricaoEquip'][$key];

			if(isset($_POST['descricaoEquip'][$key])&&$_POST['descricaoEquip'][$key] != ''){
				$objFinalizarEquipamento 						= new FinalizarEquipamento();
				$objFinalizarEquipamento->finalizar_id 			= $objOrdemservicoFinalizar->id;
				$objFinalizarEquipamento->equipamento_id		= $_POST['IdEquip'][$key];
				$objFinalizarEquipamento->descricao				= $_POST['descricaoEquip'][$key];
				$objFinalizarEquipamento->save();
			}
		}
		$_POST['descricao'] = implode('<br>', $descricao);
	}
	

	$objOrdemservicoFinalizar->descricao 	        = isset($_POST['descricao'])&&$_POST['descricao']!=''?$_POST['descricao']:"";
	$objOrdemservicoFinalizar->save();

	$objOrdemServico->status			    = 1;
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
    $tipo = $tipo==9?'Atendimento Avulso':$tipo;

	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'success';
	$_SESSION['return_message']	= 'Executado com sucesso!';

    Util::regLog('Ordem de Serviço', $objOrdemServico->id, 'finalizou', $objOrdemServico->Cliente->nome_completo, $tipo);
} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!'.$e;
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN.$_GET['model'].'/');