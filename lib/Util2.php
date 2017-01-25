<?php

/**
 * Classe para verificações e execuções úteis
 */
abstract class Util {
	
	/**
	 * Debug de erros
	 */
	static function debug($var){
		echo '<pre>';
		print_r($var);
	}
	
	/**
	 * Checa Login para o Gerenciador
	 */
	static function checkLoginAdmin(){
		if (isset($_SESSION['sess_usuario_id']) 
			&& isset($_SESSION['sess_usuario_grupo_id'])){
			
			return true;
			
		} else { 
			return false;
		}
	}
	
	/**
	 * Checagem de Tipos de Imagem
	 * @return string Tipo da Imagem
	 */
	static function checkImageType($type,$flag = ''){
		// Tipo de Arquivo (Extensão ou Mime)
		$imageType = '';
		
		// Extensão por Mime
		$ext = array(
			'image/gif'	=> 'gif',
			'image/jpeg'=> 'jpg',
			'image/png'	=> 'png'	
		);
		
		// Mime por Extensão
		$mime = array(
			'gif' => 'image/gif',
			'jpg' => 'image/jpeg',
			'png' => 'image/png'
		);
		
		// Verifica o Tipo de Busca
		if ($flag == 'mime'){
			
			// Verifica se o MIME está cadastrado
			if (isset($mime[$type])){
				$imageType = $mime[$type];
			} else {
				return false;
			}
			
		} else {
			
			// Verifica se o MIME está cadastrado
			if (isset($ext[$type])){
				$imageType = $ext[$type];
			} else {
				return false;
			}
			
		}
		
		return $imageType;
		
	}

	/**
	 * Checagem de Tipos de Arquivos
	 * @return string Tipo do Arquivo
	 */
	static function checkFileType($type,$flag = ''){
		// Tipo de Arquivo (Extensão ou Mime)
		$imageType = '';
	
		// Extensão por Mime
		$ext = array(
			'application/pdf'							=> 'pdf',
			'application/x-unknown-content-type-text'	=> 'pdf'
		);
	
		// Mime por Extensão
		$mime = array(
			'pdf' => 'application/pdf',
			'pdf' => 'application/x-unknown-content-type-text'
		);
	
		// Verifica o Tipo de Busca
		if ($flag == 'mime'){
				
			// Verifica se o MIME está cadastrado
			if (isset($mime[$type])){
				$imageType = $mime[$type];
			} else {
				return false;
			}
				
		} else {
				
			// Verifica se o MIME está cadastrado
			if (isset($ext[$type])){
				$imageType = $ext[$type];
			} else {
				return false;
			}
				
		}
	
		return $imageType;
	
	}
	
	/**
	 * Upload de Imagens
	 */
	static function uploadImage($pathFile, $pathDestination, $ext, $name = '', 
			 $width = NULL, $height = NULL){

		// Verifica se o usuário enviou um nome, caso contrário gera um novo
		$name = $name==''?md5(date('YmdHis')):$name;
			
		// Path para gravação da Imagem
		$imgPath = $pathDestination.$name.'.'.$ext;
		
		// Grava o arquivo
		$img = WideImage::load($pathFile);
		$img = $img->resize($width,$height,'inside');
		$img->saveToFile($imgPath);
		
		return $name;
	
	}
	
	/**
	 * Upload de Arquivos
	 */
	static function uploadFile($pathFile, $pathDestination, $ext, $name = ''){
	
		// Verifica se o usuário enviou um nome, caso contrário gera um novo
		$name = $name==''?md5(date('YmdHis')):$name;
			
		// Path para gravação da Imagem
		$filePath = $pathDestination.$name.'.'.$ext;
	
		// Grava o arquivo
		move_uploaded_file($pathFile, $filePath);
	
		return $name;
	
	}
	
	/**
	 * Conversão de data PTBR => EN
	 */
	static function dateConvert($date){
		$aux 	= explode('/',$date);
		$date 	= $aux[2].'-'.$aux[1].'-'.$aux[0];
		
		return $date;
	}
	
