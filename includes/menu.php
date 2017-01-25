<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<ul id="navigation"><!-- Main Navigation Begin -->
	<?php 
	
	try {

		$objPermissao = new UsuarioPermissao();
		$objPermissao->getMenu(0);
	
	} catch (Exception $e){
		$return_type	= 'error';
		$return_message	= 'Ocorreu um erro de permissão.';
	}
	
	unset($objPermissao);
	
	?>
	<li><a href="<?php echo URL_ADMIN.'logout/'; ?>" class="icon_logout">Sair</a></li>
</ul><!-- Main Navigation End -->