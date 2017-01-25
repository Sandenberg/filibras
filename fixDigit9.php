<?php 

	include('lib/Config.php');


	$ddd[] = 11; $ddd[] = 12; $ddd[] = 13; $ddd[] = 14; $ddd[] = 15; $ddd[] = 16; $ddd[] = 17; $ddd[] = 18; $ddd[] = 19;

	$ddd[] = 21; $ddd[] = 22; $ddd[] = 24; $ddd[] = 27; $ddd[] = 28; 

	$ddd[] = 31; $ddd[] = 32; $ddd[] = 33; $ddd[] = 34; $ddd[] = 35; $ddd[] = 37; $ddd[] = 38; 

	$ddd[] = 71; $ddd[] = 73; $ddd[] = 74; $ddd[] = 75; $ddd[] = 77; $ddd[] = 79; 

	$ddd[] = 91; $ddd[] = 92; $ddd[] = 93; $ddd[] = 94; $ddd[] = 95; $ddd[] = 96; $ddd[] = 97; $ddd[] = 98; 

	$num_valido[] = 9; $num_valido[] = 8; $num_valido[] = 7; 

	try {

	    $retFuncionario = Doctrine_Core::getTable('ClienteResponsavel')->findAll();
	    foreach ($retFuncionario as $objFuncionario) {
	    	if(strlen($objFuncionario->telefone)==10&&in_array(substr($objFuncionario->telefone, 0, 2), $ddd)&&in_array(substr($objFuncionario->telefone, 2, 1), $num_valido)){
	    		$objFuncionario->telefone = substr($objFuncionario->telefone, 0, 2)."9".substr($objFuncionario->telefone, 2, 8);
		    	try {
		    		echo $objFuncionario->telefone." - ".$objFuncionario->id."<br>";
	    			$objFuncionario->save();	    		
		    	} catch (Exception $e) {
		    		echo "Erro ".$objFuncionario->id.": ".$e;
		    	}
	    	}
	    }

	} catch (Exception $e) {
		echo "Erro ".$objFuncionario->id.": ".$e;
	}


?>