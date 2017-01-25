<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<link rel="stylesheet" href="<?php echo URL_ADMIN_CSS; ?>reset.css" type="text/css" />
<link rel="stylesheet" href="<?php echo URL_ADMIN_CSS; ?>grid.css" type="text/css" />
<link rel="stylesheet" href="<?php echo URL_ADMIN_CSS; ?>style.css" type="text/css" />
<link rel="stylesheet" href="<?php echo URL_ADMIN_JS; ?>plugins.css" type="text/css" />
<link rel="stylesheet" href="<?php echo URL_ADMIN_CSS; ?>multiselectfilter.css" type="text/css" />
<?php 

$css_file = '';

// Verificação para abertura de um arquivo específico para o módulo
if (isset($_GET['model']) && isset($_GET['action'])){
	$css_file = URL_ADMIN.'app/'.$_GET['model'].'/css/'.$_GET['action'].'.css';
	if (file_exists(PATH_ADMIN.'app/'.$_GET['model'].'/css/'.$_GET['action'].'.css')){
		echo '<link rel="stylesheet" href="'.$css_file.'" type="text/css" />';
	}
} else if (isset($_GET['model'])){
	$css_file = URL_ADMIN.'app/'.$_GET['model'].'/css/listar.css';
	if (file_exists(PATH_ADMIN.'app/'.$_GET['model'].'/css/listar.css')){
		echo '<link rel="stylesheet" href="'.$css_file.'" type="text/css" />';
	}
} else {
	$css_file = URL_ADMIN.'app/perfil/css/editar.css';
	if (file_exists(PATH_ADMIN.'app/perfil/css/editar.css')){
		echo '<link rel="stylesheet" href="'.$css_file.'" type="text/css" />';
	}
}

unset($css_file);

?>