	/**
	 * Limpeza de string para geração de URL amigável
	 */
	static function getCleanUrl($string){
		// Caracteres especiais
		$caracter =	array('.','´','`','¨','^','~','$','!',',',';',':','?',
					'[','@','#','%','&','*','(',')','_','+','{','}','<','>','/',
					'=','º','ª','¹','²','³','£','¢','¬','§',']',"'");
		
		// Retirada de caracteres especiais
		$string = str_replace($caracter, '-', $string);

		// Letras acentuadas
		$acentos = 	array(
					'A' => '/À|Á|Â|Ã|Ä|Å/',
					'a' => '/à|á|â|ã|ä|å/',
					'C' => '/Ç/',
					'c' => '/ç/',
					'E' => '/È|É|Ê|Ë/',
					'e' => '/è|é|ê|ë/',
					'I' => '/Ì|Í|Î|Ï/',
					'i' => '/ì|í|î|ï/',
					'N' => '/Ñ/',
					'n' => '/ñ/',
					'O' => '/Ò|Ó|Ô|Õ|Ö/',
					'o' => '/ò|ó|ô|õ|ö/',
					'U' => '/Ù|Ú|Û|Ü/',
					'u' => '/ù|ú|û|ü/',
					'Y' => '/Ý/',
					'y' => '/ý|ÿ/',
					'a.' => '/ª/',
					'-' => '/ |"|ˆ|´|•/',
					'o.' => '/º/'
		);
		
		$res = preg_replace($acentos, array_keys($acentos), $string);
		$res = str_replace('----', '-', $res);
		$res = str_replace('---', '-', $res);
		$res = str_replace('--', '-', $res);

		$exp = strrev($res);
		$exp = substr($exp, 0, 1);
		
		if($exp == '-'){
			$res = substr($res, 0, (strlen($res)-1));
		}

		return strtolower($res);
	}
	
	/**
	 * Geração de mascaras
	 * @param string $mask
	 * @param string $string
	 */
	static function mask($mask,$string){
	
		if ($string == '')
			return $string;
	
		$string = str_replace(' ','',$string);
	
		for($i=0;$i<strlen($string);$i++){
			$mask[strpos($mask,"#")] = $string[$i];
		}
		return $mask;
	}
	
	/**
	 * Seleciona apenas os números da string
	 */
	static function getNumbers($string){
		return preg_replace('/[^0-9]/','',$string);
	}
	
	/**
	 * Geração de senha aleatória
	 */
	static function randPswd(){
		// Caracteres para geração da senha
		$chars 		= 'abcdxywzABCDZYWZ0123456789!@#$%&*/_-+=';

		// Valor máximo para a função rand()
		$max 		= strlen($chars)-1;
		
		// String com o novo password
		$pswd	 	= null;
		
		// Repetição para a geração no novo password
		for($i=0; $i < 8; $i++){
			$pswd .= substr($chars, rand(0, $max),1);
		}
		
		return $pswd;
	}
	
	/**
	 * Validação de CPF
	 */
	static function checkCPF($cpf){
		$cpf = preg_replace('/[^0-9]/', '', $cpf);
		$digitoUm	= 0;
		$digitoDois	= 0;
	
		for ($i = 0, $x = 10; $i <= 8; $i++, $x--){
			$digitoUm += $cpf[$i] * $x;
		}
		
		for ($i = 0, $x = 11; $i <= 9; $i++, $x--){
			
			if(str_repeat($i, 11) == $cpf){
				return false;
			}
			
			$digitoDois += $cpf[$i] * $x;
		}

		$calculoUm  = (($digitoUm%11) < 2) ? 0 : 11-($digitoUm%11);
		$calculoDois = (($digitoDois%11) < 2) ? 0 : 11-($digitoDois%11);

		if($calculoUm <> $cpf[9] || $calculoDois <> $cpf[10]){
			return false;
		}
		
		return true;
	}
	
	/**
	 * Pega o código do vídeo do Youtube de vários tipos de string de URL/EMBED
	 */
	static function getYoutubeId($string){
		preg_match('#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#', $string, $string);
		
		// Verifica se houve retorno
		if (is_array($string) && count($string) > 0){
			return $string[0];
		} else {
			return false;
		}
	}
	
	
	/**
	 * Cria o registro de log
	 */
	static function regLog($modulo, $codigo, $acao){
		$registro 					= new Log();
		$registro->data_alteracao 	= date('Y-m-d H:i:s');
		$registro->modulo 			= $modulo;
		$registro->codigo 			= $codigo;
		$registro->acao 			= $acao;
		$registro->usuario_id		= $_SESSION['sess_usuario_id'];
		$registro->save();
	}
}