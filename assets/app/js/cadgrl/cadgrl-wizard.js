// Forms Demo
// ----------------------------------- 

(function(window, document, $, undefined){

  $(function(){

    var form = $("#form-cadastro");
    form.validate({
        errorPlacement: function errorPlacement(error, element) {
            if (element.hasClass("select-select2")){
                element.next(".select2-container").find(".select2-selection").addClass("error");
            }
            element.before(error);
        },
        rules: {
            'cpf': {
                cpf: true,
                cpf_cnpj_existente: true
            },
            'cnpj': {
                cnpj: true,
                cpf_cnpj_existente: true
            },
            'ddtfundacao': {
                dateBR: true,
                maxdatetoday: true
            },
            'data_nascimento': {
                dateBR: true,
                maxdatetoday: true
            },
            'data_emissao': {
                dateBR: true,
                maxdatetoday: true
            }
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
        },
        onStepChanged: function(event, currentIndex, priorIndex){
            toggleFields();
            resizeJquerySteps();
            if (typeof updateRemoverEnderecoButton !== 'undefined' && $.isFunction(updateRemoverEnderecoButton)) {
                updateRemoverEnderecoButton();
            }
            $('.select-select2').select2({
                width: "resolve"
            });
        },
        onStepChanging: function (event, currentIndex, newIndex)
        {

            form.validate().settings.ignore = ":disabled,:hidden,.required-before";
            
            var id = form.find("#nidcadgrl").val();
            var etapa = form.find("#etapa").val();

            /* Verifica o tipo de pessoa */

            var tipo_pessoa = $("[name='tipo_pessoa']").val();

            if (tipo_pessoa == "j"){

                /* Validações de pessoa jurídica */

                if (etapa == "geral"){
                    var erro_socio = false;
                    $(".socio").not("[data-id='-1']").each(function(){
                        var nome = $(this).find("[name='nome_socio[]']").val();
                        var socio_id = $(this).find("[name='socio_id[]']").val();
                        var observacoes = $(this).find("[name='observacoes_socio[]']").val();
                        if (nome && !socio_id){
                            $(this).find("[name='nome_socio[]']").addClass("error").removeClass("valid").attr("aria-invalid", "true");
                            erro_socio = true;
                        }
                        if (observacoes && !socio_id){
                            $(this).find("[name='nome_socio[]']").addClass("error").removeClass("valid").attr("aria-invalid", "true");
                            erro_socio = true;
                        }
                    })
                    if (erro_socio){
                        alert("Preencha os dados obrigatórios dos sócios. Selecione o nome do sócio na lista de sugestões.");
                        return false;
                    }
                }

            } else {

                /* Validações de pessoa física */
                var erro_parente = false;
                $(".parente").not("[data-id='-1']").each(function(){
                    var tipo_parentesco = $(this).find("[name='tipoparentesco[]']").val();
                    var nome_parente = $(this).find("[name='nome_parente[]']").val();
                    var parente_id = $(this).find("[name='parente_id[]']").val();
                    if ((tipo_parentesco && !nome_parente) || (nome_parente && !tipo_parentesco) || (nome_parente && !parente_id)){
                        $(this).find("[name='nome_parente[]']").addClass("error").removeClass("valid").attr("aria-invalid", "true");
                        $(this).find("[name='tipo_parentesco[]']").addClass("error").removeClass("valid").attr("aria-invalid", "true");
                        erro_parente = true;
                    }
                })
                if (erro_parente){
                    alert("Preencha os dados obrigatórios dos parentes. Selecione o nome do parente na lista de sugestões.");
                    return false;
                }

            }

            if (!form.valid()){
                resizeJquerySteps();
                return false;
            } else {

                // Fazer validações

                if (etapa == "geral"){
                    var total_tipos_cadastro = $("[name='nidtbxtcg[]']:checked").length;
                    if (total_tipos_cadastro == 0){
                        alert("Selecione ao mínimo um tipo de cadastro");
                        return false;
                    }
                } else if (etapa == "endereco"){
                    var erro = false;
                    var elemento;
                    $(".endereco label.error").remove();
                    $(".select2-selection").removeClass("error");
                    $(".endereco").each(function(){
                        var elemento = $(this);
                        var tipoendereco = $(this).find("[name='tipoendereco[]']").first().val();
                        var nidtbxtpl = $(this).find("[name='nidtbxtpl[]']").first().val();
                        var endereco = $(this).find("[name='endereco[]']").first().val();
                        var numero = $(this).find("[name='numero[]']").first().val();
                        var complemento = $(this).find("[name='complemento[]']").first().val();
                        var uf = $(this).find("[name='uf[]']").first().val();
                        var cidade = $(this).find("[name='cidade[]']").first().val();
                        var bairro = $(this).find("[name='bairro[]']").first().val();
                        var cep = $(this).find("[name='cep[]']").first().val();
                        var cep_cidade = $(this).find("[name='cep_cidade[]']").first().val();
                        var pais = $(this).find("[name='pais[]']").first().val();
                        if (tipoendereco || endereco || numero || complemento || bairro || cidade || cep || nidtbxtpl || uf || pais ){
                          /* O endereço foi preenchido, verificar se todos estão preenchidos */
                          if (!tipoendereco){
                            $(this).find("[name='tipoendereco[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                          }
                          if (!endereco){
                            $(this).find("[name='endereco[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                          }
                          if (!numero){
                            $(this).find("[name='numero[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                          }
                          if (!bairro){
                            $(this).find("[name='bairro[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                          }
                          if (!cidade){
                            $(this).find("[name='cidade[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                          }
                          if (!cep){
                            $(this).find("[name='cep[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                          }
                          if (!nidtbxtpl){
                            $(this).find("[name='nidtbxtpl[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                          }
                          if (!uf){
                            $(this).find("[name='uf[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                            $(this).find("select[name='uf[]']").next(".select2").find(".select2-selection").addClass("error");
                          }
                          if (!pais){
                            $(this).find("[name='pais[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                            $(this).find("select[name='pais[]']").next(".select2").find(".select2-selection").addClass("error");
                          }
                          if (!(tipoendereco && endereco && numero && bairro && cidade && nidtbxtpl && uf && pais && cep)){
                            erro = true;
                          }
                        }
                    });
                    if (erro == true){
                        alert("Preencha os dados obrigatórios do endereço");
                        return false;
                    }
                } else if (etapa == "contato"){
                    /* Valida os telefones */
                    var erro_telefone = false;
                    var erro_email = false;
                    $(".telefone .error").removeClass("error").attr("aria-invalid", "false");
                    var lista_tipos_telefone = new Array();
                    var lista_telefone = new Array();
                    var lista_tipos_email = new Array();
                    var lista_email = new Array();
                    $(".telefone").each(function(){
                        var tipo = $(this).find("[name='tipotelefone[]']").first().val();
                        var telefone = $(this).find("[name='telefone[]']").first().val();
                        lista_tipos_telefone.push(tipo);
                        lista_telefone.push(telefone);
                        if (tipo || telefone){
                            if (!tipo){
                                $(this).find("[name='tipotelefone[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                                erro_telefone = true;
                            }
                            if (!telefone){
                                $(this).find("[name='telefone[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");   
                                erro_telefone = true;
                            }
                        }
                    })
                    $(".email").each(function(){
                        var tipo = $(this).find("[name='tipoemail[]']").first().val();
                        var email = $(this).find("[name='email[]']").first().val();
                        lista_tipos_email.push(tipo);
                        lista_email.push(email);
                        if (tipo || email){
                            if (!tipo){
                                $(this).find("[name='tipoemail[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                                erro_email = true;
                            }
                            if (!email){
                                $(this).find("[name='email[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");   
                                erro_email = true;
                            }
                        }                        
                    })
                    if (erro_telefone){
                        alert("Preencha corretamente os dados do telefone");
                        return false;
                    }
                    if (erro_email){
                        alert("Preencha corretamente os dados do e-mail");
                        return false;
                    }

                    /* Procura por e-mails repetidos */
                    
                    var lista_email_unico = new Array();
                    for (i in lista_email){
                        var email = lista_email[i];
                        var tipo = lista_tipos_email[i];
                        var pos = lista_email_unico.indexOf(tipo+"-"+email);
                        if (pos == -1){
                            lista_email_unico.push(tipo+"-"+email);
                        } else {
                            alert('Favor remover e-mails repetidos');
                            $("[name='tipoemail[]']").eq(i).addClass("error").removeClass("valid").attr("aria-invalid", "true");
                            $("[name='email[]']").eq(i).addClass("error").removeClass("valid").attr("aria-invalid", "true"); 
                            return false;
                        }
                    }
                    
                    /* Procura por e-mails repetidos */
                
                    var lista_telefone_unico = new Array();
                    for (i in lista_telefone){
                        var telefone = lista_telefone[i];
                        var tipo = lista_tipos_telefone[i];
                        var pos = lista_telefone_unico.indexOf(tipo+"-"+telefone);
                        if (pos == -1){
                            lista_telefone_unico.push(tipo+"-"+telefone);
                        } else {
                            alert('Favor remover telefones repetidos');
                            $("[name='tipotelefone[]']").eq(i).addClass("error").removeClass("valid").attr("aria-invalid", "true");
                            $("[name='telefone[]']").eq(i).addClass("error").removeClass("valid").attr("aria-invalid", "true"); 
                            return false;
                        }
                    }

                }
               
                // Fazer ajax para salvar o registro e jogar o ID como um parâmetro
                $.post(basedir+"/cadgrl/cadastro/registerAjax", { 
                    params: form.serialize(),
                    id: id
                }, 
                function(response){
                    console.log(response);
                    if (response.success!==undefined && etapa == "geral"){
                        form.append('<input type="hidden" name="nidcadgrl" id="nidcadgrl" value="' + response.id + '">');                        
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
                    form.find("#etapa").val("endereco");
                } else if (newIndex == 2) {
                    form.find("#etapa").val("contato");
                } else if (newIndex == 3){
                    form.find("#etapa").val("dadosbancarios");
                }

                var tipo_pessoa = $("input[name=tipo_pessoa]").val();

                if (!tipo_pessoa || tipo_pessoa == undefined){
                    var tipo_pessoa = $("select[name=tipo_pessoa]").val();
                    $("select[name=tipo_pessoa]").attr("disabled", "disabled");
                    $("select[name=tipo_pessoa]").after("<input type='hidden' name='tipo_pessoa' value='"+tipo_pessoa+"'>");    
                }


                return true;
            }
        
        },
        onFinishing: function (event, currentIndex)
        {

            $(".conta .error").removeClass("error").removeAttr("aria-invalid").addClass("valid");
            form.validate().settings.ignore = ":disabled";
            var total_principais = 0;
            $("[name='principal[]']").each(function(){
                if ($(this).is(":checked")){
                    total_principais++;
                }
            })
            if (total_principais > 1){
                alert("Apenas uma conta deve ser setada como principal");
                return false;
            }

            var erro_contas = false;

            var erro_repeticao = false;

            var contas = new Array();

            var elemento_erro_repeticao;

            $(".conta").each(function(){
                var banco = $(this).find("select[name='banco[]']").first().val();
                var titular = $(this).find("input[name='titular[]']").first().val();
                var agencia = $(this).find("input[name='agencia[]']").first().val();
                var conta = $(this).find("input[name='conta[]']").first().val();
                var tipo_conta = $(this).find("select[name='tipo_conta[]']").first().val(); 
                var codigo_tipo_conta = $(this).find("input[name='codigo_tipo_conta[]']").first().val();
                
                /* Salvar cada item na lista geral */

                if (banco || titular || agencia || conta || tipo_conta){
                    if (!banco || banco == "" || banco == null){
                        $(this).find("select[name='banco[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                        erro_contas = true;
                    }
                    if (!titular || titular == "" || titular == null){
                        $(this).find("input[name='titular[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                        erro_contas = true;
                    }
                    if (!agencia || agencia == "" || agencia == null){
                        $(this).find("input[name='agencia[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                        erro_contas = true;
                    }
                    if (!conta || conta == "" || conta == null){
                        $(this).find("input[name='conta[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                        erro_contas = true;
                    }
                    if (!tipo_conta || tipo_conta == "" || conta == null){
                        $(this).find("select[name='tipo_conta[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                        erro_contas = true;
                    }

                    var string_conta = banco + ":" + ":" + agencia + ":" + conta + ":" + tipo_conta;

                    if (contas.indexOf(string_conta) >= 0){
                        erro_repeticao = true;
                        elemento_erro_repeticao = $(this);
                    } else {
                        contas.push(string_conta);
                    }

                
                }
            })

            if (erro_contas){
                alert("Preencha os dados obrigatórios das contas bancárias");
                return false;
            }

            if (erro_repeticao){
                alert("Você não pode cadastrar contas repetidas");
                if ($(elemento_erro_repeticao).length > 0){
                    $(elemento_erro_repeticao).find("select[name='banco[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                    $(elemento_erro_repeticao).find("input[name='titular[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                    $(elemento_erro_repeticao).find("input[name='agencia[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                    $(elemento_erro_repeticao).find("input[name='conta[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                    $(elemento_erro_repeticao).find("select[name='tipo_conta[]']").first().addClass("error").removeClass("valid").attr("aria-invalid", "true");
                }
                return false;
            }

            var id = form.find("#nidcadgrl").val();
            var etapa = form.find("#etapa").val();

            // Fazer ajax para salvar o registro e jogar o ID como um parâmetro
            $.post(basedir+"/cadgrl/cadastro/registerAjax", { 
                params: form.serialize(),
                id: id
            }, 
            function(response){
                console.log(response);
            }, "json");   

            return true;

        },
        onFinished: function (event, currentIndex)
        {

            if ($("#edit").length && $("#edit").val() == "1"){

                /* Salvar a edição de um cadastro geral */

                var id = $("#nidcadgrl").val();

                $.post(basedir+"/cadgrl/cadastro/update", { 
                    params: form.serialize(),
                    id: id
                }, 
                function(response){
                    console.log(response);
                }, "json"); 


                alert("Cadastro atualizado com sucesso!");

            } else {

                alert("Cadastro realizado com sucesso!");

            }

            document.location = form.find("#redirectUrl").val();

        }
    });

    // IE ISENTO

    $("#ie_isento").change(function(){
        if ($(this).is(":checked")){
           $("input[name='ie']").val("").attr("readonly", "readonly"); 
        } else {
            $("input[name='ie']").removeAttr("readonly");
        }
    })
    
    // VERTICAL
    // ----------------------------------- 

    $('.select-select2').select2({
        width: "resolve"
    });
    
  });

})(window, document, window.jQuery);
