<?php

// Arquivo de configuração
require('lib/Config.php');

try {
	
	Doctrine_Core::generateModelsFromDb('models', array('doctrine'), array(
		'generateTableClasses' => true)
	);
	
	echo 'Classes geradas com sucesso!';

} catch (Exception $e){
	echo '<pre>';
	print_r($e);
}