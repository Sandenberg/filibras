<?php defined('_SYSTEM') or exit('Direct access to the script is not allowed!'); ?>
<div id="body">
    <script type="text/javascript">
        $(document).ready(function(){
            
            $('#data_vencimento_I').mask('99/99/9999');
            $('#data_vencimento_F').mask('99/99/9999');
            $('#data_baixa_I').mask('99/99/9999');
            $('#data_baixa_F').mask('99/99/9999');

            $('.tipo').change(function(){
                if($(this).val() == 'credito'){
                    $('#cliente_id').parent().css('display', 'inline-block');
                    $('#beneficiario_id').parent().css('display', 'none');
                }else if($(this).val() == 'debito'){
                    $('#cliente_id').parent().css('display', 'none');
                    $('#beneficiario_id').parent().css('display', 'inline-block');
                }else{
                    $('#cliente_id').parent().css('display', 'none');
                    $('#beneficiario_id').parent().css('display', 'none');
                }
            });
        });

    </script>
	<div class="block big"><!-- Block Begin -->
		<div class="titlebar">
			<h3>Baixa de Lançamentos</h3>
			<a href="#" class="toggle">&nbsp;</a>
		</div>
		<div class="block_cont">
			<form class="form" action="<?php echo URL_ADMIN.''.$_GET['model'].'/detalhes/'; ?>" method="POST" id="form">
                

                <div class="form_row">
                    <input type="radio" name="tipo" id="tipoc" class="tipo radio validate[required,maxSize[60]]" checked value="credito" />
                    <label style="display: inline-block;" for='tipoc'>Crédito</label>
                </div>

                <div class="form_row">
                    <input type="radio" name="tipo" id="tipod" class="tipo radio validate[required,maxSize[60]]" value="debito" />
                    <label style="display: inline-block;" for='tipod'>Débito</label>
                </div>

                <div class="form_row">
                    <input type="radio" name="tipo" id="tipoc" class="tipo radio validate[required,maxSize[60]]" value="" />
                    <label style="display: inline-block;" for='tipoc'>Nenhuma das opções</label>
                </div>

                <div class="clear"></div>


                <div class="form_row">
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



                <div class="form_row" style='display: none'>
                    <label>Beneficiario:</label>
                    <select name="beneficiario_id" id="beneficiario_id" class="select" style="width: 215px;">
                        <option value=""></option>
                        <?php 
                        
                        try {
                        
                            $resBeneficiario = Doctrine_Query::create()->select()->from('Beneficiario')->orderBy('nome ASC')->execute();
                                        // 
                            if ($resBeneficiario->count() > 0){
                                $resBeneficiario->toArray();
                                
                                foreach ($resBeneficiario as $value){
                                    $id = $value['id'];
                                    $nome = $value['nome'];

                                    echo "<option value='$id'>$nome</option>";
                                }
                            
                            } else {
                                echo '<option value="">Ocorreu um erro de sistema</option>';
                            }
                        
                        } catch (Exception $e){
                            echo '<option value="">Ocorreu um erro de sistema'.$e.'</option>';
                        }
                        
                        
                        ?>
                    </select>
                </div>
                

				<div class="form_row">
					<label>Tipo:</label>
					<select name="lancamento_tipo_id" id="lancamento_tipo_id" class="select" style="width: 230px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resTipo = Doctrine_Query::create()->select()->from('LancamentoTipo')->orderBy('nome ASC')->execute();
							
							if ($resTipo->count() > 0){
								$resTipo->toArray();
								
								foreach ($resTipo as $value){
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
					<label>Conta:</label>
					<select name="conta_id" id="conta_id" class="select" style="width: 230px;">
						<option value=""></option>
						<?php 
						
						try {
						
							$resStatus = Doctrine_Query::create()->select()->from('Conta')->orderBy('nome ASC')->execute();
							
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
                <div class="clear"></div>
				
                <div class="form_row" style="margin-right: 20px;">
                    <label>Data de Vencimento:</label>
                    <input type="text" name="data_vencimento_I" id="data_vencimento_I" class="input data validate[custom[dateBR]]" style="width: 70px;" /> a
                    <input type="text" name="data_vencimento_F" id="data_vencimento_F" class="input data validate[custom[dateBR]]" style="width: 70px;" />
                </div>
                

				<div class="clear"></div><br />
				
				<div class="form_row"><input type="submit" class="submit" value="Gerar a lista" /></div>
			</form>
		</div>
	</div><!-- Block End -->
</div><!-- Body Wrapper End -->