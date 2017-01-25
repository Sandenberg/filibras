<?php 
defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); 
    

?>
<div id="body">
    <script type="text/javascript">
        $(document).ready(function(){
            
            $('#data_periodo_I').mask('99/99/9999');
            $('#data_periodo_F').mask('99/99/9999');

            $('.tipo').change(function(){
                if($(this).val() == 'tecnico'){
                    $('#usuario_id').parent().css('display', 'inline-block');
                    $('#ordem').parent().css('display', 'none');
                    $('#cliente_id').parent().css('display', 'none');
                }else if($(this).val() == 'cliente'){
                    $('#usuario_id').parent().css('display', 'none');
                    $('#cliente_id').parent().css('display', 'inline-block');
                    $('#ordem').parent().css('display', 'none');
                }else{
                    $('#usuario_id').parent().css('display', 'none');
                    $('#cliente_id').parent().css('display', 'none');
                    $('#ordem').parent().css('display', 'inline-block');
                }
            });

            $('#periodo').change(function(){
                if($(this).val() == 1){
                    $('#data_periodo_I').val('<?php echo date('d/m/Y') ?>');
                    $('#data_periodo_F').val('<?php echo date('d/m/Y') ?>');
                }else if($(this).val() == 2){
                    $('#data_periodo_I').val('<?php echo date('d/m/Y', strtotime('-7 days')) ?>');
                    $('#data_periodo_F').val('<?php echo date('d/m/Y') ?>');
                }else if($(this).val() == 3){
                    $('#data_periodo_I').val('<?php echo date('d/m/Y', strtotime('-1 month')) ?>');
                    $('#data_periodo_F').val('<?php echo date('d/m/Y') ?>');
                }else if($(this).val() == 4){
                    $('#data_periodo_I').val('<?php echo date('d/m/Y', strtotime('-1 year')) ?>');
                    $('#data_periodo_F').val('<?php echo date('d/m/Y') ?>');
                }else if($(this).val() == 5){
                    $('#data_periodo_I').val('');
                    $('#data_periodo_F').val('');
                }
            });

        });

    </script>
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Relatório de Lançamentos</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<form class="form"  autocomplete="off" action="<?php echo URL_ADMIN.''.$_GET['model'].'/detalhes/'; ?>" method="POST" id="form">
                
                <div class="form_row">
                    <label>Tipo:</label>
                </div>

                <div class="clear"></div>

                <div class="form_row">
                    <input type="radio" name="tipo" id="tipoc" class="tipo radio validate[required,maxSize[60]]" checked value="tecnico" />
                    <label style="display: inline-block;" for='tipoc'>Técnico</label>
                </div>

                <div class="form_row">
                    <input type="radio" name="tipo" id="tipod" class="tipo radio validate[required,maxSize[60]]" value="cliente" />
                    <label style="display: inline-block;" for='tipod'>Cliente</label>
                </div>

                <div class="form_row">
                    <input type="radio" name="tipo" id="tipon" class="tipo radio validate[required,maxSize[60]]" value="ordem" />
                    <label style="display: inline-block;" for='tipon'>Ordem de Serviço</label>
                </div>

                <div class="clear"></div>


                <div class="form_row" style="display:none">
                    <label>Cliente:</label>
                    <select name="cliente_id" id="cliente_id" class="select" style="width: 215px;">
                        <option value=""></option>
                        <?php 
                        
                        try {
                        
                            $resCliente = Doctrine_Query::create()->select('c.id, c.nome_completo, c.filial_id')->from('Cliente c')->orderBy('nome_completo ASC')->execute();
                                        
                            if ($resCliente->count() > 0){
                                $resCliente->toArray();
                                
                                foreach ($resCliente as $value){
                                    $resFilial = Doctrine_Core::getTable('Filial')->find($value['filial_id']);
                                    $filial = $resFilial->nome;
                                    $id = $value['id'];
                                    $nome = $value['nome_completo'];
                                    echo "<option value=$id>$nome - $filial</option>";
                                }
                                
                            } else {
                                echo '<option value="">Ocorreu um erro de sistema</option>';
                            }
                        
                        } catch (Exception $e){
                            echo '<option value="">Ocorreu um erro de sistema</option>';
                        }
                        
                        
                        ?>
                    </select>
                </div>

				<div class="form_row" style="display:none">
					<label>Ordem de serviço:</label>
					<select name="ordem" id="ordem" class="select" style="width: 230px;">
                        <option value="">Todos</option>
                        <option value="0">Manutenção no Equipamento</option>
                        <option value="1">Troca de Cilindro/Toner</option>
                        <option value="2">Leitura de Numerador</option>
                        <option value="3">Instalação de Equipamento</option>
                        <option value="5">Retirada de Equipamento</option>
                        <option value="6">Manutenção Preventiva</option>
                        <option value="7">Serviços de Informática</option>
                        <option value="8">Acesso Remoto</option>
					</select>
				</div>
				
				<div class="form_row">
					<label>Usuario:</label>
					<select name="usuario_id" id="usuario_id" class="select" style="width: 230px;">
						<option value="">Todos</option>
						<?php 
						
						try {
						
							$resStatus = Doctrine_Query::create()->select()->from('Usuario')->where('id <> 1 and status = 1 and id <> 9')->orderBy('nome ASC')->execute();
							
							if ($resStatus->count() > 0){
								$resStatus->toArray();
								
								foreach ($resStatus as $value){
									echo '<option value="'.$value['id'].'">'.$value['nome'].'</option>';
								}
								
							} else {
								echo '<option value="">Nenhum registro encontrado.</option>';
							}
						
						} catch (Exception $e){
							echo '<option value="">Ocorreu um erro de sistema</option>';
						}
						
						
						?>
					</select>
				</div>
				

                <div class="form_row">
                    <label>Período:</label>
                    <select name="periodo" id="periodo" class="select" style="width: 230px;">
                        <option value=""></option>
                        <option value="1"/>Diário</option>
                        <option value="2"/>Semanal</option>
                        <option value="3"/>Mensal</option>
                        <option value="4"/>Anual</option>
                        <option value="5"/>Especifico</option>
                    </select>
                </div>
                
                
                <div class="form_row">
                    <label>Data do Periodo:</label>
                    <input type="text" name="data_periodo_I" id="data_periodo_I" class="input data validate[custom[dateBR]]" style="width: 70px;" /> a
                    <input type="text" name="data_periodo_F" id="data_periodo_F" class="input data validate[custom[dateBR]]" style="width: 70px;" />
                </div>

				<div class="clear"></div><br />
				
				<div class="form_row"><input type="submit" class="submit" value="Gerar o relatório" /></div>
			</form>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->