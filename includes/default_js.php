<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>ui/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.corner.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>css_browser_selector.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.jqplot.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>plugins/jqplot.highlighter.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>plugins/jqplot.cursor.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>plugins/jqplot.pieRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>plugins/jqplot.barRenderer.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>editor/jquery.cleditor.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>calendar/fullcalendar.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.multiselect.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.multiselectfilter.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>tooltip/jquery.tipsy.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>validation/jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>validation/languages/jquery.validationEngine-pt.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>fancybox/jquery.easing-1.4.pack.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.maskMoney.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.maskedinput-1.3.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>js.js"></script>
<?php 

$js_file = '';

// Verificação para abertura de um arquivo específico para o módulo
if (isset($_GET['model']) && isset($_GET['action'])){
	$js_file = URL_ADMIN.'app/'.$_GET['model'].'/js/'.$_GET['action'].'.js';
	if (file_exists(PATH_ADMIN.'app/'.$_GET['model'].'/js/'.$_GET['action'].'.js')){
		echo '<script type="text/javascript" src="'.$js_file.'"></script>';
	}
} else if (isset($_GET['model'])){
	$js_file = URL_ADMIN.'app/'.$_GET['model'].'/js/listar.js';
	if (file_exists(PATH_ADMIN.'app/'.$_GET['model'].'/js/listar.js')){
		echo '<script type="text/javascript" src="'.$js_file.'"></script>';
	}
} else {
	$js_file = URL_ADMIN.'app/perfil/js/editar.js';
	if (file_exists(PATH_ADMIN.'app/perfil/js/editar.js')){
		echo '<script type="text/javascript" src="'.$js_file.'"></script>';
	}
}

unset($js_file);

?>
<script type="text/javascript" src="<?php echo URL_ADMIN ?>js/jquery.dataTables.columnFilter.js"></script>