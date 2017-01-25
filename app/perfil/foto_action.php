<?php

defined('_ACTION') or exit('Direct access to the script is not allowed!');

try {
	
	if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0){
	
		// Pega o Tipo do Arquivo
		$fileType = Util::checkImageType($_FILES['avatar']['type']);
		
		// Verifica se é um tipo de arquivo permitido
		if ($fileType){
			
			$objUsuario = Doctrine_Core::getTable('Usuario')->find($_SESSION['sess_usuario_id']);
	
			// Pega o avatar anterior (caso possua)
			$avatarAnterior = $objUsuario->avatar;
			
			$avatar = Util::uploadImage($_FILES['avatar']['tmp_name'],
						PATH_USUARIO, $fileType, '', 44, 44);
			
			if ($avatar != ''){
				// Gera o THUMB
				Util::uploadImage($_FILES['avatar']['tmp_name'],
						PATH_USUARIO_THUMB, $fileType, $avatar, 44, 44);
				
				// Apaga os avatares anteriores
				@unlink(PATH_USUARIO.$avatarAnterior);
				@unlink(PATH_USUARIO_THUMB.$avatarAnterior);

				// Insere o novo arquivo no cadastro do usuário
				$objUsuario->avatar = $avatar.'.'.$fileType;
				$objUsuario->save();
				
				// Tratamento de retorno
				$_SESSION['return_type'] 	= 'success';
				$_SESSION['return_message']	= 'Executado com sucesso!';
				
			} else {
				// Tratamento de retorno
				$_SESSION['return_type']	= 'error';
				$_SESSION['return_message'] = 'A foto não foi carregada para o servidor!';
			}
			
		} else {
			
			// Tratamento de retorno
			$_SESSION['return_type'] 	= 'error';
			$_SESSION['return_message']	= 'Tipo de arquivo não permitido!';
			
		}
		
	} else {
		
		// Tratamento de retorno
		$_SESSION['return_type'] 	= 'error';
		$_SESSION['return_message']	= 'O arquivo para upload não foi encontrado!';
		
	}

} catch(Exception $e){
	
	// Tratamento de retorno
	$_SESSION['return_type'] 	= 'error';
	$_SESSION['return_message']	= 'Ocorreu um erro, tente novamente!';
	
}

// Redirecionamento para a página principal do módulo
header('Location: '.URL_ADMIN);