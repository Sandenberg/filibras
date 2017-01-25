<?php 

require_once('lib/Config.php'); 

// Checa o usuário está logado
if (Util::checkLoginAdmin()){
	header('Location: '.URL_ADMIN);
	exit;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Autenticação - <?php echo TITLE_DEFAULT; ?></title>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.corner.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo URL_ADMIN_JS; ?>js.js"></script>
<link rel="stylesheet" href="<?php echo URL_ADMIN_CSS; ?>reset.css" type="text/css" />
<link rel="stylesheet" href="<?php echo URL_ADMIN_CSS; ?>style.css" type="text/css" />
<link rel="stylesheet" href="<?php echo URL_ADMIN_CSS; ?>grid.css" type="text/css" />
</head>
<body>
	<div id="loginbox">
		<div id="logo">IBA Concursos</div>
		<?php if (isset($_SESSION['return_message'])){ ?>
		<div class="<?php echo $_SESSION['return_type']; ?>">
			<h3><?php echo $_SESSION['return_message']; ?></h3>
			<a href="#" class="hide_btn">&nbsp;</a>
		</div>
		<?php } ?>
		<div id="loginform">
			<form id="login" action="<?php echo URL_ADMIN.'authentication/'; ?>" method="post">
				<div id="username_field"><input type="text" name="login" <?php echo 'placeholder="Usuário"'; ?> class="required" value="" /></div>
				<div id="password_field"><input type="password" name="senha" <?php echo 'placeholder="Senha"'; ?> class="required" value="" /></div>
				<div id="buttonline">
					<input type="submit" id="loginbutton" class="float_left width_4" value="Entrar" />
				</div>
			</form>
		</div>
	</div>
</body>
</html>