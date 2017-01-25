<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="header"><!-- Header Begin -->
	<div class="grid_3"><a href="<?php echo URL_ADMIN; ?>" id="logo" class="float_left"></a></div>
</div><!-- Header End -->
<?php if($_SESSION['sess_usuario_grupo_id'] == 1){ ?>
	<?php
			$where	 	= 	"'".date("Y-m-d", strtotime(date("Y-m-d")."+35 days"))."' > data_fim and tipo <> 1";
			$retAll		= 	Doctrine_Query::create()->select()->from('Contrato c')
									->where($where)->execute();
	?>
	<div style="float: right; height: 60px; width: 400px; margin: 0px 20px 0px; text-align: right; font-size: 24px" class="contratos-vencer">
		<a href="<?php echo URL_ADMIN; ?>contrato/vencido_listar/" style="text-decoration: none; color: #fff;">Contratos a vencer: (<?php echo $retAll->count(); ?>)</a>
		<br><br>
		<?php 
			
            $where      =   "'".date("Y-m-d")."' > data_vencimento and data_baixa is null";
			$retAll		= 	Doctrine_Query::create()->select()->from('Lancamento l')
                                        ->leftJoin("l.Cliente cl")->leftJoin('l.LancamentoTipo lt')->innerJoin('cl.Filial f')
										->where($where)->orderBy('data_lancamento asc')->execute();
		?>
		<a href="<?php echo URL_ADMIN; ?>credito/vencido_listar/" style="text-decoration: none; color: #fff; font-size: 18px; padding-right: 10px;">Lançamentos vencidos: (<?php echo $retAll->count(); ?>)</a>
		<!-- <br><br> -->
		<!-- Contratos vencidos: () -->
	</div>

    <style type="text/css" media="print">
        .contratos-vencer{
            display: none;
        }

    </style>
<?php } ?> 
<div class="clear"></div>

<?php 
	// if(isset($_GET['ativo'])&&$_GET['ativo']==1){
		?><div class='div-tecnicos '><?php
		$where = "usuario_grupo_id = 4 or usuario_grupo_id = 5";
		$retUsuario		= 	Doctrine_Query::create()->select()->from('Usuario u')->where($where)->execute();
		foreach ($retUsuario as $objUsuario) {

			$where2 = "f.audit = ".$objUsuario->id." and f.data_final between '".date('Y-m-01 00:00:00')."' and '".date('Y-m-t 23:59:59')."'";
			
			$retAll		= 	Doctrine_Query::create()->select()->from('FinalizarOrdemServico f')->leftJoin('f.OrdemServico o')->where($where2)->groupBy('f.id_ordem_servico');

			?>
				<div class='div-tecnico <?php echo $objUsuario->id ?>'><a style="color:#fff; text-decoration: none;" href="<?php echo URL_ADMIN."relatorio-ordem-servico/?usuario=".$objUsuario->id ?>"><?php echo $objUsuario->apelido ?> (<?php echo $retAll->count(); ?>)</a></div>
			<?php
		}
		?></div><?php
	// }
?>
<style type="text/css">
	.div-tecnicos{
		position: absolute;
	    top: 60px;
	    left: 290px;
	}
	.div-tecnico{
	    float: left;
	    margin-right: 20px;
	    font-weight: 600;
	    font-size: 16px;
	}

</style>