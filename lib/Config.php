<?php

/**
 * Configurações e definições para o funcionamento do sistema
 */

@session_start();

// Título Padrão
define('TITLE_DEFAULT', 'FILIBRAS');

// Configura o nível de report e display dos erros
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Definição de língua em datas
setlocale(LC_ALL, 'pt_BR.UTF8', 'ptb');

// Define o time zone
date_default_timezone_set('Brazil/East');

// Definição de PATH, URL, Acesso a Banco de Dados e SMTP (De acordo com o Servidor)
if(@is_dir('/var/www/Clientes/Filibras/Sistema')){
	
	// PATH, URL e CHARSET
	define('PATH', '/var/www/Clientes/Filibras/Sistema/');
	define('URL', 'http://192.168.1.250/Clientes/Filibras/Sistema/');
	define('CHARSET', 'utf-8');
	
	// Banco de Dados
	define('DB_SGBD', 'mysql');
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PSWD', 'acessoweb');
	define('DB_NAME', 'filibras');
	define('DB_CHAR', 'utf8');
	
	// SMTP
	define('SMTP_HOST', 'mail.acessoweb.com');
	define('SMTP_PORT', '587');
	define('SMTP_USER', 'envio@acessoweb.com');
	define('SMTP_PSWD', 'env02320');
	define('SMTP_FROM', 'envio@acessoweb.com.br');
	define('SMTP_FNAME', 'Universidade');
		
} else if(@is_dir('/home/filibras/public_html/')){
	
	// PATH, URL e CHARSET
	define('PATH', '/home/filibras/public_html/');
	define('URL', 'http://sistemafilibras.com.br/');
	define('CHARSET', 'utf-8');
	
	// Banco de Dados
	define('DB_SGBD', 'mysql');
	define('DB_HOST', 'localhost');
	define('DB_USER', 'filibras');
	define('DB_PSWD', '02320brfil@#');
	define('DB_NAME', 'filibras_banco');
	define('DB_CHAR', 'utf8');
	
	// SMTP
	define('SMTP_HOST', 'mail.sistemafilibras.com.br');
	define('SMTP_PORT', '587');
	define('SMTP_USER', 'envio@sistemafilibras.com.br');
	define('SMTP_PSWD', 'env02320');
	define('SMTP_FROM', 'envio@sistemafilibras.com.br');
	define('SMTP_FNAME', 'Filibras');
		
} else {
	
	exit('Sistema indisponível!');
	
}

// Requisição do arquivo de PATH's e URL's
require(PATH.'lib/Path.php');

// Bootstrap Doctrine
require(PATH.'bootstrap.php');

// Funções Úteis
require(PATH.'lib/Util.php');

// Wide Image
require(PATH.'lib/WideImage/WideImage.php');

// PHPMailer
require(PATH.'lib/phpmailer/class.phpmailer.php');

//PFD
require(PATH.'lib/fpdf/fpdf.php');