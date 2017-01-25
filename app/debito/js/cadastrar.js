$(document).ready(function(){
        
        $('#data_periodo').mask('99/99/9999');
        $('#vencimento').mask('99/99/9999');
        $('#lancamento_nf').mask('99/99/9999');

        function adicionarDias(data, dias){

                dataS = data.split("/");
                dataD = new Date(dataS[2], dataS[1], dataS[0], '0', '0', '0', '0');

                var data2 = new Date(dataD.getTime() + (dias * 24 * 60 * 60 * 1000));
                var dia = data2.getDate();
                if (dia.toString().length == 1)
                        dia = "0"+dia;
                var mes = data2.getMonth();
                if (mes.toString().length == 1)
                        mes = "0"+mes;
                var ano = data2.getFullYear();  

                if(mes == "00"){
                        mes = 12;
                        ano = ano--;
                }

                return dia+"/"+mes+"/"+ano;

        }

        function adicionarMeses(data, meses){
                // console.log(data);
                dataS = data.split("/");
                dia = dataS[0];
                mes = dataS[1];
                ano = dataS[2];
                
                mes = eval(parseInt(mes) + parseInt(meses));
                if(mes > 12){
                        mes = mes - 12;
                        ano++;
                }
                console.log(dia+"/"+mes+"/"+ano);
                
                if (dia.toString().length == 1)
                        dia = "0"+dia;
                if (mes.toString().length == 1)
                        mes = "0"+mes;
                return dia+"/"+mes+"/"+ano;

        }

        $( "#parcelado" ).on( "click", function() {
                console.log($("#parcelado:checked").val());
                if($("#parcelado:checked").val() == 'Sim'){
                        $('#qtdparcela').css('display', 'inline-block');
                        $('.venc').css('display', 'none');
                }
                else{
                        $('#qtdparcela').css('display', 'none');
                        $('.venc').css('display', 'inline-block');
                        $('#valueparcelas').html('');
                        $('#parcelas').val('0');
                }
        });

        $('.tipo').change(function(){
                if($(this).val() == 'credito'){
                        $('#cliente_id').parent().css('display', 'inline-block');
                        // $('#fornecedor_id').parent().css('display', 'none');
                        $('#beneficiario_id').parent().css('display', 'none');
                }else{
                        $('#cliente_id').parent().css('display', 'none');
                        // $('#fornecedor_id').parent().css('display', 'inline-block');
                        $('#beneficiario_id').parent().css('display', 'inline-block');
                }
        });


        $('#parcelas').change(function(){
                var campos = '';

                // CÁLCULO DO VALOR
                var total = $('#valor').val();
                var periodo = $('#periodo').val();
                var data = $('#data_periodo').val();
                total = total.replace(',', '.');
                var valor_parcela = total / $(this).val();

                parcela_arredondada = valor_parcela.toFixed(2) * $(this).val();
                parcela_arredondada = parcela_arredondada;
                parcela_arredondada = total - parcela_arredondada;

                // CÁLCULO DA DATA

                for (var i = 1; i <= $(this).val(); i++) {

                        // SETAR A ULTIMA PARCELA PARA ARREDONDAR O VALOR PARA O CORRETO
                        if(i == $(this).val())
                                valor = valor_parcela + parcela_arredondada;
                        else
                                valor = valor_parcela;

                        campos = campos+''+
                                '<div class="form_row" style="margin-right: 10px;">'+
                                        '<label>Valor ('+i+'ª parcela):</label>'+
                                        '<input type="text" name="valor_parc[]" id="valor_parc'+i+'" class="input validate[required,maxSize[60]]" style="width: 100px;" value="'+valor.toFixed(2)+'" />'+
                                '</div>'+
                                '<div class="form_row">'+
                                        '<label>Vencimento:</label>'+
                                        '<input type="text" name="vencimento_parc[]" id="vencimento_parc'+i+'" class="input validate[maxSize[60],custom[dateBR]]" style="width: 102px;" value="'+data+'" />'+
                                '</div>'+
                                '<div class="clear"></div>';

                        // ADICIONA DE ACORDO COM O TIPO
                        if(periodo == 1){
                                console.log(data);
                                data = adicionarDias(data, 1);
                        }
                        else if(periodo == 2){
                                data = adicionarDias(data, 7);
                        }
                        else if(periodo == 3){
                                data = adicionarMeses(data, 1);
                        }
                        else if(periodo == 4){
                                data = adicionarMeses(data, 3);
                        }
                        else if(periodo == 5){
                                data = adicionarMeses(data, 6);
                        }
                        else if(periodo == 6){
                                data = adicionarMeses(data, 12);
                        }
                };
                
                $('#valueparcelas').html(campos);
        });

        function addDiario(){

        }

        $("#tipo_nf_id").change(function(){
            if($(this).val() != ''){
                $('#nf').parent().css('display', 'inline-block');
                $('#lancamento_nf').parent().css('display', 'inline-block');
            }else{
                $('#nf').parent().css('display', 'none');
                $('#lancamento_nf').parent().css('display', 'none');
            }
        });

        
    $("#nf").change(function(){
        $.getJSON(URL_ADMIN+"getNf.php",{nf: jQuery(this).val()}, function(j){
            if(j.total > 0){
                alert('NF JÁ CADASTRADA PARA "'+j.cliente+'"');
            }

        });
    });
});