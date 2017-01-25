<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>

<div id="body">

	<div class="block big"><!-- Block Begin -->

		<div class="titlebar">

			<h3>Peça e Material - Cadastrar</h3>

			<a href="#" class="toggle">&nbsp;</a>

		</div>

		<style type="text/css">

		.ui-multiselect-filter input{

			background: #fff;

		}

		.ui-multiselect-filter{

			margin-top: 8px;

		}

		</style>

		<script type="text/javascript" src='<?php URL ?>js/jquery.multiselect.filter.js'></script>

		<script type="text/javascript" src='<?php URL ?>css/jquery.multiselect.filter.css'></script>

		<div class="block_cont">

			<form class="form" action="<?php echo URL_ADMIN.'action/'.$_GET['model'].'/'.$_GET['action'].'/'; ?>" method="POST" id="form">



				<div class="form_row radioui">

					<label>Tipo de Material:</label>

					<div class="clear"></div>

					<input type="radio" id="tipo1" name="tipo" value="1" class="input"><label for="tipo1">Peça de Reposição</label>

					<!-- <input type="radio" id="tipo0" name="tipo" value="0" class="input validate[required]"><label for="tipo0">Material de Consumo</label> -->

					<input type="radio" id="tipo2" name="tipo" value="2" class="input"><label for="tipo0">Cilindro</label>

					<input type="radio" id="tipo3" name="tipo" value="3" class="input"><label for="tipo0">Toner</label>

					<input type="checkbox" id="cobranca" name="cobranca" value="1" class="input "><label for="cobranca">Cobrança</label>

				</div>

				

				<div class="form_row">

					<label>Valor:</label>

					<input type="text" name="valor" id="valor" class="input validate[maxSize[10,2]]" style="width: 120px;" />

				</div>

				

				<div class="clear"></div>

		

				<div class="form_row">

					<label>Peça e Material:</label>

					<input type="text" name="nome" id="nome" class="input validate[required,maxSize[60]]" style="width: 385px;" />

				</div>

				

		

				<div class="form_row">

					<label>Estoque Mínimo:</label>

					<input type="text" name="minimo" id="minimo" class="input validate[required,maxSize[60]]" style="width: 185px;" />

				</div>

				
		

				<div class="form_row">

					<label>Estoque:</label>

					<input type="text" name="estoque" id="estoque" class="input validate[required,maxSize[60]]" style="width: 185px;" />

				</div>

				

				<div class="clear"></div>


				<div class="form_row">

					<label>Localização:</label>

					<input type="text" name="localizacao" id="localizacao" class="input" style="width: 612px;" />

				</div>

				

				<div class="clear"></div>



				<div class="form_row">

					<label>Equipamento:</label>

					<select name="equipamento_id[]" id="equipamento_id" class="select2 validate[required]" style="width: 612px;" multiple="multiple">

						<?php 

						

						try {

							



							$resEquipamento =	Doctrine_Query::create()->select()->from('EquipamentoModelo em')

												->leftJoin('em.Marca m')->orderBy('m.nome ASC, em.nome ASC')->execute();

							

							if ($resEquipamento->count() > 0){

								$resEquipamento->toArray();

								

								foreach ($resEquipamento as $value){

									echo '<option value="'.$value['id'].'">'.$value->Marca->nome.' => '.$value->nome.'</option>';

								}

								

							} else {

								echo '<option value="">Nenhum equipamento disponível</option>';

							}

						

						} catch (Exception $e){

							echo $e->getMessage();

							echo '<option value="">Ocorreu um erro de sistema</option>';

						}

						

						

						?>

					</select>

				</div>

				

				<div class="clear"></div>

				<br />

				

				<div class="form_row"><input type="submit" class="submit" value="Salvar" /></div>

			</form>

			<script type="text/javascript">

				$('#equipamento_id').multiselect().multiselectfilter();

			</script>

		</div>

	</div><!-- Block End -->

</div><!-- Body Wrapper End -->