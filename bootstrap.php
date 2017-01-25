<?php

require_once(PATH.'/lib/Doctrine.php');

try {

	spl_autoload_register(array('Doctrine', 'autoload'));
	spl_autoload_register(array('Doctrine_Core', 'modelsAutoload'));
	
	$manager = Doctrine_Manager::getInstance();
	
	$conn = Doctrine_Manager::connection(DB_SGBD.'://'.DB_USER.':'.DB_PSWD.'@'.DB_HOST.'/'.DB_NAME);
	$conn->setOption('username', DB_USER);
	$conn->setOption('password', DB_PSWD);
	$conn->setCharset(DB_CHAR);
	$manager->setAttribute(Doctrine_Core::ATTR_EXPORT, Doctrine_Core::EXPORT_ALL);
	$manager->setAttribute(Doctrine_Core::ATTR_MODEL_LOADING, Doctrine_Core::MODEL_LOADING_CONSERVATIVE);
	$manager->setAttribute(Doctrine_Core::ATTR_AUTOLOAD_TABLE_CLASSES, true);
	$manager->setAttribute(Doctrine_Core::ATTR_VALIDATE, Doctrine_Core::VALIDATE_ALL);
	$manager->setAttribute(Doctrine_Core::ATTR_AUTOCOMMIT, false);
	
	// Permite o override dos metodos do model.
	$manager->setAttribute(Doctrine_Core::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
	
	// Formato das sequências (uso para PostgreSQL)
	$manager->setAttribute(Doctrine_Core::ATTR_SEQNAME_FORMAT, '%s_seq');
	
	// Carrega os models da pasta especificada, no caso "models"
	Doctrine_Core::loadModels(PATH.'models');
	
} catch (Exception $e){
	$return_type 	= 'error';
	$return_message	= 'Sistema indisponível!';
}