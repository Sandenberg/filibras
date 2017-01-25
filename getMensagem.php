<?php 
	include('lib/Config.php');

	if($_SESSION['sess_usuario_grupo_id']==4){

		$retUsuario	= Doctrine_Core::getTable('Usuario')->findByUsuarioGrupoId(4);

		foreach ($retUsuario as $objUsuario) {
			$recebida_por[] = "recebida_por = '".$objUsuario->id."'";
		}

		$where = "lida = 0 and (".implode(" or ", $recebida_por).")";

	}else if($_SESSION['sess_usuario_grupo_id']==1){
			$where = "lida = 0 and enviada_por <> '".$_SESSION['sess_usuario_id']."'";
	}else{
		$where = "lida = 0 and recebida_por = '".$_SESSION['sess_usuario_id']."'";

	}
	$retMensagem	= Doctrine_Query::create()->select()->from('Mensagem u')->where($where)->orderBy('data_mensagem asc')->execute();
	ob_start();
	foreach ($retMensagem as $objMensagem) {
		$objUsuario	= Doctrine_Core::getTable('Usuario')->find($objMensagem->enviada_por);
		$objUsuario2	= Doctrine_Core::getTable('Usuario')->find($objMensagem->recebida_por);

		?>
			<li codigo='<?php echo $objMensagem->id ?>'>
				<a href="<?php echo $_SESSION['sess_usuario_id']==$objMensagem->recebida_por||$_SESSION['sess_usuario_grupo_id']==1?URL_ADMIN.'mensagem/visualizar/'.$objMensagem->id:URL_ADMIN.'mensagem'; ?>/" style='color: #333'>
					<span style='float: right; width: 90px; text-align: right'><?php echo $objUsuario2->nome ?></span>
					<span style='float: right; width: 30px; font-weight: 400; text-align: center'>para</span>
					<span style='float: right; width: 90px;'><?php echo $objUsuario->nome ?></span> 
					<label class='time'><?php echo date('H:i:s', strtotime($objMensagem->data_mensagem)) ?></label>
					<?php echo $objMensagem->titulo ?>
				</a>
			</li>
		<?php
	}
	$content = ob_get_contents();
	ob_end_clean();

	echo json_encode(array('count'=>$retMensagem->count(), 'content'=>$content));
?>