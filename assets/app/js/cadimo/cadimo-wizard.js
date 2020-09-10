// Forms Demo
// ----------------------------------- 

(function(window, document, $, undefined){

  $(function(){

    var form = $("#form-cadastro-imovel");
    form.validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
        rules: {
        }
    });
    
    form.children("div").steps({
        labels: {
            cancel: "Cancelar",
            current: "etapa atual:",
            pagination: "Paginação",
            finish: "Concluir",
            next: "Próximo",
            previous: "Anterior",
            loading: "Carregando..."    
        },
        
        headerTag: "h4",
        
        bodyTag: "fieldset",
        transitionEffect: "slideLeft",
        onInit: function (event, currentIndex){
            toggleFields();
            if(currentIndex == 0){
                resizeJquerySteps();
            }

            $("#data_inicio_contrato").datepicker({
                numberOfMonths: 3,
                dateFormat: 'dd/mm/yy',
                dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
                dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
                dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
                monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
                nextText: 'Próximo',
                prevText: 'Anterior',
                onClose: function( selectedDate ) {
                    $( "#data_fim_contrato" ).datepicker( "option", "minDate", selectedDate );
                }
            });

            $("#data_fim_contrato").datepicker({
                numberOfMonths: 3,
                dateFormat: 'dd/mm/yy',
                dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
                dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
                dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
                monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
                nextText: 'Próximo',
                prevText: 'Anterior',
                onClose: function( selectedDate ) {
                    $( "#data_inicio_contrato" ).datepicker( "option", "maxDate", selectedDate );
                }
            });
            
        },
        onStepChanged: function(event, currentIndex, priorIndex){
            toggleFields();
            resizeJquerySteps();
            checkComissoes();
            if (typeof updateRemoverProprietarioButton !== 'undefined' && $.isFunction(updateRemoverProprietarioButton)) {
                updateRemoverProprietarioButton();
            }
        },
        onStepChanging: function (event, currentIndex, newIndex)
        {

            form.validate().settings.ignore = ":disabled,:hidden,.required-before";
            
            var id = form.find("#nidcadimo").val();
            var etapa = form.find("#etapa").val();

            if (!form.valid()){
                resizeJquerySteps();
                return false;
            } else {

                if (etapa == "geral"){

                    /* Validar proprietários */

                    var lista_proprietarios = new Array();

                    var erro_proprietarios = false;                    

                    var total_percentual = 0;

                    var total_proprietarios = 0;

                    $(".proprietario").each(function(){
                        var percentual = $(this).find("[name='percentualproprietario[]']").val();
                        var nome = $(this).find("[name='nomecpfproprietario[]']").val();
                        var id = $(this).find("[name='idcpfproprietario[]']").val();
                        if (!nome && !percentual){
                            $(this).find("[name='idcpfproprietario[]']").val("");
                            return true;
                        }
                        if (nome && (!id || id == "" || id == "0" || id === undefined)){
                            erro_proprietarios = true;
                            alert("O parceiro informado não está cadastrado");
                            $(this).find("[name='nomecpfproprietario[]']").addClass("error").removeClass("valid").attr("aria-invalid", "true").focus();
                            return false;
                        }
                        if (nome && !percentual){
                            erro_proprietarios = true;
                            alert("Percentual em branco");
                            $(this).find("[name='percentualproprietario[]']").addClass("error").removeClass("valid").attr("aria-invalid", "true").focus();
                            return false;
                        }
                        if (!nome && percentual){
                            erro_proprietarios = true;
                            alert("Nome do parceiro em branco");
                            $(this).find("[name='nomecpfproprietario[]']").addClass("error").removeClass("valid").attr("aria-invalid", "true").focus();
                            return false;
                        }
                        if (nome && percentual && id){
                            total_proprietarios++;
                            var percentual = parseFloat(percentual);
                            if (!isNaN(percentual)){
                                total_percentual += percentual;
                            }
                        }
                        if (id != "" && id != "0"){
                            if (lista_proprietarios.indexOf(id) >= 0){
                                alert("Parceiro repetido");
                                $(this).find("[name='nomecpfproprietario[]']").addClass("error").removeClass("valid").attr("aria-invalid", "true").focus();
                                erro_proprietarios = true;
                            } else {
                                lista_proprietarios.push(id);
                            }
                        }
                    })
                    
                    if (erro_proprietarios){
                        return false;
                    }

                    if (total_percentual.toFixed(2) != 100.00 && total_proprietarios > 0){
                        alert("A soma dos percentuais dos parceiros está diferente de 100%");
                        $("[name='percentualproprietario[]']").addClass("error").removeClass("valid").attr("aria-invalid", "true").focus();
                        return false;
                    }

                    if (total_proprietarios == 0){
                        alert("Você deve informar ao menos um parceiro");
                        $("[name='percentualproprietario[]']").addClass("error").removeClass("valid").attr("aria-invalid", "true");
                        $("[name='nomecpfproprietario[]']").addClass("error").removeClass("valid").attr("aria-invalid", "true");
                        return false;
                    }

                    /* Validar angariadores */

                    var erro_angariadores = false; 

                    var list_angariadores = new Array();                   

                    var total_percentual = 0;

                    var total_angariadores = 0;

                    $(".angariador").each(function(){
                        var percentual = $(this).find("[name='percentualangariador[]']").val();
                        var nome = $(this).find("[name='nomeangariador[]']").val();
                        var id = $(this).find("[name='idangariador[]']").val();
                        if (!nome && !percentual){
                            $(this).find("[name='idangariador[]']").val("");
                            return true;
                        }
                        if (nome && (!id || id == "" || id == "0" || id === undefined)){
                            erro_angariadores = true;
                            alert("O indicador informado não está cadastrado");
                            $(this).find("[name='nomeangariador[]']").addClass("error").removeClass("valid").attr("aria-invalid", "true").focus();
                            return false;
                        }
                        if (nome && !percentual){
                            erro_angariadores = true;
                            $(this).find("[name='percentualangariador[]']").addClass("error").removeClass("valid").attr("aria-invalid", "true").focus();
                            alert("Percentual em branco");
                            return false;
                        }
                        if (!nome && percentual){
                            erro_angariadores = true;
                            $(this).find("[name='nomeangariador[]']").addClass("error").removeClass("valid").attr("aria-invalid", "true").focus();
                            alert("Nome do indicador em branco");
                            return false;
                        }
                        if (nome && percentual && id){
                            total_angariadores++;
                            var percentual = parseFloat(percentual);
                            if (!isNaN(percentual)){
                                total_percentual += percentual;
                            }
                        }
                    })
                    
                    if (erro_angariadores){
                        return false;
                    }

                    if (total_percentual.toFixed(2) != 100.00 && total_angariadores > 0){
                        alert("A soma dos percentuais dos indicadores está diferente de 100%");
                        $("[name='percentualangariador[]']").addClass("error").removeClass("valid").attr("aria-invalid", "true");
                        return false;
                    }

                } else if (etapa == "permuta"){

                    var erro_observacoes = false;

                    $(".observacao").each(function(){
                        var tipo = $(this).find("[name='tipoobservacao[]']").val();
                        var observacao = $(this).find("[name='observacao[]']").val();
                        if (tipo != "" && (observacao == "" || observacao == null)){
                            erro_observacoes = true;
                            alert("A observação deve ser preenchida caso o tipo esteja selecionado");
                            $(this).find("[name='observacao[]']").addClass("error").removeClass("valid").attr("aria-invalid", "true").focus();
                            return false;
                        }
                        if (observacao != "" && (tipo == "" || tipo == null)){
                            erro_observacoes = true;
                            alert("O tipo de observação deve ser selecionado caso a observação esteja preenchida");
                            $(this).find("[name='tipoobservacao[]']").addClass("error").removeClass("valid").attr("aria-invalid", "true").focus();
                            return false;
                        }
                    })

                    if (erro_observacoes){
                        return false;
                    }

                }

                var etapa = form.find("#etapa").val();
                // Fazer ajax para salvar o registro e jogar o ID como um parâmetro
                $.post(basedir+"/cadimo/imovel/registerAjax", { 
                    params: form.serialize(),
                    id: id
                }, 
                function(response){
                    console.log(response);
                    if (response.success!==undefined && etapa == "geral"){
                        form.append('<input type="hidden" name="nidcadimo" id="nidcadimo" value="' + response.id + '">');                        
                    }
                }, "json");             
                
                /**
                Seta o campo etapa com base no index (aba) aberto.
                Etapa 0: Cadastro geral
                Etapa 1: Endereço
                */

                if (newIndex == 0){
                    form.find("#etapa").val("geral");
                } else if (newIndex == 1) {
                    form.find("#etapa").val("area");
                } else if (newIndex == 2) {
                    form.find("#etapa").val("permuta");
                } else if (newIndex == 3) {
                    form.find("#etapa").val("endereco");
                }

                return true;
            }
        
        },
        onFinishing: function (event, currentIndex)
        {

            form.validate().settings.ignore = ":disabled";

            var erro_distancias = false;

            $(".distancia").each(function(){
                var tipo_distancia = $(this).find("select[name='tipodistancia[]']").first().val();
                var tipo_medida = $(this).find("select[name='tipomedidadistancia[]']").first().val();
                var distancia = $(this).find("input[name='distancia[]']").first().val();
                
                if (tipo_distancia != "" || tipo_medida != "" || distancia != ""){
                    if (!tipo_distancia || tipo_distancia == "" || tipo_distancia == null){
                        $(this).find("select[name='tipodistancia[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                        erro_distancias = true;
                    }
                    if (!tipo_medida || tipo_medida == "" || tipo_medida == null){
                        $(this).find("select[name='tipomedidadistancia[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                        erro_distancias = true;
                    }
                    if (!distancia || distancia == "" || distancia == null){
                        $(this).find("input[name='distancia[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                        erro_distancias = true;
                    }
                
                }
            })

            if (erro_distancias){
                alert("Todos os dados da distância são obrigatórios caso um esteja preenchido");
                return false;
            }

            var id = $("#nidcadimo").val();

            // Salvar os últimos dados */

            $.post(basedir+"/cadimo/imovel/registerAjax", { 
                params: form.serialize(),
                id: id
            });  

            return form.valid();
        
        },
        onFinished: function (event, currentIndex)
        {

            if ($("#edit").length && $("#edit").val() == "1"){

                /* Salvar a edição de um cadastro geral */

                var id = $("#nidcadimo").val();

                $.post(basedir+"/cadimo/imovel/update", { 
                    params: form.serialize(),
                    id: id
                }, 
                function(response){
                    console.log(response);
                }, "json"); 


                alert("Produto atualizado com sucesso!");

            } else {

                alert("Produto cadastrado com sucesso!");

            }

            document.location = form.find("#redirectUrl").val();

        }
    });
    
    // VERTICAL
    // ----------------------------------- 

    $('.select-select2').select2();
    
  });

})(window, document, window.jQuery);

/* Função para puxar os tipos secundários elencados com o tipo primário selecionado */

jQuery(document).ready(function(){
    latitudeLongitudeMap();
    var $ = jQuery;
    $("#nidtbxtpi").change(function(){
        checkTiposSecundarios();
        checkCaracteristicas();
    }) 
    $("#nidtbxfin").change(function(){
        checkCaracteristicas();
        checkComissoes();
    })  
    $("#aceitaPermuta").change(function(){
        checkAceitaPermuta();
    })
    $("input.nidtbxtpp").change(function(){
        checkTipoPermuta($(this));
    })
    $("input.nidtbxtpp").each(function(){
        checkTipoPermuta($(this));
    })
    $("#nidtbxfin").change(function(){
        checkStatusImoveis();
    })
    checkAceitaPermuta();
    checkTiposSecundarios();
    checkCaracteristicas();
    checkComissoes();
    checkStatusImoveis();
    $("#inputSomarData").click(function(){
        var data_inicial = $("#data_inicio_contrato").val();
        var quantidade_dias = $("#dias_somar").val();
        if (!data_inicial){
            alert("Preencha a data inicial");
            return false;
        }
        if (!quantidade_dias){
            alert('Preencha a quantidade de dias a ser somada');
            return false;
        }
        $.post(basedir+"/cadimo/imovel/somarData", {data_inicial: data_inicial, quantidade_dias: quantidade_dias}, function(response){
            $("#data_fim_contrato").val(response);
        }, "json");
        return false;
    })
})

function checkComissoes(){
    $(".form-control-comissao").each(function(){
        var finalidade = $("#nidtbxfin").val();
        var valor_atual = $(this).val();
        var padrao_campo = $(".valor_padrao_comissao[data-finalidade-id='"+finalidade+"'][data-tipo='"+$(this).attr('drtgata-tipo-comissao')+"']").val();
        if (valor_atual == ""){
            $(this).val(padrao_campo);
        }
    })
}

function checkStatusImoveis(){
    var nidtbxfin = $("#nidtbxfin").val();
    $.post(basedir+"/dci/statusimovel/getByFinalidade", { 
        nidtbxfin: nidtbxfin
    }, 
    function(response){
        $("#nidtbxsti").html("");
        for (i in response){
            $("#nidtbxsti").append("<option value='"+response[i].nidtbxsti+"'>"+response[i].cdescristi+"</option>");
        }
        resizeJquerySteps();
    }, "json");
}

function checkTiposSecundarios(){
    var current_tipos = $("#listaTiposSecundarios").attr("data-tipos");
    if (current_tipos !== undefined){
        current_tipos = current_tipos.split("|");
    } else {
        current_tipos = [];
    }
    $("#listaTiposSecundarios #lista").html("");
    var nidtbxtpi = $("#nidtbxtpi").val();
    if (!nidtbxtpi == "" && !nidtbxtpi == null){
        $.post(basedir+"/dci/tipoimovel/getSecundarios", { 
            nidtbxtpi: nidtbxtpi
        }, 
        function(response){
            if (response.length == 0){
                $("#listaTiposSecundarios").hide();
            } else {
                for (i in response){
                    $("#listaTiposSecundarios").show();
                        var item = '<div class="checkbox">';
                        item += '<label>';
                        if (current_tipos.indexOf(response[i].id) > -1){
                            item += '<input type="checkbox" name="nidtagti2[]" value="'+response[i].id+'" checked="checked">';
                        } else {
                            item += '<input type="checkbox" name="nidtagti2[]" value="'+response[i].id+'">';
                        }
                        item += response[i].nome;
                        item += '</label></div>';
                    $("#listaTiposSecundarios #lista").append(item);
                }
            }
            resizeJquerySteps();
        }, "json");  
    }
    resizeJquerySteps();
    autocomplete_cidade();
    resetarAutocompleteCidade();

}

function checkAceitaPermuta(){
    if ($("#aceitaPermuta").is(":checked")){
        $("#listaTipoPermuta").show();
    } else {
        $("#listaTipoPermuta").hide();
    }
    resizeJquerySteps();
}

function checkTipoPermuta(elemento){
    if ($(elemento).is(":checked")){
        $(elemento).closest("label").find(".form-control").removeAttr("readonly");
    } else {
        $(elemento).closest("label").find(".form-control").attr("readonly","readonly");
    }
}

function checkCaracteristicas(){
    var current_car = $("#listaCaracteristicas").attr("data-caracteristicas");
    if (current_car !== undefined){
        current_car = current_car.split("|");
    } else {
        current_car = [];
    }
    $("#listaCaracteristicas #lista").html("");
    var nidtbxtpi = $("#nidtbxtpi").val();
    var nidtbxfin = $("#nidtbxfin").val();
    if (nidtbxtpi != "" && nidtbxtpi != null && nidtbxfin != "" && nidtbxfin != null){
        $.post(basedir+"/dci/tipoimovel/getCaracteristicas", {
            nidtbxtpi: nidtbxtpi,
            nidtbxfin: nidtbxfin
        }, 
        function(response){
            if (response.length == 0){
                $("#listaCaracteristicas").hide();
            } else {
                for (i in response){
                    $("#listaCaracteristicas").show();
                    var item = '<div class="checkbox">';
                    item += '<label>';
                    if (current_car.indexOf(response[i].id) > -1){
                        item += '<input type="checkbox" name="nidtbxcar[]" value="'+response[i].id+'" checked="checked">';
                    } else {
                        item += '<input type="checkbox" name="nidtbxcar[]" value="'+response[i].id+'">';
                    }
                    item += response[i].nome;
                    item += '</label></div>';
                    $("#listaCaracteristicas #lista").append(item);
                }
            }
            resizeJquerySteps();
        }, "json");  
    }
    resizeJquerySteps();
}

function resetarAutocompleteCidade(){
    var $ = jQuery;
    $(".resetarAutocompleteCidade").unbind("click").click(function(){
        var endereco = $(this).closest(".endereco");
        endereco.find(".autocomplete-cidade").removeAttr("readonly").val("");
        endereco.find(".idcidade").val("");
        $(this).remove();
        resizeJquerySteps();
        return false;
    })
}

function latitudeLongitudeMap(){
    $("#modalLatitudeLongitude").on('shown.bs.modal', function(e){
        initMap();
    });
    $("#getLatitudeLongitudeMapa").unbind("click").click(function(){
        $("#modalLatitudeLongitude").modal('show');
    })
}

function initMap(){
    var marker;
    $("#mapLatitudeLongitudeContainer").css('width', '100%');
    $("#mapLatitudeLongitudeContainer").css('height', 450);
    var map_pos = document.getElementById('mapLatitudeLongitudeContainer');
    var map = new google.maps.Map(map_pos, {
        zoom: 15,
        center: {lat: -25.877807, lng: -48.5746738}
    });
    google.maps.event.addListener(map, 'click', function(event) {
      if ( marker ) {
        marker.setPosition(event.latLng);
      } else {
        marker = new google.maps.Marker({
          position: event.latLng,
          map: map
        });
      }
    });
    $("#modalLatitudeLongitude .adicionar-latitude-longitude-action").unbind("click").click(function(){
        if (marker){
            var latitude = marker.getPosition().lat();
            var longitude = marker.getPosition().lng();
            $("#latitude").val(latitude);
            $("#longitude").val(longitude);
            $("#modalLatitudeLongitude").modal('hide');
        } else {
            alert('Selecione um ponto no mapa');
        }
    })

}

function autocomplete_cidade(){
    $(".autocomplete-cidade").each(function(){
        var endereco = $(this).closest(".endereco");
        if ($(this).hasClass("ui-autocomplete-input"))
            return true;
        $(this).autocomplete({
          source: $(this).attr("data-action"),
          minLength: 2,
          select: function( event, ui ) {
            endereco.find(".idcidade").val(ui.item.id);
            endereco.find(".autocomplete-cidade").attr("readonly", "readonly").after('<a href="#" class="resetarAutocompleteCidade btn btn-danger btn-xs">[X]</a>');
            resetarAutocompleteCidade();
            resizeJquerySteps();
          }
        });
    })
}